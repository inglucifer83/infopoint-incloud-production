<?php

namespace App\Http\Controllers;

use App\Http\Requests\LingueUserRequest;
use App\Models\LingueUser;
use Illuminate\Http\Request;

class LingueUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(LingueUserRequest $req)
    {
        $lingueuser = new LingueUser();

        $lingueuser->lingua_id = $req->input('linguaParlata');
        $lingueuser->user_id = $req->input('user_id');
        
        $lingueuser->save();

        $lingueuserId = $lingueuser->id;

        return $lingueuserId;
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LingueUser  $lingueUser
     * @return \Illuminate\Http\Response
     */
    public function show(LingueUser $lingueUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LingueUser  $lingueUser
     * @return \Illuminate\Http\Response
     */
    public function edit(LingueUser $lingueUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LingueUser  $lingueUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LingueUser $lingueUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LingueUser  $lingueUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(LingueUser $lingueuser)
    {
        $res = $lingueuser->delete();
        return ''.$res;
    }
}
