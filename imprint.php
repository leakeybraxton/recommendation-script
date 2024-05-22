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

    <div class="py-5 container" style="max-width: 800px;">
        <h1 class="">Imprint</h1>


        <h2 class="mt-5 mb-3">Information in accordance with section 5 TMG</h2>
        <p>Hartmund Wendlandt<br />
            Relax Reach Marketing Agency<br />
            Bahnhofstra&szlig;e 7<br />
            82296 Sch&ouml;ngeising<br />
            Germany</p>
        <p>VAT-ID: DE300932975</p>
        <p>Phone: +49 15147301297<br />
            E-Mail: hartmund@relaxreach.com</p>


        <h2 class="mt-5 mb-3">Person responsible for content in accordance with 55 Abs. 2 RStV
        </h2>
        <p>Hartmund Wendlandt<br />
            Bahnhofstra&szlig;e 7<br />
            82296 Sch&ouml;ngeising<br />
            Germany</p>


        <h2 class="mt-5 mb-3">Disclaimer</h2><br>
        <h3 class="mt-3">Accountability for content</h3>
        <p>The contents of our pages have been created with the utmost care. However, we cannot guarantee the contents’ accuracy, completeness or topicality. According to statutory provisions, we are furthermore responsible for our own content on these web pages. In this context, please note that we are accordingly not obliged to monitor merely the transmitted or saved information of third parties, or investigate circumstances pointing to illegal activity. Our obligations to remove or block the use of information under generally applicable laws remain unaffected by this as per §§ 8 to 10 of the Telemedia Act (TMG).</p>


        <h3 class="mt-3">Accountability for links</h3>
        <p>Responsibility for the content of external links (to web pages of third parties) lies solely with the operators of the linked pages. No violations were evident to us at the time of linking. Should any legal infringement become known to us, we will remove the respective link immediately.</p>


        <h3 class="mt-3">Copyright</h3>
        <p>Our web pages and their contents are subject to German copyright law. Unless expressly permitted by law (§ 44a et seq. of the copyright law), every form of utilizing, reproducing or processing works subject to copyright protection on our web pages requires the prior consent of the respective owner of the rights. Individual reproductions of a work are allowed only for private use, so must not serve either directly or indirectly for earnings. Unauthorized utilization of copyrighted works is punishable (§ 106 of the copyright law).</p>


        <h2 class="mt-5 mb-3">EU Dispute Resolution</h2><br>
        <p>The European Comission offers a platform for <a href="https://ec.europa.eu/consumers/odr/" target="_blank" rel="noopener noreferrer">Online Dispute Resolution (ODR)</a>. You can find our email address above. We are not willing or obliged to participate in dispute resolution proceedings before a consumer arbitration board.</p>
    </div>
</div>


<div>



    <?php require('footer.php') ?>