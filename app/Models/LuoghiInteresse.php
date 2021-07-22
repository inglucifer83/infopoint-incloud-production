<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LuoghiInteresse extends Model
{
    protected $table = "luoghiinteresse";
    protected $primaryKey = "id";

    public function images() {
        return $this->hasMany(FotoLuoghiInteresse::class, 'luogointeresse_id', 'id');
    }


    public function getPathLuoghiInteresseAttribute(){
        $url_image = $this->pathImage;
        if(stristr($this->pathImage, 'http') === false){
            $url_image = 'storage/'.$this->pathImage;
        }
        return $url_image;
    }

    public function getPathFileLuoghiInteresseAttribute(){
        $url_file = $this->pathFile;
        if(stristr($this->pathFile, 'http') === false){
            $url_file = 'storage/'.$this->pathFile;
        }
        return $url_file;
    }

    use HasFactory;
}
