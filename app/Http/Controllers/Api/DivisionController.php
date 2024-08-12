<?php

namespace App\Http\Controllers\Api;

use App\Models\Division;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DivisionController extends Controller
{
    public function searchDivisions(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $name = $request->input('name');

        $divisions = Division::where('name', 'like', '%' . $name . '%')->paginate(10);

        $formattedDivisions = $divisions->map(function ($division) {
            return [
                'id' => $division->id,
                'name' => $division->name,
            ];
        });

        if ($divisions->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak ada divisi yang ditemukan',
                'data' => [
                    'divisions' => [],
                ],
                'pagination' => [
                    'current_page' => $divisions->currentPage(),
                    'total_pages' => $divisions->lastPage(),
                    'per_page' => $divisions->perPage(),
                    'total' => $divisions->total(),
                ],
            ], 404);
        } else {
            $formattedDivisions = $divisions->map(function ($division) {
                return [
                    'id' => $division->id,
                    'name' => $division->name,
                ];
            });
            return response()->json([
                'status' => 'success',
                'message' => 'Divisi berhasil ditemukan',
                'data' => [
                    'divisions' => $formattedDivisions,
                ],
                'pagination' => [
                    'current_page' => $divisions->currentPage(),
                    'total_pages' => $divisions->lastPage(),
                    'per_page' => $divisions->perPage(),
                    'total' => $divisions->total(),
                ],
            ]);
        }
    }
}