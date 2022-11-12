<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthUserGroup extends Model
{
    protected $table = 'auth_user_groups';

    protected $fillable = [
        'user_id',
        'group_id',
    ];

    public function user()
    {
        return $this->belongsTo(AuthUser::class, 'user_id');
    }

    public function group()
    {
        return $this->belongsTo(AuthGroup::class, 'group_id');
    }
}
