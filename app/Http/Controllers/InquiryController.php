<?php

namespace App\Http\Controllers;

use App\Http\Requests\InquiryRequest;
use App\Mail\InquiryMail;
use App\Models\Inquiry;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class InquiryController extends Controller
{
    public function submit(InquiryRequest $request)
    {
        $validated = $request->validated();
        $payload = Arr::only($validated, ['name', 'email', 'phone', 'message']);

        $inquiry = Inquiry::create([
            ...$payload,
            'status' => Inquiry::STATUS_RECEIVED,
        ]);

        $recipient = setting('contact_email');

        if (! $recipient) {
            logger()->warning('Inquiry saved without mail recipient', [
                'inquiry_id' => $inquiry->id,
            ]);

            return back()->with('inquiry_success', 'Запитването беше получено успешно.');
        }

        try {
            Mail::to($recipient)->send(new InquiryMail($payload));

            $inquiry->update([
                'status'      => Inquiry::STATUS_NOTIFIED,
                'notified_at' => now(),
                'mail_error'  => null,
            ]);
        } catch (\Throwable $e) {
            $inquiry->update([
                'status'     => Inquiry::STATUS_MAIL_FAILED,
                'mail_error' => Str::limit($e->getMessage(), 500),
            ]);

            logger()->error('Inquiry mail failed', [
                'inquiry_id' => $inquiry->id,
                'exception'  => $e::class,
                'message'    => $e->getMessage(),
            ]);
        }

        return back()->with('inquiry_success', 'Запитването беше получено успешно.');
    }
}
