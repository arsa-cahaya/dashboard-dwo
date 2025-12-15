<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchasingTrendController extends Controller
{
    public function index()
    {
        $trend = DB::table('FactPurchasing as fp')
            ->join('DimTime as dt', 'fp.TimeKey', '=', 'dt.TimeKey')
            ->select(
                'dt.Year as year',
                DB::raw('SUM(fp.LineTotal) as total_cost')
            )
            ->groupBy('dt.Year')
            ->orderBy('dt.Year')
            ->get();

        // Hitung Year over Year
        $previous = null;
        foreach ($trend as $row) {
            if ($previous !== null) {
                $row->change_percentage = round(
                    (($row->total_cost - $previous) / $previous) * 100,
                    2
                );
            } else {
                $row->change_percentage = null;
            }
            $previous = $row->total_cost;
        }

        return view('trend', [
            'trend' => $trend
        ]);
    }
}
