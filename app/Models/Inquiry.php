<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    public const STATUS_RECEIVED = 'received';

    public const STATUS_NOTIFIED = 'notified';

    public const STATUS_MAIL_FAILED = 'mail_failed';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
        'status',
        'mail_error',
        'notified_at',
    ];

    protected $casts = [
        'notified_at' => 'datetime',
    ];
}
