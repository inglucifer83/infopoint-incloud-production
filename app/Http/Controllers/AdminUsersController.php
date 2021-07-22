<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\{Comuni, InfoPoint, LingueUser, User, Role, Lingue};

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('name')->get();
        $infopoint = InfoPoint::get();
        $comuni = Comuni::get();
        $role = Role::get();
        return view('users.listadmin', compact('users', 'comuni', 'infopoint', 'role'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User();

        $role = Role::get();
        $comuni = Comuni::get();
        $infopoint = InfoPoint::get();
        $lingueuser = LingueUser::get();
        $lingue = Lingue::get();

        return view('users.addeditadmin', compact('user', 'comuni', 'infopoint', 'role', 'lingueuser', 'lingue'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserFormRequest $req)
    {
        $user = new User();

        $user->name = $req->input('inputName');
        $user->email = $req->input('inputEmail');
        $user->role_id = $req->input('tipoRuolo');
        if($req->input('tipoRuolo') === '2')
        {
            $user->infopoint_id = 0;
        }
        else
        {
            $user->infopoint_id = $req->input('infopoint');
        }
        
        $user->cellulare = $req->input('inputCellulare');
        $user->password = bcrypt($req->input('password'));

        $this->processFile($user);
    
        $res = $user->save();

        $messaggio = $res ? 'Utente Creato! ' : 'Utente nonCreato!';
        $color = $res ? 'alert-success' : 'alert-danger';
        session()->flash('message', $messaggio);
        session()->flash('color', $color);

        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $role = Role::get();
        $comuni = Comuni::get();
        $infopoint = InfoPoint::get();
        $lingueuser = LingueUser::where('user_id', $user->id)->get();
        $lingue = Lingue::get();

        return view('users.addeditadmin', compact('user', 'comuni', 'infopoint', 'role', 'lingueuser', 'lingue'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserFormRequest $req, User $user)
    {
        if($req->hasFile('caricaImg'))
        {
            $this->processFile($user);
        }

        $user->name = $req->input('inputName');
        $user->email = $req->input('inputEmail');
        $user->role_id = $req->input('tipoRuolo');
        
        if($req->input('tipoRuolo') === '2')
        {
            $user->infopoint_id = 0;
        }
        else
        {
            $user->infopoint_id = $req->input('infopoint');
        }
        $user->cellulare = $req->input('inputCellulare');
    
        $res = $user->save();

        $messaggio = $res ? 'Utente Modificato! ' : 'Utente non modificato!';
        $color = $res ? 'alert-success' : 'alert-danger';
        session()->flash('message', $messaggio);
        session()->flash('color', $color);

        return redirect()->route('users.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $res = $user->delete();
        return ''.$res;
    }

    public function processFile(User $user, Request $req = null)
    {
        if(!$req)
        {
            $req = request();
            if($user->pathImage && Storage::exists($user->pathImage))
            {
                Storage::delete($user->pathImage);
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

        $filename = $file->store(env('IMG_USER'));
        $user->pathImage = $filename;
    }

    public function deleteFile(User $user)
    {
        if($user->pathImage && Storage::exists($user->pathImage))
        {
            Storage::delete($user->pathImage);
            return true;
        }
        return false;
    }
}
