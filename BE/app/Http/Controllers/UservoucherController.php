<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UservoucherController extends Controller
{
    public function index()
    {
        $search = request('search');
        $userId = Auth::id();
        $now = \Carbon\Carbon::now();

        $usableVouchers = Voucher::where('is_active', 1)
            ->where('start_day', '<=', $now)
            ->where('end_day', '>=', $now)
            ->whereRaw('quantity > used_times')
            ->whereDoesntHave('voucherUsages', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            });
        if ($search) {
            $usableVouchers = $usableVouchers->where('code', 'like', "%$search%");
        }
        $usableVouchers = $usableVouchers->paginate(8);

        $unusableVouchers = Voucher::where(function($query) use ($userId, $now) {
                $query->where('is_active', 0)
                    ->orWhere('end_day', '<', $now)
                    ->orWhereRaw('quantity <= used_times')
                    ->orWhereHas('voucherUsages', function ($q) use ($userId) {
                        $q->where('user_id', $userId);
                    });
            });
        if ($search) {
            $unusableVouchers = $unusableVouchers->where('code', 'like', "%$search%");
        }
        $unusableVouchers = $unusableVouchers->paginate(8);

        return view('user.voucher', compact('usableVouchers', 'unusableVouchers', 'search'));
    }


    }
