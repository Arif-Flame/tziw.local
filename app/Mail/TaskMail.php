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
        if ($this->type == "updating") {
            $this->ansver = $data["ansver"];
        }




//        dd($data);
//        $this->username = $data['user_name'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
    if ($this->type == "creating") {
            $this->view('mails.tasksCreate', ['user_name' => $this->user_name, 'theme' => $this->theme, 'text' => $this->text]);
        }
        else{
                $this->view('mails.tasksCreate', ['theme' => $this->theme, 'ansver' => $this->ansver]);
        }
    }
}
