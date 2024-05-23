<?php
$acceptableValues = ['yes', 'not interested', 'not interested / hung up', 'not interested', 'hang up', 'hangup'];

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
        return "`$column` VARCHAR(255)";
    }, $columns);
    $columnDefinitions = implode(', ', $columnDefinitions);
    $query = "CREATE TABLE `$tableName` (id INT AUTO_INCREMENT PRIMARY KEY, $columnDefinitions)";
    $SB_CONNECTION->query($query);
}

function addMissingColumns($tableName, $columns, $existingColumns)
{
    global $SB_CONNECTION;
    sb_db_connect();
    $newColumns = array_diff($columns, $existingColumns);
    foreach ($newColumns as $column) {
        $query = "ALTER TABLE `$tableName` ADD `$column` VARCHAR(255)";
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
    foreach ($data as $row) {
        try {
            $valuesList = implode("', '", array_map([$SB_CONNECTION, 'real_escape_string'], $row));
            $query = "INSERT INTO `$tableName` (`$columnsList`) VALUES ('$valuesList')";
            if (!$SB_CONNECTION->query($query)) {
                throw new Exception("Error executing query: " . $SB_CONNECTION->error);
            }
            $i++;
        } catch (Exception $e) {
        }
    }
    return $i;
}
