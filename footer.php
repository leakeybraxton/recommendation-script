<div class="reach_footer-logo">
    <img src="<?= $sub_dir ?>/Images/LogoTagline.png" alt="Relax Reach Logo">
</div>

<div class="footer_copyright">
    <p>
        <a href="tel:+12402000020">+1 (240) 200-0020</a>
        <br class="d-block d-sm-none"><span class="d-none d-sm-inline"> – </span>
        <a href="mailto:hello@relaxreach.com">hello@relaxreach.com</a>
        <br class="d-block d-sm-none"><span class="d-none d-sm-inline"> – </span>
        <a href="imprint.php" target="_blank">Imprint</a> –
        <a href="privacy-policy.php" target="_blank">Privacy Policy</a>
    </p>
    <p class="copyright">Copyright © 2023–<?php echo date("Y"); ?> Relax Reach Social Media Marketing Agency. All Rights Reserved.</p>
</div>
</div>

<!-- Start of HubSpot Embed Code -->
<script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/46124342.js"></script>
<!-- End of HubSpot Embed Code -->
</body>

<script>
    <?php
    if (isset($_GET['status']) && $_GET['status'] == 'success') {
        echo "
    dltKeyFromUrl(['status']);
    alert('Thank you! your form is submitted successfully.');";
    }
    ?>

    function dltKeyFromUrl(key = []) {
        let currentUrl = new URL(window.location.href);
        key.forEach(k => {
            currentUrl.searchParams.delete(k);
        })
        history.replaceState(null, null, currentUrl.href);
    }
</script>

</html>