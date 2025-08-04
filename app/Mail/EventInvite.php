<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventInvite extends Mailable
{
    use Queueable, SerializesModels;

    public $invite;
    public $event;
    public $setting;
    public $inviteUrl;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($invite, $event, $setting, $inviteUrl)
    {
        $this->invite = $invite;
        $this->event = $event;
        $this->setting = $setting;
        $this->inviteUrl = $inviteUrl;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Event Invitation: ' . $this->event->name;
        
        return $this->from($this->setting->sender_email, $this->setting->app_name)
            ->subject($subject)
            ->view('emails.event-invite')
            ->with([
                'invite' => $this->invite,
                'event' => $this->event,
                'setting' => $this->setting,
                'inviteUrl' => $this->inviteUrl,
            ]);
    }
}
