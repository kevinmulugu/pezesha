<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Transaction
 * @package App
 *
 * ORM for Transaction instance.
 */
class Transaction extends Model
{
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    /**
     * Finds the customer for this transaction.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Format the amount
     * @param $value
     * @return string
     */
    public function getAmountAttribute($value)
    {
        return number_format($value, 2);
    }
}
