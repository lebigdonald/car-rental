<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\ContactMail;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * @param ContactRequest $request
     * @return RedirectResponse
     */
    public function send(ContactRequest $request)
    {
        $data = $request->validated();

        try {
            // Send email to admin (using the FROM address as the recipient for now, or a specific admin email)
            Mail::to(config('mail.from.address'))->send(new ContactMail($data));
        } catch (Exception $exception) {
            return redirect()->back()->withErrors(['message' => 'Une erreur est survenue lors de l\'envoi du message. Veuillez réessayer plus tard.']);
        }

        return redirect()->back()->with('success', 'Votre message a été envoyé avec succès.');
    }
}
