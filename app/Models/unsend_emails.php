<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class unsend_emails extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'user_birthday';

    protected $fillable = [
        'user_id',
        'email',
        'message',
        'timezone',
        'status'
    ];

    public static function get_unsent_user() {
        $unsent_user_ids = DB::table('unsent_email')->select('user_id');
 
        $users = DB::table('user_birthday')
            ->whereIn('id', $unsent_user_ids)
            ->get();

        return $users;
    }
}
