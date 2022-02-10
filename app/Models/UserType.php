<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    use HasFactory;

    const commonType = 1;
    const shopkeepersType = 2;

    protected $fillable = [
        'name',
        'description',
    ];
}
