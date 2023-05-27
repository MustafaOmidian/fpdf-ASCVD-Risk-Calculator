<?php
function calculateASCVDScore($age, $gender, $totalCholesterol, $hdlCholesterol, $systolicBloodPressure, $isSmoker, $hasDiabetes) {
    $score = 0;
    if ($age >= 40 && $age <= 79) {
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
    } else {
        return "ASCVD score calculator is applicable for individuals aged 40 to 79 only.";
    }

    return $score;
}

// Example usage

$age = $_POST['Age'];
$gender = $_POST['Gender'];
$totalCholesterol = $_POST['LDL'];
$hdlCholesterol = $_POST['HDL'];
$systolicBloodPressure = $_POST['SBP'];
$isSmoker = $_POST['Smoker'];
$hasDiabetes = $_POST['Diabetes'];

$ascvdScore = calculateASCVDScore($age, $gender, $totalCholesterol, $hdlCholesterol, $systolicBloodPressure, $isSmoker, $hasDiabetes);

echo "ASCVD Score: " . $ascvdScore;
?>
