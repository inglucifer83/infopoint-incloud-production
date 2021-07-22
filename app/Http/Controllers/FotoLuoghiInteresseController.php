<?php

namespace App\Http\Controllers;

use App\Models\FotoLuoghiInteresse;
use App\Models\LuoghiInteresse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FotoLuoghiInteresseController extends Controller
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FotoLuoghiInteresse  $fotoLuoghiInteresse
     * @return \Illuminate\Http\Response
     */
    public function show(FotoLuoghiInteresse $fotoLuoghiInteresse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FotoLuoghiInteresse  $fotoLuoghiInteresse
     * @return \Illuminate\Http\Response
     */
    public function edit(FotoLuoghiInteresse $fotoLuoghiInteresse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FotoLuoghiInteresse  $fotoLuoghiInteresse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FotoLuoghiInteresse $fotoLuoghiInteresse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FotoLuoghiInteresse  $fotoLuoghiInteresse
     * @return \Illuminate\Http\Response
     */
    public function destroy(FotoLuoghiInteresse $fotoluoghiinteresse)
    {
        $res = $fotoluoghiinteresse->delete();
        if($res)
        {
            $this->deleteImg($fotoluoghiinteresse);
        }
        return ''.$res;
    }

    public function deleteImg(FotoLuoghiInteresse $fotoluoghiinteresse)
    {
        if($fotoluoghiinteresse->pathImage && Storage::exists($fotoluoghiinteresse->pathImage))
        {
            Storage::delete($fotoluoghiinteresse->pathImage);
            return true;
        }
        return false;
    }
}
