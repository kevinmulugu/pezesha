<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LoanFunding
 * @package App
 *
 * ORM for LoanFunding instance.
 */
class LoanFunding extends Model
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
     * Finds the Loan for this funding
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
