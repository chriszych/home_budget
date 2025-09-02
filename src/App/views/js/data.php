<?php
// data.php

$labels = [];
$data = [];

foreach ($chartResults as $row) {
    $labels[] = $row['exp_cat_name'];
    $data[] = (float)$row['total_amount'];
}

echo json_encode([
    'labels' => $labels,
    'data' => $data
]);
?>