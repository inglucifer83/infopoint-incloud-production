<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use App\Models\News;
use App\Models\TipoNews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{Eventi, User, Comuni, TipoEvento};

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $id = Auth::user()->getUserInfopointId();
        $dataattuale = Carbon::now()->toDateString();
        if($id)
        {
            $eventi = Eventi::where('inizio_evento', '<=', $dataattuale)->where('fine_evento', '>=', $dataattuale)->where('comune_id', '!=', $id)->get();
            $eventicomune = Eventi::where('inizio_evento', '<=', $dataattuale)->where('fine_evento', '>=', $dataattuale)->where('comune_id', '=', $id)->paginate(7);
            $comuni = Comuni::select('id', 'nomecomune')->get();
            $tipoeventi = TipoEvento::select('id', 'descrizione')->get();
            $news = News::orderBy('id', 'DESC')->paginate(5);
            $tiponews = TipoNews::select('id', 'descrizione', 'icona', 'colore')->get();
            $users = User::get();

            return view('dashboard', compact('eventi', 'eventicomune', 'comuni', 'tipoeventi', 'news', 'tiponews', 'users'));
        }
        else if(Auth::user()->isAdmin())
        {
            $eventi = Eventi::where('inizio_evento', '<=', $dataattuale)->where('fine_evento', '>=', $dataattuale)->get();
            return view('dashboardadmin', compact('eventi'));
        }
    }
}
