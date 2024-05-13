<?php

namespace App\Http\Controllers\api;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $data = Vehicle::all();
            return [
                "status" => 200,
                "message" => "berhasil mendapatkan data",
                "data" => $data
            ];
        } catch(\Exception $e){
            return [
                "status" => 400,
                "message" => "Bad Request",
                "error" => $e
            ];
        }   
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $request->validate([
                "name" => "required|string",
                "desc" => "required|string",
                "type" => "required|string",
                "price" => "required|int",
            ]);

            $data = Vehicle::create([
                "name" => $request->name,
                "desc" => $request->desc,
                "type" => $request->type,
                "price" => $request->price,
            ]);

            return [
                "status" => 200,
                "message" => "Data berhasil ditambahkan",
                "data" => $data
            ];

        }catch(\Exception $e){
            return [
                "status" => 400,
                "message" => "Bad Request",
                "data" => $e
            ];
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $data = Vehicle::find($id);

            return [
                "status" => 200,
                "message" => "Berhasil mendapatkan data",
                "data" => $data
            ];
        } catch(\Exception $e){
            return [
                "status" => 400,
                "message" => "Bad Request",
                "error" => $e
            ];
        }  
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         try{
            $data = Vehicle::find($id);
            $validator = Validator::make($request->all(), [
                'name' => 'nullable|string|max:255',
                'desc' => 'nullable|string',
                'type' => 'nullable|string|max:255',
                'price' => 'nullable|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Validation error',
                    'errors' => $validator->errors(),
                ], 400);
            }

            if ($request->has('name')) {
                $data->update(['name' => $request->name]);
            }

            if ($request->has('desc')) {
                $data->update(['desc' => $request->desc]);
            }

            if ($request->has('type')) {
                $data->update(['type' => $request->type]);
            }

            if ($request->has('price')) {
                $data->update(['price' => $request->price]);
            }
            
            return [
                "status" => 200,
                "message" => "Data berhasil diperbaharui",
                "data" => $data
            ];
        } catch(\Exception $e){
            return [
                "status" => 400,
                "message" => "Bad Request",
                "error" => $e
            ];
        } 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         try{
            $data = Vehicle::find($id);
            $data->delete();

            return [
                "status" => 200,
                "message" => "Data Berhasil dihapus",
            ];
        } catch(\Exception $e){
            return [
                "status" => 400,
                "message" => "Bad Request",
                "error" => $e
            ];
        } 
    }
}
