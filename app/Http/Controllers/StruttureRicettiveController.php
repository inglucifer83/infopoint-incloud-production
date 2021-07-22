<?php

namespace App\Http\Controllers;

use App\Models\{ApertureStruttureRicettive, 
                Comuni,
                FotoStruttureRicettive,
                StruttureRicettive, 
                TipoStruttureRicettive,
                GiorniSettimana,
                Orari};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StruttureRicettiveRequest;
use App\Events\CreazioneStrutture;
use Illuminate\Support\Facades\Auth;


class StruttureRicettiveController extends Controller
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
        $strutturericettive = StruttureRicettive::get();
        $comuni = Comuni::select('id', 'nomecomune')->get();
        $tipostrutturaricettiva = TipoStruttureRicettive::select('id', 'descrizione')->get();


        return view('strutturericettive.list',
               compact('strutturericettive',
                       'comuni',
                       'tipostrutturaricettiva'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $req)
    {
        $strutturericettive = new StruttureRicettive();

        $id = $req->has('comune_id')?$req->input('comune_id') : null;
        $tipostrutturaricettiva = TipoStruttureRicettive::select('id', 'descrizione')->get();
        $comuni = Comuni::firstOrNew(['id' => $id]);
        $aperturestrutturericettive = ApertureStruttureRicettive::where('strutturericettive_id', $strutturericettive->id)->get();
        $giornisettimana = GiorniSettimana::select('id', 'giorno')->get();
        $orari = Orari::select('id', 'orario')->get();
        $fotostrutturericettive = null;


        return view('strutturericettive.addeditstruttura',
            compact('comuni',
                'strutturericettive',
                'tipostrutturaricettiva',
                'aperturestrutturericettive',
                'giornisettimana',
                'orari',
                'fotostrutturericettive'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StruttureRicettiveRequest $req)
    {
        $strutturericettive = new StruttureRicettive();

        $strutturericettive->comune_id = $req->input('comune_id');
        $strutturericettive->denominazione = $req->input('inputDenominazione');
        $strutturericettive->tipostrutturaricettiva_id = $req->input('tipoLuogo');
        $strutturericettive->frazione = $req->input('inputFrazione');
        $strutturericettive->indirizzo = $req->input('inputIndirizzo');
        $strutturericettive->latitudine = $req->input('inputLatitudine');
        $strutturericettive->longitudine = $req->input('inputLongitudine');
        $strutturericettive->website = $req->input('website');
        $strutturericettive->responsabile = $req->input('responsabile');
        $strutturericettive->email = $req->input('email');
        $strutturericettive->telefono = $req->input('inputTelefono');
        $strutturericettive->descrizione = $req->input('descrizione');
        $strutturericettive->urlext = $req->input('urlext');
        $strutturericettive->urlmappa = $req->input('urlmappa');
        $strutturericettive->note = $req->input('note');



        $this->processImg($strutturericettive);

        $this->processFile($strutturericettive);

        $res = $strutturericettive->save();

        if($res)
        {
            event(new CreazioneStrutture($strutturericettive, Auth::user()));
        }

        if($req->hasFile('fotoAddizionali'))
        {
            $images = [];
            foreach($req->file('fotoAddizionali') as $file)
            {
                $filename = $file->store(env('PTH_PHSTRUTTURE' ).'/'. $strutturericettive->id);

                $images[] = new FotoStruttureRicettive([
                    'pathImage' => $filename
                ]);
            }
            $strutturericettive->images()->saveMany($images);
        }

        $messaggio = $res ? 'Struttura creata con successo! ' : 'Struttura non creato!';
        $color = $res ? 'alert-success' : 'alert-danger';
        session()->flash('message', $messaggio);
        session()->flash('color', $color);

        return redirect()->route('strutturericettive.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StruttureRicettive  $struttureRicettive
     * @return \Illuminate\Http\Response
     */
    public function show(StruttureRicettive $strutturericettive)
    {
        $comuni = Comuni::where('id', $strutturericettive->comune_id)->first();
        $tipostrutturaricettiva = TipoStruttureRicettive::select('id', 'descrizione')->get();
        $aperturestrutturericettive = ApertureStruttureRicettive::where('strutturericettive_id', $strutturericettive->id)
            ->orderBy('giornosettimana_id')
            ->orderBy('orario_apertura')
            ->get();
        $fotostrutturericettive = FotoStruttureRicettive::where('strutturericettive_id', $strutturericettive->id)
            ->inRandomOrder()
            ->take(6)
            ->get();
        $giornisettimana = GiorniSettimana::select('id', 'giorno')->get();
        $orari = Orari::select('id', 'orario')->get();

        return view('strutturericettive.struttura',
            compact('strutturericettive',
                'comuni',
                'tipostrutturaricettiva',
                'aperturestrutturericettive',
                'giornisettimana',
                 'orari',
                 'fotostrutturericettive'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StruttureRicettive  $struttureRicettive
     * @return \Illuminate\Http\Response
     */
    public function edit(StruttureRicettive $strutturericettive)
    {
        $comuni = Comuni::where('id', $strutturericettive->comune_id)->first();
        $tipostrutturaricettiva = TipoStruttureRicettive::select('id', 'descrizione')->get();
        $aperturestrutturericettive = ApertureStruttureRicettive::where('strutturericettive_id', $strutturericettive->id)->get();
        $giornisettimana = GiorniSettimana::select('id', 'giorno')->get();
        $orari = Orari::select('id', 'orario')->get();
        $fotostrutturericettive = FotoStruttureRicettive::where('strutturericettive_id', $strutturericettive->id)->get();

        return view('strutturericettive.addeditstruttura',
            compact(
                'comuni',
                'strutturericettive',
                'tipostrutturaricettiva',
                'aperturestrutturericettive',
                'giornisettimana',
                'orari',
                'fotostrutturericettive'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StruttureRicettive  $struttureRicettive
     * @return \Illuminate\Http\Response
     */
    public function update(StruttureRicettiveRequest $req, StruttureRicettive $strutturericettive)
    {
        if($req->hasFile('caricaImg'))
        {
            $this->processImg($strutturericettive);
        }
        if($req->hasFile('caricaFile'))
        {
            $this->processFile($strutturericettive);
        }

        if($req->hasFile('fotoAddizionali'))
        {
            $images = [];
            foreach($req->file('fotoAddizionali') as $file)
            {

                $filename = $file->store(env('PTH_PHSTRUTTURE' ).'/'. $strutturericettive->id);

                $images[] = new FotoStruttureRicettive([
                    'pathImage' => $filename
                ]);
            }

            $strutturericettive->images()->saveMany($images);
        }


        $strutturericettive->denominazione = $req->input('inputDenominazione');
        $strutturericettive->tipostrutturaricettiva_id = $req->input('tipoLuogo');
        $strutturericettive->frazione = $req->input('inputFrazione');
        $strutturericettive->indirizzo = $req->input('inputIndirizzo');
        $strutturericettive->latitudine = $req->input('inputLatitudine');
        $strutturericettive->longitudine = $req->input('inputLongitudine');
        $strutturericettive->website = $req->input('website');
        $strutturericettive->responsabile = $req->input('responsabile');
        $strutturericettive->email = $req->input('email');
        $strutturericettive->telefono = $req->input('inputTelefono');
        $strutturericettive->descrizione = $req->input('descrizione');
        $strutturericettive->urlext = $req->input('urlext');
        $strutturericettive->urlmappa = $req->input('urlmappa');
        $strutturericettive->note = $req->input('note');

        $res = $strutturericettive->save();

        $messaggio = $res ? 'Struttura modificata con successo! ' : 'Struttura non modificata!';
        $color = $res ? 'alert-success' : 'alert-danger';
        session()->flash('message', $messaggio);
        session()->flash('color', $color);

        return redirect()->route('strutturericettive.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StruttureRicettive  $struttureRicettive
     * @return \Illuminate\Http\Response
     */
    public function destroy(StruttureRicettive $strutturericettive)
    {
        $res = $strutturericettive->delete();
            if($res > 0)
            {
                $fotostrutturericettive = FotoStruttureRicettive::where('strutturericettive_id', $strutturericettive->id)->get();
                if($fotostrutturericettive)
                {
                    foreach($fotostrutturericettive as $foto)
                    {
                        
                        $this->deleteFotoStrutture($foto);
                    }
                    
                }
                
                $fotostrutturericettive = FotoStruttureRicettive::where('strutturericettive_id', $strutturericettive->id)->delete();
                $this->deleteFile($strutturericettive);
                $this->deleteImg($strutturericettive);
                return ''.$res;
            }
        return ''.$res;
    }

    public function processImg(StruttureRicettive $strutturericettive, Request $req = null)
    {
        if(!$req)
        {
            $req = request();
            if($strutturericettive->pathImage && Storage::exists($strutturericettive->pathImage))
            {
                Storage::delete($strutturericettive->pathImage);
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

        $filename = $file->store(env('IMG_STRUTTURE'));
        $strutturericettive->pathImage = $filename;
    }

    public function deleteImg(StruttureRicettive $strutturericettive)
    {
        if($strutturericettive->pathFile && Storage::exists($strutturericettive->pathFile))
        {
            Storage::delete($strutturericettive->pathFile);
            return true;
        }
        return false;
    }

    public function processFile(StruttureRicettive $strutturericettive, Request $req = null)
    {
        if(!$req)
        {
            $req = request();
            if($strutturericettive->pathFile && Storage::exists($strutturericettive->pathFile))
            {
                Storage::delete($strutturericettive->pathFile);
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

        $filename = $file->store(env('PTH_STRUTTURE' ).'/'. $strutturericettive->id);
        $strutturericettive->pathFile = $filename;
    }

    public function deleteFile(StruttureRicettive $strutturericettive)
    {
        if($strutturericettive->pathFile && Storage::exists($strutturericettive->pathFile))
        {
            Storage::delete($strutturericettive->pathFile);
            return true;
        }
        return false;
    }

    public function deleteFotoStrutture(FotoStruttureRicettive $fotostrutturericettive)
    {
        if($fotostrutturericettive->pathImage && Storage::exists($fotostrutturericettive->pathImage))
        {
            Storage::delete($fotostrutturericettive->pathImage);
            return true;
        }
        return false;
    }
}
