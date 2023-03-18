<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'auth_user';

    public $timestamps = false;

    const ROLE_SELECT = [
        'staff' => 'Karyawan',
        'student' => 'Murid',
        'teacher' => 'Guru',
    ];

    const ROLE_COLOR = [
        'staff' => 'green',
        'student' => 'yellow',
        'teacher' => 'indigo',
    ];

    protected $fillable = [
        'password',
        'last_login',
        'is_superuser',
        'username',
        'first_name',
        'last_name',
        'email',
        'is_staff',
        'is_active',
        'date_joined',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'last_login' => 'datetime',
        'date_joined' => 'datetime',
    ];

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'auth_user_groups', 'user_id', 'group_id');
    }
}
