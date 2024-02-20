<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class MonthlyUsersChart
{
    protected $chart;

    public function __construct($chart)
    {
        $this->chart = $chart;
    }

    public function build(): array
    {
        return $this->chart->areaChart()
            ->setTitle('Grafik Nilai Per Kolom')
            ->setSubtitle('Menampilkan Data Jawaban Yang Benar Per Kolom')
            ->addData('', [30, 32, 35, 36, 32, 29, 32, 45, 50, 22])
            ->setMarkers(['#FF5722', '#E040FB'], 7, 10)
            ->setXAxis(['Kolom 1', 'Kolom 2', 'Kolom 3', 'Kolom 4', 'Kolom 5', 'Kolom 6', 'Kolom 7', 'Kolom 8', 'Kolom 9', 'Kolom 10'])
            ->toVue();
    }
}
