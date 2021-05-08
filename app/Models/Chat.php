<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $table = 'chatting';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    
}
