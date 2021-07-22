<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventiRequest;
use App\Models\{Comuni,
    Eventi, 
    tipoeventi,
    GiorniSettimana,
     TipoEvento};
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Events\CreazioneEvento;
use Illuminate\Support\Facades\Auth;

class EventiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataattuale = Carbon::now()->toDateString();
        $eventi = Eventi::where('fine_evento', '>=', $dataattuale)->get();
        $comuni = Comuni::select('id', 'nomecomune')->get();
        $tipoeventi = TipoEvento::select('id', 'descrizione')->get();


        return view('eventi.list',
               compact('eventi',
                       'comuni',
                       'tipoeventi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $req)
    {
        $eventi = new Eventi();

        $id = $req->has('comune_id')?$req->input('comune_id') : null;
        $tipoeventi = TipoEvento::select('id', 'descrizione')->get();
        $comuni = Comuni::firstOrNew(['id' => $id]);


        return view('eventi.addeditevento',
            compact('comuni',
                'eventi',
                'tipoeventi'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventiRequest $req)
    {
        $eventi = new Eventi();

        $eventi->comune_id = $req->input('comune_id');
        $eventi->denominazione = $req->input('inputDenominazione');
        $eventi->tipoeventi_id = $req->input('tipoEvento');
        $eventi->frazione = $req->input('inputFrazione');
        $eventi->indirizzo = $req->input('inputIndirizzo');
        $eventi->latitudine = $req->input('inputLatitudine');
        $eventi->longitudine = $req->input('inputLongitudine');
        $eventi->website = $req->input('website');
        $eventi->responsabile = $req->input('responsabile');
        $eventi->email = $req->input('email');
        $eventi->telefono = $req->input('inputTelefono');
        $eventi->descrizione = $req->input('descrizione');
        $eventi->urlext = $req->input('urlext');
        $eventi->urlmappa = $req->input('urlmappa');
        $eventi->note = $req->input('note');
        $eventi->inizio_evento = Carbon::createFromFormat('d-m-Y', $req->input('dataInizio'))->format('Y-m-d');
        $eventi->fine_evento = Carbon::createFromFormat('d-m-Y', $req->input('dataFine'))->format('Y-m-d');

        $this->processImg($eventi);

        $this->processFile($eventi);
        
        $res = $eventi->save();

        if($res)
        {
            event(new CreazioneEvento($eventi, Auth::user()));
        }
        

        $messaggio = $res ? 'Evento creato con successo! ' : 'Evento non creato!';
        $color = $res ? 'alert-success' : 'alert-danger';
        session()->flash('message', $messaggio);
        session()->flash('color', $color);

        return redirect()->route('eventi.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Eventi  $eventi
     * @return \Illuminate\Http\Response
     */
    public function show(Eventi $eventi)
    {
        $comuni = Comuni::where('id', $eventi->comune_id)->first();
        $tipoeventi = TipoEvento::where('id', $eventi->tipoeventi_id)->first();

        return view('eventi.evento',
            compact('eventi',
                'comuni',
                'tipoeventi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Eventi  $eventi
     * @return \Illuminate\Http\Response
     */
    public function edit(Eventi $eventi)
    {
        $comuni = Comuni::where('id', $eventi->comune_id)->first();
        $tipoeventi = TipoEvento::select('id', 'descrizione')->get();
    

        return view('eventi.addeditevento',
            compact(
                'comuni',
                'eventi',
                'tipoeventi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Eventi  $eventi
     * @return \Illuminate\Http\Response
     */
    public function update(EventiRequest $req, Eventi $eventi)
    {
        if($req->hasFile('caricaImg'))
        {
            $this->processImg($eventi);
        }
        if($req->hasFile('caricaFile'))
        {
            $this->processFile($eventi);
        }


        $eventi->denominazione = $req->input('inputDenominazione');
        $eventi->tipoeventi_id = $req->input('tipoEvento');
        $eventi->frazione = $req->input('inputFrazione');
        $eventi->indirizzo = $req->input('inputIndirizzo');
        $eventi->latitudine = $req->input('inputLatitudine');
        $eventi->longitudine = $req->input('inputLongitudine');
        $eventi->website = $req->input('website');
        $eventi->responsabile = $req->input('responsabile');
        $eventi->email = $req->input('email');
        $eventi->telefono = $req->input('inputTelefono');
        $eventi->descrizione = $req->input('descrizione');
        $eventi->urlext = $req->input('urlext');
        $eventi->urlmappa = $req->input('urlmappa');
        $eventi->note = $req->input('note');
        $eventi->inizio_evento = Carbon::createFromFormat('d-m-Y', $req->input('dataInizio'))->format('Y-m-d');
        $eventi->fine_evento = Carbon::createFromFormat('d-m-Y', $req->input('dataFine'))->format('Y-m-d');

        $res = $eventi->save();

        $messaggio = $res ? 'Struttura modificata con successo! ' : 'Struttura non modificata!';
        $color = $res ? 'alert-success' : 'alert-danger';
        session()->flash('message', $messaggio);
        session()->flash('color', $color);

        return redirect()->route('eventi.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Eventi  $eventi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Eventi $eventi)
    {
        $res = $eventi->delete();
        if($res){

            $this->deleteFile($eventi);
        }
        return ''.$res;
    }

    public function processImg(Eventi $eventi, Request $req = null)
    {
        if(!$req)
        {
            $req = request();
            if($eventi->pathImage && Storage::exists($eventi->pathImage))
            {
                Storage::delete($eventi->pathImage);
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

        $filename = $file->store(env('IMG_EVENTI'));
        $eventi->pathImage = $filename;
    }

    public function processFile(Eventi $eventi, Request $req = null)
    {
        if(!$req)
        {
            $req = request();
            if($eventi->pathFile && Storage::exists($eventi->pathFile))
            {
                Storage::delete($eventi->pathFile);
            }
        }

        if(!$req->hasFile('caricaFile'))
        {
           return false;
        }

        $file = $req->file('caricaFile');

        if(!$file->isValid())
        {
            return false;
        }

        $filename = $file->store(env('PTH_EVENTI' ).'/'. $eventi->id);
        $eventi->pathFile = $filename;
    }

    public function deleteFile(Eventi $eventi)
    {
        if($eventi->pathFile && Storage::exists($eventi->pathFile))
        {
            Storage::delete($eventi->pathFile);
            return true;
        }
        return false;
    }

}
