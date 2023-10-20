<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactAddress extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'contact_id', 'type', 'street', 'city', 'state', 'postalcode', 'country',
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
