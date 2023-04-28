<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\CommissionCalculator;

$rows = explode("\n", file_get_contents($argv[1]));

foreach ($rows as $row) {
    try {
        $calculator = new CommissionCalculator($row);
        $commission = $calculator->calculateCommission();
        echo $commission . "\n";
    } catch (Exception $e) {
        // I'd like to log smth, but I have no time :)
    }
}

