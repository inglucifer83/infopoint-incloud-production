<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilesInfopoint extends Model
{
    protected $table = "filesinfopoint"; 
    protected $primaryKey = "id";
    protected $fillable = ['id', 'descrizioneFile', 'gruppo_id', 'comune_id', 'infopoint_id', 'livelloaccesso_id'];
    
    public function getPathInfopointFilesAttribute(){
        $url_image = $this->pathFile;
        if(stristr($this->pathFile, 'http') === false){
            $url_image = 'storage/'.$this->pathFile;
        }
        return $url_image;
    }

    use HasFactory;
}
