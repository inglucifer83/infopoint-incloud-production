<?php

namespace App\Models;

use App\Models\Comuni;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InfoPoint extends Model
{
    protected $table = "infopoint"; 
    protected $primaryKey = "id";

    protected $fillable = ['id', 'denominazione', 'comune_id'];

    use SoftDeletes;
    use HasFactory;

    public function getPathInfopointAttribute(){
        $url_image = $this->pathImage;
        if(stristr($this->pathImage, 'http') === false){
            $url_image = 'storage/'.$this->pathImage;
        }
        return $url_image;
    }

    
}
