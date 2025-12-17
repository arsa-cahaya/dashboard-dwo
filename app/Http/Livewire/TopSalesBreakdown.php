<?php

namespace App\Http\Livewire;

use App\Models\FactSales;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TopSalesBreakdown extends Component
{
    public array $totals = [];
    public array $years = [];


    public $labels = [];
    public $values = [];

    public $topProducts = [];
    public $topTotals = [];


    public array $availableYears = [];
    public ?string $selectedYear = null;

    public function updatedSelectedYear($value)
    {
        $this->selectedYear = $value !== '' ? $value : null;
        $this->loadData();
    }

    public function mount()
    {
        $this->selectedYear = null;

        $this->availableYears = FactSales::query()
            ->join('DimTime', 'factsales.TimeKey', '=', 'DimTime.TimeKey')
            ->select('DimTime.Year')
            ->distinct()
            ->orderBy('DimTime.Year')
            ->pluck('Year')
            ->toArray();

        $this->loadData();
    }

    private function loadData()
    {
        $baseQuery = DB::table('FactSales')
            ->leftJoin('DimProduct', 'FactSales.ProductKey', '=', 'DimProduct.ProductKey')
            ->leftJoin('DimTime', 'FactSales.TimeKey', '=', 'DimTime.TimeKey');

        if ($this->selectedYear) {
            $baseQuery->where('DimTime.Year', $this->selectedYear);
        }

        // PIE chart
        $catQuery = clone $baseQuery;
        $cat = $catQuery
            ->selectRaw('CASE WHEN Category IS NULL OR Category = "" THEN "Tanpa Kategori" ELSE Category END AS category, SUM(LineTotal) AS total')
            ->groupBy('category')
            ->get();

        $this->labels = $cat->pluck('category')->toArray();
        $this->values = $cat->pluck('total')->map(fn($v) => floatval($v ?? 0))->toArray();

        // TOP 5 products
        $topQuery = clone $baseQuery;
        $top = $topQuery
            ->selectRaw('ProductName, SUM(LineTotal) AS total')
            ->groupBy('ProductName')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $this->topProducts = $top->pluck('ProductName')->toArray();
        $this->topTotals = $top->pluck('total')->map(fn($v) => floatval($v ?? 0))->toArray();

        // TOTAL Sales per year / atau per filter
        $totalQuery = clone $baseQuery;

        $totals = $totalQuery
            ->selectRaw('DimTime.Year, SUM(LineTotal) AS total')
            ->groupBy('DimTime.Year')
            ->orderBy('DimTime.Year')
            ->get();

        $this->years = $totals->pluck('Year')->toArray();
        $this->totals = $totals->pluck('total')->map(fn($v) => floatval($v ?? 0))->toArray();

        $this->dispatchBrowserEvent('updateCharts', [
            'labels' => $this->labels,
            'values' => $this->values,
            'topLabels' => $this->topProducts,
            'topTotals' => $this->topTotals,
        ]);
    }


    public function render()
    {
        return view('livewire.top-sales-breakdown');
    }
}
