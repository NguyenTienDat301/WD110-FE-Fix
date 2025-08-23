<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\{Cart, CartItem, Order, Order_detail, ProductVariant, Ship_address, Voucher, Voucher_usage};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, DB, Log};

class OrderController extends Controller
{
    public function store(Request $request)
    {
        Log::info('OrderController@store: Bắt đầu xử lý đơn hàng.', ['request_data' => $request->all()]);
        try {
            if (!Auth::check()) return response()->json(['message' => 'User not logged in.'], 401);
            $userId = Auth::id();

            // Địa chỉ giao hàng
            $shippingAddress = Ship_address::where('user_id', $userId)
                ->orderByDesc('is_default')
                ->orderByDesc('created_at')
                ->first();
            if (!$shippingAddress) {
                return response()->json([
                    'message' => 'No shipping address found. Please add a new address.',
                    'redirect_url' => route('address.create')
                ], 400);
            }

            // Giỏ hàng
            $cart = Cart::where('user_id', $userId)->first();
            if (!$cart) return response()->json(['message' => 'No items in the cart.'], 400);

            $cartItems = CartItem::with(['productVariant.product', 'productVariant.color', 'productVariant.size'])
                ->where('cart_id', $cart->id)->get();
            if ($cartItems->isEmpty()) return response()->json(['message' => 'No items in the cart.'], 400);

            $totalQuantity = $cartItems->sum('quantity');
            $totalAmount   = $cartItems->sum(fn($i) => $i->quantity * $i->price);

            // Voucher
            $voucherId     = $request->input('voucher_id');
            $discountValue = 0;
            $voucher       = null;
            if ($voucherId) {
                try {
                    [$discountValue, $voucher] = $this->handleVoucher($voucherId, $totalAmount, $userId);
                } catch (\Exception $e) {
                    return response()->json(['message' => $e->getMessage()], 400);
                }
            }
            $totalAmount -= $discountValue;

            // Tạo Order
            $orderId = $this->generateOrderId();
            $order = Order::create([
                'id'             => $orderId,
                'user_id'        => $userId,
                'quantity'       => $totalQuantity,
                'total_amount'   => $totalAmount,
                'payment_method' => $request->input('payment_method', 1),
                'ship_method'    => $request->input('ship_method', 1),
                'voucher_id'     => $voucherId,
                'ship_address_id'=> $shippingAddress->id,
                'discount_value' => $discountValue,
                'status'         => 0,
            ]);

            // Chi tiết đơn hàng + cập nhật tồn kho
            $orderDetails = $cartItems->map(function ($item) use ($orderId) {
                $variant = $item->productVariant;
                $product = $variant->product;

                $detail = Order_detail::create([
                    'order_id'          => $orderId,
                    'product_id'        => $product->id,
                    'product_variant_id'=> $variant->id,
                    'product_name'      => $product->name,
                    'quantity'          => $item->quantity,
                    'price'             => $item->price,
                    'price_sale'        => $item->price,
                    'total'             => $item->quantity * $item->price,
                    'size_id'           => $variant->size_id,
                    'size_name'         => $variant->size->size ?? null,
                    'color_id'          => $variant->color_id,
                ]);

                $variant->decrement('quantity', $item->quantity);
                return $detail;
            });

            // Lưu voucher_usage nếu có
            if ($voucherId && $voucher) {
                Voucher_usage::create([
                    'user_id'       => $userId,
                    'order_id'      => $orderId,
                    'voucher_id'    => $voucherId,
                    'discount_value'=> $discountValue,
                ]);
            }

            // Thanh toán Online
            if ($request->input('payment_method') == 2) {
                $paymentResponse = $this->createPaymentUrl($request, $totalAmount, $orderId);
                $paymentData = $paymentResponse->getData(true);
                return isset($paymentData['payment_url'])
                    ? response()->json([
                        'status'      => true,
                        'message'     => 'Order created successfully, please complete your payment.',
                        'payment_url' => $paymentData['payment_url'],
                    ], 201)
                    : response()->json(['message' => 'Failed to create payment URL.'], 500);
            }

            // COD: xóa giỏ hàng
            CartItem::where('cart_id', $cart->id)->delete();

            return response()->json([
                'status'        => true,
                'message'       => 'Đơn hàng đã được tạo thành công.',
                'order_id'      => $orderId,
                'total_amount'  => $totalAmount,
                'order_details' => $orderDetails,
            ], 201);

        } catch (\Exception $e) {
            Log::error('OrderController@store: Lỗi khi tạo đơn hàng.', ['exception' => $e->getMessage()]);
            return response()->json(['message' => 'An error occurred: '.$e->getMessage()], 500);
        }
    }

    /** Xử lý voucher */
    private function handleVoucher($voucherId, $totalAmount, $userId)
    {
        $voucher = Voucher::find($voucherId);
        if (!$voucher || $voucher->is_active != 1 || $voucher->quantity <= 0) {
            throw new \Exception('Voucher không hợp lệ hoặc đã hết.');
        }

        if (DB::table('voucher_usages')->where('user_id', $userId)->where('voucher_id', $voucherId)->exists()) {
            throw new \Exception('Bạn đã sử dụng voucher này rồi.');
        }

        $now = now();
        if ($now < $voucher->start_day || $now > $voucher->end_day) throw new \Exception('Voucher chưa hiệu lực hoặc đã hết hạn.');
        if ($totalAmount <= $voucher->total_min) throw new \Exception('Tổng tiền thấp hơn mức tối thiểu.');
        if ($totalAmount >= $voucher->total_max) throw new \Exception('Tổng tiền vượt quá mức tối đa.');

        $discountValue = min($voucher->discount_value, $totalAmount);
        $voucher->increment('used_times');
        $voucher->decrement('quantity');

        return [$discountValue, $voucher];
    }

    /** Sinh mã Order ID */
    private function generateOrderId()
    {
        $today = now()->format('dmY');
        $latest = Order::where('id', 'LIKE', "$today%")->latest('id')->first();
        $suffix = $latest ? (int)substr($latest->id, -4) + 1 : 1;
        return $today . str_pad($suffix, 4, '0', STR_PAD_LEFT);
    }

    // Hàm createPaymentUrl giữ nguyên code gốc
}
