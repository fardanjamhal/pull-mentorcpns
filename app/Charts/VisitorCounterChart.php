<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use Spatie\Analytics\Period;
use Analytics;
use Carbon\Carbon;

class VisitorCounterChart
{
    protected $chart;

    public function __construct($chart)
    {
        $this->chart = $chart;
    }

    public function build(): array
    {
        $startDate = Carbon::now()->subMonth(1);
        $endDate = Carbon::now();
        $analyticsData = json_decode(Analytics::fetchTotalVisitorsAndPageViews(Period::create($startDate, $endDate)));

        $visitors = [];
        $pageViews = [];
        $labels = [];

        foreach($analyticsData as $analytics) {
            $visitors[] = $analytics->visitors;
            $pageViews[] = $analytics->pageViews;
            $labels[] = Carbon::parse($analytics->date)->format('d F Y');
        }

        return $this->chart->areaChart()
            ->setTitle('Grafik Pengunjung Tanggal '.$startDate->format('d F Y').' s/d '.$endDate->format('d F Y'))
            ->setSubtitle('Data Diambil dari Google Analytics')
            ->addData('Visitor', $visitors)
            // ->addData('Page View', $pageViews)
            ->setXAxis($labels)
            ->setGrid()
            ->setMarkers(['#FF5722', '#E040FB'], 7, 10)
            ->toVue();
    }
}
