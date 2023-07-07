<?php

namespace App\Charts;

use App\Models\User;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;

use DB;
class UserChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }


    public function build(): \ArielMejiaDev\LarapexCharts\LineChart
    {
        $data = User::selectRaw("DATE_FORMAT(created_at, '%Y-%m') AS month, COUNT(*) AS total")
                ->groupBy('month')
                ->orderBy('month', 'ASC')
                ->get();

            $months = $data->pluck('month');
            $totals = $data->pluck('total');

            return $this->chart->lineChart()
            ->setTitle('User')
            ->setSubtitle('User')
            ->setXAxis($months->toArray())
            ->addData('User created', $totals->toArray());
    }
}
