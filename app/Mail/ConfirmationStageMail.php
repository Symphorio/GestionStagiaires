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
    public $internCode;
    
    public function __construct(DemandeStage $demande, $internCode)
    {
        $this->demande = $demande;
        $this->internCode = $internCode;
    }
    
    public function build()
    {
        return $this->subject('Confirmation de votre demande de stage')
                    ->view('emails.confirmation_stage')
                    ->with([
                        'demande' => $this->demande,
                        'internCode' => $this->internCode
                    ]);
    }
}