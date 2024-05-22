<?php require("header.php") ?>
<meta name="robots" content="noindex">
<script>
    const logoImage = document.querySelector('.reachlogo img');

    // Add click event listener
    logoImage.addEventListener('click', () => {
        // Redirect to the index page
        window.location.href = 'index.php'; // Change the URL to your index page
    });
</script>

    <div style="background-color:#f5f5f5">
    
        <div class="py-5 container" style="max-width: 800px;"><br><br><br>
            <strong><h1 style="padding: 10px;border: 3px solid #000;">Thank you! Your <span style="color:#50C878">Discovery Call</span> Has Been Scheduled.</h1></strong><br>
    
            <p>We are looking forward to getting on a call with you and discuss how we can help your company get more leads through paid advertising on social media.<br><br>You will soon receive a separate email with our appointment confirmation.</p><br><br><br>
            
        </div>
    </div>
<div>
    
<?php require('footer.php') ?>