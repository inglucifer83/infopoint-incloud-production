<?php

namespace App\Models;

use App\Models\InfoPoint;
use Exception;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'infopoint_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin()
    {
        return $this->role_id === 2;
    }

    public function getUserInfopointId()
    {
        if($this->infopoint_id !== 0){
            
            try
            {
                $infopoint = InfoPoint::where('id', $this->infopoint_id)->firstOrFail();
		$comune = Comuni::where('id', $infopoint->comune_id)->firstOrFail();

                return $comune->id;
            }
            catch(Exception $e)
            {
                return 0;
            }
            
        }
        
    }

public function getUserComuneName($id)
    {
       
        $users = User::where('id', $id)->firstOrFail();
        
        if($users->infopoint_id !== 0)
        {
            $infopoint = InfoPoint::where('id', $users->infopoint_id)->firstOrFail();
            
            $comuni = Comuni::where('id', $infopoint->comune_id)->firstOrFail();

            return $comuni->nomecomune;
                
        }
        else
        {
            return 'Tutti i Comuni';
        }
    }
    public function getPathAvatarAttribute(){
        $url_image = $this->pathImage;
        if(stristr($this->pathImage, 'http') === false){
            $url_image = 'storage/'.$this->pathImage;
        }
        return $url_image;
    }
}
