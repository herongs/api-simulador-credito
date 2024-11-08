<?php

namespace App\Mail;

use App\DataTransferObjects\SimulationsDto;
use App\Models\ExchangeRates;
use App\Models\Simulations;
use Brick\Money\Currency;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendExchangeSimulationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
       public Simulations $simulation,
       public ExchangeRates $exchangeRate,
       public SimulationsDto $dto,
    ) {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Simulação de Crédito - Câmbio',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.send_exchange_simulation_result',
            with: [
                'simulation' => $this->simulation,
                'exchangeRate' => $this->exchangeRate,
                'dto' => $this->dto,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
