<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class SectionGradeChart
{
    protected $chart;

    public function __construct($chart, $grade)
    {
        $this->chart = $chart;
        $this->grade = $grade;
    }

    public function build(): array
    {
        $totalCorrectPerSection = $this->grade->total_correct_per_section;
        
        $generateLabel = [];

        for($i = 1; $i <= $this->grade->exam->questionTitle->total_section; $i++) {
            $generateLabel[] = 'Kolom '.$i;
        }

        return $this->chart->areaChart()
            ->setTitle('Grafik Nilai Per Kolom')
            ->setSubtitle('Menampilkan Data Jawaban Yang Benar Per Kolom')
            ->addData('Jawaban Benar', $totalCorrectPerSection)
            ->setMarkers(['#FF5722', '#E040FB'], 7, 10)
            ->setXAxis($generateLabel)
            ->toVue();
    }
}
