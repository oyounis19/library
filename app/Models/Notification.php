<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = [
        'message',
        'is_read',
    ];

    public function markAsRead(){
        $this->is_read = true;
        return $this->save();
    }

    public function markAsUnread(){
        $this->is_read = false;
        return $this->save();
    }
}
