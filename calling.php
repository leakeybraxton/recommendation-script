<?php
session_start();
require("config.php");
require("includes/sql_functions.php");
global $SB_CONNECTION;
sb_db_connect();

if (isset($_GET['next'])) {
    unset($_SESSION['loaded_lead_id']);
}


$tableName = 'leads';
$lead = false;
if (isset($_SESSION['loaded_lead_id'])) {
    $leadRow = sb_db_get("SELECT *
    FROM `$tableName`
    WHERE id=" . $_SESSION['loaded_lead_id'] . " and ( `locked_status` is NULL or `locked_status` = 1) LIMIT 1");
    if ($leadRow && isset($leadRow['id'])) {
        $lead = $leadRow;
    }
} else {
    // Start a transaction
    $SB_CONNECTION->begin_transaction();
    try {
        $query = "SELECT *
        FROM `$tableName`
        WHERE `locked_status` is NULL 
        ORDER BY ISNULL(`queue`) desc, `queue` ASC, `id` ASC
        LIMIT 1
        FOR UPDATE";

        $result = $SB_CONNECTION->query($query);

        if ($result->num_rows > 0) {
            $lead = $result->fetch_assoc();

            $leadId = $lead['id'];
            $_SESSION['loaded_lead_id'] = $leadId;
            $updateQuery = "UPDATE `$tableName` SET `locked_status` = 1 WHERE `id` = $leadId";
            $SB_CONNECTION->query($updateQuery);

            $SB_CONNECTION->commit();
        } else {
            $SB_CONNECTION->rollback();
            echo "No Lead.<br>";
            exit;
        }
    } catch (Exception $e) {
        // An error occurred, rollback transaction
        $SB_CONNECTION->rollback();
        echo "error please reload.<br>";
        echo $e->getMessage();
        exit;
    }
}
if (!$lead) {
    header('location: callsubmit.php');
    exit;
}
$leadbackup = $lead;
require("header.php");
?>

<meta name="robots" content="noindex">
<title>Relax Reach – Appointment Setting</title>

<style>
    .reach_hero {
        background-image: url(Images/bg2.jpg);

    }

    .containe-fluid {
        background-image: none;
        background-color: #000;
    }
</style>

<!-- --------------------------Hero Section----------------------- -->
<div class="reach_bannersection">
    <div class="reach_hero">
        <div class="hero_container">
            <div class="container hero_content">
                <h1>Appointment Setting</h1>
            </div>
        </div>
    </div>
</div>

<!-- -------------------section-1----------------- -->
<div class="container mt-5">
    <div id="modalContent">

    </div>
</div>
<div class="container">
    <div id="modalContent2" class="mt-3 mb-5"></div>
</div>
<!-- ---------------------------section-3--------------------------->
<div class="containe-fluid">
    <div class="reachprt3">
        <div class="relaxereachprt3 container">
            <div class="row" id="schedule">
                <div class="col-md-7 ps-4">
                    <div class="container p-5 caller">
                        <form class="needs-validation" novalidate method="POST" action="callsubmit.php" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?= $lead['id'] ?>">
                            <div class="form-group ">
                                <label for="appointment_setter"><u>Appointment Setter</u> *</label>
                                <small class="form-text text-muted text-light">Always use the same name, please.</small>
                                <input type="text" class="form-control" id="appointment_setter" name="appointment_setter" required>
                            </div>


                            <hr class="my-5">
                            <div class="form-group">
                                <label for="introduction"><u>Introduction</u> *</label>
                                <p>Hi this is &lt;name&gt;, Am I talking to <strong><?= $lead['name'] ?></strong>? How is your day going so far?</p>
                                <p>Great! I'm calling in from Relax Reach, a company that specializes in helping <strong><?= $lead['category'] ?></strong> businesses just like yours get more customers.</p>
                                <p>Is that something you would be interested in?</p>
                            </div>

                            <div class="form-group mb-5 mt-3">
                                <label><u>Objection</u></label>
                                <p><strong>Not interested</strong> – Explain our lead magnet and offer to send them to them. Do not ask for a meeting in this email. Only ask for a quick reception reply on the phone and in the email - to start a conversation.</p>
                                <p><strong>Busy</strong> – I won't take up too much of your time, but I wanted to connect because I noticed something intriguing about <strong><?= $lead['company_name'] ?></strong> that caught my attention. This is something that can benefit your business in the future. Do you have a minute or a few? <strong>No:</strong> When would be a good time to call you back?</p>
                                <p><strong>Not the decision-maker</strong> – Can you put me through?</p>
                                <p><strong>Decision-maker busy</strong> – It won't take much time.</p>
                                <p><strong>What is it about?</strong> – We noticed that many <strong><?= $lead['category'] ?></strong> in <strong><?= $lead['city'] ?></strong> are struggling because they don't get enough new customers into their business. I'd like to talk with <strong><?= $lead['name'] ?></strong> about how we can help out with this for <strong><?= $lead['company_name'] ?></strong>.</p>
                            </div>

                            <div class="form-group mb-5">
                                <label for="picked_up">Picked Up?</label><br>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="picked_up" id="picked_upYes" value="Yes" required>
                                    <label class="form-check-label" for="picked_upYes">Yes, Continue</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="picked_up" id="picked_upEmail" value="Email Request" required>
                                    <label class="form-check-label" for="picked_upEmail">Email Request</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="picked_up" id="picked_upVoicemail" value="Voicemail" required>
                                    <label class="form-check-label" for="picked_upVoicemail">Voicemail</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="picked_up" id="picked_upNotInterested" required value="Not Interested / Hung Up">
                                    <label class="form-check-label" for="picked_upNotInterested">Not Interested / Hung Up</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="picked_up" id="picked_upBusy" required value="Decision-Maker Busy / Unreachable">
                                    <label class="form-check-label" for="picked_upBusy">Decision-Maker Busy / Unreachable</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="picked_up" id="picked_upOut" required value="Invalid Number / Out Of Business">
                                    <label class="form-check-label" for="picked_upOut">Invalid Number / Out Of Business</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="picked_up" required id="picked_upOther" value="Other">
                                    <label class="form-check-label" for="picked_upOther">Other:</label>
                                </div>
                                <textarea class="form-control mt-2" id="picked_upOtherInput" name="picked_upOtherInput" style="display: none;" placeholder="Specify (e.g. Call back at 3pm on June 7, 2024)"></textarea>
                            </div>


                            <hr class="my-5">
                            <div class="form-group">
                                <label for="tellMeMore"><u>Ok. / Tell me more about it. / How does that help me?</u></label>
                                <p>From our research, it seems like many <strong><?= $lead['category'] ?></strong> in <strong><?= $lead['city'] ?></strong> are struggling when it comes to getting new customers into their business. If you could take on a few new customers as well, then I'd like to have a chat about how we can help out with this for <strong><?= $lead['company_name'] ?></strong>.</p>
                                <p class="mt-5"><u>Objection</u></p>
                                <p><strong>Not really:</strong> Okay, are you fully booked, or could you take on a few more customers per week?</p>
                                <p><strong>We're fully booked:</strong> Okay, that sounds amazing for you! And would you like to get customers who pay more?</p>
                            </div>

                            <div class="form-group mb-5">
                                <label for="pitched">Pitched?</label><br>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="pitched" id="pitchedYes" value="Yes" required>
                                    <label class="form-check-label" for="pitchedYes">Yes, Continue</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="pitched" id="pitchedEmail" value="Email Request" required>
                                    <label class="form-check-label" for="pitchedEmail">Email Request</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="pitched" id="pitchedNotInterested" value="Not Interested" required>
                                    <label class="form-check-label" for="pitchedNotInterested">Not Interested</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="pitched" id="pitchedEnoughCustomers" value="Enough Customers" required>
                                    <label class="form-check-label" for="pitchedEnoughCustomers">Enough Customers</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="pitched" id="pitchedOther" value="Other" required>
                                    <label class="form-check-label" for="pitchedOther">Other:</label>
                                </div>
                                <textarea class="form-control mt-2" id="pitchedOtherInput" name="pitchedOtherInput" style="display: none;" placeholder="Specify"></textarea>
                            </div>

                            <hr class="my-5">
                            <div class="form-group">
                                <label><u>Interested</u></label>
                                <p>Our company is called Relax Reach, and we specialize in getting customers for <strong><?= $lead['category'] ?></strong> businesses just like yours.
                                    <br><br>
                                    What we do is we create ads on social media for people in your area that are interested in <strong><?= $lead['category'] ?></strong> and get them to call in and book a session with you.
                                    <br><br>
                                    So, if you have a few more minutes, then I’ll tell you a little bit about how our agency operates, then I’ll ask some questions, so I can understand the nuances of your business, then we’ll see whether it’s worth scheduling in a longer call.

                                </p>
                                <p class="mt-5"><u>Objection</u></p>
                                <p><strong>I have tried this before / It doesn't work for me: </strong> Yes, it can be tricky. What I can say is that we are an agency consisting of a team of professionals who do this for a living. We specialize in doing ads just for businesses in the wellness industry - so we know what we're doing.</p>
                                <p><strong>Is this a scam? / I don't trust you. / I don't trust that it works: </strong> We understand that new clients who don't know us that well yet may have reservations, which is why we offer a satisfaction guarantee to our services, meaning: We either manage to get you 10 new leads to your business in the first month, or you pay nothing for our services.</p>
                            </div>


                            <hr class="my-5">
                            <div class="form-group">
                                <label><u>Introducing Agency</u></label>
                                <p>We are called Relax Reach and are a marketing agency that specializes in creating and managing advertising campaigns on Facebook and Instagram, only for wellness businesses. We are talking about businesses like spas, resorts, hotels, yoga studios, and meditation retreats. Everything that's supposed to create more relaxation and wellness for their clients.
                                    <br>
                                    The way we work is that once a client signs up, we assign to them members of our team, which includes the campaign manager who creates the strategies for the campaigns and oversees them, a copywriter who writes the ads, and the designer who creates the grabbing visuals.
                                    <br><br>
                                    Once the team is in place, we start creating the content for your business and make sure that the people who are close to your location and already interested in your services get your ads, and then book a session with you. We tailor the campaigns to specific demographics, interests and behaviors they've shown in the past and adjust them every day to get the best performance. We also take a good look at what your competitors do online and offer insights into what kind of ads they are running and how we can do it even better for you.
                                </p>
                            </div>

                            <hr class="my-5">
                            <div class="form-group">
                                <label for="conversationReason" class="mb-3"><strong><?= $lead['name'] ?></strong>, you just decided to take the time out of your busy schedule today to have this conversation with me. Why is that?</label>
                                <p style="font-size: small;">
                                    < Wait for reply, show gratitude and confirm relevance>
                                </p>
                                <input type="text" class="form-control" id="conversationReason" name="conversationReason">
                            </div>


                            <hr class="my-5">
                            <div class="form-group">
                                <label for="inspiration"><u>What inspired you to start your business?</u></label>
                                <textarea class="form-control" id="inspiration" name="inspiration"></textarea>
                            </div>


                            <hr class="my-5">
                            <div class="form-group">
                                <label for="clientInfo" class="mb-3"><u>What sort of client / customer do you serve & at what price point?</u></label>
                                <p>+ Do you know what the Customer Lifetime Value for your business is?</p>
                                <textarea class="form-control" id="clientInfo" name="clientInfo"></textarea>
                            </div>

                            <hr class="my-5">
                            <div class="form-group">
                                <p class="mb-0">Awesome, I’m going to ask you some more specific questions now so I can understand where your business is at and where you think we can get it to in 12 months time. Does that sound good?</p>
                            </div>

                            <hr class="my-5">
                            <div class="form-group">
                                <label for="gettingNewCustomers"><u>Okay, so what's the current process of getting new clients / customers?</u></label>
                                <textarea class="form-control" id="gettingNewCustomers" name="gettingNewCustomers"></textarea>
                            </div>


                            <hr class="my-5">
                            <div class="form-group">
                                <label for="employees"><u>How many employees do you have?</u></label>
                                <input type="text" class="form-control" id="employees" name="employees">
                            </div>


                            <hr class="my-5">
                            <div class="form-group">
                                <label for="monthlyRevenue"><u>How much revenue is <strong><?= $lead['company_name'] ?></strong> currently doing per month?</u></label>
                                <input type="text" class="form-control" id="monthlyRevenue" name="monthlyRevenue">
                            </div>

                            <hr class="my-5">
                            <div class="form-group">
                                <label for="revenue12Month"><u>How much revenue would you like to be making in 12 months?</u></label>
                                <input type="text" class="form-control" id="revenue12Month" name="revenue12Month">
                            </div>

                            <hr class="my-5">
                            <div class="form-group">
                                <label for="adbudgetMonth">To get to that number, how much ad budget would you be willing to spend per month?</label>
                                <input type="text" class="form-control" id="adbudgetMonth" name="adbudgetMonth">
                            </div>

                            <hr class="my-5">
                            <div class="form-group">
                                <label for="didPaidAdsBefore">Have you ever done paid advertising before?</label>
                                <textarea class="form-control" id="didPaidAdsBefore" name="didPaidAdsBefore"></textarea>
                            </div>

                            <hr class="my-5">
                            <div class="form-group">
                                <label for="workedWithAgencyBefore">Have you ever worked with an agency before?</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="workedWithAgencyBefore" id="workedWithAgencyBeforeInputNo" value="No">
                                    <label class="form-check-label" for="workedWithAgencyBeforeInputNo">No</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="workedWithAgencyBefore" id="workedWithAgencyBeforeInputYes" value="Yes">
                                    <label class="form-check-label" for="workedWithAgencyBeforeInputYes">Yes</label>
                                </div>
                                <textarea class="form-control" style="display: none;" id="workedWithAgencyBeforeInput" name="workedWithAgencyBeforeInput" placeholder="What were your experiences? Why did you stop?"></textarea>
                            </div>

                            <hr class="my-5">
                            <div class="form-group">
                                <label><u>Scheduling Sales Meeting</u></label>
                                <p>I think it's worth having a longer conversation.</p>
                                <p>If you agree to it, we will prepare a free report for you with an analysis of your social media and website presence, and walk you through it. Whether you’re going to work with us or not – in this way you know what you could improve on in your business.</p>
                                <p>If yes:</p>
                                <ul>
                                    <li><b>Confirm lead</b> timezone in the calendar. Schedule for Sales Meeting.</li>
                                    <li>Is there another person who makes the decisions with you?</li>
                                    <ul>
                                        <li>If yes: Okay, and who's that? <span class="font-weight-bold">Wait for reply</span>. Is it possible for them to join as well? <span class="font-weight-bold">Wait for reply</span>. Okay, can you give me their email address?</li>
                                        <ul>
                                            <li>Add as guest in calendar</li>
                                        </ul>
                                    </ul>
                                    <li>You'd also need to be on a computer at that time, so we can show you the free report and what else we have for you in store – does that work for you?</li>
                                    <li>Alright, I scheduled the meeting. You should have received an email with the subject line "Confirmed: Relax Reach Meeting on <span class="font-weight-bold">event date</span>" – is that correct?</li>
                                </ul>
                                <p>Close the call.</p>

                            </div>

                            <div class="form-group">
                                <label for="result">Result:</label><br>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="call_end_result" id="call_end_resultME" value="Scheduled Meeting" required>
                                    <label class="form-check-label" for="call_end_resultME">Scheduled Meeting</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="call_end_result" id="call_end_resultDC" value="Scheduled Discovery Call" required>
                                    <label class="form-check-label" for="call_end_resultDC">Scheduled Discovery Call</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="call_end_result" id="call_end_resultNI" value="Not Interested" required>
                                    <label class="form-check-label" for="call_end_resultNI">Not Interested</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="call_end_result" id="call_end_resultOther" value="Other" required>
                                    <label class="form-check-label" for="call_end_resultOther">Other:</label>
                                </div>
                                <textarea class="form-control mt-2" id="call_end_resultInput" name="call_end_resultInput" style="display: none;" placeholder="Specify"></textarea>
                            </div>
                            <hr class="my-5">
                            <div class="form-group mb-3">
                                <label for="companyName" class="mb-0">Company Name</label>
                                <small class="form-text text-muted text-light">Automatically inserted, please confirm.</small>
                                <input type="text" class="form-control" id="companyName" placeholder="Enter company name" name="company" value="<?= $leadbackup['comapny_name'] ?>">
                            </div>
                            <div class="form-group mb-3">
                                <label for="contactPerson" class="mb-0">Contact Person</label>
                                <small class="form-text text-muted text-light">Automatically inserted, please confirm.</small>
                                <input type="text" class="form-control" id="contactPerson" placeholder="Enter contact person" name="contactName" value="">
                            </div>
                            <div class="form-group mb-3">
                                <label for="contactEmail" class="mb-0">Contact Person Email Address</label>
                                <small class="form-text text-muted text-light">Automatically inserted, please confirm.</small>
                                <input type="email" class="form-control" id="contactEmail" placeholder="Enter email" name="contactEmail" value="<?= $leadbackup['email'] ?>">
                            </div>
                            <div class="form-group mb-3">
                                <label for="contactPhone" class="mb-0">Contact Person Phone Number</label>
                                <small class="form-text text-muted text-light">Automatically inserted, please confirm.</small>
                                <input type="text" class="form-control" id="contactPhone" placeholder="Enter phone number" name="contactPhone" value="<?= $leadbackup['phone_number'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="uploadCall">Call Upload :      </label>
                                <input type="file" name="uploadCall" id="uploadCall">
                            </div>
                            <button type="submit" class="btn btn-primary mt-5">Submit</button>
                        </form>
                    </div>

                    <br>
                    <p class="text-center">Step 2: Rename your successful call to "Company Name - Date" and upload it here: <a href="https://drive.google.com/open?id=1--9KWLaLemCZgp5QA7JAe0ja5BwryAd8" target="_blank">Recordings</a></p><br>
                    
                </div>

                <div class="col-md-5 pe-4">
                    <p class="cfs-52 mb-3 text-center" style="padding: 10px;border: 2px solid #fff;">Schedule Sales Meeting</p>
                    <div class="alert alert-info mb-5 mt-3">! Confirm the correct timezone with the prospect !</div>
                    <div style="width:100%;height:1000px;overflow:scroll !important" id="salesmeeting-inline"></div>
                    <p class="cfs-52 mb-3 text-center" style="padding: 10px;border: 2px solid #fff;">Schedule Discovery Call</p>
                    <div class="alert alert-info mb-5 mt-3">! Confirm the correct timezone with the prospect !</div>
                    <div style="width:100%;height:1000px;overflow:scroll !important" id="dc-inline"></div>


                    <script type="text/javascript">
                        (function(C, A, L) {
                            let p = function(a, ar) {
                                a.q.push(ar);
                            };
                            let d = C.document;
                            C.Cal = C.Cal || function() {
                                let cal = C.Cal;
                                let ar = arguments;
                                if (!cal.loaded) {
                                    cal.ns = {};
                                    cal.q = cal.q || [];
                                    d.head.appendChild(d.createElement("script")).src = A;
                                    cal.loaded = true;
                                }
                                if (ar[0] === L) {
                                    const api = function() {
                                        p(api, arguments);
                                    };
                                    const namespace = ar[1];
                                    api.q = api.q || [];
                                    if (typeof namespace === "string") {
                                        cal.ns[namespace] = cal.ns[namespace] || api;
                                        p(cal.ns[namespace], ar);
                                        p(cal, ["initNamespace", namespace]);
                                    } else p(cal, ar);
                                    return;
                                }
                                p(cal, ar);
                            };
                        })(window, "https://app.cal.com/embed/embed.js", "init");

                        Cal("init", {
                            origin: "https://cal.com"
                        });

                        Cal("inline", {
                            elementOrSelector: "#salesmeeting-inline",
                            calLink: "relaxreach/meeting",
                            layout: "month_view"
                        });

                        Cal("ui", {
                            "theme": "light",
                            "styles": {
                                "branding": {
                                    "brandColor": "#000"
                                }
                            },
                            "hideEventTypeDetails": false,
                            "layout": "month_view"
                        });

                        Cal("init", "mySecond", {
                            origin: "https://app.cal.com"
                        });

                        Cal.ns.mySecond("inline", {
                            elementOrSelector: "#dc-inline",
                            calLink: "relaxreach/discovery-call",
                            layout: "month_view"
                        });

                        Cal.ns.mySecond("ui", {
                            "theme": "light",
                            "styles": {
                                "branding": {
                                    "brandColor": "#000"
                                }
                            },
                            "hideEventTypeDetails": false,
                            "layout": "month_view"
                        });
                    </script>
                    <!-- Cal inline embed code ends -->
                </div>
            </div>
        </div>

    </div>
</div>
<!-- ------------------------------------footer----------------------------- -->
<script src="<?= $sub_dir ?>/admin/script.js"></script>
<script src="https://app.aminos.ai/js/chat_plugin.js" data-bot-id="23074"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<style>
    .caller {
        background-color: #fff;
        color: #000;
    }

    .caller p {
        margin-bottom: 15px !important;
    }

    .caller label:not(.mb-0) {
        margin-bottom: 15px !important;
    }

    .text-light {
        line-height: 1;
        color: #ddd;
    }

    table {
        table-layout: fixed;
        width: 100%;
    }

    table td {
        padding-top: 10px;
        padding-bottom: 10px;
        word-break: break-all;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }
    .skip-btn {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 10%;
            
        }
</style>
<script>
    $(document).ready(function() {
        let rowData = <?= json_encode($lead) ?>;
        let call_history = <?= !empty($leadbackup['call_history']) ? $leadbackup['call_history'] : '[]' ?>;
        var modalContent = displayLeadDataImproved(rowData);
        // var modalContent = displayLeadData(rowData);
        $('#modalContent').html(modalContent);
        $('#modalContent2').append('<h3 class="text-center">Call History</h3>');

        if (call_history.length === 0) {
            $('#modalContent2').append('<p class="text-center">No call history found.</p>');
        } else {
            var table = $('<table class="table table-striped"></table>');
            var thead = $('<thead></thead>');
            var tbody = $('<tbody></tbody>');

            thead.append('<tr><th>Call Time</th><th>Picked Up</th><th>Pitched</th><th>Call End Result</th></tr>');
            table.append(thead);

            $.each(call_history, function(i, v) {
                var callTimestamp = v.time || '';
                var pickedUp = v.picked_up == 'Yes' ? 'Picked Up' : (v.picked_up || '');
                var pitched = v.pitched || '';
                var callEndResult = v.call_end_result || '';
                if (callTimestamp) {
                    callTimestamp = timestampToHumanTime(parseInt(callTimestamp) * 1000);
                }
                var row = $('<tr></tr>');
                row.append('<td>' + callTimestamp + '</td>');
                row.append('<td>' + pickedUp + '</td>');
                row.append('<td>' + pitched + '</td>');
                row.append('<td>' + callEndResult + '</td>');

                // Append the row to the table body
                tbody.append(row);
            });

            // Append the table body to the table
            table.append(tbody);

            // Append the table to the modal content
            $('#modalContent2').append(table);
        }

        // Add a button to trigger pop up modal onclick
        $('#modalContent2').append('<button type="button" class="btn btn-primary" onclick="showSkipModal()">Skip Lead</button>');

        $('form').on('submit', function(event) {
            const form = $(this);
            if (!form[0].checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
                form.addClass('was-validated');
            }
        });
        $('input[name="picked_up"]').change(function() {
            if ($(this).val() === 'Other') {
                $('#picked_upOtherInput').show();
            } else {
                $('#picked_upOtherInput').hide().val('');
            }
        });
        $('input[id="skipped"]').change(function() {
            if ($(this).val() === 'Other') {
                $('#skipOtherInput').show();
            } else {
                $('#skipOtherInput').hide().val('');
            }
        });

        $('input[name="pitched"]').change(function() {
            if ($(this).val() === 'Other') {
                $('#pitchedOtherInput').show();
            } else {
                $('#pitchedOtherInput').hide().val('');
            }
        });
        $('input[name="call_end_result"]').change(function() {
            if ($(this).val() === 'Other') {
                $('#call_end_resultInput').show();
            } else {
                $('#call_end_resultInput').hide().val('');
            }
        });
        $('input[name="workedWithAgencyBefore"]').change(function() {
            if ($(this).val() === 'Yes') {
                $('#workedWithAgencyBeforeInput').attr('placeholder', 'What were your experiences? Why did you stop?').show();
            } else {
                $('#workedWithAgencyBeforeInput').attr('placeholder', 'Why not?').show();
            }
        });
    });

    //function to display modal
    function showSkipModal() {
        $('#skipModal').modal('show');
    }

    
</script>


    <!-- Skip Lead Modal -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="<?= $sub_dir ?>/admin/script.js"></script>
<div class="modal fade" id="skipModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Skip Lead</h4> &nbsp;&nbsp;
                
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form method="post" id="transfer" name="transfer" action="callsubmit.php">                        
                    
                    <input type="hidden" name="id" value="<?= $lead['id'] ?>">
                    <div class="form-group">
                        <label>Reason for Skipping</label><br>
                        <input type="radio" name="skipped" id="skipped" value="Lead Not in Target Market"> Lead Not in Target Market <br>                                                        
                        <input type="radio" name="skipped" id="skipped" value="Other"> Other <br>                                                        
                        <textarea class="form-control mt-2" id="skipOtherInput" name="skipOtherInput" style="display: none;" width="100" placeholder="Specify (e.g. Call back at 3pm on June 7, 2024)"></textarea>
                    </div>  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" id="Transfer" name="Transfer" class="btn btn-primary btn-sm rounded-pill">Continue</button>
                </form>
            </div>
        </div>
    </div>
</div>
    <!-- End of modal -->

<?php require('footer.php') ?>