<?php
require("../config.php");
require("../includes/sql_functions.php");
require("../includes/table_func.php");
global $SB_CONNECTION;
sb_db_connect();
$tableName = 'leads'; 
$totalRecordsQuery = "SELECT COUNT(*) AS count FROM `$tableName`";
$totalRecordsResult = $SB_CONNECTION->query($totalRecordsQuery);
$totalRecords = $totalRecordsResult->fetch_assoc()['count'];

$limit = $_POST['length'];
$offset = $_POST['start'];
$searchValue = $_POST['search']['value'];

$query = "SELECT * FROM `$tableName`";
if (!empty($searchValue)) {
    $query .= " WHERE ";
    $fields = getExistingColumns($tableName);
    $searchConditions = [];
    foreach ($fields as $field) {
        $searchConditions[] = "`$field` LIKE '%" . $SB_CONNECTION->real_escape_string($searchValue) . "%'";
    }
    $query .= implode(" OR ", $searchConditions);
}
$query .= " LIMIT $limit OFFSET $offset";

$result = $SB_CONNECTION->query($query);
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = array_values($row);
}

$filteredRecordsQuery = "SELECT COUNT(*) AS count FROM `$tableName`";
if (!empty($searchValue)) {
    $filteredRecordsQuery .= " WHERE " . implode(" OR ", $searchConditions);
}
$filteredRecordsResult = $SB_CONNECTION->query($filteredRecordsQuery);
$filteredRecords = $filteredRecordsResult->fetch_assoc()['count'];

$response = [
    "draw" => intval($_POST['draw']),
    "recordsTotal" => $totalRecords,
    "recordsFiltered" => $filteredRecords,
    "data" => $data,
];

echo json_encode($response);
