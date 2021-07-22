<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApertureLuoghiInteresse extends Model
{
    protected $table = "apertureluoghiinteresse"; 
    protected $primaryKey = "id";

    protected $fillable = ['id', 'luogointeresse_id', 'giornosettimana_id', 'orario_apertura', 'orario_chiusura']; 


    use HasFactory;
}
