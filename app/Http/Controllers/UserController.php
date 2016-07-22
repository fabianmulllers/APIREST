<?php

namespace apirest\Http\Controllers;

use Illuminate\Http\Request;

use apirest\Http\Requests;
use apirest\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Mockery\CountValidator\Exception;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (!is_array($request->all())) {

            return ['error' => 'request must be on array'];
        }

        // Creamos las reglas de validación
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ];

        try {

            // Ejecutamos el validador, en caso de que falle devolvemos la respuesta
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return [
                    'created' => false,
                    'errors' => $validator->errors()->all()
                ];
            }

            User::create($request->all());
            return ['create' => true];

        } catch (Exception $e) {
            Log::info('Error creating user:' . $e);
            return Response::json(['create' => false], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    //public function show($id)
    public function show(User $user)
    {
        //  return User::findOrFail($id);
        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->update($request->all());
        return ['update' => true];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
        return ['deleted' => true];
    }


    public function names()
    {
        return User::all()->lists('name');
    }

}