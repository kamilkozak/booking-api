<?php

namespace App\Http\Controllers;

use App\Events\BookingStored;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BookingController extends Controller
{
    public function index(Request $request): ResourceCollection
    {
        /**
         * @var User $user
         */
        $user = $request->user();

        return BookingResource::collection($user->bookings()->paginate());
    }

    public function store(StoreBookingRequest $request): ResourceCollection
    {
        $bookings = collect();

        foreach ($request->validated('periods') as $period) {
            $booking = new Booking();
            $booking->check_in = $period['check_in'];
            $booking->check_out = $period['check_out'];
            $booking->user_id = auth()->id();
            $booking->save();

            $bookings->push($booking);

            event(new BookingStored($booking));
        }

        return BookingResource::collection($bookings);
    }

    public function destroy(Booking $booking)
    {
        //
    }
}
