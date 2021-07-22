<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\CreazioneNews;
use App\Http\Requests\NewsRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\{News, TipoNews, User};
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
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
        $news = News::orderBy('id', 'DESC')->get();
        $tiponews = TipoNews::select('id', 'descrizione')->get();
        $users = User::get();

        return view('news.list',
            compact('news', 'tiponews', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $req)
    {
        $news = new News();

        $id = $req->has('user_id')?$req->input('user_id') : null;

        $tiponews = TipoNews::select('id', 'descrizione')->get();

        return view('news.addnews', compact('news', 'tiponews'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewsRequest $req)
    {
        $news = new News();
        
        $news->tiponews_id = $req->input('tipoNews');
        $news->user_id = $req->input('user_id');
        $news->title = $req->input('inputTitolo');
        $news->descrizione = $req->input('inputDescrizione');

        $this->processFile($news);
       
        $res = $news->save();

        if($res)
        {
            event(new CreazioneNews($news, Auth::user()));
        }


        $messaggio = $res ? 'News creata con successo! ' : 'News non creata!';
        $color = $res ? 'alert-success' : 'alert-danger';
        session()->flash('message', $messaggio);
        session()->flash('color', $color);


        return redirect()->route('news.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show(News $news)
    {
        $tiponews = TipoNews::select('id', 'descrizione')->get();
        $users = User::get();

        return view('news.show',
            compact('news', 'tiponews', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit(News $news)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, News $news)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news)
    {
        $res = $news->delete();
        if($res)
        {
            $this->deleteFile($news);
        }
        return ''.$res;
    }

    public function processFile(News $news, Request $req = null)
    {
        if(!$req)
        {
            $req = request();
            if($news->pathFile && Storage::exists($news->pathFile))
            {
                Storage::delete($news->pathFile);
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

        $filename = $file->store(env('PTH_NEWS'));
        $news->pathFile = $filename;
    }

    public function deleteFile(News $news)
    {
        if($news->pathFile && Storage::exists($news->pathFile))
        {
            Storage::delete($news->pathFile);
            return true;
        }
        return false;
    }
}
