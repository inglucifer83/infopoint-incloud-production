<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comuni extends Model
{
    protected $table = "comuni"; 
    protected $primaryKey = "id";

    use SoftDeletes;
    use HasFactory;

    public function infopoint()
    {
        return $this->hasMany(Infopoint::class, 'comune_id');
    }

    public function getPathComuneLogoAttribute(){
        $url_image = $this->pathImage;
        if(stristr($this->pathImage, 'http') === false){
            $url_image = 'storage/'.$this->pathImage;
        }
        return $url_image;
    }

    use HasFactory;
}
