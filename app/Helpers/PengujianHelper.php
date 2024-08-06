<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class PengujianHelper
{
    // Menghitung Precision
    public function precision($relevantRetrieved, $retrieved)
    {
        // Log::info("Retrieved : " . print_r($retrieved, true));
        // Log::info("Relevant Retrieved : " . print_r($relevantRetrieved, true));
        if (count($retrieved) == 0) {
            return 0;
        }
        $truePositive = count(array_intersect($relevantRetrieved, $retrieved));
        // $totRetrieved = count($retrieved);
        // $res = $truePositive / $totRetrieved;
        // Log::info("True Positive : " . $truePositive);
        // Log::info("Total Retrieved : " . $totRetrieved);
        // Log::info("Precision : " . $res);
        
        return $truePositive / count($retrieved);
    }

    // Menghitung Recall
    public function recall($relevantRetrieved, $relevant)
    {
        // Log::info("Relevant : " . print_r($relevant, true));
        // Log::info("Relevant Retrieved : " . print_r($relevantRetrieved, true));
        if (count($relevant) == 0) {
            return 0;
        }
        $truePositive = count(array_intersect($relevantRetrieved, $relevant));
        // $totRelevant = count($relevant);
        // $res = $truePositive / $totRelevant;
        // Log::info("True Positive : " . $truePositive);
        // Log::info("Total Relevant : " . $totRelevant);
        // Log::info("Recall : " . $res);

        return $truePositive / count($relevant);
    }

    // Menghitung F-Measure
    public function fMeasure($precision, $recall)
    {
        // Log::info("Precision : " . $precision);
        // Log::info("Recall : " . $recall);
        if ($precision + $recall == 0) {
            return 0;
        }

        $res = 2 * ($precision * $recall) / ($precision + $recall);
        // Log::info("F-Measure : " . $res);

        return 2 * ($precision * $recall) / ($precision + $recall);
    }

    // Menghitung Accuracy
    public function accuracy($relevantRetrieved, $retrieved, $relevant, $totalDocuments)
    {
        // Log::info("Relevant : " . print_r($relevant, true));
        // Log::info("Retrieved : " . print_r($retrieved, true));
        // Log::info("Relevant Retrieved : " . print_r($relevantRetrieved, true));
        // Log::info("Total Dokument : " . $totalDocuments);
        $truePositive = count(array_intersect($relevantRetrieved, $relevant));
        // Log::info("True Positive : " . $truePositive);
        $trueNegative = $totalDocuments - (count($retrieved) + count($relevant) - $truePositive);
        // Log::info("True Negative : " . $trueNegative);

        $res = ($truePositive + $trueNegative) / $totalDocuments;
        // Log::info("Accuracy : " . $res);


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