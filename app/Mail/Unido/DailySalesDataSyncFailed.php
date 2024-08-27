<?php

namespace App\Mail\Unido;

use App\Jobs\Unido\SyncDailySalesCollectionReturn;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class DailySalesDataSyncFailed extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(protected string $error)
    {
        //
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: '[Unido] Daily Sales Data Sync Failed',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.unido-data-sync-failed',
            with: [
                'error' => Str::limit($this->error, 400, '...'),
                'appEnv' => app()->environment() === 'production' ? 'Production ' : 'Development',
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [
            Attachment::fromStorageDisk(SyncDailySalesCollectionReturn::UNIDO_FTP, SyncDailySalesCollectionReturn::INV_HEADER),
            Attachment::fromStorageDisk(SyncDailySalesCollectionReturn::UNIDO_FTP, SyncDailySalesCollectionReturn::INV_LINES),
            Attachment::fromStorageDisk(SyncDailySalesCollectionReturn::UNIDO_FTP, SyncDailySalesCollectionReturn::RETURN_HEADER),
            Attachment::fromStorageDisk(SyncDailySalesCollectionReturn::UNIDO_FTP, SyncDailySalesCollectionReturn::RETURN_LINES),
            Attachment::fromStorageDisk(SyncDailySalesCollectionReturn::UNIDO_FTP, SyncDailySalesCollectionReturn::COLLECTION)
        ];
    }
}
