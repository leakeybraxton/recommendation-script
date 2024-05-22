<?php
require("../config.php");
require("../includes/sql_functions.php");
require("../includes/table_func.php");
$tableName = 'leads';
global $SB_CONNECTION;
sb_db_connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id']; // Assuming 'id' is the primary key

    $fields = [];

    foreach ($_POST as $key => $value) {
        if ($key !== 'id') {
            $value = $SB_CONNECTION->real_escape_string($value);
            $fields[] = "`$key`=" . (($value == null || $value == '') ? 'NULL' : "'$value'");
        }
    }

    $setClause = implode(', ', $fields);

    $sql = "UPDATE $tableName SET $setClause WHERE id = '$id'";

    if ($SB_CONNECTION->query($sql)) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record.";
    }
} else {
    // Handle invalid requests
    echo "Invalid request method";
}
