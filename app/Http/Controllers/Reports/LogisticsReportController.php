<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use \App\Models\Sale;

class LogisticsReportController extends Controller
{


    public function content(Request $request)
    {
        return view('reports.logistics.content');
    }

    public function item(Request $request)
    {
        $q = \App\Models\Sale::
        select('sales.name',
            'sales.status as sale_status',
            'hotels.name as hotel_name',
            'hotels.address as hotel_address',
            'items.name as item_name',
            'sales_items.*',
            'users.name as user_name',
            'entities.name as partner_name',
            'payments.description as payment_description'
        )
            ->join('hotels', 'hotels.id', '=', 'sales.hotel_id', 'left outer')
            ->join('sales_items', 'sales.id', '=', 'sales_items.sale_id')
            ->join('items', 'items.id', '=', 'sales_items.item_id')
            ->join('users', 'users.id', '=', 'sales.user_id', 'left outer')
            ->join('entities', 'entities.id', '=', 'sales_items.partner_id', 'left outer')
            ->join('payments', 'payments.id', '=', 'sales.payment_id', 'left outer')
        ;

        if ($request->input('begin_date') != "" && $request->input('end_date') != "") {
            $q->whereBetween('sales_items.dt_tour', [$request->input('begin_date'), $request->input('end_date')]);
        }

        $items = $q
            ->orderBy('sales_items.dt_tour')
            ->orderBy('sales_items.hr_tour')
            ->get();


        return view("reports.logistics.item", ['items' => $items]);
    }

    public function update(Request $request)
    {

        $item = \App\Models\SaleItem::find($request->input('sale_item_id'));

        $item->hr_tour = $request->input('hr_tour');
        $item->partner_id = $request->input('partner_id');
        $item->save();

        $r['success'] = true;

        return "ok";
    }
}