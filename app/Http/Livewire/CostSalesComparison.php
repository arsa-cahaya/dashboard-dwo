<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CostSalesComparison extends Component
{
    public $chartData = [];

    public function mount()
    {
        // Total sales per year
        $sales = DB::table('factsales as f')
            ->join('dimtime as t', 'f.TimeKey', '=', 't.TimeKey')
            ->select('t.Year', DB::raw('SUM(f.LineTotal) as total_sales'))
            ->groupBy('t.Year');

        // Total cost per year
        $costs = DB::table('factpurchasing as fp')
            ->join('dimtime as t', 'fp.TimeKey', '=', 't.TimeKey')
            ->select('t.Year', DB::raw('SUM(fp.LineTotal) as total_cost'))
            ->groupBy('t.Year');

        // Gabungkan sales & cost
        $chart = DB::table(DB::raw("({$sales->toSql()}) as s"))
            ->mergeBindings($sales)
            ->leftJoinSub($costs, 'c', 's.Year', '=', 'c.Year')
            ->select(
                's.Year',
                DB::raw('COALESCE(s.total_sales,0) as total_sales'),
                DB::raw('COALESCE(c.total_cost,0) as total_cost'),
                DB::raw('(COALESCE(s.total_sales,0) - COALESCE(c.total_cost,0)) / NULLIF(COALESCE(s.total_sales,0),0) * 100 as profit_margin')
            )
            ->orderBy('s.Year')
            ->get();

        $this->chartData = $chart->map(function ($item) {
            return [
                'year' => $item->Year,
                'cost' => (float) $item->total_cost,
                'sales' => (float) $item->total_sales,
                'profit_margin' => (float) $item->profit_margin
            ];
        })->toArray();
    }

    public function render()
    {
        return view('livewire.cost-sales-comparison');
    }
}
