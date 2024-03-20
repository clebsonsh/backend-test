<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RedirectStatsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Redirect $redirect)
    {
        $total_accesses_last_10_days = [];

        for ($i = 0; $i < 10; $i++) {
            $date = now()->subDays($i)->format('Y-m-d');
            $total_accesses_last_10_days[] = (object) [
                'date' => $date,
                'total' => $redirect->logs()
                    ->whereDate('created_at', $date)
                    ->count(),
                'unique' => $redirect->logs()
                    ->whereDate('created_at', $date)
                    ->distinct('ip_address')->count('ip_address')
            ];
        }

        $stats = [
            'total_accesses' => $redirect->logs()->count(),
            'total_unique_accesses' => $redirect->logs()->distinct('ip_address')->count('ip_address'),
            'top_referers' => $redirect->logs()->select('referer', DB::raw('count(*) as count'))
                ->groupBy('referer')
                ->orderByDesc('count')
                ->limit(5)
                ->get()
                ->pluck('referer'),
            'total_accesses_last_10_days' => $total_accesses_last_10_days
        ];

        return response()->json($stats);
    }
}
