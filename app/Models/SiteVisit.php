<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SiteVisit extends Model
{
    use HasFactory;

    protected $guarded = [];

    final public function get_dashboard_data(): array
    {
        if (Cache::has('dash_visitors_data')) {
            return Cache::get('dash_visitors_data');
        }
        $dash_data = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $data = SiteVisit::query()
                ->whereYear('date', $month->year)
                ->whereMonth('date', $month->month)
                ->sum('count');

            $dash_data['month'][] = $month->format('M');
            $dash_data['data'][]  = $data;
        }

        //cache for 24 hr
        Cache::put('dash_visitors_data', $dash_data, 60 * 24);
        return $dash_data;
    }

    final function prepare_data(): array
    {
        return [
            'date'  => now(),
            'count' => 0,
        ];
    }

    final public function get_current_data(): SiteVisit
    {
        if (Cache::has('visitors_data')) {
            return Cache::get('visitors_data');
        }

        $site_data = SiteVisit::query()->whereDate('date', now())->first();
        if (!$site_data) {
            $site_data = self::create($this->prepare_data());
        }

        Cache::put('visitors_data', $site_data, 60 * 30);
        return $site_data;
    }

    final public function increase_count(SiteVisit $site_visit): bool
    {
        $site_visit->increment('count');
        return true;
    }
}
