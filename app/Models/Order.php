<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    const SENT = 'sent';
    const CANCELED = 'canceled';
    const DONE = 'done';

    protected $fillable = [
        'amount',
        'status',
        'payer_id',
        'receiver_id'
    ];

    /**
     * Get the payee that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id', 'id');
    }


    /**
     * Get the payer that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'payer_id', 'id');
    }
}
