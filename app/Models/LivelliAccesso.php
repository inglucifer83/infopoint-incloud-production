<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LivelliAccesso extends Model
{
    protected $table = "livelliaccesso"; 
    protected $primaryKey = "id";

    use HasFactory;
}
