<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\InfopointRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\{InfoPoint, Comuni, FilesInfopoint, GruppoFiles, LivelliAccesso};

class InfoPointController extends Controller
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
        $infopoint = InfoPoint::get();
        $comuni = Comuni::get();
        return view('infopoint.listall', compact('infopoint', 'comuni'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $req)
    {
        $infopoint = new InfoPoint();

        $id = $req->has('comune_id')?$req->input('comune_id') : null;

        $comuni = Comuni::firstOrNew(['id' => $id]);

        return view('infopoint.addedit', compact('infopoint', 'comuni'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InfopointRequest $req)
    {
        $infopoint = new InfoPoint();
        
        $infopoint->comune_id = $req->input('comune_id');
        $infopoint->indirizzo = $req->input('inputIndirizzo');
        $infopoint->latitudine = $req->input('inputLatitudine');
        $infopoint->longitudine = $req->input('inputLongitudine');
        $infopoint->urlmappa = $req->input('urlaMappa');
        $infopoint->denominazione = $req->input('denominazioneInfopoint');
        $infopoint->cap = $req->input('cap');
        $infopoint->responsabile = $req->input('responsabile');
        $infopoint->numerotelefono = $req->input('telefono');
        $infopoint->email = $req->input('email');
        $infopoint->note = $req->input('note');
        $infopoint->frazione = $req->input('inputFrazione');

        $this->processFile($infopoint);
       
        $res = $infopoint->save();

        $messaggio = $res ? 'Infopoint creato con successo! ' : 'Infopoint non creato!';
        $color = $res ? 'alert-success' : 'alert-danger';
        session()->flash('message', $messaggio);
        session()->flash('color', $color);

        return redirect()->route('comuni.getinfopoint', $infopoint->comune_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InfoPoint  $infoPoint
     * @return \Illuminate\Http\Response
     */
    public function show(InfoPoint $infoPoint)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InfoPoint  $infoPoint
     * @return \Illuminate\Http\Response
     */
    public function edit(InfoPoint $infopoint)
    {
        $comuni = Comuni::where('id', $infopoint->comune_id)->first();
        
        return view('infopoint.addedit', compact('comuni', 'infopoint'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InfoPoint  $infoPoint
     * @return \Illuminate\Http\Response
     */
    public function update(InfopointRequest $req, InfoPoint $infopoint)
    {
        if($req->hasFile('caricaImg'))
        {
            $this->processFile($infopoint);
        }
        
        $infopoint->indirizzo = $req->input('inputIndirizzo');
        $infopoint->latitudine = $req->input('inputLatitudine');
        $infopoint->longitudine = $req->input('inputLongitudine');
        $infopoint->urlmappa = $req->input('urlaMappa');
        $infopoint->denominazione = $req->input('denominazioneInfopoint');
        $infopoint->cap = $req->input('cap');
        $infopoint->responsabile = $req->input('responsabile');
        $infopoint->numerotelefono = $req->input('telefono');
        $infopoint->email = $req->input('email');
        $infopoint->note = $req->input('note');
        $infopoint->frazione = $req->input('inputFrazione');
       
        $res = $infopoint->save();

        $messaggio = $res ? 'Infopoint modificato con successo! ' : 'Infopoint non modificato!';
        $color = $res ? 'alert-success' : 'alert-danger';
        session()->flash('message', $messaggio);
        session()->flash('color', $color);

        return redirect()->route('comuni.getinfopoint', $req->input('comune_id'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InfoPoint  $infoPoint
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfoPoint $infopoint)
    {
        $res = $infopoint->delete();
        return ''.$res;
    }

    public function processFile(InfoPoint $infopoint, Request $req = null)
    {
        if(!$req)
        {
            $req = request();
            if($infopoint->pathImage && Storage::exists($infopoint->pathImage))
            {
                Storage::delete($infopoint->pathImage);
            }
        }

        if(!$req->hasFile('caricaImg'))
        {
           return false;
        }
          
        $file = $req->file('caricaImg');

        if(!$file->isValid())
        {
            return false;
        }

        $filename = $file->store(env('IMG_INFOPOINT'));
        $infopoint->pathImage = $filename;
    }

    public function deleteFile(InfoPoint $infopoint)
    {
        if($infopoint->pathImage && Storage::exists($infopoint->pathImage))
        {
            Storage::delete($infopoint->pathImage);
            return true;
        }
        return false;
    }

    public function getFilesInfopoint(InfoPoint $infopoint)
    {
        $filesinfopoint = FilesInfopoint::where('infopoint_id', $infopoint->id)->orderBy('created_at', 'DESC')->get();
        $gruppofiles = GruppoFiles::select('id','descrizione', 'codcolore')->get();
        $livelliaccesso = LivelliAccesso::select('id','descrizione')->get();
        $comuni = Comuni::select('id','nomecomune')->first();

        return view('files.listfilesinfopoint', compact('infopoint', 'filesinfopoint', 'gruppofiles', 'livelliaccesso', 'comuni'));
    }
}
