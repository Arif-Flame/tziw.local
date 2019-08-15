<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TaskMail extends Mailable
{
    use Queueable, SerializesModels;
    public $feedback;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {   info($data);
        $this->type = $data["type"];
        $this->user_name =$data['user_name'];
        $this->theme = $data['theme'];
        $this->text = $data['message'];
        $this->ansver = $data["ansver"] ;





        info($data);
//        $this->username = $data['user_name'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

            $this->view('mails.tasksCreate', ['type'=>$this->type, 'user_name' => $this->user_name, 'theme' => $this->theme, 'text' => $this->text, 'ansver' => $this->ansver]);

    }
}
