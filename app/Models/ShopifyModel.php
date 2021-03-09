<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ShopifyModel extends Model
{
    use HasFactory;
    public static function getPlanById($planId) {
        return DB::table('plans')
            ->where('plans.id', $planId)
            ->select('plans.*')
            ->first();
    }
}
