<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoStruttureRicettive extends Model
{
    protected $table = "tipostrutturericettive"; 
    protected $primaryKey = "id";

    use HasFactory;
}
