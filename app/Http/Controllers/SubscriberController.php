<?php

namespace App\Http\Controllers;

use App\Http\Requests\Subscriber\StoreSubscriberRequest;
use App\Http\Requests\Subscriber\UpdateSubscriberRequest;
use App\Mail\Subscriber\WelcomeSubscriberMail;
use App\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SubscriberController extends Controller
{
    public function __construct()
    {
        $this->middleware('unpaid')->only(['update', 'updateStatus']);
    }

    public function indexData(Request $request)
    {
        $filters = $request->get('filters');
        $subscribers = Subscriber::where('email', 'LIKE', '%'.$request->get('searchKeyword').'%');

        if ($filters['status']) {
            $subscribers->where('status', $filters['status']);
        }

        return response()->custom(200, "Subscribers!", $subscribers->orderBy('id', 'desc')->paginate(10));
    }

    public function store(StoreSubscriberRequest $request)
    {
        $subscriber = Subscriber::where('email', $request->get('email'))->first();

        if (!$subscriber) {
            $subscriber = new Subscriber;
            $subscriber->fill($request->all());

            if ($subscriber->save()) {
                return response()->custom(200, "Subscriber created!", $subscriber);
            }

            return response()->custom(400, "Subscriber not created!", null);
        }

        return response()->custom(200, "Subscriber already exist!", $subscriber);
    }

    public function update(UpdateSubscriberRequest $request, Subscriber $subscriber)
    {
        if ($request->has('status')) {
            $subscriber->status = $request->get('status');
        }

        if ($subscriber->update()) {
            sendMails($subscriber);
            return response()->custom(200, "Subscriber updated!", $subscriber);
        }

        return response()->custom(400, "Subscriber not updated!", $subscriber);
    }

    public function updateStatus(Subscriber $subscriber, $status)
    {
        if ($status == Subscriber::ACTIVE_STATUS) {
            $subscriber->status = Subscriber::ACTIVE_STATUS;
        } elseif ($status == Subscriber::INACTIVE_STATUS) {
            $subscriber->status = Subscriber::INACTIVE_STATUS;
        }

        if ($subscriber->update()) {
            sendMails($subscriber);
            return redirect()->route('home');
        }

        return redirect()->route('home');
    }

    public function updateActiveStatus(Subscriber $subscriber)
    {
        $subscriber->status = Subscriber::ACTIVE_STATUS;

        if ($subscriber->update()) {
            Mail::to($subscriber->email)->queue((new WelcomeSubscriberMail($subscriber))->onQueue('emails'));
            return response()->custom(200, "successfully", $subscriber);
        }

        return response()->custom(400, "unsuccessfully", $subscriber);
    }

    public function sendMail(Subscriber $subscriber)
    {
        sendMails($subscriber);
        return response()->custom(200, "Mail!", $subscriber);
    }
}
