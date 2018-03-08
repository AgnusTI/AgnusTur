<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function show()
    {
        return view("backpack::base.home.home");
    }

    public function sales(Request $request)
    {

        $q = \App\Models\Sale::
            select('sales.name', 
                'hotels.name as hotel_name', 
                'hotels.address as hotel_address', 
                'items.name as item_name', 
                'sales_items.*',
                'users.name as user_name'
                )
            ->join('hotels', 'hotels.id', '=', 'sales.hotel_id', 'left outer')
            ->join('sales_items', 'sales.id', '=', 'sales_items.sale_id')
            ->join('items', 'items.id', '=', 'sales_items.item_id')
            ->join('users', 'users.id', '=', 'sales.user_id', 'left outer');

        if ($request->input('begin_date') != "" && $request->input('end_date') != "")
        {
            $q->whereBetween('sales_items.dt_tour', [$request->input('begin_date'), $request->input('end_date')]);
        

            $items = $q
                ->orderBy('sales_items.dt_tour')
                ->orderBy('sales_items.hr_tour')
                ->get();
            
            
            return view("backpack::base.home.inc.sales", ['items' => $items]);
        }
    }

    public function logisticsReport(Request $request)
    {

        $q = \App\Models\Sale::
            select('sales.name', 
                'hotels.name as hotel_name', 
                'hotels.address as hotel_address', 
                'items.name as item_name', 
                'sales_items.*',
                'users.name as user_name'
                )
            ->join('hotels', 'hotels.id', '=', 'sales.hotel_id', 'left outer')
            ->join('sales_items', 'sales.id', '=', 'sales_items.sale_id')
            ->join('items', 'items.id', '=', 'sales_items.item_id')
            ->join('users', 'users.id', '=', 'sales.user_id', 'left outer')
            ;

        if ($request->input('begin_date') != "" && $request->input('end_date') != "")
        {
            $q->whereBetween('sales_items.dt_tour', [$request->input('begin_date'), $request->input('end_date')]);
        

            $items = $q
                ->orderBy('sales_items.dt_tour')
                ->orderBy('sales_items.hr_tour')
                ->get();
            
            
            return view("backpack::base.home.inc.sales", ['items' => $items]);
        }
    }
}