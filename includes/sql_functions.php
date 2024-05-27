<?php
global $SB_CONNECTION;

function sb_db_connect() {
    if(defined('SB_CONNECTION_INIT')){
        return true;
    }
    global $SB_CONNECTION;
    if (SB_DB_NAME != '' && isset($SB_CONNECTION) && $SB_CONNECTION->ping()) {
        sb_db_init_settings();
        return true;
    }
    $SB_CONNECTION = new mysqli(SB_DB_HOST, SB_DB_USER, SB_DB_PASSWORD, SB_DB_NAME, defined('SB_DB_PORT') && SB_DB_PORT != '' ? ini_get('mysqli.default_port') : intval(SB_DB_PORT));
    if ($SB_CONNECTION->connect_error) {
        die('Connection error. Visit the admin area for more details or open the config.php file and check the database information. Message: ' . $SB_CONNECTION->connect_error . '.');
    }
    sb_db_init_settings();
    return true;
}

function sb_db_init_settings() {
    if(!defined('SB_CONNECTION_INIT')){
        global $SB_CONNECTION;
        $SB_CONNECTION->set_charset('utf8mb4');
        $SB_CONNECTION->query("SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
        define('SB_CONNECTION_INIT', true);
    }
}
function sb_db_encode($string) {
    global $SB_CONNECTION;
    sb_db_connect();
    return $SB_CONNECTION->real_escape_string($string);
}

function sb_json_enconde($array) {
    return sb_db_encode(str_replace(['"false"', '"true"'], ['false', 'true'], json_encode($array)));
}

function sb_db_error($function) {
    global $SB_CONNECTION;
    $message = new SBError($SB_CONNECTION->error, $function);
    return $message;
}

class SBError {
    public $error;
    function __construct($message, $function = '', $error_code = false) {
        $this->error = ['message' => $message, 'function' => $function, 'code' => $error_code];
    }

    function message() {
        return 'Error [' . $this->error['function'] . ']: ' . $this->error['message'];
    }

    function code() {
        return $this->error['code'];
    }

    public function __toString() {
        return $this->message();
    }
}

function sb_is_error($object) {
    return is_a($object, 'SBError');
}

function sb_db_get($query, $single = true) {
    global $SB_CONNECTION;
    $status = sb_db_connect();
    $value = ($single ? '' : []);
    if ($status) {
        $result = $SB_CONNECTION->query($query);
        if ($result) {
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    if ($single) {
                        $value = $row;
                    } else {
                        array_push($value, $row);
                    }
                }
            }
        } else {
            return sb_db_error('sb_db_get');
        }
    } else {
        return $status;
    }
    return $value;
}

function sb_db_query($query, $return = false) {
    global $SB_CONNECTION;
    $status = sb_db_connect();
    if ($status) {
        $result = $SB_CONNECTION->query($query);
        if ($result) {
            if ($return) {
                if (isset($SB_CONNECTION->insert_id) && $SB_CONNECTION->insert_id > 0) {
                    return $SB_CONNECTION->insert_id;
                } else {
                    return sb_db_error('sb_db_query');
                }
            } else {
                return true;
            }
        } else {
            return sb_db_error('sb_db_query');
        }
    } else {
        return $status;
    }
}

//function to check if column exists.
function columnExists($tableName, $column, $SB_CONNECTION) {
    $queryCheck = "SHOW COLUMNS FROM `$tableName` LIKE '$column'";
    $resultCheck = $SB_CONNECTION->query($queryCheck);
    return $resultCheck->num_rows > 0;
}