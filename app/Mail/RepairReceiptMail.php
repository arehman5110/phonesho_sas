<?php

namespace App\Mail;

use App\Models\Repair;
use App\Models\ShopSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RepairReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $settings;
    public float $totalPaid;
    public float $outstanding;

    // -----------------------------------------------
    // Constructor
    // -----------------------------------------------
    public function __construct(
        public Repair $repair,
    ) {
        $this->repair->loadMissing([
            'customer',
            'status',
            'devices.deviceType',
            'devices.parts.product',
            'payments',
            'createdBy',
            'shop',
        ]);

        $this->settings    = ShopSetting::getAllForShop($repair->shop_id);
        $this->totalPaid   = (float) $repair->payments->sum('amount');
        $this->outstanding = max(0, (float) $repair->final_price - $this->totalPaid);
    }

    // -----------------------------------------------
    // Envelope — subject line
    // -----------------------------------------------
    public function envelope(): Envelope
    {
        $subject = "Repair Receipt — {$this->repair->reference}";

        return new Envelope(subject: $subject);
    }

    // -----------------------------------------------
    // Content
    // -----------------------------------------------
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.repair-receipt',
            with    : [
                'repair'      => $this->repair,
                'settings'    => $this->settings,
                'totalPaid'   => $this->totalPaid,
                'outstanding' => $this->outstanding,
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