<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountAddress extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'account_id', 'type', 'street', 'city', 'state', 'postalcode', 'country',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
