<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = array(
        'user_id',
        'category_id',
        'type_id',
        'amount',
        'short_description',
        'additional_notes',
        'date'
    );
}
