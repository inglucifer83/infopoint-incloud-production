<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{

    protected $table = "news"; 
    protected $primaryKey = "id";

    public function getPathFileNewsAttribute(){
        $url_file = $this->pathFile;
        if(stristr($this->pathFile, 'http') === false){
            $url_file = 'storage/'.$this->pathFile;
        }
        return $url_file;
    }


    use HasFactory;
}
