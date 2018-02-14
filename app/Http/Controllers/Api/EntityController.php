<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Entity;

class EntityController extends Controller
{
    public function list(Request $request, $entityType)
    {
        $search_term = $request->input('q');
        $page = $request->input('page');

        if ($search_term)
        {
            $results = Entity::
                select('entities.*', 'hotels.name as hotel_name', 'hotels.address as hotel_address')
                ->join('hotels', 'hotels.id', '=', 'entities.hotel_id', 'left outer')
                ->where('entities.type', 'like', '%'.$entityType.'%')
                ->where('entities.name', 'ilike', $search_term.'%')
                ->orderBy('entities.name')
                ->paginate(10);
        }
        else
        {
            $results = Entity::
                select('entities.*', 'hotels.name as hotel_name', 'hotels.address as hotel_address')
                ->join('hotels', 'hotels.id', '=', 'entities.hotel_id', 'left outer')
                ->where('entities.type', 'like', '%'.$entityType.'%')
                ->orderBy('entities.name')
                ->paginate(10);
        }

        return $results;
    }

    public function find($id)
    {
        return Entity::find($id);
    }
}
