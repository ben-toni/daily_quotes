<?php

namespace App\Mail\Subscriber;

use App\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class SubscriberReactivatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subscriber;
    public $url;

    /**
     * Create a new message instance.
     *
     * @param Subscriber $subscriber
     * @return void
     */
    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
        $this->url = Url::signedRoute('change-status-mail', ['subscriber' => $subscriber->id, 'status' => 'INACTIVE']);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.subscriber.subscriber-reactivated-mail')
            ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject(__('mail.activatedAcc'));
    }
}
