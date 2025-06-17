<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use Carbon\Carbon;

class AutoCompleteBookings extends Command
{
    protected $signature = 'bookings:autoupdate';
    protected $description = 'Automatically mark bookings as completed if time has elapsed';

    public function handle()
    {
        $now = Carbon::now();

        $count = Booking::where('status', 'active')
            ->where('time', '<=', $now)
            ->update(['status' => 'completed']);

        $this->info("Auto-completed $count bookings.");
    }
}
