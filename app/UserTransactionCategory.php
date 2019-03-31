<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTransactionCategory extends Model
{
    protected $fillable = [
        'user_id', 'type_id', 'title'
    ];
}
