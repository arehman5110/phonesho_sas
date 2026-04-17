<?php

namespace App\Mail;

use App\Models\Sale;
use App\Models\ShopSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    public array  $settings;
    public float  $totalPaid;
    public float  $outstanding;
    public float  $change;

    public function __construct(
        public Sale $sale,
        protected ?string $customSubject = null,
        protected ?string $customMessage = null,
    ) {
        $this->sale->loadMissing([
            'items.product',
            'customer',
            'payments',
            'createdBy',
            'shop',
        ]);

        $this->settings    = ShopSetting::getAllForShop($sale->shop_id);
        $this->totalPaid   = (float) $sale->payments->sum('amount');
        $this->outstanding = max(0, (float) $sale->final_amount - $this->totalPaid);
        $this->change      = max(0, $this->totalPaid - (float) $sale->final_amount);
    }

    public function envelope(): Envelope
    {
        if ($this->customSubject) {
            $subject = $this->customSubject;
        } else {
            $subject = $this->settings['email_subject'] ?? 'Your Receipt — {reference}';
            $subject = str_replace('{reference}', $this->sale->reference, $subject);
        }

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.receipt',
            with    : [
                'sale'          => $this->sale,
                'settings'      => $this->settings,
                'totalPaid'     => $this->totalPaid,
                'outstanding'   => $this->outstanding,
                'change'        => $this->change,
                'customMessage' => $this->customMessage,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}