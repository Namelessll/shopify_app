<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserModel extends Model
{
    use HasFactory;

    public static function getUser($userId) {
        return DB::table('users')
            ->where('users.id', $userId)
            ->select('users.*')
            ->first();
    }

    public static function updateUser($userId, $data) {
        return DB::table('users')
            ->where('users.id', $userId)
            ->update($data);
    }

    public static function getUserField($userId, $field = null) {
        if ($field)
            return DB::table('users')
                ->where('users.id', $userId)
                ->select('users.'.$field)
                ->first();
        else
            return DB::table('users')
                ->where('users.id', $userId)
                ->select('users.*')
                ->first();
    }

    public static function getFreePlan() {
        return DB::table('plans')
            ->where('plans.price', '=', 0)
            ->select('plans.*')
            ->first();
    }
}
