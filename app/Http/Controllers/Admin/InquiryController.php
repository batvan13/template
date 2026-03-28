<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\InquiryMail;
use App\Models\Inquiry;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class InquiryController extends Controller
{
    public function index()
    {
        $status = request('status', 'all');
        $allowed = ['all', Inquiry::STATUS_RECEIVED, Inquiry::STATUS_NOTIFIED, Inquiry::STATUS_MAIL_FAILED];

        if (! in_array($status, $allowed, true)) {
            $status = 'all';
        }

        $query = Inquiry::query()->orderByDesc('created_at');

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $inquiries = $query->paginate(20)->withQueryString();

        return view('admin.inquiries.index', [
            'inquiries' => $inquiries,
            'filter'    => $status,
        ]);
    }

    public function show(Inquiry $inquiry)
    {
        return view('admin.inquiries.show', ['inquiry' => $inquiry]);
    }

    public function resend(Inquiry $inquiry)
    {
        if ($inquiry->status !== Inquiry::STATUS_MAIL_FAILED) {
            return redirect()
                ->route('admin.inquiries.show', $inquiry)
                ->with('error', 'Повторно изпращане е възможно само при неуспешен имейл.');
        }

        $recipient = setting('contact_email');

        if (! $recipient) {
            return redirect()
                ->route('admin.inquiries.show', $inquiry)
                ->with('error', 'Няма конфигуриран контактен имейл в настройките.');
        }

        $data = [
            'name'    => $inquiry->name,
            'email'   => $inquiry->email,
            'phone'   => $inquiry->phone,
            'message' => $inquiry->message,
        ];

        try {
            Mail::to($recipient)->send(new InquiryMail($data));

            $inquiry->update([
                'status'      => Inquiry::STATUS_NOTIFIED,
                'notified_at' => now(),
                'mail_error'  => null,
            ]);

            return redirect()
                ->route('admin.inquiries.show', $inquiry)
                ->with('success', 'Имейлът е изпратен успешно.');
        } catch (\Throwable $e) {
            $inquiry->update([
                'status'     => Inquiry::STATUS_MAIL_FAILED,
                'mail_error' => Str::limit($e->getMessage(), 500),
            ]);

            logger()->error('Inquiry mail resend failed', [
                'inquiry_id' => $inquiry->id,
                'exception'  => $e::class,
                'message'    => $e->getMessage(),
            ]);

            return redirect()
                ->route('admin.inquiries.show', $inquiry)
                ->with('error', 'Изпращането отново не успя. Вижте грешката по-долу.');
        }
    }
}
