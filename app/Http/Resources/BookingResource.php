<?php

namespace App\Http\Resources;

use App\Models\Booking;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        /**
         * @var Booking $booking
         */
        $booking = $this->resource;

        return [
            'id' => $booking->getKey(),
            'check_in' => $booking->check_in,
            'check_out' => $booking->check_out,
        ];
    }
}
