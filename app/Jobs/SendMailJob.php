<?php

namespace App\Jobs;

use App\Mail\TaskMail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
//        $this->theme = $request['theme'];
//        $this->message = $request['message'];
//        $this->user_name = DB::table('users')->where('id', $request['user_id'])->value('name');
//        $this->user_email = DB::table('users')->where('id', $request['user_id'])->value('email');
//        $this->theme = $data['theme'];
//        $this->text = $data['text'];
//        $this->user_name = $data['user_name'];
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {


        $mail = new TaskMail($this->data);
        info($this->data['email']);
        Mail::to($this->data['email'])->send($mail);
    }
}
