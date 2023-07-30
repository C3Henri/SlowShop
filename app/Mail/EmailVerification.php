<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Cliente;

class EmailVerification extends Mailable
{
    use Queueable, SerializesModels;

    public $cliente;

    public function __construct(Cliente $cliente)
    {
        $this->cliente = $cliente;
    }

    public function build()
    {
        return $this->subject('Bem-vindo à SlowShop!')
                    ->attach(public_path('/logo.svg'), [
                        'as' => 'logo.svg',
                        'mime' => 'image/svg+xml',
                    ])
                    ->markdown('emails.welcome');
    }
}
