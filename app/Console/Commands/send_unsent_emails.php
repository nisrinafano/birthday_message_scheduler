<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\unsend_emails;
use App\Http\Controllers\api\user_controller;

class send_unsent_emails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'unsent_email:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $selected_user = unsend_emails::get_unsent_user();
        if ($selected_user) {
            foreach ($selected_user as $users) {
                user_controller::send_message_email($users, 'birthday');
            }
        }
    }
}
