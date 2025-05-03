<?php

namespace App\Mail;

use App\Models\DemandeStage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmationStageMail extends Mailable
{
    use Queueable, SerializesModels;

    public $demande;

    public function __construct(DemandeStage $demande)
    {
        $this->demande = $demande;
    }

    public function build()
    {
        return $this->subject('Confirmation de votre demande de stage')
                    ->view('emails.confirmation-stage');
    }
}