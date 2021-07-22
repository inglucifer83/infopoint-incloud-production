<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilesComuniRequest;
use App\Models\FilesComuni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FilesComuniController extends Controller
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
        return FilesComuni::get();
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
    public function store(FilesComuniRequest $req)
    {
        $filescomuni = new FilesComuni();

        $filescomuni->nomeFile = $req->file('caricaFileComune')->getClientOriginalName();
        $filescomuni->estensioneFile = $req->file('caricaFileComune')->getClientOriginalExtension();
        $filescomuni->descrizioneFile = $req->input('descrizioneFile');
        $filescomuni->gruppo_id = $req->input('gruppoFile');
        $filescomuni->comune_id = $req->input('comune_id');

        $this->processFile($filescomuni);

        $res = $filescomuni->save();

        $messaggio = $res ? 'File Comune creato con successo! ' : 'Fine Comune non creato!';
        $color = $res ? 'alert-success' : 'alert-danger';
        session()->flash('message', $messaggio);
        session()->flash('color', $color);

        return redirect()->route('comuni.getComuniFiles', $filescomuni->comune_id);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FilesComuni  $filesComuni
     * @return \Illuminate\Http\Response
     */
    public function show(FilesComuni $filesComuni)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FilesComuni  $filesComuni
     * @return \Illuminate\Http\Response
     */
    public function edit(FilesComuni $filescomuni)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FilesComuni  $filesComuni
     * @return \Illuminate\Http\Response
     */
    public function update(FilesComuniRequest $req, FilesComuni $filescomuni)
    {
        $filescomuni->descrizioneFile = $req->input('descrizioneFileMod');
        $filescomuni->gruppo_id = $req->input('gruppoFileMod');

        $res = $filescomuni->save();

        $messaggio = $res ? 'File Modificato con successo! ' : 'File non modificato!';
        $color = $res ? 'alert-success' : 'alert-danger';
        session()->flash('message', $messaggio);
        session()->flash('color', $color);

        return $res;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FilesComuni  $filesComuni
     * @return \Illuminate\Http\Response
     */
    public function destroy(FilesComuni $filescomuni)
    {
        $res = $filescomuni->delete();
        if($res)
        {
            $this->deleteFile($filescomuni);
        }
        return ''.$res;
    }

    public function processFile(FilesComuni $filescomuni, Request $req = null)
    {
        if(!$req)
        {
            $req = request();
            if($filescomuni->pathFile && Storage::exists($filescomuni->pathFile))
            {
                Storage::delete($filescomuni->pathFile);
            }
        }

        if(!$req->hasFile('caricaFileComune'))
        {
           return false;
        }
        
        $file = $req->file('caricaFileComune');

        if(!$file->isValid())
        {
            return false;
        }

        $filename = $file->store(env('PTH_COMUNI').'/'. $filescomuni->comune_id);
        $filescomuni->pathFile = $filename;
    }

    public function deleteFile(FilesComuni $filescomuni)
    {
        if($filescomuni->pathFile && Storage::exists($filescomuni->pathFile))
        {
            Storage::delete($filescomuni->pathFile);
            return true;
        }
        return false;
    }
}
