<?php
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
                <h1>Client Onboarding</h1>
                <p>Please complete the steps below so we can get you started as soon as possible.</p>
            </div>
        </div>
    </div>
</div>

<div style="background-color:#f5f5f5">
    <div class="py-5 container" style="max-width: 800px;" id="schedule">
        <br><h2 class="text-center fpnt-weight-bold">Step 2: Schedule Your First Strategy Session</h2><br>
        <!-- Progress Bar -->
        <div class="progress mb-5 ms-0">
            <div class="progress-bar ms-0" id="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        
        <div class="form-content">
            <!-- Calendly inline widget begin -->
                <div style="border:0" class="calendly-inline-widget" data-url="https://calendly.com/relaxreach/strategy-session?hide_event_type_details=1&hide_gdpr_banner=1&primary_color=50c878" style="min-width:320px;height:700px;"></div>
                <script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js" async></script>
            <!-- Calendly inline widget end -->
        </div><br><br>
    </div>
</div>
<style type="text/css">
    .calendly-inline-widget iframe{min-width:320px;height:700px;
    }

    .reach_hero {
        background-image: url(Images/bg2.jpg);
    }
        
</style>
<div>
    <?php require('footer.php') ?>