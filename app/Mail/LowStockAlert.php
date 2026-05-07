<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LowStockAlert extends Mailable
{
    use Queueable, SerializesModels;

    public array $lowStockProducts;

    public function __construct(array $lowStockProducts)
    {
        $this->lowStockProducts = $lowStockProducts;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '⚠️ Alert Stok Kritis — TokoAdv',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.low-stock-alert',
        );
    }
}