<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Loan
 * @package App
 *
 * ORM for Loan instance.
 */
class Loan extends Model
{
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    /**
     * Finds the customer for this loan
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Find fundings for this loan
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function loanFundings()
    {
        return $this->hasMany(LoanFunding::class);
    }

    /**
     * Finds payments made for this loan.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
