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
                <h1>Onboarding Complete</h1>
            </div>
        </div>
    </div>
</div>

<div style="background-color:#f5f5f5">
    <div class="py-5 container" style="max-width: 800px;" id="schedulemeeting">
            <div class="form-content">
                <div class="">
                    <br><p class="cfs-5 mb-3 text-center">WELCOME TO RELAX REACH! &#127881;</p><br><br>
                    <p class="cfs-2 mb-3">Thanks for choosing our agency and allowing us to help you get new leads & customers via paid advertising on social media. By booking our services, you have gained access to the following:
                    <br><br></p>
                    <ul class="cfs-1 listc mt-3">
                        <li><p>A <strong>dedicated professional team</strong> that will run your Meta Ads for the month, consisting of a copywriter, a designer, a campaign manager, and an account manager</p></li>
                        <li><p><strong>Daily ad optimizations</strong> to ensure the best-possible results for your campaigns</p></li>
                        <li><p><strong>Weekly content</strong> for the ads, adjusted to your followers and customers</p></li>
                        <li><p><strong>Weekly reports</strong> so you can track your campaign progress as well</p></li>
                        <li><p><strong>(Bi-)Weekly meetings</strong> to ensure alignment with you and your team</p></li>
                        <li><p>Setup of your <strong>Meta Ads account</strong></p></li>
                        <li><p>Setup of your <strong>Facebook & Instagram pages</strong></p></li>
                        <li><p>Setup of required <strong>landing pages</strong></p></li>
                    </ul>
                    <br><br>
                    <p class="cfs-2 mb-3">We are looking forward to your first Strategy Session, where we will:</p><br>              
                    <ul class="cfs-1 listc mt-3">
                        <li>
                            <p>Retrieve all the necessary <strong>information &amp; login data</strong to start advertising for you.</p>
                        </li>
                        <li>
                            <p>Present you our <strong>strategy</strong> for your ad campaigns</p>
                        </li>
                        <li>
                            <p>Introduce you to our <strong>reporting process</strong> & <strong>schedule check-in meetings</strong></p>
                        </li>
                    </ul><br>
                </div>
            </div>
    </div>
</div>
<style type="text/css">
    ul.listc li::marker{
        color: #000;
    }
    .reach_hero {
        background-image: url(Images/bg2.jpg);
    }
        
</style>
<div>
    <?php require('footer.php') ?>