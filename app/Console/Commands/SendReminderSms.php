<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Twilio\Rest\Client;

class SendReminderSms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-reminder-sms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send SMS reminders for orders two days before the order date';

    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today_date = Carbon::now()->format('Y-m-d');
        $orders = Order::with('MembersData')->where('date', $today_date)->where('status', 0)->select('id', 'date', 'timing')->get();
        $name = User::where('id', auth()->id())->value('name');

        foreach ($orders as $order) {
            $time = '';
            if ($order->timing == 0) {
                $time = 'Morning';
            } elseif ($order->timing == 1) {
                $time = 'Noon';
            } else {
                $time = 'Evening';
            }

            foreach ($order->MembersData as $member) {

                $message = "Hello $member->name, Greetings of the day! Get ready for your upcoming order on $order->date at $time with" . $name . ".";

                $this->sendSms($message, $member->mobile);
            }
        }

        $this->info('Reminder SMS sent successfully.');

    }

    protected function sendSms($msg, $mobileNumber)
    {
        $sid = env('TWILIO_SID');
        $authToken = env('TWILIO_AUTH_TOKEN');
        $twilioNumber = env('TWILIO_PHONE_NUMBER');

        $client = new Client($sid, $authToken);

        $message = $msg;

        try {
            $client->messages->create(
                $mobileNumber, // Send to this number
                [
                    'from' => $twilioNumber, // From a valid Twilio number
                    'body' => $message
                ]
            );
            // dd(1);
        } catch (\Exception $e) {
            // dd($e->getMessage());

            // Log the error or handle as needed
            \Log::error('Twilio SMS failed: ' . $e->getMessage());
        }
    }

}
