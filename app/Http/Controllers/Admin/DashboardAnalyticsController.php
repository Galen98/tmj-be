<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardAnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $days = (int) $request->query('days', 30);

        if (!in_array($days, [7, 30, 90], true)) {
            $days = 30;
        }

        $now = Carbon::now();
        $today = $now->copy()->startOfDay();
        $tomorrow = $today->copy()->addDay();
        $monthStart = $now->copy()->startOfMonth();

        $startDate = $today->copy()->subDays($days - 1);

        $analytics = DB::table('analytics');

        /*
         * OVERVIEW
         */

        $stats = [
            'today' => (clone $analytics)
                ->where('created_at', '>=', $today)
                ->where('created_at', '<', $tomorrow)
                ->count(),

            'month' => (clone $analytics)
                ->where('created_at', '>=', $monthStart)
                ->where('created_at', '<', $tomorrow)
                ->count(),

            'total' => (clone $analytics)->count(),

            'unique' => (clone $analytics)
                ->whereNotNull('user_token_id')
                ->distinct()
                ->count('user_token_id'),

            'travelViews' => (clone $analytics)
                ->whereNotNull('travel_id')
                ->where('created_at', '>=', $startDate)
                ->where('created_at', '<', $tomorrow)
                ->count(),
        ];

        /*
         * TRAFFIC CHART
         */

        $trafficRows = DB::table('analytics')
            ->selectRaw('DATE(created_at) AS visit_date')
            ->selectRaw('COUNT(*) AS views')
            ->selectRaw(
                'COUNT(DISTINCT user_token_id) AS visitors'
            )
            ->where('created_at', '>=', $startDate)
            ->where('created_at', '<', $tomorrow)
            ->groupByRaw('DATE(created_at)')
            ->orderBy('visit_date')
            ->get()
            ->keyBy('visit_date');

        $traffic = [
            'labels' => [],
            'views' => [],
            'visitors' => [],
        ];

        for ($i = 0; $i < $days; $i++) {
            $date = $startDate->copy()->addDays($i);
            $key = $date->toDateString();
            $row = $trafficRows->get($key);

            $traffic['labels'][] = $date->format('d M');
            $traffic['views'][] = (int) ($row->views ?? 0);
            $traffic['visitors'][] = (int) ($row->visitors ?? 0);
        }

        /*
         * TRAVEL PERFORMANCE
         *
         * LEFT JOIN agar travel dengan 0 views
         * tetap muncul.
         */

        $travelStats = DB::table('travels as t')
            ->leftJoin('analytics as a', 'a.travel_id', '=', 't.id')
            ->select(
                't.id',
                't.travel_name'
            )
            ->selectRaw('COUNT(a.id) AS total_views')
            ->selectRaw(
                'SUM(CASE WHEN a.created_at >= ? AND a.created_at < ? THEN 1 ELSE 0 END) AS period_views',
                [$startDate, $tomorrow]
            )
            ->groupBy('t.id', 't.travel_name')
            ->orderByDesc('period_views')
            ->orderByDesc('total_views')
            ->limit(10)
            ->get();

        /*
         * GEOGRAPHIC ANALYTICS
         */

        $provinces = DB::table('analytics')
            ->select('province')
            ->selectRaw('COUNT(*) AS total')
            ->whereNotNull('province')
            ->where('province', '<>', '')
            ->where('created_at', '>=', $startDate)
            ->where('created_at', '<', $tomorrow)
            ->groupBy('province')
            ->orderByDesc('total')
            ->limit(8)
            ->get();

        $countries = DB::table('analytics')
            ->select('country')
            ->selectRaw('COUNT(*) AS total')
            ->whereNotNull('country')
            ->where('country', '<>', '')
            ->where('created_at', '>=', $startDate)
            ->where('created_at', '<', $tomorrow)
            ->groupBy('country')
            ->orderByDesc('total')
            ->limit(8)
            ->get();

        /*
         * POPULAR PAGES
         */

        $popularPages = DB::table('analytics')
            ->select('path')
            ->selectRaw('COUNT(*) AS total')
            ->whereNotNull('path')
            ->where('created_at', '>=', $startDate)
            ->where('created_at', '<', $tomorrow)
            ->groupBy('path')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        /*
         * DEVICE ESTIMATION
         */

        $deviceRows = DB::table('analytics')
            ->selectRaw("
                CASE
                    WHEN LOWER(COALESCE(user_agent, '')) LIKE '%ipad%'
                      OR LOWER(COALESCE(user_agent, '')) LIKE '%tablet%'
                    THEN 'Tablet'

                    WHEN LOWER(COALESCE(user_agent, '')) LIKE '%mobile%'
                      OR LOWER(COALESCE(user_agent, '')) LIKE '%android%'
                      OR LOWER(COALESCE(user_agent, '')) LIKE '%iphone%'
                    THEN 'Mobile'

                    WHEN user_agent IS NULL OR user_agent = ''
                    THEN 'Unknown'

                    ELSE 'Desktop'
                END AS device
            ")
            ->selectRaw('COUNT(*) AS total')
            ->where('created_at', '>=', $startDate)
            ->where('created_at', '<', $tomorrow)
            ->groupBy('device')
            ->get();

        /*
         * RECENT ACTIVITY
         */

        $recentActivities = DB::table('analytics as a')
            ->leftJoin('travels as t', 't.id', '=', 'a.travel_id')
            ->select(
                'a.id',
                'a.path',
                'a.country',
                'a.province',
                'a.created_at',
                'a.travel_id',
                't.travel_name as travel_title'
            )
            ->orderByDesc('a.created_at')
            ->limit(10)
            ->get();

        return view(
            'dashboard.dashboard-analytics.dashboard',
            compact(
                'days',
                'stats',
                'traffic',
                'travelStats',
                'provinces',
                'countries',
                'popularPages',
                'deviceRows',
                'recentActivities'
            )
        );
    }
}
