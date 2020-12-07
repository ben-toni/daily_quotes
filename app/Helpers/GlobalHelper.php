<?php

use App\Mail\Subscriber\SubscriberDeactivatedMail;
use App\Mail\Subscriber\SubscriberReactivatedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;
use KgBot\LaravelLocalization\Facades\ExportLocalizations;


/**
 * @return mixed
 */
function returnLocalizationMessage() {

    Artisan::call('cache:clear');

    return ExportLocalizations::export()->toArray();
}

/**
 * Send mail for activate or deactivate
 *
 * @param $subscriber
 * @return mixed
 */
function sendMails($subscriber) {
    // Send email
    if ($subscriber->status == $subscriber::ACTIVE_STATUS) {
        Mail::to($subscriber->email)->queue((new SubscriberReactivatedMail($subscriber))->onQueue('emails'));
    } elseif ($subscriber->status == $subscriber::INACTIVE_STATUS) {
        Mail::to($subscriber->email)->queue((new SubscriberDeactivatedMail($subscriber))->onQueue('emails'));
    }
}
