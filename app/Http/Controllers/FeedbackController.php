<?php

namespace App\Http\Controllers;

use App\Containers\Books\Classes\BinderImagesBooks;
use App\Http\Requests\FeedbackRequest;
use App\Mail\FeedbackFormMail;
use App\Models\Category;
use App\Models\Feedback;
use App\Models\Setting;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class FeedbackController extends Controller
{
    public function create()
    {
        return Inertia::render('Feedback', ['status' => session('status')]);
    }

    public function store(FeedbackRequest $request)
    {
        $request->validated();

        $feedback = Feedback::create($request->all());

        /// Отправка письма ///
        /*$emailRecipient = Setting::where('code', 'email_recipient')->first();
        $emailRecipient = $emailRecipient ? $emailRecipient->value : config('settings.default_email_recipient');
        Mail::to($emailRecipient)->send(new FeedbackFormMail($feedback));*/
        /// Отправка письма ///

        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
