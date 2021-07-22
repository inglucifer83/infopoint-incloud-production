<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GruppoFiles extends Model
{
    protected $table = "gruppofiles"; 
    protected $primaryKey = "id";

    use HasFactory;
}
