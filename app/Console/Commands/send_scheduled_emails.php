<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DateTimeZone;
use Carbon\Carbon;
use App\Models\user_birthday;
use App\Http\Controllers\api\user_controller;
use Illuminate\Support\Facades\Http;

class send_scheduled_emails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scheduled_email:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send scheduled email for everyday at 09.00 a.m';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $selected_timezone = [];
        
        // get user's unique timezone 
        $timezones = DateTimeZone::listIdentifiers();

        foreach ($timezones as $timezone) { 
            $date = Carbon::now($timezone); 
            // send only at 9:00 am 
            if ($date->hour == 9 && $date->minute == 0) {
                array_push($selected_timezone, $timezone);
            }
        }

        $selected_user = user_birthday::get_selected_user($selected_timezone);

        if ($selected_user) {
            foreach ($selected_user as $users) {
                $email_message = 'Hey, ' . $users->first_name . ' ' . $users->last_name . ' it\'s your birthday';

                if ((date('m', strtotime($users->birthdate)) == date('m', strtotime($date))) && (date('d', strtotime($users->birthdate)) == date('d', strtotime($date)))) {
                    user_controller::send_message_email($users, 'birthday');
                }
            }
        }
    }
}
