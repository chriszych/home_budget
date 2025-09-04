<?php
// data.php

use Framework\Database;
use App\Services\BalanceService;
//namespace App\Services;

$labels = [];
$data = [];

//$chartResults = getChartResults();
$balanceService = new BalanceService($db);
$chartResults = $balanceService->getChartResults();

dd($chartResults);

foreach ($chartResults as $row) {
    $labels[] = $row['exp_cat_name'];
    $data[] = (float)$row['total_amount'];
}

echo json_encode([
    'labels' => $labels,
    'data' => $data
]);
?>