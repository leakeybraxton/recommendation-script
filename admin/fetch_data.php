<?php
require("../config.php");
require("../includes/sql_functions.php");
require("../includes/table_func.php");
global $SB_CONNECTION;
sb_db_connect();

$tableName = 'leads';

// Fetch total number of records without any filters
$totalRecordsQuery = "SELECT COUNT(*) AS count FROM `$tableName`";
$totalRecordsResult = $SB_CONNECTION->query($totalRecordsQuery);
$totalRecords = $totalRecordsResult->fetch_assoc()['count'];

// Get parameters from the DataTables request
$limit = $_POST['length'];
$offset = $_POST['start'];
$searchValue = $_POST['search']['value'];
$orderColumnIndex = $_POST['order'][0]['column'];
$orderColumnDirection = $_POST['order'][0]['dir'];

// Validate the order direction
$orderColumnDirection = ($orderColumnDirection === 'asc' || $orderColumnDirection === 'desc') ? $orderColumnDirection : 'asc';

// Map DataTables column index to database column names
$fields = getExistingColumns($tableName);
$orderColumn = isset($fields[$orderColumnIndex]) ? $fields[$orderColumnIndex] : $fields[0]; // Default to the first column if index is out of bounds

// Construct the base query
$query = "SELECT * FROM `$tableName`";

// Add search functionality
if (!empty($searchValue)) {
    $query .= " WHERE ";
    $searchConditions = [];
    foreach ($fields as $field) {
        $searchConditions[] = "`$field` LIKE '%" . $SB_CONNECTION->real_escape_string($searchValue) . "%'";
    }
    $query .= implode(" OR ", $searchConditions);
}

// Add ordering functionality
$query .= " ORDER BY `$orderColumn` $orderColumnDirection";

// Add limit and offset, consider the case where limit is -1 (show all rows)
if ($limit != -1) {
    $query .= " LIMIT $limit OFFSET $offset";
}

$result = $SB_CONNECTION->query($query);
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = array_values($row);
}

// Fetch the filtered number of records
$filteredRecordsQuery = "SELECT COUNT(*) AS count FROM `$tableName`";
if (!empty($searchValue)) {
    $filteredRecordsQuery .= " WHERE " . implode(" OR ", $searchConditions);
}
$filteredRecordsResult = $SB_CONNECTION->query($filteredRecordsQuery);
$filteredRecords = $filteredRecordsResult->fetch_assoc()['count'];

// Construct the response
$response = [
    "draw" => intval($_POST['draw']),
    "recordsTotal" => $totalRecords,
    "recordsFiltered" => $filteredRecords,
    "data" => $data,
];

echo json_encode($response);
