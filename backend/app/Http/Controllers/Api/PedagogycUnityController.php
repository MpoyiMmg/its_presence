<?php

namespace App\Http\Controllers\Api;

use App\Models\unite_pedagogique;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PedagogycUnityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $pedagogic_unities = unite_pedagogique::all();
        } catch (Exception  $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ], 500);
        }
        return response()->json([
            'pedagogic_unities' => $pedagogic_unities
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        try {
            
            $this->validate($request, [
                'designation' => 'required|max:255',
                'is_deleted' => 'required',
            ]);

            $unite_pedagogique = unite_pedagogique::Create([
                'designation' => $request->designation,
                'is_deleted' => $request->is_deleted,
            ]);

        } catch(Exception $exception) {

            return response()->json([
                'error' => [
                    "message" => "Les données saisies sont invalides.",
                    "type" => "ValidationException."
                ],
            ], 422);
        }
        
        return response()->json([
            'unite_pedagogique' => $unite_pedagogique
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\unite_pedagogique  $unite_pedagogique
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,Unite_pedagogique $unite_pedagogique)
    {
        try {
            $unite_pedagogique = unite_pedagogique::find($request->id);
            if (empty($unite_pedagogique)) {
                return response()->json([
                    'message' => 'Aucune unité pedagogique coresspondante.'
                ], 404);
            }

        } catch (Exception $exception) {
            return response()->json([
                'error' => $e->getMessage() 
            ], 500);
        }
        return response()->json([
            "unite_pedagogique" => $unite_pedagogique,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\unite_pedagogique  $unite_pedagogique
     * @return \Illuminate\Http\Response
     */
    public function edit(unite_pedagogique $unite_pedagogique)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\unite_pedagogique  $unite_pedagogique
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $$unite_pedagogique_id = $request->id;

        try {
            $validator = Validator::make($request->all(), [
                'designation' => 'required|max:25',
                'is_deleted' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors(),
                ], 422);
            }            

            $unitePedagoqique = unite_pedagogique::findOrFail($unite_pedagogique_id);
            $unitePedagoqique->designation = $request->designation;
            $unitePedagoqique->is_deleted= $request->is_deleted == 1 ? true : false;
            $unitePedagoqique->save();

        } catch (Exception $exception) {

            return response()->json([
                'error' => $exception->getMessage(),
            ], 500);
        }

        return response()->json([
            'unitePedagoqique' => $unitePedagoqique,
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\unite_pedagogique  $unite_pedagogique
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Unite_pedagogique $unite_pedagogique)
    {
        try {
            $unite_pedagogique = $unite_pedagogique->find($request->id);
            if (empty($unite_pedagogique)) {
                return response()->json([
                    'message' => 'Aucune unité pedagogique correspondante.'
                ], 404);
            } else {
                unite_pedagogique::where('id', $unite_pedagogique->id)->delete();
            } 
        } catch(Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 500);
        }
        return response()->json([
            "message" => "L'Unité pedagogique a été supprimée avec succès.",
        ], 200);
    }
    }