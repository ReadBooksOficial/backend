<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = "my_notifications";

    protected $primaryKey = 'id_my_notification';

    protected $fillable = [
        'id_user', 
        'text_notification', 
        'link', 
        'text_link',
        'type_notification',
        'old_version_app',
        'new_version_app',
        'excludable',
    ];
}
