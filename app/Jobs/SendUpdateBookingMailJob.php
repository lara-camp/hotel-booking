<?php

namespace App\Jobs;

use App\Mail\BookingUpdateMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendUpdateBookingMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $reservation;
    private $email;

    /**
     * Create a new job instance.
     */
    public function __construct($reservation, $email)
    {
        $this->reservation = $reservation;
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->email)->send(new BookingUpdateMail($this->reservation));
    }
}
