<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationDetail extends Model
{
    protected $table = 'notification_detail';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    
    public function notification() {
        return $this->belongsTo(Notification::class);
    }
    
}
