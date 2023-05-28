<?php
require_once 'jpgraph/src/jpgraph.php';
require_once 'jpgraph/src/jpgraph_bar.php';

function calculateASCVDScore($age, $gender, $totalCholesterol, $hdlCholesterol, $systolicBloodPressure, $isSmoker, $hasDiabetes)
{
    if ($age < 40 || $age > 79) {
        throw new InvalidArgumentException("ASCVD score calculator is applicable for individuals aged 40 to 79 only.");
    }

    $score = 0;

    if ($gender === 'male') {
        $score += 3;
    }

    if ($totalCholesterol >= 160 && $totalCholesterol <= 189) {
        $score += 4;
    } elseif ($totalCholesterol >= 190) {
        $score += 8;
    }

    if ($hdlCholesterol < 40) {
        $score += 2;
    } elseif ($hdlCholesterol >= 60) {
        $score -= 1;
    }

    if ($systolicBloodPressure >= 140 && $systolicBloodPressure <= 159) {
        $score += 2;
    } elseif ($systolicBloodPressure >= 160 && $systolicBloodPressure <= 179) {
        $score += 3;
    } elseif ($systolicBloodPressure >= 180) {
        $score += 4;
    }

    if ($isSmoker) {
        $score += 2;
    }

    if ($hasDiabetes) {
        $score += 4;
    }

    return $score;
}

function calculateRiskPercentage($ascvdScore)
{
    $riskPercentages = [
        0 => 5,
        5 => 7,
        10 => 11,
        15 => 16,
        20 => 22,
        25 => 29,
        30 => 36,
        35 => 45,
        40 => 54,
        45 => 64,
        50 => 75,
    ];

    foreach ($riskPercentages as $scoreRange => $percentage) {
        if ($ascvdScore >= $scoreRange) {
            return $percentage;
        }
    }

    return end($riskPercentages);
}

try {
    // Validate and sanitize input
    $age = isset($_POST['Age']) ? intval($_POST['Age']) : 0;
    $gender = isset($_POST['Gender']) ? htmlspecialchars($_POST['Gender']) : '';
    $totalCholesterol = isset($_POST['LDL']) ? intval($_POST['LDL']) : 0;
    $hdlCholesterol = isset($_POST['HDL']) ? intval($_POST['HDL']) : 0;
    $systolicBloodPressure = isset($_POST['SBP']) ? intval($_POST['SBP']) : 0;
    $isSmoker = isset($_POST['Smoker']) ? boolval($_POST['Smoker']) : false;
    $hasDiabetes = isset($_POST['Diabetes']) ? boolval($_POST['Diabetes']) : false;

    // Calculate ASCVD score
    $ascvdScore = calculateASCVDScore($age, $gender, $totalCholesterol, $hdlCholesterol, $systolicBloodPressure, $isSmoker, $hasDiabetes);

    // Output ASCVD score
    echo "ASCVD Score: " . $ascvdScore . "<br>";

    // Calculate risk percentage
    $riskPercentage = calculateRiskPercentage($ascvdScore);

    // Output risk percentage
    echo "Risk Percentage: " . $riskPercentage . "<br>";

    // Chart data
    $data = [
        ['ASCVD Score', 'Risk Percentage'],
        ['0-4', 5],
        ['5-9', 7],
        ['10-14', 11],
        ['15-19', 16],
        ['20-24', 22],
        ['25-29', 29],
        ['30-34', 36],
        ['35-39', 45],
        ['40-44', 54],
        ['45-49', 64],
        ['50+', 75],
    ];

    $labels = array_column($data, 0);
    $percentages = array_map('intval', array_column($data, 1));

    // Generate chart
    $graph = new Graph(400, 300);
    $graph->SetScale('textlin', 0, 80);
    $graph->SetMargin(50, 30, 30, 50);
    $graph->xaxis->SetTickLabels($labels);

    $barplot = new BarPlot($percentages);
    $barplot->SetFillColor('blue');
    $graph->Add($barplot);

    $chartFilename = 'C:\xampp\htdocs\ascvd\fpdf-ASCVD-Risk-Calculator\chart.png';
    $graph->Stroke($chartFilename);
} catch (Exception $e) {
    echo "An error occurred: " . $e->getMessage();
}
?>