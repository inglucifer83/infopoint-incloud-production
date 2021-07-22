<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoLuoghiInteresse extends Model
{
    protected $table = "fotoluoghiinteresse";
    protected $primaryKey = "id";

    protected $fillable = ['id', 'pathImage'];

    public function getPathFotoLuoghiAttribute(){
        $url_image = $this->pathImage;
        if(stristr($this->pathImage, 'http') === false){
            $url_image = 'storage/'.$this->pathImage;
        }
        return $url_image;
    }

    use HasFactory;
}
