<?php

namespace App\Http\Requests;

use App\Models\Vacancy;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Illuminate\Validation\Validator;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'periods' => ['required', 'array'],
            'periods.*' => ['required', 'array:check_in,check_out'],
            'periods.*.check_in' => ['required', 'date', 'after_or_equal:today'],
            'periods.*.check_out' => ['required', 'date', 'after:periods.*.check_in'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $countedDates = collect($validator->safe()->collect()->get('periods'))
                ->map(fn (array $period) => CarbonPeriod::create($period['check_in'], $period['check_out']))
                ->flatMap(function (CarbonPeriod $carbonPeriod) {
                    return array_map(fn (Carbon $date) => $date->toDateString(), $carbonPeriod->toArray());
                })
                ->countBy()
                ->mapToGroups(function (string $date, string $count) {
                    return [$date => $count];
                });

            $vacancies = Vacancy::query();

            $countedDates->each(function (Collection $dates, int $count) use ($vacancies) {
                $vacancies->orWhere(fn (Builder $query) => $query->whereIn('date', $dates)->where('amount', '>=', $count));
            });

            if ($vacancies->count() < $countedDates->flatten()->count()) {
                $validator->errors()->add('periods', 'There are no vacancies for given periods.');
            }
        });
    }
}
