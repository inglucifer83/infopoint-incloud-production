<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoNews extends Model
{
    protected $table = "tiponews"; 
    protected $primaryKey = "id";
    use HasFactory;
}
