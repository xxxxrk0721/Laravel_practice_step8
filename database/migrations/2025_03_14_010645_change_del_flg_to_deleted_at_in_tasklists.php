<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // `deleted_at` カラムが存在しない場合のみ追加
        if (!Schema::hasColumn('task_lists', 'deleted_at')) {
            Schema::table('task_lists', function (Blueprint $table) {
                $table->softDeletes(); // `deleted_at` (timestamp型) を追加
            });
        }

        // `del_flg` のデータを `deleted_at` に移行
        if (Schema::hasColumn('task_lists', 'del_flg')) {
            DB::statement("UPDATE task_lists SET deleted_at = NOW() WHERE del_flg = 1");
        }

        // `del_flg` カラムが存在する場合のみ削除
        if (Schema::hasColumn('task_lists', 'del_flg')) {
            Schema::table('task_lists', function (Blueprint $table) {
                $table->dropColumn('del_flg');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // `del_flg` カラムが存在しない場合のみ復元
        if (!Schema::hasColumn('task_lists', 'del_flg')) {
            Schema::table('task_lists', function (Blueprint $table) {
                $table->boolean('del_flg')->default(0);
            });
        }

        // `deleted_at` のデータを `del_flg` に移行
        DB::statement("UPDATE task_lists SET del_flg = 1 WHERE deleted_at IS NOT NULL");

        // `deleted_at` カラムが存在する場合のみ削除
        if (Schema::hasColumn('task_lists', 'deleted_at')) {
            Schema::table('task_lists', function (Blueprint $table) {
                $table->dropColumn('deleted_at');
            });
        }
    }
};
