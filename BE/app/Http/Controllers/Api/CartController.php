<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\{Cart, CartItem, ProductVariant};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    private function buildResponse(CartItem $cartItem)
    {
        $variant = $cartItem->productVariant;
        $product = $variant->product;

        return [
            'id' => $cartItem->id,
            'product_id' => $product->id,
            'product_variant_id' => $variant->id,
            'product_name' => $product->name,
            'avatar' => $product->img_thumb ?? null,
            'color' => $variant->color->name_color ?? null,
            'size' => $variant->size->size ?? null,
            'quantity' => $cartItem->quantity,
            'price' => $cartItem->price,
            'total' => $cartItem->total,
        ];
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'product_variant_id' => 'required|exists:product_variants,id',
                'quantity' => 'required|integer|min:1',
            ]);

            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
            $variant = ProductVariant::with(['product','color','size'])->findOrFail($data['product_variant_id']);

            if ($data['quantity'] > $variant->quantity) {
                return response()->json(['message' => 'Số lượng yêu cầu vượt quá tồn kho.'], 400);
            }

            $cartItem = CartItem::firstOrNew([
                'cart_id' => $cart->id,
                'product_variant_id' => $variant->id,
            ]);

            $newQty = $cartItem->exists ? $cartItem->quantity + $data['quantity'] : $data['quantity'];
            if ($newQty > $variant->quantity) {
                return response()->json(['message' => 'Số lượng tổng cộng vượt quá tồn kho.'], 400);
            }

            $cartItem->fill([
                'product_id' => $variant->product_id,
                'color_id' => $variant->color_id,
                'size_id' => $variant->size_id,
                'quantity' => $newQty,
                'price' => $variant->effective_price,
                'total' => $newQty * $variant->effective_price,
            ])->save();

            return response()->json($this->buildResponse($cartItem) + ['message' => 'Đã thêm vào giỏ hàng.'], 201);
        } catch (\Exception $e) {
            Log::error('CartController@store error: '.$e->getMessage());
            return response()->json(['message' => 'Lỗi: '.$e->getMessage()], 500);
        }
    }

    public function show($userId)
    {
        try {
            $cart = Cart::firstOrCreate(['user_id' => $userId]);
            $items = CartItem::with(['productVariant.product','productVariant.color','productVariant.size'])
                ->where('cart_id', $cart->id)->get();

            return response()->json([
                'status' => true,
                'cart_items' => $items->map(fn($i) => $this->buildResponse($i))->filter()->values(),
                'message' => 'Thông tin giỏ hàng.',
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Lỗi: '.$e->getMessage()], 500);
        }
    }

    public function update(Request $request, $itemId)
    {
        try {
            $data = $request->validate([
                'quantity' => 'nullable|integer|min:1',
                'product_variant_id' => 'nullable|exists:product_variants,id',
            ]);

            $item = CartItem::with('productVariant')->findOrFail($itemId);
            $variant = $item->productVariant;

            if (isset($data['product_variant_id'])) {
                $variant = ProductVariant::findOrFail($data['product_variant_id']);
                $item->fill([
                    'product_id' => $variant->product_id,
                    'product_variant_id' => $variant->id,
                    'color_id' => $variant->color_id,
                    'size_id' => $variant->size_id,
                    'price' => $variant->effective_price,
                ]);
            }

            if (isset($data['quantity'])) {
                if ($data['quantity'] > $variant->quantity) {
                    return response()->json(['message' => 'Số lượng vượt quá tồn kho.', 'available_quantity' => $variant->quantity], 400);
                }
                $item->quantity = $data['quantity'];
            }

            $item->total = $item->quantity * $variant->effective_price;
            $item->save();

            return response()->json($this->buildResponse($item) + [
                'message' => 'Giỏ hàng đã cập nhật.',
                'available_quantity' => $variant->quantity,
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Lỗi: '.$e->getMessage()], 500);
        }
    }

    public function destroy($itemId)
    {
        try {
            CartItem::findOrFail($itemId)->delete();
            return response()->json(['message' => 'Đã xóa sản phẩm khỏi giỏ hàng.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Lỗi: '.$e->getMessage()], 500);
        }
    }

    public function clearCart($userId)
    {
        try {
            $cart = Cart::where('user_id',$userId)->first();
            if (!$cart) return response()->json(['message'=>'Không tìm thấy giỏ hàng.'],404);

            $count = CartItem::where('cart_id',$cart->id)->delete();
            return response()->json(['message'=>'Đã xóa giỏ hàng.','deleted_items_count'=>$count]);
        } catch (\Exception $e) {
            return response()->json(['message'=>'Lỗi: '.$e->getMessage()],500);
        }
    }

    public function getSelectedItems(Request $request)
    {
        try {
            $data = $request->validate([
                'cart_item_ids' => 'required|array|min:1',
                'cart_item_ids.*' => 'integer|exists:cart_items,id',
            ]);

            $items = CartItem::with(['productVariant.product','productVariant.color','productVariant.size'])
                ->whereIn('id',$data['cart_item_ids'])
                ->whereHas('cart', fn($q)=>$q->where('user_id',Auth::id()))
                ->get();

            if ($items->count() !== count($data['cart_item_ids'])) {
                return response()->json(['message'=>'Cart items không hợp lệ.'],400);
            }

            return response()->json([
                'status'=>true,
                'cart_items'=>$items->map(fn($i)=>$this->buildResponse($i))->values(),
                'message'=>'Thông tin sản phẩm đã chọn.',
            ]);
        } catch (\Exception $e) {
            return response()->json(['message'=>'Lỗi: '.$e->getMessage()],500);
        }
    }
}
