<?php
require_once('config.php');
if(isset($_GET['decode'])){
    echo decrypt($_GET['decode'], $_GET['pass']);
    exit;
}
// Function to fetch data by row ID
function fetchRowData($rowId) {
    global $googleAppsScriptURL;

    // Initialize cURL
    $ch = curl_init($googleAppsScriptURL . "?rowId=" . $rowId); // Append row ID as a query parameter
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response as string
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects
    curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Timeout after 10 seconds

    // Execute cURL request
    $response = curl_exec($ch);

    if ($response === false) {
        echo "Error fetching data: " . curl_error($ch); // Handle cURL errors
        curl_close($ch);
        return null;
    }

    // Check if "Moved Temporarily" exists in the response (indicating a redirect)
    if (strpos($response, 'Moved Temporarily') !== false) {
        // Extract the new URL from the <a href="..."> tag
        $pattern = '/<a\s+[^>]*href=["\']([^"\']+)["\'][^>]*>/i';
        preg_match($pattern, $response, $matches);

        if (!empty($matches)) {
            $newURL = $matches[1];
            $googleAppsScriptURL = $newURL; // Update the global URL variable

            // Re-fetch data with the updated URL
            curl_setopt($ch, CURLOPT_URL, $newURL); // Update cURL with the new URL
            $response = curl_exec($ch); // Execute again
        }
    }

    curl_close($ch); // Close cURL

    return json_decode($response, true); // Return the JSON-decoded response
}
// Fetch a specific row by ID (example: row 5)
if(!isset($_GET['id'])){
    echo 'Invalid row';
    exit;
}
$rowId = $_GET['id']; // You can get this dynamically or from a form input
$rowData = fetchRowData($rowId); // Fetch the data

if ($rowData && !isset($rowData['error']) && isset($rowData['data'])) {
    $rowData=$rowData['data'];
} else {
    echo "<p>Error: " . htmlspecialchars($rowData['error'] ?? 'Unknown error') . "</p>"; // Show error message if any
}


if(!isset($_GET['c']) || $_GET['c']!=$rowData[17]){
    echo 'Invalid access.';
    exit;
}
require('onboarding.php') ?>

<style type="text/css">
    input,textarea{
    background: gray;
    }
    .hero_container p,.progress, h2{
        display: none;
    }.form-check{
        pointer-events: none;
    }
</style>

<script type="text/javascript"> 
$(document).ready(function() {
    <?php 
if(is_array($rowData) && count($rowData)>1){
foreach ([
    "companyName",
    "contactPerson",
    "businessEmail",
    "businessPhone",
    "website",
    "goalsObjectives",
    "targetAudience",
    "nonIdealCustomer",
    "existingCustomerPatterns",
    "metaAdBudget",
    "prevAdvertisingExp",
    "competitiveLandscape",
    "brandMessaging",
    "creativeAssets",
    "marketingSuccess",
    "timeline",
    "accessChecklist",
    "loginDetails"
]
 as $key => $value) {
    if($value=='accessChecklist'){
        $arr = explode(", ", $rowData[$key]);
        foreach($arr as $el){
        echo "$('[value=\'".htmlspecialchars($el)."\']').prop('checked', true);\n";
        }
    }else{
        echo "$('#".$value."').val('".htmlspecialchars($rowData[$key])."');\n";
    }
}
}

?>
    $('form input, form textarea').prop('readonly', true);
    $('form [type="submit"]').attr('type', 'button').text('Show Login Details').css('width', 'auto').removeClass('btn-lg').click(function(){
        const data = $('#loginDetails').val();
        const encryptionKey = prompt("Enter password:");
        let that = $(this);
        $.get('client.php?pass='+encryptionKey+'&decode='+data, function($r) {
            if($r!=''){
              $('#loginDetails').val($r);
              that.hide();
            }else{
                alert('Error.');
            }
        });
    });


});
</script>