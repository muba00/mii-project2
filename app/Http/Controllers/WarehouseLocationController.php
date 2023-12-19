<?php

namespace App\Http\Controllers;

use App\Models\WarehouseLocation;
use Illuminate\Http\Request;

class WarehouseLocationController extends Controller
{
    public function index()
    {
        $locations = WarehouseLocation::all();
        return response()->json($locations);
    }

    public function show($id)
    {
        $location = WarehouseLocation::findOrFail($id);
        return response()->json($location);
    }

    public function showByCode($code)
    {
        try {
            $location = WarehouseLocation::findByCode($code);
            return response()->json($location);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 404);
        }
    }

    public function store(Request $request)
    {
        $location = WarehouseLocation::create($request->all());
        return response()->json($location, 201);
    }

    public function update(Request $request, $id)
    {
        $location = WarehouseLocation::findOrFail($id);
        $location->update($request->all());
        return response()->json($location, 200);
    }

    public function destroy($id)
    {
        $location = WarehouseLocation::findOrFail($id);
        $location->delete();
        return response()->json(null, 204);
    }
}
