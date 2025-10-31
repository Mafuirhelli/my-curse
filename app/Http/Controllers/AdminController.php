<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Discount;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'total_products' => Product::count(),
            'active_discounts' => Discount::where('is_active', true)->count(),
            'total_users' => User::count(),
            'recent_orders' => Order::with('user')->latest()->take(5)->get(),
        ];


        $ordersByDay = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        )->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.dashboard', compact('stats', 'ordersByDay'));
    }


    public function products(Request $request)
    {
        $query = Product::with(['discounts' => function($q) {
            $q->where('is_active', true)
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now());
        }]);


        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }


        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }


        if ($request->has('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $products = $query->latest()->get();
        $categories = Product::distinct()->pluck('category');

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function createProduct()
    {
        $categories = Product::distinct()->pluck('category');
        return view('admin.products.create', compact('categories'));
    }

    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        Product::create($validated);

        return redirect()->route('admin.products')->with('success', 'Продукт успешно создан');
    }

    public function editProduct(Product $product)
    {
        $categories = Product::distinct()->pluck('category');
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('image')) {

            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        $product->update($validated);

        return redirect()->route('admin.products')->with('success', 'Продукт успешно обновлен');
    }

    public function deleteProduct(Product $product)
    {

        if ($product->orderItems()->exists()) {
            return redirect()->back()->with('error', 'Нельзя удалить продукт, так как он есть в заказах');
        }


        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();
        return redirect()->route('admin.products')->with('success', 'Продукт успешно удален');
    }


    public function discounts(Request $request)
    {
        $query = Discount::with('product');

        if ($request->has('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true)
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now());
            } elseif ($request->status === 'expired') {
                $query->where('end_date', '<', now());
            } elseif ($request->status === 'upcoming') {
                $query->where('start_date', '>', now());
            }
        }

        $discounts = $query->latest()->get();
        $products = Product::where('is_active', true)->get();

        return view('admin.discounts.index', compact('discounts', 'products'));
    }

    public function createDiscount()
    {
        $products = Product::where('is_active', true)->get();
        return view('admin.discounts.create', compact('products'));
    }

    public function storeDiscount(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'discount_percent' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'boolean'
        ]);

        $existingDiscount = Discount::where('product_id', $validated['product_id'])
            ->where('is_active', true)
            ->where(function($query) use ($validated) {
                $query->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
                    ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']])
                    ->orWhere(function($q) use ($validated) {
                        $q->where('start_date', '<=', $validated['start_date'])
                            ->where('end_date', '>=', $validated['end_date']);
                    });
            })->first();

        if ($existingDiscount) {
            return redirect()->back()->with('error', 'На этот продукт уже действует скидка в указанный период');
        }

        Discount::create($validated);

        return redirect()->route('admin.discounts')->with('success', 'Скидка успешно создана');
    }

    public function editDiscount(Discount $discount)
    {
        $products = Product::where('is_active', true)->get();
        return view('admin.discounts.edit', compact('discount', 'products'));
    }

    public function updateDiscount(Request $request, Discount $discount)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'discount_percent' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'boolean'
        ]);

        $existingDiscount = Discount::where('product_id', $validated['product_id'])
            ->where('id', '!=', $discount->id)
            ->where('is_active', true)
            ->where(function($query) use ($validated) {
                $query->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
                    ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']])
                    ->orWhere(function($q) use ($validated) {
                        $q->where('start_date', '<=', $validated['start_date'])
                            ->where('end_date', '>=', $validated['end_date']);
                    });
            })->first();

        if ($existingDiscount) {
            return redirect()->back()->with('error', 'На этот продукт уже действует другая скидка в указанный период');
        }

        $discount->update($validated);

        return redirect()->route('admin.discounts')->with('success', 'Скидка успешно обновлена');
    }

    public function deleteDiscount(Discount $discount)
    {
        $discount->delete();
        return redirect()->route('admin.discounts')->with('success', 'Скидка успешно удалена');
    }


    public function orders(Request $request)
    {
        $query = Order::with(['user', 'items.product']);


        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }


        if ($request->has('date') && $request->date) {
            $query->whereDate('created_at', $request->date);
        }

        $orders = $query->latest()->get();
        $statuses = ['pending', 'processing', 'completed', 'cancelled'];

        return view('admin.orders.index', compact('orders', 'statuses'));
    }

    public function showOrder(Order $order)
    {
        $order->load(['user', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        $oldStatus = $order->status;
        $order->update($validated);


        if ($validated['status'] === 'cancelled' && $oldStatus !== 'cancelled') {
            if ($order->points_used > 0) {
                $order->user->increment('points', $order->points_used);
            }
        }

        return redirect()->route('admin.orders')->with('success', 'Статус заказа обновлен');
    }

    public function users(Request $request)
    {
        $query = User::withCount('orders');

        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        $users = $query->latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function updateUserPoints(Request $request, User $user)
    {
        $validated = $request->validate([
            'points' => 'required|integer|min:0'
        ]);

        $user->update($validated);

        return redirect()->route('admin.users')->with('success', 'Баллы пользователя обновлены');
    }
}
