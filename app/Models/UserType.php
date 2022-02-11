<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    use HasFactory;

    const COMMON_TYPE = 1;
    const SHOPKEEPERS_TYPE = 2;

    protected $fillable = [
        'name',
        'description',
    ];
}
