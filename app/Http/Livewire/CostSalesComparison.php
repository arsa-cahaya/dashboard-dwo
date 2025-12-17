<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CostSalesComparison extends Component
{
    public $scatterData = [];

    public function mount()
    {
        // Contoh: ambil data cost & sales per produk
        $sales = DB::table('factsales')
            ->select('ProductKey', DB::raw('SUM(linetotal) as total_sales'))
            ->groupBy('ProductKey');

        $costs = DB::table('factpurchasing')
            ->select('ProductKey', DB::raw('SUM(linetotal) as total_cost'))
            ->groupBy('ProductKey');

        $scatter = DB::table(DB::raw("({$sales->toSql()}) as s"))
            ->mergeBindings($sales) // agar binding parameter ikut
            ->joinSub($costs, 'c', function ($join) {
                $join->on('s.ProductKey', '=', 'c.ProductKey');
            })
            ->select('s.ProductKey', 's.total_sales', 'c.total_cost')
            ->get();

        $this->scatterData = $scatter->map(function ($item) {
            return [(float) $item->total_cost, (float) $item->total_sales];
        })->toArray();
    }

    public function render()
    {
        return view('livewire.cost-sales-comparison');
    }
}
