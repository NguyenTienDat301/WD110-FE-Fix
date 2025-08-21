<?php

namespace App\Http\Controllers\Api;

use App\Events\OrderStatusUpdated;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderStatusController extends Controller
{
    /**
     * Update order status via API
     */
    public function updateStatus(Request $request, $orderId)
    {
        try {
        

            if (!in_array($newStatus, $allowedTransitions[$oldStatus])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể chuyển từ trạng thái này sang trạng thái khác'
                ], 400);
            }

            // Update order status
            $order->status = $newStatus;
            if ($request->has('message')) {
                $order->message = $request->input('message');
            }
            $order->save();

            // Broadcast the event
            event(new OrderStatusUpdated($order, $oldStatus, $newStatus, 'admin'));

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật trạng thái thành công',
                'data' => [
                    'order_id' => $order->id,
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus,
                    'status_text' => $this->getStatusText($newStatus)
                ]
            ]);

        } catch (\Exception $e) {
           
    }

    /**
     * Get order status
     */
    public function getStatus($orderId)
    {
        try {
            $order = Order::findOrFail($orderId);
            
           
            
        } catch (\Exception $e) {
           
    }

    /**
     * Get status text for display
     */
    private function getStatusText($status): string
    {
        

        return $statusMap[$status] ?? 'Không xác định';
    }
}
