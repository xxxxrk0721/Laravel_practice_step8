<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Admin;

class TaskList extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'task_name',
        'ymd_to',
        'ymd_from',
        'task_content',
        'user_id',
        'status',
        'del_flg'
    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
