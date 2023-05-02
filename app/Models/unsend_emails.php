<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class unsend_emails extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'unsent_email';

    protected $fillable = [
        'user_id',
        'email',
        'message',
        'timezone',
        'status'
    ];

    public static function get_unsent_user() {
        //$unsent_user_ids = DB::table('unsent_email')->select('user_id');
 
        $users = DB::table('unsent_email')
            ->join('user_birthday', 'user_birthday.id', '=', 'unsent_email.user_id')
            //->select('unsent_email.id AS ue_id, unsent_email.user_id AS id, unsent_email.message AS message, user_birthday.id, user_birthday.first_name, user_birthday.last_name, user_birthday.email, user_birthday.birthdate, user_birthday.timezone')
            //->select('unsent_email.id AS ue_id, unsent_email.user_id AS id, unsent_email.message AS message, user_birthday.*')
            ->get();

        return $users;
    }
}
