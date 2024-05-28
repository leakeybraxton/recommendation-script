<?php
session_start();
require("config.php");
require("includes/sql_functions.php");
require("includes/table_func.php");
global $SB_CONNECTION;
sb_db_connect();
$tableName = 'leads';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postData = $_POST;
    $tableColumns = getExistingColumns($tableName);

    $newColumns = [
        'skipped' => 'VARCHAR(255)',  // Column name => Data type
        'call_name' => 'VARCHAR(255)'
    ];    

    //update table if columns missing
    $columnsAdded = false;
    foreach ($newColumns as $column => $type) {
        if (!columnExists($tableName, $column, $SB_CONNECTION)) {
            $alterTableQuery = "ALTER TABLE `$tableName` ADD `$column` $type";
            $SB_CONNECTION->query($alterTableQuery);
            $columnsAdded = true;
        } 
    }

    // Freshly fetch table columns if new columns were added
    if ($columnsAdded) {
        $tableColumns = getExistingColumns($tableName);
    }

    $leadId = isset($postData['id']) ? intval($postData['id']) : null;
    if ($leadId === null) {
        die('No ID provided.');
    }

    //check if the lead was skipped
    if(isset($postData['skipped'])){
        if ($postData['skipped'] == 'Other') {
            $postData['skipped'] = $postData['skipOtherInput'];
            unset($postData['skipOtherInput']);
        } 

       
    }else{

        if ($postData['picked_up'] == 'Other') {
            $postData['picked_up'] = $postData['picked_upOtherInput'];
            unset($postData['picked_upOtherInput']);
        }
        if ($postData['pitched'] == 'Other') {
            $postData['pitched'] = $postData['pitchedOtherInput'];
            unset($postData['pitchedOtherInput']);
        }
        if ($postData['call_end_result'] == 'Other') {
            $postData['call_end_result'] = $postData['call_end_resultInput'];
            unset($postData['call_end_resultInput']);
        }
    

    }

    
    $updateColumns = [];
    $call_historyNewEntry = [];
    foreach ($postData as $key => $value) {
        if (in_array($key, $tableColumns)) {
            $updateColumns[$key] = $value;
        }
        $call_historyNewEntry[$key] = $value;
    }

    //capture the audio file from the form
    $audio_file = $_FILES["uploadCall"];     
  
    // Allowed file types
    $allowed_types = ["audio/mpeg", "audio/mp3", "audio/wav"];
    $mimeToExtension = [
        'audio/mpeg' => '.mp3',
        'audio/mp3' => '.mp3',
        'audio/wav' => '.wav'
    ];

    $companyNameQuery = "SELECT `company_name` FROM `$tableName` WHERE `id` = $leadId FOR UPDATE";
    $companyNameResult = $SB_CONNECTION->query($companyNameQuery);
    $companyNameRow = $companyNameResult->fetch_assoc();    
    
    //authenticate the type of the file
    if (isset($_FILES['uploadCall']) && $_FILES['uploadCall']['error'] == UPLOAD_ERR_OK) {
        $extension = isset($mimeToExtension[$audio_file["type"]]) ? $mimeToExtension[$audio_file["type"]] : '';
        $tmpFilePath = $_FILES['uploadCall']['tmp_name'];
        $fileName = basename($_FILES['uploadCall']['name']);
        $uploadDir = 'uploads/appointment-setting/';
        $rename = trim(strval($companyNameRow['company_name']));
        
        $destination = $uploadDir . $rename . $extension;

        // Check if the upload directory exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Check if the upload directory is writable
        if (!is_writable($uploadDir)) {
            
            print_r("Upload directory is not writable.");
            exit;
        }

        // Move the uploaded file
        move_uploaded_file($tmpFilePath, $destination);

        $updateColumns['call_name'] = $rename . $extension;
    }
    

    if(!isset($postData['skipped'])){
        $updateColumns['locked_status'] = 2; //disable load again
    }
    $call_historyNewEntry['time'] = time();
    $SB_CONNECTION->begin_transaction(); 


    try {
        $query = "SELECT `call_history` FROM `$tableName` WHERE `id` = $leadId FOR UPDATE";
        $result = $SB_CONNECTION->query($query);
        $existingcall_history = [];

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row['call_history'] == null) {
                $row['call_history'] = '';
            }
            $existingcall_history = json_decode($row['call_history'], true) ?: [];           
        }

        $existingcall_history[] = $call_historyNewEntry;
        $call_historyJson = json_encode($existingcall_history);

        $updateSets = [];
        foreach ($updateColumns as $column => $value) {
            $escapedValue = $SB_CONNECTION->real_escape_string($value);
            $updateSets[] = "`$column` = '$escapedValue'";
        }
        $updateSets[] = "`call_history` = '" . $SB_CONNECTION->real_escape_string($call_historyJson) . "'";
        $updateQuery = "UPDATE `$tableName` SET " . implode(', ', $updateSets) . " WHERE `id` = $leadId";
        $SB_CONNECTION->query($updateQuery);

        


        if (
            (isset($updateColumns['pitched']) && checkValueIfForQueue($updateColumns['pitched'])) ||
            (isset($updateColumns['picked_up']) && checkValueIfForQueue($updateColumns['picked_up'])) ||
            (isset($updateColumns['call_end_result']) && checkValueIfForQueue($updateColumns['call_end_result']))
        ) {
            //do not call again if not intarested/already called
        } else {
            $queueResult = $SB_CONNECTION->query("SELECT MAX(`queue`) AS max_queue FROM `$tableName`");
            $queueRow = $queueResult->fetch_assoc();
            $newQueue = $queueRow['max_queue'] + 1;



            $queueUpdateQuery = "UPDATE `$tableName` SET `locked_status` = NULL, `queue` = $newQueue WHERE `id` = $leadId";            
            
            $SB_CONNECTION->query($queueUpdateQuery);            
            
        }

        $SB_CONNECTION->commit();
        $message =  "Successfully saved.";
        unset($_SESSION['loaded_lead_id']);
    } catch (Exception $e) {
        $SB_CONNECTION->rollback();
        $message = $e->getMessage();
    }
}

require("header.php");
?>
<meta name="robots" content="noindex">
<script>
    const logoImage = document.querySelector('.reachlogo img');
    // Add click event listener
    logoImage.addEventListener('click', () => {
        // Redirect to the index page
        window.location.href = '<?= $sub_dir ?>/index.php'; // Change the URL to your index page
    });
</script>
<div style="background-color:#f5f5f5">
    <div class="py-5 container">

        <?php if (!empty($message)) : ?>
            <div class="alert alert-info my-5"><?php echo $message; ?></div>
        <?php endif; ?>
        <a href="<?= $sub_dir ?>/calling.php?next=true" class="btn btn-primary mb-5">Next Lead >></a>
    </div>
</div>
<div>
    <?php require('footer.php') ?>