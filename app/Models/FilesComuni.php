<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilesComuni extends Model
{
    protected $table = "filescomuni"; 
    protected $primaryKey = "id";
    protected $fillable = ['id', 'descrizioneFile', 'gruppo_id', 'comune_id'];

    
    public function getPathComuneFilesAttribute(){
        $url_image = $this->pathFile;
        if(stristr($this->pathFile, 'http') === false){
            $url_image = 'storage/'.$this->pathFile;
        }
        return $url_image;
    }

    use HasFactory;
}
