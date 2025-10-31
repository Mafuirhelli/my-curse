<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function cart()
    {
        $cartItems = Auth::user()->cartItems()->with('product')->get();
        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->price;
        });

        return view('cart', compact('cartItems', 'total'));
    }

    public function addToCart(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = Auth::user()->cartItems()->where('product_id', $product->id)->first();

        if ($cartItem) {
            $cartItem->update([
                'quantity' => $cartItem->quantity + $request->quantity
            ]);
        } else {
            Auth::user()->cartItems()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->current_price
            ]);
        }

        return redirect()->back()->with('success', 'Товар добавлен в корзину');
    }

    public function removeFromCart(Product $product)
    {
        Auth::user()->cartItems()->where('product_id', $product->id)->delete();

        return redirect()->back()->with('success', 'Товар удален из корзины');
    }

    public function updateCart(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        if ($request->quantity == 0) {
            return $this->removeFromCart($product);
        }

        Auth::user()->cartItems()->where('product_id', $product->id)->update([
            'quantity' => $request->quantity
        ]);

        return redirect()->back()->with('success', 'Корзина обновлена');
    }

    public function checkout(Request $request)
    {
        $user = Auth::user();
        $cartItems = $user->cartItems()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Корзина пуста');
        }

        DB::transaction(function () use ($user, $cartItems, $request) {
            $totalAmount = $cartItems->sum(function ($item) {
                return $item->quantity * $item->price;
            });

            $pointsUsed = min($request->points_used ?? 0, $user->points);
            $finalAmount = max($totalAmount - ($pointsUsed * 0.1), 0); // 1 балл = 0.1 рубля
            $pointsEarned = (int)($finalAmount * 0.05); // 5% от суммы в баллы

            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $totalAmount,
                'final_amount' => $finalAmount,
                'points_used' => $pointsUsed,
                'points_earned' => $pointsEarned,
                'status' => 'pending'
            ]);

            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price
                ]);
            }


            $user->decrement('points', $pointsUsed);
            $user->increment('points', $pointsEarned);


            $user->cartItems()->delete();
        });

        return redirect()->route('profile')->with('success', 'Заказ успешно оформлен!');
    }

    public function orderHistory()
    {
        $orders = Auth::user()->orders()->with('items.product')->latest()->get();
        return view('order-history', compact('orders'));
    }
}
