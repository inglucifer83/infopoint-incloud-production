<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiorniSettimana extends Model
{
    protected $table = "giornisettimana";
    protected $primaryKey = "id";

    use HasFactory;
}
