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

    // -----------------------------------------------
    // Constructor
    // -----------------------------------------------
    public function __construct(
        public Sale $sale,
    ) {
        // Load relationships
        $this->sale->loadMissing([
            'items.product',
            'customer',
            'payments',
            'createdBy',
            'shop',
        ]);

        // Load shop settings
        $this->settings = ShopSetting::getAllForShop($sale->shop_id);

        // Pre-calculate amounts
        $this->totalPaid   = (float) $sale->payments->sum('amount');
        $this->outstanding = max(0, (float) $sale->final_amount - $this->totalPaid);
        $this->change      = max(0, $this->totalPaid - (float) $sale->final_amount);
    }

    // -----------------------------------------------
    // Envelope — subject line
    // -----------------------------------------------
    public function envelope(): Envelope
    {
        // Replace {reference} placeholder in subject
        $subject = $this->settings['email_subject']
            ?? 'Your Receipt — {reference}';

        $subject = str_replace(
            '{reference}',
            $this->sale->reference,
            $subject
        );

        return new Envelope(subject: $subject);
    }

    // -----------------------------------------------
    // Content — which view to use
    // -----------------------------------------------
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.receipt',
            with    : [
                'sale'        => $this->sale,
                'settings'    => $this->settings,
                'totalPaid'   => $this->totalPaid,
                'outstanding' => $this->outstanding,
                'change'      => $this->change,
            ],
        );
    }

    // -----------------------------------------------
    // Attachments
    // -----------------------------------------------
    public function attachments(): array
    {
        return [];
    }
}