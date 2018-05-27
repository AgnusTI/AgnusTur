<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use \App\Models\Sale;

class PartnerTourReportController extends Controller
{


    public function content(Request $request)
    {
        return view('reports.partner_tour.content');
    }


    public function item(Request $request)
    {
        $q = \App\Models\Sale::
        select(
            'entities.id as partner_id',
            'entities.name as partner_name',
            'sales_items.*',
            'sales.name as name',
            'items.name as item_name'
        )
            ->join('sales_items', 'sales.id', '=', 'sales_items.sale_id')
            ->join('items', 'items.id', '=', 'sales_items.item_id')
            ->join('entities', 'entities.id', '=', 'sales_items.partner_id')
        ;

        if ($request->input('filter_date') != "" ) {
            $q->where('sales_items.dt_tour', '=', $request->input('filter_date'));
        }

        $items = $q
            ->orderBy('entities.name')
            ->orderBy('entities.id')
            ->orderBy('items.name')
            ->orderBy('sales_items.dt_tour')
            ->orderBy('sales_items.hr_tour')
            ->get();


        return view("reports.partner_tour.item", ['items' => $items]);
    }
}