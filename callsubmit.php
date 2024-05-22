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

    $leadId = isset($postData['id']) ? intval($postData['id']) : null;
    if ($leadId === null) {
        die('No ID provided.');
    }

    if ($postData['pickedUp'] == 'Other') {
        $postData['pickedUp'] = $postData['pickedUpOtherInput'];
        unset($postData['pickedUpOtherInput']);
    }
    if ($postData['pitched'] == 'Other') {
        $postData['pitched'] = $postData['pitchedOtherInput'];
        unset($postData['pitchedOtherInput']);
    }
    if ($postData['callEndResult'] == 'Other') {
        $postData['callEndResult'] = $postData['callEndResultInput'];
        unset($postData['callEndResultInput']);
    }

    $updateColumns = [];
    $callHistoryNewEntry = [];
    foreach ($postData as $key => $value) {
        if (in_array($key, $tableColumns)) {
            $updateColumns[$key] = $value;
        }
        $callHistoryNewEntry[$key] = $value;
    }

    $updateColumns['locked_status'] = 2; //disable load again
    $callHistoryNewEntry['time'] = time();
    $SB_CONNECTION->begin_transaction();


    try {
        $query = "SELECT `callHistory` FROM `$tableName` WHERE `id` = $leadId FOR UPDATE";
        $result = $SB_CONNECTION->query($query);
        $existingCallHistory = [];

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row['callHistory'] == null) {
                $row['callHistory'] = '';
            }
            $existingCallHistory = json_decode($row['callHistory'], true) ?: [];
        }

        $existingCallHistory[] = $callHistoryNewEntry;
        $callHistoryJson = json_encode($existingCallHistory);

        $updateSets = [];
        foreach ($updateColumns as $column => $value) {
            $escapedValue = $SB_CONNECTION->real_escape_string($value);
            $updateSets[] = "`$column` = '$escapedValue'";
        }
        $updateSets[] = "`callHistory` = '" . $SB_CONNECTION->real_escape_string($callHistoryJson) . "'";
        $updateQuery = "UPDATE `$tableName` SET " . implode(', ', $updateSets) . " WHERE `id` = $leadId";
        $SB_CONNECTION->query($updateQuery);


        if (
            (isset($updateColumns['pitched']) && checkValueIfForQueue($updateColumns['pitched'])) ||
            (isset($updateColumns['pickedUp']) && checkValueIfForQueue($updateColumns['pickedUp'])) ||
            (isset($updateColumns['callEndResult']) && checkValueIfForQueue($updateColumns['callEndResult']))
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
        <a href="<?= $sub_dir ?>/calling.php" class="btn btn-primary mb-5">Next Lead >></a>
    </div>
</div>
<div>
    <?php require('footer.php') ?>