<?php

namespace App\Console\Commands;

use App\Mail\Quote\SendQuoteMail;
use App\Quote;
use App\Subscriber;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendQuotesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:quote';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send quote';

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
     * @return mixed
     */
    public function handle()
    {
        // Find subscribers
        $subscribers = Subscriber::with('quotes')->withCount('quotes')->active()->get();
        $nextQuote = null;
        // Foreach subscribers
        foreach ($subscribers as $subscriber) {
            $lastQuote = $subscriber->quotes()->where('subscriber_id', $subscriber->id)->orderBy('pivot_created_at', 'desc')->first();
            $firstQuote = $subscriber->quotes()->where('subscriber_id', $subscriber->id)->orderBy('pivot_created_at')->first();
            // Find last quote or create first quote
            if ($lastQuote) {
                if ($lastQuote->id > $firstQuote->id) {
                    $nextQuote = Quote::where('id', '>', $lastQuote->id)->first();
                } elseif ($subscriber->quotes_count == 1) {
                    $nextQuote = Quote::where('id', '>', $lastQuote->id)->first();
                }
            } else {
                $nextQuote = Quote::first();
            }
            // If next quote exist
            if ($nextQuote) {
                // Attach subscriber and quote
                $subscriber->quotes()->attach($nextQuote->id);
                // Send mail
                Mail::to($subscriber->email)->queue((new SendQuoteMail($subscriber, $nextQuote))->onQueue('emails'));
            }
        }
    }
}
