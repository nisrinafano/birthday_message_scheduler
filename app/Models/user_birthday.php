<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class user_birthday extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'user_birthday';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'birthdate',
        'location',
        'timezone'
    ];

    public static function get_selected_user(Array $timezone) {
        return DB::table('user_birthday')
            ->whereIn('timezone', $timezone)
            ->get();
    }
}