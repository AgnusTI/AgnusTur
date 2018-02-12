<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Hotel;

class HotelController extends Controller
{
    public function list(Request $request)
    {
        $search_term = $request->input('q');
        $page = $request->input('page');

        if ($search_term)
        {
            $results = Hotel::select('id', 'name', 'address', DB::raw("name || ' (' || address || ')' as description"))->where('name', 'ilike', '%'.$search_term.'%')->paginate(10);
            //$results = Hotel::where('name', 'ilike', '%'.$search_term.'%')->paginate(10);
        }
        else
        {
            $results = Hotel::select('id', 'name', 'address', DB::raw("name || ' (' || address || ')' as description"))->paginate(10);
            // $results = Hotel::paginate(10);
        }

        return $results;
    }

    public function find($id)
    {
        return Hotel::find($id);
    }
}
