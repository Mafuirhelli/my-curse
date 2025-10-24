<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class OrderController extends Controller
{

    public function cart(): View
    {
        $cart = session()->get('cart', []);
        $products = [];
        $total = 0;

        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            if ($product) {
                $product->quantity = $quantity;
                $products[] = $product;
                $total += $product->current_price * $quantity;
            }
        }

        return view('cart', compact('products', 'total'));
    }

    public function addToCart(Request $request, Product $product): RedirectResponse
    {
        $cart = session()->get('cart', []);
        $cart[$product->id] = ($cart[$product->id] ?? 0) + 1;
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Товар добавлен в корзину');
    }

    public function removeFromCart(Product $product): RedirectResponse
    {
        $cart = session()->get('cart', []);
        unset($cart[$product->id]);
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Товар удален из корзины');
    }

    public function updateCart(Request $request, Product $product): RedirectResponse
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = session()->get('cart', []);
        $cart[$product->id] = $request->quantity;
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Количество обновлено');
    }

    public function checkout(Request $request): RedirectResponse
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Корзина пуста');
        }

        $user = Auth::user();
        $total = 0;
        $pointsToUse = min($request->points_used ?? 0, $user->points);
        $pointDiscount = $pointsToUse;

        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            $total += $product->current_price * $quantity;
        }

        $finalAmount = max($total - $pointDiscount, 0);
        $pointsEarned = (int)($finalAmount * 0.05);

        $order = Order::create([
            'user_id' => $user->id,
            'total_amount' => $total,
            'final_amount' => $finalAmount,
            'points_used' => $pointsToUse,
            'points_earned' => $pointsEarned,
            'status' => 'pending'
        ]);

        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $product->current_price
            ]);
        }

        $user->points = $user->points - $pointsToUse + $pointsEarned;
        $user->save();

        session()->forget('cart');

        return redirect()->route('profile')->with('success', 'Заказ успешно оформлен!');
    }

    public function orderHistory(): View
    {
        $orders = Auth::user()->orders()->with('items.product')->latest()->get();
        return view('order-history', compact('orders'));
    }
}
