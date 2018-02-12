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
            $results = Entity::where('type', 'like', '%'.$entityType.'%')
                ->where('name', 'ilike', '%'.$search_term.'%')->paginate(10);
        }
        else
        {
            $results = Entity::where('type', 'ilike', '%'.$entityType.'%')->paginate(10);
        }

        return $results;
    }

    public function find($id)
    {
        return Entity::find($id);
    }
}
