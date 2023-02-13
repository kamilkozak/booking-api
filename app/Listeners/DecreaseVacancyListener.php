<?php

namespace App\Listeners;

use App\Events\BookingStored;
use App\Models\Vacancy;

class DecreaseVacancyListener
{
    public function handle(BookingStored $event): void
    {
        Vacancy::whereBetween('date', [$event->booking->check_in, $event->booking->check_out])
            ->decrement('amount');
    }
}
