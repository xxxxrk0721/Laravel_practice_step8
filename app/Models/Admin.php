<?php

namespace App\Models;

use App\Models\TaskList;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\User;
use Illuminate\Foundation\Auth\User as Authenticatable; // ここを追加

//class Admin extends Model
class Admin extends Authenticatable
{
//    use HasFactory;
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'admins';
//    const DELETED_AT = 'del_flg';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function TaskList()
    {
        return $this->hasMany(TaskList::class);
    }

    public function User()
    {
        return $this->hasMany(User::class);
    }
}
