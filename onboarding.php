<?php
require_once('config.php');
// PHP script to process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve the form data from the POST request
    $companyName = $_POST["companyName"];
    $contactPerson = $_POST["contactPerson"];
    $businessEmail = $_POST["businessEmail"];
    $businessPhone = $_POST["businessPhone"];
    $website = $_POST["website"];
    $goalsObjectives = $_POST["goalsObjectives"];
    $targetAudience = $_POST["targetAudience"];
    $nonIdealCustomer = $_POST["nonIdealCustomer"];
    $existingCustomerPatterns = $_POST["existingCustomerPatterns"];
    $metaAdBudget = $_POST["metaAdBudget"];
    $prevAdvertisingExp = $_POST["prevAdvertisingExp"];
    $competitiveLandscape = $_POST["competitiveLandscape"];
    $brandMessaging = $_POST["brandMessaging"];
    $creativeAssets = $_POST["creativeAssets"];
    $marketingSuccess = $_POST["marketingSuccess"];
    $timeline = $_POST["timeline"];
    $accessChecklist = $_POST["accessChecklist"]; // This could be an array
    $loginDetails = $_POST["loginDetails"]; // Get the input
    $encrypted_otherAccessDetails = encrypt($loginDetails, $encryption_key); 

    // Prepare the data for submission
    $data = [
        "companyName" => $companyName,
        "contactPerson" => $contactPerson,
        "businessEmail" => $businessEmail,
        "businessPhone" => $businessPhone,
        "website" => $website,
        "goalsObjectives" => $goalsObjectives,
        "targetAudience" => $targetAudience,
        "nonIdealCustomer" => $nonIdealCustomer,
        "existingCustomerPatterns" => $existingCustomerPatterns,
        "metaAdBudget" => $metaAdBudget,
        "prevAdvertisingExp" => $prevAdvertisingExp,
        "competitiveLandscape" => $competitiveLandscape,
        "brandMessaging" => $brandMessaging,
        "creativeAssets" => $creativeAssets,
        "marketingSuccess" => $marketingSuccess,
        "timeline" => $timeline,
        "accessChecklist" => is_array($accessChecklist) ? implode(", ", $accessChecklist) : $accessChecklist,
        "loginDetails" => $encrypted_otherAccessDetails,
    ];

    // Initialize cURL
    $ch = curl_init($googleAppsScriptURL);

    // Set cURL options for POST request
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute the cURL request and get the response
    $response = curl_exec($ch);

    // Check for errors
    if ($response === false) {
        $error = curl_error($ch);
    } else {
        $success= "Success: $response"; 
        header("location: /onboarding-2.php");
        exit;
        // Display response from Google Apps Script
    }

    // Close cURL
    curl_close($ch);
}
$title="Relax Reach – Client Onboarding";require("header.php") ?>
<meta name="robots" content="noindex">
<script>
    const logoImage = document.querySelector('.reachlogo img');

    // Add click event listener
    logoImage.addEventListener('click', () => {
        // Redirect to the index page
        window.location.href = 'index.php'; // Change the URL to your index page
    });
</script>
<!-- --------------------------Hero Section----------------------- -->
<div class="reach_bannersection">
    <div class="reach_hero">
        <div class="hero_container">
            <div class="container hero_content">
                <p><mark>Your Payment Was Successful</mark></p>
                <h1>Client Onboarding</h1>
                <p>Please complete the steps below so we can get you started as soon as possible.</p>
            </div>
        </div>
    </div>
</div>

<div style="background-color:#f5f5f5">
    <div class="py-5 container" style="max-width: 800px;">
        <br><h2 class="text-center fpnt-weight-bold">Step 1: Complete Your Business Survey</h2><br>
        <!-- Progress Bar -->
        <div class="progress mb-5 ms-0">
            <div class="progress-bar ms-0" id="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="75" aria-valuemin="75" aria-valuemax="100"></div>
        </div>
        <form class="needs-validation" novalidate method="POST" action="?">
            <div class="form-content">
                <br><h4 class="mb-3"><strong>1. Basic Information</strong></h4><br>
                <!-- Company Name -->
                <div class="mb-4">
                    <label for="companyName" class="form-label2" style="padding-top: 20px;">Company Name <span class="text-danger">*</span></label>
                    <input name="companyName" type="text" class="form-control" id="companyName" required>
                    <div class="bolder invalid-feedback">
                        Please add your company name.
                    </div>
                </div>
                <!-- Contact Person -->
                <div class="mb-4">
                    <label for="contactPerson" class="form-label2">Contact Person <span class="text-danger">*</span></label>
                    <input name="contactPerson" type="text" class="form-control" id="contactPerson" required>
                    <div class="bolder invalid-feedback">
                        Please add a contact person.
                    </div>
                </div>
                <!-- Business Email Address -->
                <div class="mb-4">
                    <label for="businessEmail" class="form-label2">Business Email Address <span class="text-danger">*</span></label>
                    <input name="businessEmail" type="email" class="form-control" id="businessEmail" required>
                    <div class="bolder invalid-feedback">
                        Please add a valid email address.
                    </div>
                </div>
                <!-- Business Phone Number -->
                <div class="mb-4">
                    <label for="businessPhone" class="form-label2">Business Phone Number <span class="text-danger">*</span></label>
                    <input name="businessPhone" type="tel" class="form-control" id="businessPhone" required>
                    <div class="bolder invalid-feedback">
                        Please add a valid phone number.
                    </div>
                </div>
                <!-- Website -->
                <div class="mb-5">
                    <label for="website" class="form-label2">Website <span class="text-danger">*</span></label>
                    <input name="website" type="text" class="form-control" id="website" required>
                    <div class="bolder invalid-feedback">
                        Please add your website or "n/a" if you have none.
                    </div>
                </div>
                <br><h4 class="mb-3"><strong>2. Advertising Objectives</strong></h4><br>
                <!-- Goals and Objectives -->
                <div class="mb-4">
                    <label for="goalsObjectives" class="form-label">Goals and Objectives <span class="text-danger">*</span></label>
                    <p>What specific goals do you want to achieve with Meta (Facebook & Instagram) advertising?</p>
                    <textarea name="goalsObjectives" class="form-control" id="goalsObjectives" rows="3" required></textarea>
                    <div class="bolder invalid-feedback">
                        Please specify your advertising goals and objectives.
                    </div>
                </div>
                <!-- Target Audience -->
                <div class="mb-4">
                    <label for="targetAudience" class="form-label">Target Audience <span class="text-danger">*</span></label>
                    <p>Who is your ideal customer? Can you describe them briefly? Please include the geographic region.</p>
                    <textarea name="targetAudience" class="form-control" id="targetAudience" rows="3" required></textarea>
                    <div class="bolder invalid-feedback">
                        Please describe your ideal customer.
                    </div>
                </div>
                <!-- Non-ideal Customer -->
                <div class="mb-4">
                    <label for="nonIdealCustomer" class="form-label">Target Audience #2 <span class="text-danger">*</span></label><p>What does your ideal customer NOT look like? What are the characteristics that make them NOT a good fit for you? Please be as detailed as you can.</p>
                    <textarea name="nonIdealCustomer" class="form-control" id="nonIdealCustomer" rows="3" required></textarea>
                    <div class="bolder invalid-feedback">
                        Please describe what your ideal customer does NOT look like.
                    </div>
                </div>
                <!-- Patterns in Existing Customers -->
                <div class="mb-4">
                    <label for="existingCustomerPatterns" class="form-label">Target Audience #3 <span class="text-danger">*</span></label>
                    <p>If you look at existing customers, what are the common traits between them? Are there patterns you noticed?</p>
                    <textarea name="existingCustomerPatterns" class="form-control" id="existingCustomerPatterns" rows="3" required></textarea>
                    <div class="bolder invalid-feedback">
                        Please describe any common traits among your existing customers.
                    </div>
                </div>
                <!-- Meta Ad Budget -->
                <div class="mb-4">
                    <label for="metaAdBudget" class="form-label">Budgeting <span class="text-danger">*</span></label>
                    <p>What is your monthly Meta advertising budget in USD? </p>
                    <input name="metaAdBudget" type="number" class="form-control" id="metaAdBudget" required>
                    <div class="bolder invalid-feedback">
                        Please enter your advertising budget.
                    </div>
                </div>
                <!-- Previous Advertising Experience -->
                <div class="mb-4">
                    <label for="prevAdvertisingExp" class="form-label">Previous Advertising Experience <span class="text-danger">*</span></label><p>Have you run Meta ads before? If yes, what were the results? Did you work with an agency before? If so, why did you stop?</p>
                    <textarea name="prevAdvertisingExp" class="form-control" id="prevAdvertisingExp" rows="3" required></textarea>
                    <div class="bolder invalid-feedback">
                        Please describe your previous advertising experience.
                    </div>
                </div>
                <!-- Competitive Landscape -->
                <div class="mb-4">
                    <label for="competitiveLandscape" class="form-label">Competitive Landscape <span class="text-danger">*</span></label><p>Who are your main competitors?</p>
                    <textarea name="competitiveLandscape" class="form-control" id="competitiveLandscape" rows="3" required></textarea>
                    <div class="bolder invalid-feedback">
                        Please specify your competitors.
                    </div>
                </div>
                <!-- Brand Messaging -->
                <div class="mb-4">
                    <label for="brandMessaging" class="form-label">Brand Messaging <span class="text-danger">*</span></label><p>What message or offer do you want to convey through your ads?</p>
                    <textarea name="brandMessaging" class="form-control" id="brandMessaging" rows="3" required></textarea>
                    <div class="bolder invalid-feedback">
                        Please describe your brands' messaging or offer as much as possible.
                    </div>
                </div>
                <!-- Creative Assets -->
                <div class="mb-4">
                    <label for="creativeAssets" class="form-label">Creative Assets</label><p>Do you have any existing creative assets we can use? (Link Folder)</p>
                    <textarea name="creativeAssets" class="form-control" id="creativeAssets" rows="3"></textarea>
                </div>
                <!-- Marketing Success -->
                <div class="mb-4">
                    <label for="marketingSuccess" class="form-label">Marketing Success <span class="text-danger">*</span></label><p>How do you measure the success of your marketing efforts currently?</p>
                    <textarea name="marketingSuccess" class="form-control" id="marketingSuccess" rows="3" required></textarea>
                    <div class="bolder invalid-feedback">
                        Please explain how you currently measure marketing success.
                    </div>
                </div>
                <!-- Timeline -->
                <div class="mb-5">
                    <label for="timeline" class="form-label">Timeline <span class="text-danger">*</span></label><p>What is your desired timeline for launching your Meta campaign?</p>
                    <textarea name="timeline" class="form-control" id="timeline" rows="3" required></textarea>
                    <div class="bolder invalid-feedback">
                        Please specify when you would like your Meta campaign to be launched.
                    </div>
                </div>
                <br><h4 class="mb-3"><strong>3. Login Details</strong></h4><br>

                <!-- Checklist Section -->
                <div class="mb-4">
                    <label class="form-label bolder">Please complete as many items of the checklist as possible – we can finish what's left during our next call.</label><br><br>
                    <!-- List of Checkboxes -->
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="check-website-admin" name="accessChecklist[]" value="Website Admin Access">
                        <label class="form-check-label" for="check-website-admin">Admin access to website added below</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="check-meta-ads-admin" name="accessChecklist[]" value="Meta Ads Account Admin Access">
                        <label class="form-check-label" for="check-meta-ads-admin">Admin access to Meta Ad Account given</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="check-facebook-manager-admin" name="accessChecklist[]" value="Facebook Manager Admin Access">
                        <label class="form-check-label" for="check-facebook-manager-admin">Admin access to Facebook Manager given</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="check-crm-admin" name="accessChecklist[]" value="CRM / 3rd Party Application Admin Access">
                        <label class="form-check-label" for="check-crm-admin">Admin access to CRM / 3rd party application added below (if needed)</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="check-meta-payment-method" name="accessChecklist[]" value="Meta payment method is added">
                        <label class="form-check-label" for="check-meta-payment-method">Meta payment method is added</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="check-meta-tax-information" name="accessChecklist[]" value="Meta tax information is added">
                        <label class="form-check-label" for="check-meta-tax-information">Meta tax information is added (if needed)</label>
                    </div>
                   <!--  
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="check-other" name="accessChecklist[]" value="Other">
                        <label class="form-check-label" for="check-other">Other</label>
                        <input type="text" class="form-control mt-2" id="other-input" name="otherAccessDetails" style="display: none;" placeholder="Specify other access">
                    </div> -->
                </div>
                <!-- Admin Access Details -->
                <div class="mb-3">
                    <label for="loginDetails" class="form-label bolder">Please list any administrative access details below. (Platform, Username, Password)</label>
                    <textarea class="form-control" id="loginDetails" name="loginDetails" rows="3"></textarea>
                    <p style="font-size: 14px">🔒 Your sensitive data is submitted securely via SSL and stored encrypted on our servers. Only authorized personnel gets access to it.</p>
                </div>
                <!-- Navigation Buttons -->
                <br><br><button type="submit" class="btn btn-primary btn-lg" style="width:250px">Submit Form</button><br><br>
            </div>
        </form>
    </div>
</div>
<style type="text/css">
   
    .form-label + p,.bolder{
        font-weight: bolder;
    }
    .form-label {
        padding-top: 20px;
    }
    .form-label2 {
        padding-top: 10px;
        padding-bottom: 10px;
    }
    
    
    .reach_hero {
        background-image: url(Images/bg2.jpg);
    }
        
</style>
<!-- JavaScript to handle form navigation and validation -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/js/bootstrap.min.js"></script>
<script>
$(document).ready(function() {
    // Form validation
    $('form').on('submit', function(event) {
        const form = $(this);
        if (!form[0].checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
            form.addClass('was-validated');
        }
    });

    // Access the checkbox and the "Other" input
    const checkOther = $('#check-other');
    const otherInput = $('#other-input');

    // Handle the change event for the "Other" checkbox
    checkOther.change(function() {
        if (checkOther.is(':checked')) {
            otherInput.show(); // Show the "Other" input field
        } else {
            otherInput.hide(); // Hide the "Other" input field
        }
    });

    // Initially hide the "Other" input field if checkbox is not checked
    if (!checkOther.is(':checked')) {
        otherInput.hide();
    }
});
</script>
<div>
    <?php require('footer.php') ?>