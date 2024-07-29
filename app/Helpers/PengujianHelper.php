<?php

namespace App\Helpers;

class PengujianHelper
{
    // Menghitung Precision
    public function precision($relevantRetrieved, $retrieved)
    {
        if (count($retrieved) == 0) {
            return 0;
        }
        $truePositive = count(array_intersect($relevantRetrieved, $retrieved));
        return $truePositive / count($retrieved);
    }

    // Menghitung Recall
    public function recall($relevantRetrieved, $relevant)
    {
        if (count($relevant) == 0) {
            return 0;
        }
        $truePositive = count(array_intersect($relevantRetrieved, $relevant));
        return $truePositive / count($relevant);
    }

    // Menghitung F-Measure
    public function fMeasure($precision, $recall)
    {
        if ($precision + $recall == 0) {
            return 0;
        }
        return 2 * ($precision * $recall) / ($precision + $recall);
    }

    // Menghitung Accuracy
    public function accuracy($relevantRetrieved, $retrieved, $relevant, $totalDocuments)
    {
        $truePositive = count(array_intersect($relevantRetrieved, $relevant));
        $trueNegative = $totalDocuments - (count($retrieved) + count($relevant) - $truePositive);
        return ($truePositive + $trueNegative) / $totalDocuments;
    }

    // Evaluasi
    public function evaluate($relevantRetrieved, $retrieved, $relevant, $totalDocuments)
    {
        $precision = $this->precision($relevantRetrieved, $retrieved);
        $recall = $this->recall($relevantRetrieved, $relevant);
        $fMeasure = $this->fMeasure($precision, $recall);
        $accuracy = $this->accuracy($relevantRetrieved, $retrieved, $relevant, $totalDocuments);

        return [
            'precision' => $precision,
            'recall' => $recall,
            'fMeasure' => $fMeasure,
            'accuracy' => $accuracy
        ];
    }
}