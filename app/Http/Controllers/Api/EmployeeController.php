<?php

namespace App\Http\Controllers\Api;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    public function searchEmployees(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'divisions_id' => 'required|exists:divisions,id',
        ]);

        // Ambil input
        $name = $request->input('name');
        $divisions_id = $request->input('divisions_id');

        // Query karyawan berdasarkan name dan division_id
        $query = Employee::with('Division');

        if ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        }

        if ($divisions_id) {
            $query->where('divisions_id', $divisions_id);
        }

        $employees = $query->paginate(10);

        // Cek apakah data ditemukan
        if ($employees->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak ada pegawai yang ditemukan',
                'data' => [
                    'employees' => [],
                ],
                'pagination' => [
                    'current_page' => $employees->currentPage(),
                    'total_pages' => $employees->lastPage(),
                    'per_page' => $employees->perPage(),
                    'total' => $employees->total(),
                ],
            ], 200); // Status code 200
        }

        // Format data
        $formattedEmployees = collect($employees->items())->map(function ($employee) {
            return [
                'id' => $employee->id,
                'image' => $employee->image,
                'name' => $employee->name,
                'phone' => $employee->phone,
                'division' => [
                    'id' => $employee->division->id,
                    'name' => $employee->division->name,
                ],
                'position' => $employee->position,
            ];
        });

        // Kembalikan respons JSON
        return response()->json([
            'status' => 'success',
            'message' => 'Employees berhasil ditampilkan',
            'data' => [
                'employees' => $formattedEmployees,
            ],
            'pagination' => [
                'current_page' => $employees->currentPage(),
                'total_pages' => $employees->lastPage(),
                'per_page' => $employees->perPage(),
                'total' => $employees->total(),
            ],
        ]);
    }


    public function store(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'image' => 'nullable',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string',
            'divisions_id' => 'required|exists:divisions,id',
            'position' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => "error",
                'message' => 'Validation failed',
                'data' => $validator->errors(),
            ], 422);
        }

        if ($request->hasFile('image')) {
            $fileName = 'foto-' . uniqid() . '.' . $request->file('image')->extension();
            $request->file('image')->move(public_path('foto_pegawai'), $fileName);
        } else {
            $fileName = '';
        }

        $employee = Employee::create([
            'image' => $fileName,
            'name' => $request->name,
            'phone' => $request->phone,
            'divisions_id' => $request->divisions_id,
            'position' => $request->position,
        ]);

        return response()->json([
            'success' => "succes",
            'message' => 'Employee created successfully',
            'data' => $employee,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $fotoLama = Employee::where('id', $id)->value('image');

        $validator = validator()->make($request->all(), [
            'image' => 'nullable',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string',
            'divisions_id' => 'required|exists:divisions,id',
            'position' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        if (!empty($request->image)) {
            if (!empty($fotoLama)) {
                unlink(public_path('foto_pegawai/' . $fotoLama));
            }

            $fileName = 'image-' . $request->id . '.' . $request->image->extension();

            $request->image->move(public_path('foto_pegawai'), $fileName);
        } else {
            $fileName = $fotoLama;
        }

        $data = Employee::whereId($id)->update([
            'image' => $fileName,
            'name' => $request->name,
            'phone' => $request->phone,
            'divisions_id' => $request->divisions_id,
            'position' => $request->position,
        ]);


        return response()->json([
            'status' => 'success',
            'message' => 'Employee Berhasil Diupdate',
            'data' => $data,
        ]);
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Employee Berhasil Dihapus',
        ]);
    }


}
