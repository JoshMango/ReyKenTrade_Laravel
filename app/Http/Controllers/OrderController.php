<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function showCheckout()
    {
        $cartItems = Cart::where('user_id', Auth::id())
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->withErrors(['cart' => 'Your cart is empty!']);
        }

        $total = $cartItems->sum(function ($item) {
            return $item->product->productPrice * $item->quantity;
        });

        return view('checkout', compact('cartItems', 'total'));
    }

    public function processOrder(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string',
            'shipping_address' => 'required|string',
            'phonenumber' => 'required|string',
            'reference' => 'nullable|string',
        ]);

        $cartItems = Cart::where('user_id', Auth::id())
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return back()->withErrors(['order' => 'Your cart is empty!'])->withInput();
        }

        $total = $cartItems->sum(function ($item) {
            return $item->product->productPrice * $item->quantity;
        });

        DB::beginTransaction();

        try {
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $total,
                'payment_mode' => $request->payment_method,
                'refNumber' => $request->reference,
                'shipping_address' => $request->shipping_address,
                'customer_number' => $request->phonenumber,
                'order_date' => now(),
                'order_status' => 'Undelivered',
            ]);

            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->order_id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'unit_price' => $cartItem->product->productPrice,
                    'total_price' => $cartItem->product->productPrice * $cartItem->quantity,
                ]);
            }

            Cart::where('user_id', Auth::id())->delete();

            DB::commit();

            return redirect()->route('order.confirmation', $order->order_id);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['order' => 'Failed to process order. Please try again.'])->withInput();
        }
    }

    public function confirmation($id)
    {
        $order = Order::where('order_id', $id)
            ->where('user_id', Auth::id())
            ->with('items.product')
            ->firstOrFail();

        return view('order_confirmation', compact('order'));
    }

    public function myOrders()
    {
        $orders = Order::where('user_id', Auth::id())
        ->where('order_status', '!=', 'Delivered')
        ->with('items.product')
        ->orderBy('order_date', 'desc')
        ->paginate(8) // 8 orders per page
        ->through(function ($order) {
            return [
                'order_id' => $order->order_id,
                'order_date' => $order->order_date->format('Y-m-d H:i:s'),
                'total_amount' => $order->total_amount,
                'order_status' => $order->order_status,
                'shipping_address' => $order->shipping_address,
                'customer_number' => $order->customer_number,
                'payment_mode' => $order->payment_mode,
                'items' => $order->items->map(function ($item) {
                    return [
                        'product_name' => $item->product->productName,
                        'product_price' => $item->product->productPrice,
                        'quantity' => $item->quantity,
                        'total_price' => $item->total_price,
                        'product_image' => $item->product->productImage, // include image
                    ];
                }),
            ];
        });


        return view('customer_orders', compact('orders'));
    }

    public function sellerOrders()
    {
        $orders = Order::whereNotIn('order_status', ['Delivered', 'Rejected'])
            ->with(['user', 'items.product'])
            ->orderBy('order_date', 'desc')
            ->paginate(9) // 9 per page
            ->through(function ($order) {
                return [
                    'order_id' => $order->order_id,
                    'fullname' => $order->user->fullname,
                    'username' => $order->user->username,
                    'email' => $order->user->email,
                    'order_date' => $order->order_date->format('Y-m-d H:i:s'),
                    'total_amount' => $order->total_amount,
                    'order_status' => $order->order_status,
                    'shipping_address' => $order->shipping_address,
                    'customer_number' => $order->customer_number,
                    'payment_mode' => $order->payment_mode,
                    'reference_number' => $order->refNumber,
                    'items' => $order->items->map(function ($item) {
                        return [
                            'product_name' => $item->product->productName,
                            'product_price' => $item->product->productPrice,
                            'quantity' => $item->quantity,
                            'total_price' => $item->total_price,
                        ];
                    }),
                ];
            });

        return view('seller_orders', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'order_status' => 'required|string|in:Undelivered,Delivered,Rejected',
        ]);

        $order = Order::findOrFail($id);
        $order->order_status = $request->order_status;
        $order->save();

        return back()->with('success', 'Order status updated!');
    }
}
