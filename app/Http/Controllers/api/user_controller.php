<?php

namespace App\Http\Controllers\api;

use App\Helpers\api_formatter;
use App\Http\Controllers\Controller;
use App\Models\user_birthday;
use App\Models\unsend_emails;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class user_controller extends Controller
{
    public function index() {
        $user_birthday = user_birthday::all();

        if ($user_birthday) return api_formatter::create_api(200, 'Success', $user_birthday);
        else return api_formatter::create_api(400, 'Data not found');
    }

    public function store(Request $request) {
        try {
            $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required',
                'birthdate' => 'required',
                'location' => 'required',
                'timezone' => 'required'
            ]);

            $valid_email = ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $request->email)) ? FALSE : TRUE;
            if (!$valid_email) return api_formatter::create_api(400, 'Email invalid');

            $user_birthday = user_birthday::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'birthdate' => $request->birthdate,
                'location' => $request->location,
                'timezone' => $request->timezone
            ]);

            // show the inserted data
            $new_user_birthday = user_birthday::find($user_birthday->id);

            if ($new_user_birthday) return api_formatter::create_api(200, 'Success', $new_user_birthday);
            else return api_formatter::create_api(400, 'Data not inserted');

        } catch (Exception $error) {
            return api_formatter::create_api(400, $error);
        }
    }

    public function update(Request $request, int $id) {
        try {
            $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required',
                'birthdate' => 'required',
                'location' => 'required',
                'timezone' => 'required'
            ]);

            $user_birthday = user_birthday::find($id);

            $valid_email = ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $request->email)) ? FALSE : TRUE;
            if (!$valid_email) return api_formatter::create_api(400, 'Email invalid');

            $user_birthday->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'birthdate' => $request->birthdate,
                'location' => $request->location,
                'timezone' => $request->timezone
            ]);

            // show the updated data
            $updated_user_birthday = user_birthday::find($user_birthday->id);

            if ($updated_user_birthday) return api_formatter::create_api(200, 'Success', $updated_user_birthday);
            else return api_formatter::create_api(400, 'Data not updated');

        } catch (Exception $error) {
            return api_formatter::create_api(400, $error);
        }
    }

    public function destroy(int $id) {
        $user_birthday = user_birthday::find($id);

        $deleted_user_birthday = $user_birthday->delete();

        if ($deleted_user_birthday) return api_formatter::create_api(200, 'Success');
        else return api_formatter::create_api(400, 'Data not deleted');
    }

    public static function send_message_email(Array $users, string $message_type) {
        $email_message = 'Hey, ' . $users['first_name'] . ' ' . $users['last_name'] . ' it\'s your ' . $message_type;
        
        $response = Http::post('https://eo93xtp2drzt01e.m.pipedream.net', [
            'email' => $users['email'],
            'message' => $email_message
        ]);

        // log unsend message
        if (!$response->ok()) {
            $user_birthday = user_birthday::create([
                'user_id' => $users['id'],
                'email' => $users['email'],
                'message' => $email_message,
                'timezone' => $users['timezone'],
                'status' => $response->status()
            ]);
        }
        return true;
    }
}