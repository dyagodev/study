<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    const sent = 'sent';
    const canceled = 'canceled';
    const done = 'done';

    protected $fillable = [
        'amount',
        'status',
        'payer_id',
        'receiver_id'
    ];
}
