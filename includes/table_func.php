<?php
$acceptableValues = ['yes', 'not interested', 'not interested / hung up', 'not interested', 'hang up', 'hangup'];
// Set maximum execution time to 800 seconds
ini_set('max_execution_time', 800);
function checkValueIfForQueue($value)
{
    global $acceptableValues;
    return in_array(trim(strtolower($value)), $acceptableValues);
}
function tableExists($tableName)
{
    global $SB_CONNECTION;
    sb_db_connect();
    $result = $SB_CONNECTION->query("SHOW TABLES LIKE '$tableName'");
    return $result && $result->num_rows > 0;
}

function getExistingColumns($tableName)
{
    global $SB_CONNECTION;
    sb_db_connect();
    $columns = [];
    $result = $SB_CONNECTION->query("SHOW COLUMNS FROM `$tableName`");
    while ($row = $result->fetch_assoc()) {
        $columns[] = $row['Field'];
    }
    return $columns;
}

function convertToSlug($string)
{
    $slug = trim(strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '_', $string))), '_');
    if ($slug == 'name') {
        $slug = 'company_name';
    } elseif ($slug == 'phone') {
        $slug = 'phone_number';
    }
    return $slug;
}

function createTable($tableName, $columns)
{
    global $SB_CONNECTION;
    sb_db_connect();
    $columnDefinitions = array_map(function ($column) {
        return "`$column` VARCHAR(255) DEFAULT NULL";
    }, $columns);
    $columnDefinitions = implode(', ', $columnDefinitions);
    $query = "CREATE TABLE `$tableName` (id INT AUTO_INCREMENT PRIMARY KEY, $columnDefinitions)"; // make all column defualts null
    $SB_CONNECTION->query($query);
}

function addMissingColumns($tableName, $columns, $existingColumns)
{
    global $SB_CONNECTION;
    sb_db_connect();
    $newColumns = array_diff($columns, $existingColumns);
    foreach ($newColumns as $column) {
        $query = "ALTER TABLE `$tableName` ADD `$column` VARCHAR(255) DEFAULT NULL"; // make all column defualts null
        $SB_CONNECTION->query($query);
    }
}
function insertData($tableName, $data)
{
    global $SB_CONNECTION;
    sb_db_connect();
    $columns = array_keys($data[0]);
    $columnsList = implode('`, `', $columns);
    $i = 0;
    // var_dump($columnsList);
    foreach ($data as $row) {
        try {
            $escapedRow = array_map([$SB_CONNECTION, 'real_escape_string'], $row);
            
            // Filter out empty values
            $filteredRow = array_filter($escapedRow, function ($value) {
                return $value !== '';
            });
            
            // Construct the columns list and values list for the query
            $columnsList = implode('`, `', array_keys($filteredRow));
            $valuesList = implode("', '", $filteredRow);
            
            $query = "INSERT INTO `$tableName` (`$columnsList`) VALUES ('$valuesList')";
            if (!$SB_CONNECTION->query($query)) {
                throw new Exception("Error executing query: " . $SB_CONNECTION->error);
            }
            $i++;
        } 
        catch (Exception $e) {
            // Handle the error (e.g., log it, display a message)
            echo $e->getMessage();
        }

    
}
    return $i;
}