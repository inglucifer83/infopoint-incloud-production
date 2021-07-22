<?php

namespace App\Http\Controllers;

use App\Models\ApertureLuoghiInteresse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ApertureLuoghiInteresseController extends Controller
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
        return ApertureLuoghiInteresse::get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        $apertureluoghiinteresse = new ApertureLuoghiInteresse();

        $apertureluoghiinteresse->luogointeresse_id = $req->input('luogointeresse_id');
        $apertureluoghiinteresse->giornosettimana_id = $req->input('giornoSettimana');
        $apertureluoghiinteresse->orario_apertura = $req->input('oraApertura');
        $apertureluoghiinteresse->orario_chiusura = $req->input('oraChiusura');

        $apertureluoghiinteresse->save();

        $apertureluoghiinteresseId = $apertureluoghiinteresse->id;

        return $apertureluoghiinteresseId;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ApertureLuoghiInteresse  $apertureLuoghiInteresse
     * @return \Illuminate\Http\Response
     */
    public function show(ApertureLuoghiInteresse $apertureluoghiinteresse)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ApertureLuoghiInteresse  $apertureLuoghiInteresse
     * @return \Illuminate\Http\Response
     */
    public function edit(ApertureLuoghiInteresse $apertureLuoghiInteresse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ApertureLuoghiInteresse  $apertureLuoghiInteresse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ApertureLuoghiInteresse $apertureLuoghiInteresse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ApertureLuoghiInteresse  $apertureLuoghiInteresse
     * @return \Illuminate\Http\Response
     */
    public function destroy(ApertureLuoghiInteresse $apertureluoghiinteresse)
    {
        $res = $apertureluoghiinteresse->delete();
        return ''.$res;
    }
}
