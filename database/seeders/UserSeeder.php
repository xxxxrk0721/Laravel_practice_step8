<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => '管理者',
            'email' => 'user1@example.com',  // 任意の管理者用メールアドレス
            'password' => ('password'),
            'remember_token' => null,  // remember_token を NULL に設定（必要に応じて設定）
            'user_id' => 1,  // 任意の user_id
            'created_at' => Carbon::now(),  // 現在の日時
            'updated_at' => Carbon::now(),  // 現在の日時
            'deleted_at' => null,  // del_flg を false に設定
        ]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
