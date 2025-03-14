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
        Schema::table('users', function (Blueprint $table) {
            // `deleted_at` カラムが存在しない場合のみ追加
            if (!Schema::hasColumn('users', 'deleted_at')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->softDeletes(); // `deleted_at` (timestamp型) を追加
                });
            }

            // `del_flg` のデータを `deleted_at` に移行
            if (Schema::hasColumn('users', 'del_flg')) {
                DB::statement("UPDATE users SET deleted_at = NOW() WHERE del_flg = 1");
            }

            // `del_flg` カラムが存在する場合のみ削除
            if (Schema::hasColumn('users', 'del_flg')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->dropColumn('del_flg');
                });
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // `del_flg` カラムが存在しない場合のみ復元
            if (!Schema::hasColumn('users', 'del_flg')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->boolean('del_flg')->default(0);
                });
            }

            // `deleted_at` のデータを `del_flg` に移行
            DB::statement("UPDATE users SET del_flg = 1 WHERE deleted_at IS NOT NULL");

            // `deleted_at` カラムが存在する場合のみ削除
            if (Schema::hasColumn('users', 'deleted_at')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->dropColumn('deleted_at');
                });
            }
        });
    }
};
