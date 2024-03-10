<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AppToken extends Model
{
    protected $table = 'app_tokens';

    protected $primaryKey = 'app';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'app',
        'access_token',
        'refresh_token',
        'username',
        'expires_at',
    ];
}