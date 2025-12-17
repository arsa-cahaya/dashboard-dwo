<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CostByCategory extends Component
{
    public array $categories = [];
    public array $subcategories = [];
    public array $labels = [];
    public array $totals = [];

    public float $totalCost = 0;
    public float $prevCost = 0;
    public float $growthPct = 0;

    public ?string $selectedCategory = null;
    public ?string $selectedSubcategory = null;

    public function mount()
    {
        $this->selectedCategory = ''; // BUKAN null

        $this->categories = DB::table('DimProduct')
            ->selectRaw('COALESCE(NULLIF(Category, ""), "Uncategorized") AS Category')
            ->distinct()
            ->orderBy('Category')
            ->pluck('Category')
            ->toArray();

        $this->loadChart(); // ini penting
    }

    public function updatedSelectedCategory($value)
    {
        $this->selectedSubcategory = null;

        if (!empty($value)) {
            $this->subcategories = DB::table('DimProduct')
                ->where('Category', $value)
                ->whereNotNull('SubCategory')
                ->whereRaw('TRIM(SubCategory) != ""')
                ->distinct()
                ->pluck('SubCategory')
                ->toArray();
        } else {
            $this->subcategories = [];
        }

        $this->loadChart();
    }

    public function updatedSelectedSubcategory()
    {
        $this->loadChart();
    }

    private function loadChart()
    {
        $query = DB::table('FactPurchasing')
            ->join('DimProduct', 'FactPurchasing.ProductKey', '=', 'DimProduct.ProductKey');

        /**
         * LEVEL 1 — ALL CATEGORY
         */
        if (empty($this->selectedCategory)) {

            $data = $query
                ->selectRaw('
                    CASE
                        WHEN (DimProduct.Category IS NULL OR TRIM(DimProduct.Category) = "")
                        AND (DimProduct.SubCategory IS NULL OR TRIM(DimProduct.SubCategory) = "")
                        THEN "Tanpa Category"
                        ELSE DimProduct.Category
                    END AS label,
                    SUM(FactPurchasing.LineTotal) AS total
                ')
                ->groupBy(DB::raw('
                    CASE
                        WHEN (DimProduct.Category IS NULL OR TRIM(DimProduct.Category) = "")
                        AND (DimProduct.SubCategory IS NULL OR TRIM(DimProduct.SubCategory) = "")
                        THEN "Tanpa Category"
                        ELSE DimProduct.Category
                    END
                '))
                ->orderByDesc('total')
                ->get();
        }


        /**
         * LEVEL 2 — CATEGORY → SUBCATEGORY
         */
        elseif ($this->selectedCategory && !$this->selectedSubcategory) {

            $data = $query
                ->when($this->selectedCategory === 'Uncategorized', function ($q) {
                    $q->where(function ($x) {
                        $x->whereNull('DimProduct.Category')
                            ->orWhereRaw('TRIM(DimProduct.Category) = ""');
                    });
                }, function ($q) {
                    $q->where('DimProduct.Category', $this->selectedCategory);
                })
                ->selectRaw('
            COALESCE(NULLIF(DimProduct.SubCategory, ""), "Others") AS label,
            SUM(FactPurchasing.LineTotal) AS total
        ')
                ->groupBy(DB::raw('COALESCE(NULLIF(DimProduct.SubCategory, ""), "Others")'))
                ->orderByDesc('total')
                ->get();
        }

        /**
         * LEVEL 3 — SUBCATEGORY → PRODUCT
         */
        else {

            $data = $query
                ->where('DimProduct.Category', $this->selectedCategory)
                ->where('DimProduct.SubCategory', $this->selectedSubcategory)
                ->selectRaw('
                DimProduct.ProductName AS label,
                SUM(FactPurchasing.LineTotal) AS total
            ')
                ->groupBy('DimProduct.ProductName')
                ->orderByDesc('total')
                ->get();
        }

        $this->labels = $data->pluck('label')->toArray();
        $this->totals = $data->pluck('total')->toArray();

        $this->totalCost = array_sum($this->totals);

        $this->dispatchBrowserEvent('update-chart', [
            'labels' => $this->labels,
            'totals' => $this->totals,
        ]);
    }


    public function render()
    {
        return view('livewire.cost-by-category');
    }
}
