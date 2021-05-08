<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryService extends Model
{
    protected $table = 'delivery_services';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

}