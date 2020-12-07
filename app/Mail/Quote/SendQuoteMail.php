<?php

namespace App\Mail\Quote;

use App\Quote;
use App\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendQuoteMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subscriber;
    public $quote;

    /**
     * Create a new message instance.
     *
     * @param Subscriber $subscriber
     * @param Quote $quote
     * @return void
     */
    public function __construct(Subscriber $subscriber, Quote $quote)
    {
        $this->subscriber = $subscriber;
        $this->quote = $quote;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.quote.send-quote-mail')
            ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject(__('mail.newQuote'));
    }
}
