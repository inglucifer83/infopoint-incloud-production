<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilesInfopointRequest;
use Illuminate\Http\Request;
use App\Models\FilesInfopoint;
use Illuminate\Support\Facades\Storage;

class FilesInfopointController extends Controller
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
        return FilesInfopoint::get();
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
    public function store(FilesInfopointRequest $req)
    {
        $filesinfopoint = new FilesInfopoint();

        $filesinfopoint->nomeFile = $req->file('caricaFileInfopoint')->getClientOriginalName();
        $filesinfopoint->estensioneFile = $req->file('caricaFileInfopoint')->getClientOriginalExtension();
        $filesinfopoint->infopoint_id = $req->input('infopoint_id');
        $filesinfopoint->descrizioneFile = $req->input('descrizioneFile');
        $filesinfopoint->gruppo_id = $req->input('gruppoFile');
        $filesinfopoint->comune_id = $req->input('comune_id');
        $filesinfopoint->livelloaccesso_id = $req->input('accessoFile');
        $filesinfopoint->user_id = 0;
        
        $filesinfopoint->note = $req->input('note');

        $this->processFile($filesinfopoint);

        $res = $filesinfopoint->save();

        $messaggio = $res ? 'File Infopoint creato con successo! ' : 'File Infopoint non creato!';
        $color = $res ? 'alert-success' : 'alert-danger';
        session()->flash('message', $messaggio);
        session()->flash('color', $color);

        return redirect()->route('infopoint.getfilesinfopoint', $filesinfopoint->infopoint_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FilesInfopoint  $filesInfopoint
     * @return \Illuminate\Http\Response
     */
    public function show(FilesInfopoint $filesInfopoint)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FilesInfopoint  $filesInfopoint
     * @return \Illuminate\Http\Response
     */
    public function edit(FilesInfopoint $filesInfopoint)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FilesInfopoint  $filesInfopoint
     * @return \Illuminate\Http\Response
     */
    public function update(FilesInfopointRequest $req, FilesInfopoint $filesinfopoint)
    {
        
        $filesinfopoint->descrizioneFile = $req->input('descrizioneFileMod');
        $filesinfopoint->gruppo_id = $req->input('gruppoFileMod');
        $filesinfopoint->livelloaccesso_id = $req->input('livelloAccessoMod');
        $filesinfopoint->user_id = 0;
        $filesinfopoint->note = $req->input('noteMod');

        $res = $filesinfopoint->save();


        $messaggio = $res ? 'File Infopoint modificato con successo! ' : 'File Infopoint non modificato!';
        $color = $res ? 'alert-success' : 'alert-danger';
        session()->flash('message', $messaggio);
        session()->flash('color', $color);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FilesInfopoint  $filesInfopoint
     * @return \Illuminate\Http\Response
     */
    public function destroy(FilesInfopoint $filesinfopoint)
    {
        $res = $filesinfopoint->delete();
        if($res)
        {
            $this->deleteFile($filesinfopoint);
        }
        return ''.$res;
    }

    public function processFile(FilesInfopoint $filesinfopoint, Request $req = null)
    {
        if(!$req)
        {
            $req = request();
            if($filesinfopoint->pathFile && Storage::exists($filesinfopoint->pathFile))
            {
                Storage::delete($filesinfopoint->pathFile);
            }
        }

        if(!$req->hasFile('caricaFileInfopoint'))
        {
           return false;
        }
        
        $file = $req->file('caricaFileInfopoint');

        if(!$file->isValid())
        {
            return false;
        }

        $filename = $file->store(env('PTH_INFOPOINT').'/'. $filesinfopoint->infopoint_id);
        $filesinfopoint->pathFile = $filename;
    }

    public function deleteFile(FilesInfopoint $filesinfopoint)
    {
        if($filesinfopoint->pathFile && Storage::exists($filesinfopoint->pathFile))
        {
            Storage::delete($filesinfopoint->pathFile);
            return true;
        }
        return false;
    }
}
