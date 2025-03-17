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

    protected $table = 'task_lists';
//    const DELETED_AT = 'del_flg';

    protected $fillable = [
        'task_name',
        'ymd_to',
        'ymd_from',
        'task_content',
        'user_id',
        'status',
        'deleted_at'
    ];

    // デフォルトで 'del_flg' が 0（削除されていない）場合に表示
//    protected $casts = [
//        'del_flg' => 'boolean',  // 'del_flg' カラムを boolean としてキャスト
//    ];

    // 論理削除（del_flg を 1 にする）
//    public function softDelete()
//    {
//        $this->del_flg = 1;  // 削除フラグを 1 に設定
//        $this->save();
//    }

    // 削除されていないタスクを取得するスコープ
//    public function scopeNotDeleted($query)
//    {
//        return $query->where('del_flg', 0);  // del_flg が 0 のタスク（削除されていない）
//    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
