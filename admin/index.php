<?php
require("../config.php");
require("../includes/sql_functions.php");
require("../includes/table_func.php");
$tableName = 'leads';

if (isset($_POST['upload']) && isset($_FILES['csvFiles'])) {
    $files = $_FILES['csvFiles'];
    $message = '';
    $totalImported = 0;
    $totalIgnored = 0;

    for ($i = 0; $i < count($files['name']); $i++) {
        $file = $files['tmp_name'][$i];

        $fileContents = file_get_contents($file);
        if ($fileContents !== false) {
            $cleanedFileContents = str_replace('""', "'", str_replace('"""', "'", $fileContents));

            $tempFile = tempnam(sys_get_temp_dir(), 'csv');
            file_put_contents($tempFile, $cleanedFileContents);

            if (($handle = fopen($tempFile, "r")) !== FALSE) {
                $columns = fgetcsv($handle, 1000, ",");
                $columns = array_map('convertToSlug', $columns);
                $columnsToUnset = [];

                foreach ($columns as $k => $v) {
                    if (in_array($v, ['_status', 'called_', 'dialed'])) {
                        $columnsToUnset[] = $k;
                        unset($columns[$k]);
                    }
                }

                if (!tableExists($tableName)) {
                    createTable($tableName, $columns);
                } else {
                    $existingColumns = getExistingColumns($tableName);
                    addMissingColumns($tableName, $columns, $existingColumns);
                }
                $pattern = '/^https:\/\/connect\.facebook\.net\/en_US\/fbevents\.js$/';

                $data = [];
                while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $row = array_map('html_entity_decode', $row);
                    foreach ($columnsToUnset as $v) {
                        unset($row[$v]);
                    }
                    if (count($columns) == count($row)) {
                        $d = array_combine($columns, $row);

                        if (preg_match($pattern, $d['fb_url'])) {
                            $d['fb_url'] = null;
                        }
                        if (
                            (isset($d['pitched']) && checkValueIfForQueue($d['pitched'])) ||
                            (isset($d['picked_up']) && checkValueIfForQueue($d['picked_up'])) ||
                            (isset($d['call_end_result']) && checkValueIfForQueue($d['call_end_result']))
                        ) {
                            $d['locked_status'] = 2; //do not call again if not interested/already called
                        }
                        $d['imported_time'] = time();
                        if (isset($d['phone_number']) && strlen($d['phone_number']) == 10) {
                            $d['phone_number'] = '+1' . $d['phone_number'];
                        }
                        $data[] = $d;
                    }
                }
                //Add new columns locked_status and imported_time if they are missing form the database table
                $newcolumn = ['locked_status','imported_time'];
                $existingColumns = getExistingColumns($tableName);
                addMissingColumns($tableName, $newcolumn, $existingColumns);
                fclose($handle);



                $count = (int) insertData($tableName, $data);
                $totalImported += $count;
                $totalIgnored += (count($data) - $count);

                // Delete the temporary file
                unlink($tempFile);
            } else {
                $message .= "Error opening cleaned file for {$files['name'][$i]}.<br>";
            }
        } else {
            $message .= "Error reading file {$files['name'][$i]}.<br>";
        }
    }

    $message .= "Imported " . $totalImported . " unique rows. Ignored " . $totalIgnored . ' rows.';
}

require("../header.php");
?>
<meta name="robots" content="noindex">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<style>
    table.dataTable td {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 200px;
        cursor: pointer;
    }

    .modal-body {
        width: 100%;
    }


    #modalContent table {
        table-layout: fixed;
        width: 100%;
    }

    #modalContent table td {
        padding-top: 10px;
        padding-bottom: 10px;
        word-break: break-all;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }
</style>

<script>
    const logoImage = document.querySelector('.reachlogo img');
    // Add click event listener
    logoImage.addEventListener('click', () => {
        // Redirect to the index page
        window.location.href = '<?= $sub_dir ?>/index.php'; // Change the URL to your index page
    });

    // Function to hide selected rows
    function hideSelectedRows() {
        $('#dataTable tbody tr').each(function() {
            if ($(this).find('input[type="checkbox"]').prop('checked')) {
                $(this).addClass('hidden-row');
            }
        });
    }

    // Function to toggle visibility of hidden rows
    function toggleHiddenRows() {
        if ($('#show-hidden').prop('checked')) {
            $('#dataTable tbody tr').not('.hidden-row').hide();
        } else {
            $('#dataTable tbody tr').show();
        }
    }
</script>

<div style="background-color:#f5f5f5">
    <div class="py-5 container">
        <h1>Leads for calling</h1>
        <?php if (!empty($message)) : ?>
            <div class="alert alert-info mt-3"><?php echo $message; ?></div>
        <?php endif; ?>
        <form class="form-inline my-3" method="POST" enctype="multipart/form-data">
            <div class="form-group mb-2">
                <label for="csvFile" class="sr-only">CSV File:</label>
                <input type="file" class="form-control-file" id="csvFile" name="csvFiles[]" accept=".csv" required multiple>
            </div>
            <button type="submit" name="upload" class="btn btn-primary mb-2 ml-2">Upload</button>
        </form>
        <table id="dataTable" class="display">
            <thead>
                <tr>
                    <th><input type="checkbox" id="select-all" onchange="selectAll()"></th> <!-- Checkbox column -->
                    <?php
                    $existingColumns = getExistingColumns($tableName);
                    foreach ($existingColumns as $col) {
                        if ($col != 'imported_time') { // Exclude the "imported_time" column
                            if ($col == 'id') { // Check if it's the ID column
                                echo "<th>Hidden</th>"; // Add column header for hidden
                                echo "<th>" . $col . "</th>"; // Add ID column header
                            } else {
                                echo "<th>" . $col . "</th>"; // Add other column headers
                            }
                        }
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                // Assuming $data is your dataset
                foreach ($data as $row) {
                    echo "<tr>";
                    echo "<td><input type='checkbox'></td>"; // Checkbox for selection
                    foreach ($row as $key => $value) {
                        if ($key != 'imported_time') { // Exclude the "imported_time" column
                            if ($key == 'id') { // Check if it's the ID column
                                echo "<td>Hidden</td>"; // Hidden column data
                                echo "<td>" . $value . "</td>"; // ID column data
                            } else {
                                echo "<td>" . $value . "</td>"; // Other column data
                            }
                        }
                    }
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <button type="button" onclick="hideSelectedRows();" class="btn btn-danger mb-2 ml-2">Hide Selected</button>

        <input type="checkbox" id="show-hidden" onchange="toggleHiddenRows();" class="ml-2">
        <label for="show-hidden">Show Only Hidden</label>
        <script>
            let cols = <?= json_encode($existingColumns) ?>;
            var rowData, dataTable;

            function editData() {
                var columnNames = dataTable.columns().header().toArray().map(th => $(th).text()); // Get column names
                var inputFields = '';

                // Generate input fields dynamically
                columnNames.forEach((columnName, index) => {
                    if (columnName != 'call_history') {
                        inputFields += '<div class="form-group mb-3' + (columnName == 'id' ? ' d-none' : '') + '"><label for="' + columnName + '">' + columnName + ': </label>';
                        inputFields += '<input class="form-control" type="' + (columnName == 'id' ? 'hidden' : 'text') + '" id="' + columnName + '" name="' + columnName + '" value="' + ((rowData[index] == null || rowData[index] == 'null') ? '' : rowData[index]) + '"></div>';
                    }
                });

                $('#inputFields').html(inputFields); // Update modal content with input fields
                $('#myModal').modal('hide');
                $('#editModal').modal('show'); // Show modal
            }

            function loadHistory() {
                if (!window.call_history) {
                    alert('no history');
                    return false;
                }
                let call_history = JSON.parse(window.call_history);
                if (!call_history) {
                    alert('error in json');
                    return false;
                }
                $('#modalContent').html('');
                $.each(call_history, function(i, v) {
                    var modalContent2 = displayLeadData(v, false, 'col-12', 1);
                    $('#modalContent').append('<h3 class="text-center mt-3">Call History ' + (i + 1) + '</h3>');
                    $('#modalContent').append(modalContent2);
                });
                $('#modalContent').prepend('<button class="btn brn-primary my-3" onclick="leadDetails();">View Lead Details</button>');
            }

            function leadDetails() {
                var modalContent = displayLeadData(structuredClone(rowData), cols, 'col-12', 1);
                $('#modalContent').html(modalContent);
                $('#modalContent').prepend('<button class="btn brn-primary my-3" onclick="loadHistory();">View Call History</button>');
            }

            $(document).ready(function() {
                $('#dataTable thead th').each(function(index) {
                    var hideColumn = $(this).data('hide'); // Use jQuery's data method
                    if (hideColumn) {
                        $('<style>.dataTable tr th:nth-child(' + (index + 1) + '),.dataTable tr td:nth-child(' + (index + 1) + ') { display: none !important; }</style>').appendTo('body');
                    }
                });

                dataTable = $('#dataTable').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "lengthMenu": [
                        [200, 500, 1000, 2000, -1],
                        [200, 500, 1000, 2000, "All"]
                    ],
                    "pageLength": 200,
                    "scrollX": true, // Enable horizontal scrolling if needed
                    "ajax": {
                        "url": "<?= $sub_dir ?>/admin/fetch_data.php",
                        "type": "POST" // Specify POST request type
                    },
                    "createdRow": function(row, data, dataIndex) {
                        $(row).prepend('<td><input type="checkbox"></td>'); // Add checkbox to each row
                    }
                });
                $('#dataTable tbody').on('click', 'tr', function() {
                    rowData = structuredClone(dataTable.row(this).data());
                    leadDetails();
                    $('#myModal').modal('show');
                });

                $('#editModal form').submit(function(event) {
                    event.preventDefault();
                    var formData = $(this).serialize();
                    $.post('saveChanges.php', formData, function(response) {
                        alert(response); // Log server response
                        dataTable.ajax.reload(); // Reload DataTable after update
                    });
                    $('#editModal').modal('hide'); // Hide modal
                });
            });
        </script>


    </div>
</div>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="<?= $sub_dir ?>/admin/script.js"></script>
<div class="modal fade" id="myModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Additional Details</h4> &nbsp;&nbsp;
                <button type="button" onclick="editData();">Edit</button> &nbsp;&nbsp;
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="modalContent"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Details</h4> &nbsp;&nbsp;
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <div id="inputFields"></div>
                    <input type="submit" value="Save" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
</div>


<div>
    <?php require('../footer.php') ?>