<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserController extends Controller
{
    public function getLaravelUserId(Request $request)
    {
        $firebaseUid = $request->query('firebase_uid');
        $name = $request->query('name') ?? 'Guest';
        $email = $request->query('email') ?? null;

        if (!$firebaseUid) {
            return response()->json(['error' => 'firebase_uid required'], 400);
        }

        // cek apakah sudah ada mapping
        $mapping = DB::table('firebase_users')->where('firebase_uid', $firebaseUid)->first();

        if ($mapping) {
            return response()->json(['laravel_user_id' => $mapping->laravel_user_id]);
        }

        // kalau belum ada, buat user baru di Laravel dan mapping
        $laravelUserId = DB::table('users')->insertGetId([
            'username' => $name,
            'email' => $email,
            'password_hash' => bcrypt(str()->random(16)), // password random
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('firebase_users')->insert([
            'firebase_uid' => $firebaseUid,
            'laravel_user_id' => $laravelUserId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['laravel_user_id' => $laravelUserId]);
    }

    public function syncUser(Request $request)
    {
        $firebaseUid = $request->input('firebase_uid');
        $username = $request->input('username') ?? 'Guest';
        $fullname = $request->input('full_name') ?? '';
        $email = $request->input('email') ?? '';
        $phone = $request->input('phone') ?? '';

        if (!$firebaseUid) {
            return response()->json(['error' => 'firebase_uid required'], 400);
        }

        $mapping = DB::table('firebase_users')->where('firebase_uid', $firebaseUid)->first();

        if ($mapping) {
            // update data jika user sudah ada
            DB::table('users')->where('id', $mapping->laravel_user_id)->update([
                'username' => $username,
                'full_name' => $fullname,
                'email' => $email,
                'phone' => $phone,
                'updated_at' => now()
            ]);
            $laravelUserId = $mapping->laravel_user_id;
        } else {
            // buat user baru
            $laravelUserId = DB::table('users')->insertGetId([
                'username' => $username,
                'full_name' => $fullname,
                'email' => $email,
                'phone' => $phone,
                'password_hash' => bcrypt(str()->random(16)),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('firebase_users')->insert([
                'firebase_uid' => $firebaseUid,
                'laravel_user_id' => $laravelUserId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json(['laravel_user_id' => $laravelUserId]);
    }

    public function updateFcmToken(Request $request)
    {
        $user = User::find($request->user_id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->fcm_token = $request->fcm_token;
        $user->save();

        return response()->json(['success' => true]);
    }


}
