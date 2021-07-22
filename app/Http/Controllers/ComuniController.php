<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ComuniRequest;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Storage;
use App\Models\{Comuni, FilesComuni, GruppoFiles, InfoPoint};

class ComuniController extends Controller
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
        $comuni = Comuni::get();
        return view('comuni.list', compact('comuni'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('comuni.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ComuniRequest $req)
    {
        $comuni = new Comuni();

        $comuni->nomecomune = $req->input('nomeComune');
        $comuni->responsabile = $req->input('nomeResponsabile');
        $comuni->indirizzo = $req->input('indirizzoComune');
        $comuni->cap = $req->input('capComune');
        $comuni->numerotelefono = $req->input('numeroTelefono');
        $comuni->urlmappa = $req->input('urlMappa');
        $comuni->urlext = $req->input('urlComuniItalia');
        $comuni->descrizione = $req->input('descrizione');

        $this->processFile($comuni);
       
        $res = $comuni->save();

        $messaggio = $res ? 'Comune creato con successo! ' : 'Comune non creato!';
        $color = $res ? 'alert-success' : 'alert-danger';
        session()->flash('message', $messaggio);
        session()->flash('color', $color);

        return redirect()->route('comuni.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comuni  $comuni
     * @return \Illuminate\Http\Response
     */
    public function show(Comuni $comuni)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comuni  $comuni
     * @return \Illuminate\Http\Response
     */
    public function edit(Comuni $comuni)
    {
        $gruppofiles = GruppoFiles::select('id', 'descrizione', 'codcolore')->get();
        $filescomuni = FilesComuni::where('comune_id', $comuni->id);

        return view('comuni.edit', compact('comuni', 'gruppofiles', 'filescomuni'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comuni  $comuni
     * @return \Illuminate\Http\Response
     */
    public function update(ComuniRequest $req, Comuni $comuni)
    {
        if($req->hasFile('caricaLogo'))
        {
            $this->processFile($comuni);
        }

        $comuni->nomecomune = $req->input('nomeComune');
        $comuni->responsabile = $req->input('nomeResponsabile');
        $comuni->indirizzo = $req->input('indirizzoComune');
        $comuni->cap = $req->input('capComune');
        $comuni->numerotelefono = $req->input('numeroTelefono');
        $comuni->urlmappa = $req->input('urlMappa');
        $comuni->urlext = $req->input('urlComuniItalia');
        $comuni->descrizione = $req->input('descrizione');
       
        $res = $comuni->save();

        $messaggio = $res ? 'Comune modificato con successo! ' : 'Comune non modificato!';
        $color = $res ? 'alert-success' : 'alert-danger';
        session()->flash('message', $messaggio);
        session()->flash('color', $color);

        return redirect()->route('comuni.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comuni  $comuni
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comuni $comuni)
    {
        $res = $comuni->delete();
        if($res)
        {
            $this->deleteFile($comuni);
        }
        return ''.$res;
    }

    public function processFile(Comuni $comuni, Request $req = null)
    {
        if(!$req)
        {
            $req = request();
            if($comuni->pathImage && Storage::exists($comuni->pathImage))
            {
                Storage::delete($comuni->pathImage);
            }
        }

        if(!$req->hasFile('caricaLogo'))
        {
           return false;
        }
        
        $file = $req->file('caricaLogo');

        if(!$file->isValid())
        {
            return false;
        }

        $filename = $file->store(env('IMG_LOGHICOMUNI'));
        $comuni->pathImage = $filename;
    }

    public function deleteFile(Comuni $comuni)
    {
        if($comuni->pathImage && Storage::exists($comuni->pathImage))
        {
            Storage::delete($comuni->pathImage);
            return true;
        }
        return false;
    }

    public function getComuniFiles(Comuni $comuni)
    {
        $filescomuni = FilesComuni::where('comune_id', $comuni->id)->orderBy('created_at', 'DESC')->get();
        $gruppofiles = GruppoFiles::select('id','descrizione', 'codcolore')->get();
        
        return view('files.listfilescomuni', compact('comuni', 'filescomuni', 'gruppofiles'));
    }

    public function getInfopoint(Comuni $comuni)
    {   
        $infopoint = InfoPoint::where('comune_id', $comuni->id)->orderBy('created_at', 'DESC')->get();
        $users = User::get();
        return view('infopoint.list', compact('comuni', 'infopoint', 'users'));
    }

    
}
