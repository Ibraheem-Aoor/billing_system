<?php


namespace App\Helpers\traits;


use Carbon\CarbonInterval;
use DatePeriod;
use Illuminate\Support\Carbon;

trait DateRangeHelper
{

    private function today(): array
    {
        return [
            'name' => 'total',
            'range' => today(),
            'context' => 'Y'
        ];
    }
    private function last7Days(): array
    {
        return [
            'name' => 'last_7_days',
            'range' => [
                today()->subDays(7),
                now()
            ],
            'context' => 'D'
        ];
    }
    private function thisWeek(): array
    {
        return [
            'name' => 'this_week',
            'range' => [
                now()->startOfWeek(),
                now()->endOfWeek(),
            ],
            'context' => 'D'
        ];
    }
    private function lastWeek(): array
    {
        return [
            'name' => 'last_week',
            'range' => [
                now()->subWeek()->startOfWeek(),
                now()->subWeek()->endOfWeek()
            ],
            'context' => 'D'
        ];
    }
    private function thisMonth(): array
    {
        return [
            'name' => 'this_month',
            'range' => [
                now()->startOfMonth(),
                now()->endOfMonth()
            ],
            'context' => 'Y-m-d'
        ];
    }
    private function lastMonth(): array
    {
        return [
            'name' => 'last_month',
            'range' => [
                now()->subMonth()->startOfMonth(),
                now()->subMonth()->endOfMonth()->lastOfMonth()
            ],
            'context' => 'Y-m-d'
        ];
    }

    private function thisYear(): array
    {
        return [
            'name' => 'this_year',
            'range' => [
                now()->startOfYear(),
                now()->endOfYear()
            ],
            'context' => 'M'
        ];
    }

    public function startAndEndOfMonth($year, $month)
    {
        return [
            now()->setYear($year)->setMonth($month)->startOfMonth(),
            now()->setYear($year)->setMonth($month)->endOfMonth(),
        ];
    }

    public function contexts(): array
    {
        return ['today', 'thisWeek', 'lastWeek', 'thisMonth', 'lastMonth', 'thisYear'];
    }

    public function dateRange(Carbon $from, Carbon $to, $inclusive = true): array
    {
        if ($from->gt($to)) {
            return [];
        }

        // Clone the date objects to avoid issues, then reset their time
        $from = $from->copy()->startOfDay();
        $to = $to->copy()->startOfDay();

        // Include the end date in the range
        if ($inclusive) {
            $to->addDay();
        }

        $step = CarbonInterval::day();
        $period = new DatePeriod($from, $step, $to);

        // Convert the DatePeriod into a plain array of Carbon objects
        $range = [];

        foreach ($period as $day) {
            $range[] = new Carbon($day);
        }

        return ! empty($range) ? $range : [];
    }

    public function getDateRange($within = null, $year = 0)
    {
        if (!$within) {
            return [];
        }

        $range = $this->getStartAndEndOf($within, $year);

        return count($range) == 1 ? $range : $this->dateRange($range[0], $range[1]);
    }

    public function getStartAndEndOf($within = null, $year = 0)
    {
        if ($within === 'today') {
            return [nowFromApp()];
        }

        if (in_array($within, $this->contexts())) {
            $range = $this->$within();

            return [$range['range'][0], $range['range'][1]];
        }

        $month = $this->startAndEndOfMonth($year, $within);

        return [$month[0], $month[1]];
    }


    public function convertSecondsToHoursMinutes($seconds)
    {
        $minutes = $seconds / 60;

        $hours = (int)($minutes / 60);

        $restMinutes = abs($minutes % 60);
        $restSecond = abs($seconds % 60);

        $restMinutes = strlen((string) $restMinutes) === 1 ? "0".$restMinutes : $restMinutes;
        $restSecond = strlen((string) $restSecond) === 1 ? "0".$restSecond : $restSecond;

        return $hours.":".$restMinutes.":".$restSecond;
    }

    public function convertSecondsToHours($seconds): int
    {
        $minutes = $seconds / 60;

        return (int)($minutes / 60);
    }

}
