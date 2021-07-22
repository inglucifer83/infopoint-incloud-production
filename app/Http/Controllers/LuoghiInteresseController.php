<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\{ApertureLuoghiInteresse,
    GiorniSettimana,
    LuoghiInteresse,
    Comuni,
    FotoLuoghiInteresse,
    Orari,
    TipoLuoghiInteresse};
use App\Http\Requests\LuoghiInteresseRequest;
use App\Events\CreazioneLuoghi;
use Illuminate\Support\Facades\Auth;

class LuoghiInteresseController extends Controller
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
        $luoghiinteresse = LuoghiInteresse::get();
        $comuni = Comuni::select('id', 'nomecomune')->get();
        $tipoluoghiinteresse = TipoLuoghiInteresse::select('id', 'descrizione')->get();


        return view('luoghiinteresse.list',
            compact('luoghiinteresse',
                'comuni',
                'tipoluoghiinteresse'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $req)
    {
        $luoghiinteresse = new LuoghiInteresse();

        $id = $req->has('comune_id')?$req->input('comune_id') : null;
        $tipoluoghiinteresse = TipoLuoghiInteresse::select('id', 'descrizione')->get();
        $comuni = Comuni::firstOrNew(['id' => $id]);
        $apertureluoghiinteresse = ApertureLuoghiInteresse::where('luogointeresse_id', $luoghiinteresse->id)->get();
        $giornisettimana = GiorniSettimana::select('id', 'giorno')->get();
        $orari = Orari::select('id', 'orario')->get();
        $fotoluoghiinteresse = null;


        return view('luoghiinteresse.addeditluogo',
            compact('comuni',
                'luoghiinteresse',
                'tipoluoghiinteresse',
                'apertureluoghiinteresse',
                'giornisettimana',
                'orari',
                'fotoluoghiinteresse'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LuoghiInteresseRequest $req)
    {

        $luoghiinteresse = new LuoghiInteresse();

        $luoghiinteresse->comune_id = $req->input('comune_id');
        $luoghiinteresse->denominazione = $req->input('inputDenominazione');
        $luoghiinteresse->tipoluoghiinteresse_id = $req->input('tipoLuogo');
        $luoghiinteresse->frazione = $req->input('inputFrazione');
        $luoghiinteresse->indirizzo = $req->input('inputIndirizzo');
        $luoghiinteresse->latitudine = $req->input('inputLatitudine');
        $luoghiinteresse->longitudine = $req->input('inputLongitudine');
        $luoghiinteresse->website = $req->input('website');
        $luoghiinteresse->responsabile = $req->input('responsabile');
        $luoghiinteresse->email = $req->input('email');
        $luoghiinteresse->telefono = $req->input('inputTelefono');
        $luoghiinteresse->descrizione = $req->input('descrizione');
        $luoghiinteresse->urlext = $req->input('urlext');
        $luoghiinteresse->urlmappa = $req->input('urlmappa');
        $luoghiinteresse->costobigliettoadulti = floatval(str_replace(',', '.',  $req->input('costoBiglietto')));
        $luoghiinteresse->notecostobigliettoadulti = $req->input('noteCostoBiglietto');
        $luoghiinteresse->costobigliettobambini = floatval(str_replace(',', '.',  $req->input('costoBigliettoBambini')));
        $luoghiinteresse->notecostobigliettobambini = $req->input('noteCostoBigliettoBambini');
        $luoghiinteresse->costobigliettoridotto = floatval(str_replace(',', '.',  $req->input('costoBigliettoRidotto')));
        $luoghiinteresse->notecostobigliettoridotto = $req->input('noteCostoBigliettoRidotto');
        $luoghiinteresse->notebiglietti = $req->input('noteGenericheBiglietti');
        $luoghiinteresse->note = $req->input('note');



        $this->processImg($luoghiinteresse);

        $this->processFile($luoghiinteresse);

        $res = $luoghiinteresse->save();

        if($res)
        {
            event(new CreazioneLuoghi($luoghiinteresse, Auth::user()));
        }

        if($req->hasFile('fotoAddizionali'))
        {
            $images = [];
            foreach($req->file('fotoAddizionali') as $file)
            {
                $filename = $file->store(env('PTH_PHLUOGHI' ).'/'. $luoghiinteresse->id);

                $images[] = new FotoLuoghiInteresse([
                    'pathImage' => $filename
                ]);
            }
            $luoghiinteresse->images()->saveMany($images);
        }

        $messaggio = $res ? 'Luogo creato con successo! ' : 'Luogo non creato!';
        $color = $res ? 'alert-success' : 'alert-danger';
        session()->flash('message', $messaggio);
        session()->flash('color', $color);

        return redirect()->route('luoghiinteresse.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LuoghiInteresse  $luoghiInteresse
     * @return \Illuminate\Http\Response
     */
    public function show(LuoghiInteresse $luoghiinteresse)
    {
        $comuni = Comuni::where('id', $luoghiinteresse->comune_id)->first();
        $tipoluoghiinteresse = TipoLuoghiInteresse::select('id', 'descrizione')->get();
        $apertureluoghiinteresse = ApertureLuoghiInteresse::where('luogointeresse_id', $luoghiinteresse->id)
            ->orderBy('giornosettimana_id')
            ->orderBy('orario_apertura')
            ->get();
        $fotoluoghiinteresse = FotoLuoghiInteresse::where('luogointeresse_id', $luoghiinteresse->id)
            ->inRandomOrder()
            ->take(6)
            ->get();
        $giornisettimana = GiorniSettimana::select('id', 'giorno')->get();
        $orari = Orari::select('id', 'orario')->get();

        return view('luoghiinteresse.luogo',
            compact('luoghiinteresse',
                'comuni',
                'tipoluoghiinteresse',
                'apertureluoghiinteresse',
                'giornisettimana',
                 'orari',
                 'fotoluoghiinteresse'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LuoghiInteresse  $luoghiInteresse
     * @return \Illuminate\Http\Response
     */
    public function edit(LuoghiInteresse $luoghiinteresse)
    {
        $comuni = Comuni::where('id', $luoghiinteresse->comune_id)->first();
        $tipoluoghiinteresse = TipoLuoghiInteresse::select('id', 'descrizione')->get();
        $apertureluoghiinteresse = ApertureLuoghiInteresse::where('luogointeresse_id', $luoghiinteresse->id)->get();
        $giornisettimana = GiorniSettimana::select('id', 'giorno')->get();
        $orari = Orari::select('id', 'orario')->get();
        $fotoluoghiinteresse = FotoLuoghiInteresse::where('luogointeresse_id', $luoghiinteresse->id)->get();

        return view('luoghiinteresse.addeditluogo',
            compact(
                'comuni',
                'luoghiinteresse',
                'tipoluoghiinteresse',
                'apertureluoghiinteresse',
                'giornisettimana',
                'orari',
                'fotoluoghiinteresse'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LuoghiInteresse  $luoghiInteresse
     * @return \Illuminate\Http\Response
     */
    public function update(LuoghiInteresseRequest $req, LuoghiInteresse $luoghiinteresse)
    {


        if($req->hasFile('caricaImg'))
        {
            $this->processImg($luoghiinteresse);
        }
        if($req->hasFile('caricaFile'))
        {
            $this->processFile($luoghiinteresse);
        }

        if($req->hasFile('fotoAddizionali'))
        {
            $images = [];
            foreach($req->file('fotoAddizionali') as $file)
            {

                $filename = $file->store(env('PTH_PHLUOGHI' ).'/'. $luoghiinteresse->id);

                $images[] = new FotoLuoghiInteresse([
                    'pathImage' => $filename
                ]);
            }

            $luoghiinteresse->images()->saveMany($images);
        }


        $luoghiinteresse->denominazione = $req->input('inputDenominazione');
        $luoghiinteresse->tipoluoghiinteresse_id = $req->input('tipoLuogo');
        $luoghiinteresse->frazione = $req->input('inputFrazione');
        $luoghiinteresse->indirizzo = $req->input('inputIndirizzo');
        $luoghiinteresse->latitudine = $req->input('inputLatitudine');
        $luoghiinteresse->longitudine = $req->input('inputLongitudine');
        $luoghiinteresse->website = $req->input('website');
        $luoghiinteresse->responsabile = $req->input('responsabile');
        $luoghiinteresse->email = $req->input('email');
        $luoghiinteresse->telefono = $req->input('inputTelefono');
        $luoghiinteresse->descrizione = $req->input('descrizione');
        $luoghiinteresse->urlext = $req->input('urlext');
        $luoghiinteresse->urlmappa = $req->input('urlmappa');
        $luoghiinteresse->costobigliettoadulti = floatval(str_replace(',', '.',  $req->input('costoBiglietto')));
        $luoghiinteresse->notecostobigliettoadulti = $req->input('noteCostoBiglietto');
        $luoghiinteresse->costobigliettobambini = floatval(str_replace(',', '.',  $req->input('costoBigliettoBambini')));
        $luoghiinteresse->notecostobigliettobambini = $req->input('noteCostoBigliettoBambini');
        $luoghiinteresse->costobigliettoridotto = floatval(str_replace(',', '.',  $req->input('costoBigliettoRidotto')));
        $luoghiinteresse->notecostobigliettoridotto = $req->input('noteCostoBigliettoRidotto');
        $luoghiinteresse->notebiglietti = $req->input('noteGenericheBiglietti');
        $luoghiinteresse->note = $req->input('note');

        $res = $luoghiinteresse->save();

        $messaggio = $res ? 'Luogo modificato con successo! ' : 'Luogo non modificato!';
        $color = $res ? 'alert-success' : 'alert-danger';
        session()->flash('message', $messaggio);
        session()->flash('color', $color);

        return redirect()->route('luoghiinteresse.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LuoghiInteresse  $luoghiInteresse
     * @return \Illuminate\Http\Response
     */
    public function destroy(LuoghiInteresse $luoghiinteresse)
    {
        $res = $luoghiinteresse->delete();
            if($res > 0){
                $fotoluoghiinteresse = FotoLuoghiInteresse::where('luogointeresse_id', $luoghiinteresse->id)->get();
                if($fotoluoghiinteresse)
                {
                    foreach($fotoluoghiinteresse as $foto)
                    {
                        $this->deleteFotoLuoghi($foto);
                    }
                    
                }
                $fotoluoghiinteresse = FotoLuoghiInteresse::where('luogointeresse_id', $luoghiinteresse->id)->delete();
                $this->deleteFile($luoghiinteresse);
                $this->deleteImg($luoghiinteresse);
                return ''.$res;
            }
        return ''.$res;
    }

    public function processImg(LuoghiInteresse $luoghiinteresse, Request $req = null)
    {
        if(!$req)
        {
            $req = request();
            if($luoghiinteresse->pathImage && Storage::exists($luoghiinteresse->pathImage))
            {
                Storage::delete($luoghiinteresse->pathImage);
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

        $filename = $file->store(env('IMG_LUOGOINT'));
        $luoghiinteresse->pathImage = $filename;
    }

    public function deleteImg(LuoghiInteresse $luoghiinteresse)
    {
        if($luoghiinteresse->pathFile && Storage::exists($luoghiinteresse->pathFile))
        {
            Storage::delete($luoghiinteresse->pathFile);
            return true;
        }
        return false;
    }

    public function processFile(LuoghiInteresse $luoghiinteresse, Request $req = null)
    {
        if(!$req)
        {
            $req = request();
            if($luoghiinteresse->pathFile && Storage::exists($luoghiinteresse->pathFile))
            {
                Storage::delete($luoghiinteresse->pathFile);
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

        $filename = $file->store(env('PTH_LUOGHI' ).'/'. $luoghiinteresse->id);
        $luoghiinteresse->pathFile = $filename;
    }

    public function deleteFile(LuoghiInteresse $luoghiinteresse)
    {
        if($luoghiinteresse->pathFile && Storage::exists($luoghiinteresse->pathFile))
        {
            Storage::delete($luoghiinteresse->pathFile);
            return true;
        }
        return false;
    }

    public function deleteFotoLuoghi(FotoLuoghiInteresse $fotoluoghiinteresse)
    {
        if($fotoluoghiinteresse->pathImage && Storage::exists($fotoluoghiinteresse->pathImage))
        {
            Storage::delete($fotoluoghiinteresse->pathImage);
            return true;
        }
        return false;
    }


}
