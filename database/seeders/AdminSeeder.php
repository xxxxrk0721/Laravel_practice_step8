<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('admins')->insert([
            'name' => '管理者',
            'email' => 'admin3@example.com',  // 任意の管理者用メールアドレス
//            'password' => Hash::make('password123'),  // ハッシュ化したパスワード
            'password' => ('password'),
            'remember_token' => null,  // remember_token を NULL に設定（必要に応じて設定）
            'user_id' => 1,  // 任意の user_id
            'created_at' => Carbon::now(),  // 現在の日時
            'updated_at' => Carbon::now(),  // 現在の日時
            'del_flg' => false,  // del_flg を false に設定
        ]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
