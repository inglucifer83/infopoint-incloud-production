<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApertureStruttureRicettive extends Model
{
    protected $table = "aperturestrutturericettive"; 
    protected $primaryKey = "id";

    protected $fillable = ['id', 'strutturericettive_id', 'giornosettimana_id', 'orario_apertura', 'orario_chiusura'];

    use HasFactory;
}
