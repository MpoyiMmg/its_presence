<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Professor;
use Illuminate\Http\Request;
use Exception;
use Validator;

class ProfessorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $professors = Professor::all();
        } catch (Exception  $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ], 500);
        }
        return response()->json([
            'data' => $professors
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
        $firstName = $request->firstName;
        $middleName = $request->middleName;
        $lastName = $request->lastName;
        $fullName = $firstName + ' ' + $middleName + ' ' + $lastName;
        try {
            $professorValidation = Validator::make($request->all(), [
                'gender' => 'required|max:10',
            ]);
            if ($professorValidation->fails()) {
                return response()->json([
                    'errors' => $professorValidation->errors()
                ], 422);
            } else {
                // Inserting a new account.
                $account = Account::create([
                    'email' => $request->email,
                    'password' => $request->password,
                    'account_type' => $request->accountType,
                    'is_deleted' => false,
                ]);
                $account->save();
                // Inserting a new professor.
                $professor = Professor::create([
                    'fullname' => $fullName,
                    'matricule' => $request->matricule,
                    'gender' => $request->gender,
                    'account_id' => $account->id,
                ]);
                $professor->save();
            }
        } catch(Exception $exception) {
            return response()->json([
                'errors' => $exception->getMessage()
            ], 500);
        }
        return response()->json([
            'data' => $professor
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Professor  $professor
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Professor $professor)
    {
        try {
            $professor = Professor::find($request->id);
            if (empty($professor)) {
                return response()->json([
                    'message' => 'Aucun professeur coresspondant.'
                ], 404);
            }

        } catch (Exception $exception) {
            return response()->json([
                'error' => $e->getMessage() 
            ], 500);
        }
        return response()->json([
            "professor" => $professor,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Professor  $professor
     * @return \Illuminate\Http\Response
     */
    public function edit(Professor $professor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Professor  $professor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Professor $professor)
    {
        try {
            $professorValidation = Validator::make($request->all(), [
                'gender' => 'required|max:10',
            ]);
            if ($professorValidation->fails()) {
                return response()->json([
                    'errors' => $professorValidation->errors()
                ], 422);
            } else {
                $professor = $professor->find($request->id);
                if (empty($professor)) {
                    return response()->json([
                        'message' => 'Aucun professeur correspondant.'
                    ], 404);
                } else {
                    Professor::where('id', $professor->id)->delete();
                } 
            }
        } catch(Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 500);
        }
        return response()->json([
            "message" => "Professeur supprimé avec succès.",
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Professor  $professor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Professor $professor)
    {
        try {
            $professor = $professor->find($request->id);
            if (empty($professor)) {
                return response()->json([
                    'message' => 'Aucun professeur correspondant.'
                ], 404);
            } else {
                Professor::where('id', $professor->id)->delete();
            } 
        } catch(Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 500);
        }
        return response()->json([
            "message" => "Professeur supprimé avec succès.",
        ], 200);
    }
}
