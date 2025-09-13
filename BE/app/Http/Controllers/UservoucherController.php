<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UservoucherController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $now = now();
        // Voucher có thể sử dụng: đang active, chưa dùng, còn hạn
        $usableVouchers = Voucher::where('is_active', 1)
            ->where('start_day', '<=', $now)
            ->where('end_day', '>=', $now)
            ->whereDoesntHave('voucherUsages', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->paginate(8);

        // Voucher không thể sử dụng: đã dùng, hết hạn, không active
        $unusableVouchers = Voucher::where(function($query) use ($userId, $now) {
                $query->where('is_active', 0)
                    ->orWhere('end_day', '<', $now)
                    ->orWhereHas('voucherUsages', function ($q) use ($userId) {
                        $q->where('user_id', $userId);
                    });
            })
            ->paginate(8);

        return view('user.voucher', compact('usableVouchers', 'unusableVouchers'));
    }


    }
