<?php

namespace App\Http\Controllers;


use App\Models\todolist;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class todolistController extends Controller
{
    protected $user;
 
    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->user
            ->todolist()
            ->get();
    }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
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
        //Validate data
        $data = $request->only('title', 'description');
        $validator = Validator::make($data, [
            'title' => 'required|string',
            'description' => 'required'
        
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is valid, create new todolist
        $todolist = $this->user->todolist()->create([
            'title' => $request->title,
            'description' => $request->description
        ]);

        //todolist created, return success response
        return response()->json([
            'success' => true,
            'message' => 'list data created successfully',
            'data' => $todolist
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\todolist  $todolist
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $todolist = $this->user->todolist()->find($id);
    
        if (!$todolist) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, list-data not found.'
            ], 400);
        }
    
        return $todolist;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\todolist  $todolist
     * @return \Illuminate\Http\Response
     */
    public function edit(todolist $todolist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\todolist  $todolist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, todolist $todolist)
    {
        //Validate data
        $data = $request->only('title', 'description');
        $validator = Validator::make($data, [
            'title' => 'required|string',
            'description' => 'required'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is valid, update todolist
        $todolist = $todolist->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        //todolist updated, return success response
        return response()->json([
            'success' => true,
            'message' => 'list-data updated successfully',
            'data' => $todolist
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\todolist  $todolist
     * @return \Illuminate\Http\Response
     */
    public function destroy(todolist $todolist)
    {
        $todolist->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'todolist deleted successfully'
        ], Response::HTTP_OK);
    }
}