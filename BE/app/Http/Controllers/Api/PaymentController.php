<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\{Order, Payment, Voucher_usage, Cart, CartItem, Order_detail, ProductVariant, Voucher};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function handlePaymentResult(Request $request)
    {
        try {
            Log::info('Payment result received', ['data' => $request->all()]);

            $vnpAmount       = $request->input('vnp_Amount');
            $vnpTransactionNo= $request->input('vnp_TransactionNo');
            $vnpResponseCode = $request->input('vnp_ResponseCode');
            $vnpTxnRef       = $request->input('vnp_TxnRef');
            $vnpSecureHash   = $request->input('vnp_SecureHash');
            $hashSecret      = env('VNP_HASH_SECRET');

            // Xác thực chữ ký
            if ($vnpSecureHash !== $this->generateVNPaySecureHash($request, $hashSecret)) {
                Log::warning('Invalid secure hash', ['vnp_TxnRef' => $vnpTxnRef]);
                return response()->json(['message' => 'Invalid secure hash.'], 400);
            }

            $order = Order::find($vnpTxnRef);
            if (!$order) return redirect('http://localhost:3000/order-error');

            // Thành công
            if ($vnpResponseCode === '00') {
                if (Payment::where('order_id', $order->id)->where('status', 'success')->exists()) {
                    return redirect('http://localhost:3000/thank');
                }

                Payment::create([
                    'order_id'      => $order->id,
                    'transaction_id'=> $vnpTransactionNo,
                    'payment_method'=> 'online',
                    'amount'        => $vnpAmount / 100,
                    'status'        => 'success',
                    'response_code' => $vnpResponseCode,
                    'secure_hash'   => $vnpSecureHash,
                ]);

                $order->update(['status' => 1, 'message' => 'Đã thanh toán thành công']);

                if ($cart = Cart::where('user_id', $order->user_id)->first()) {
                    CartItem::where('cart_id', $cart->id)->delete();
                }

                Log::info('Payment successful', ['order_id' => $order->id]);
                return redirect('http://localhost:3000/thank');
            }

            // Thất bại
            if (Payment::where('order_id', $order->id)->where('status', 'failed')->exists()) {
                return redirect('http://localhost:3000/order-error');
            }

            Payment::create([
                'order_id'      => $order->id,
                'transaction_id'=> $vnpTransactionNo,
                'payment_method'=> 'online',
                'amount'        => $vnpAmount / 100,
                'status'        => 'failed',
                'response_code' => $vnpResponseCode,
                'secure_hash'   => $vnpSecureHash,
            ]);

            // Khôi phục tồn kho
            foreach (Order_detail::where('order_id', $order->id)->get() as $detail) {
                if ($variant = ProductVariant::find($detail->product_variant_id)) {
                    $variant->increment('quantity', $detail->quantity);
                }
            }

            // Hoàn trả voucher
            if ($voucherUsage = Voucher_usage::where('order_id', $order->id)->first()) {
                if ($voucher = Voucher::find($voucherUsage->voucher_id)) {
                    $voucher->increment('quantity');
                    $voucher->decrement('used_times');
                }
                $voucherUsage->delete();
            }

            $order->update([
                'status'  => 4,
                'message' => 'Đơn hàng của bạn đã bị hủy do thanh toán thất bại'
            ]);

            return redirect('http://localhost:3000/order-error');

        } catch (\Exception $e) {
            Log::error('Payment handling error', ['error' => $e->getMessage(), 'request_data' => $request->all()]);
            return redirect('http://localhost:3000');
        }
    }

    private function generateVNPaySecureHash(Request $request, $secretKey)
    {
        $params = $request->except('vnp_SecureHash');
        ksort($params);
        return hash_hmac('sha512', urldecode(http_build_query($params)), $secretKey);
    }

    public function checkPaymentStatus($orderId)
    {
        try {
            $order = Order::with('payment')->find($orderId);
            if (!$order) return response()->json(['message' => 'Không tìm thấy đơn hàng'], 404);

            if (!$order->payment) {
                return response()->json([
                    'order_id' => $order->id,
                    'payment_status' => 'pending',
                    'message' => 'Chưa có thông tin thanh toán'
                ]);
            }

            return response()->json([
                'order_id'       => $order->id,
                'payment_status' => $order->payment->status,
                'transaction_id' => $order->payment->transaction_id,
                'amount'         => $order->payment->amount,
                'response_code'  => $order->payment->response_code,
                'order_status'   => $order->status,
                'order_message'  => $order->message
            ]);
        } catch (\Exception $e) {
            Log::error('Check payment status error', ['error' => $e->getMessage(), 'order_id' => $orderId]);
            return response()->json(['message' => 'Lỗi khi kiểm tra trạng thái thanh toán'], 500);
        }
    }
}
