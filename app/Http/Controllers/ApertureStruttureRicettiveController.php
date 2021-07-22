<?php

namespace App\Http\Controllers;

use App\Models\ApertureStruttureRicettive;
use Illuminate\Http\Request;

class ApertureStruttureRicettiveController extends Controller
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
        return ApertureStruttureRicettive::get();
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
    public function store(Request $req)
    {
        $aperturestrutturericettive = new ApertureStruttureRicettive();

        $aperturestrutturericettive->strutturericettive_id = $req->input('strutturericettive_id');
        $aperturestrutturericettive->giornosettimana_id = $req->input('giornoSettimana');
        $aperturestrutturericettive->orario_apertura = $req->input('oraApertura');
        $aperturestrutturericettive->orario_chiusura = $req->input('oraChiusura');

        $aperturestrutturericettive->save();

        $aperturestrutturericettiveId = $aperturestrutturericettive->id;

        return $aperturestrutturericettiveId;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ApertureStruttureRicettive  $apertureStruttureRicettive
     * @return \Illuminate\Http\Response
     */
    public function show(ApertureStruttureRicettive $apertureStruttureRicettive)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ApertureStruttureRicettive  $apertureStruttureRicettive
     * @return \Illuminate\Http\Response
     */
    public function edit(ApertureStruttureRicettive $apertureStruttureRicettive)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ApertureStruttureRicettive  $apertureStruttureRicettive
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ApertureStruttureRicettive $apertureStruttureRicettive)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ApertureStruttureRicettive  $apertureStruttureRicettive
     * @return \Illuminate\Http\Response
     */
    public function destroy(ApertureStruttureRicettive $apertureStrutturericettive)
    {
        $res = $apertureStrutturericettive->delete();
        return ''.$res;
    }
}
