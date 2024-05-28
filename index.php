<<<<<<< HEAD
<?php require("header.php") ?>
<style>
    @media (max-width: 767px) {
        /* #my-cal-inline {} */
    }
</style>
<!-- --------------------------Hero Section----------------------- -->
<div class="reach_bannersection">
    <div class="reach_hero">
        <div class="hero_container">
            <div class="container hero_content">
                <p>Effortless Business Growth:</p>
                <h1>We Generate <span>High-Value</span> Leads <br> For Your <span>Wellness</span> Business</h1>
                <p class="hero_tagline">Without Hassle on Your End</p>
            </div>
            <div class="hero_button">
                <a href="#schedule" class="btn hero_btn">
                    <h2>Get More Leads</h2>
                </a>
            </div>
        </div>
    </div>
</div>
<!-- -------------------section-1----------------- -->
<div class="container relax-sct-1">
    <div class="reach_sctonce">
        <h2>Who Are <span> We</span>?</h2>
        <p>We're a social media marketing agency specializing in paid advertising for businesses with a <mark>wellness focus</mark>. With strong reliance on industry expertise and creative craftsmanship, we're delivering <mark>measurable results</mark> through strategic and data-driven advertising campaigns, helping our clients thrive in the digital landscape.</p>
    </div>
    <div class="container relax-sct-1">
        <div class="reach_flexible">
            <div class="reach_flexeble_content">
                <h2>Our <span>Process</span></h2>
            </div>
            <div class="reach_flexeble_flex">
                <div class="boxes">
                    <div class="number">
                        <h2>1</h2>
                    </div>
                    <div class="content">
                        <h2>Create Content</h2>
                        <p>In the initial step, we create copy and visuals that highlight your business. These form the foundation of our strategy, serving to attract a greater number of potential clients to your business.</p>
                    </div>
                </div>
                <div class="boxes">
                    <div class="number">
                        <h2>2</h2>
                    </div>
                    <div class="content">
                        <h2>Launch Campaign</h2>
                        <p>Next, we prepare and launch ads based on the content we've collected. These ads are strategically designed and placed on the Meta ad network to capture the attention of your clients.</p>
                    </div>
                </div>
                <div class="boxes">
                    <div class="number">
                        <h2>3</h2>
                    </div>
                    <div class="content">
                        <h2>Generate Leads</h2>
                        <p>Finally, we collect information from individuals who are genuinely interested in your services, prioritising quote-ready leads and eliminating tire kickers.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--<div class="container relax-sct-1">    
    <div class="reach_sctonce">
        <h2>Our <span> Guarantee</span></h2>

        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-3 pe-0 text-center text-md-end">
                    <img style="max-width: 220px;width: 100%;margin-top: 3rem;" src="Images/gurantee.png?">
                </div>
                <div class="col-md-9 ps-3">
        <p class="text-start mt-sml-0"><strong>Get A Measure Of Our Marketing Expertise</strong><br><br>Take us up on our special guarantee for new clients:<br><br>You either receive <mark>10 new leads</mark> in the first 30 days of advertising with us, or you pay flat out <mark>nothing!</mark><br><br>Just call in and let our representative know that you are interested in the <strong>trial offer</strong>.</p>
        </div></div></div>
    </div>
</div>-->
</div>

<!-- ---------------------------section-3--------------------------->
<div class="containe-fluid">
    <div class="reachprt3">
        <div class="relaxereachprt3 container">
            <div class="row" id="schedule">
                <div class="col-md-8 pe-4">
                    <div class="d-block d-sm-none">
                        <p class="cfs-52 mb-3 text-center" style="padding: 5px; border: 2px solid #fff;">Schedule Your Free Discovery Call</p>
                        <div class="center-on-mobile" style="padding-top:50px"><img src="Images/person1.jpg" alt="Client Success Manager" width="150" class="person-logo mb-3"></div>
                        <p class="cfs-3"><strong>QUMAIL | CLIENT SUCCESS MANAGER</strong></p><br>
                    </div>
                    <p class="d-none d-sm-block cfs-52 mb-3 text-center" style="padding: 10px;border: 2px solid #fff;">Schedule Your Free Discovery Call</p>

                    <div style="width:100%;height:400px;padding-top: 25px; overflow:scroll !important;" id="my-cal-inline"></div>
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
                            elementOrSelector: "#my-cal-inline",
                            calLink: "relaxreach/discovery-call",
                            layout: "month_view"
                        });

                        Cal("ui", {
                            "theme": "light",
                            "styles": {
                                "branding": {
                                    "brandColor": "#50C878"
                                }
                            },
                            "hideEventTypeDetails": false,
                            "layout": "month_view"
                        });
                    </script>
                    <!-- Cal inline embed code ends -->

                    <p class="cfs-2 mb-3 text-center">By the end of this short call, you will have a clear understanding of the next steps you can take for your company to get a <strong>consistent and reliable stream of new customers</strong> with paid online advertising.<br><br></p>

                </div>


                <div class="col-md-4 ps-4">
                    <div class="d-none d-sm-inline">
                        <div class="text-center"><img src="Images/person1.jpg" alt="Client Success Manager" width="170" class="person-logo"></div><br>
                        <p class="cfs-3"><strong>QUMAIL | CLIENT SUCCESS MANAGER</strong></p><br>
                    </div>
                    <p class="cfs-4 text-center"><strong>THIS 15-MINUTE CALL IS PERFECT FOR:</strong></p><br>
                    <ul class="cfs-1 listc mt-3">
                        <li>
                            <p>Wellness businesses looking to consistently and reliably get <strong> more leads.</strong></p>
                        </li>
                        <li>
                            <p>Wellness businesses looking to take their offline business <strong>online.</strong></p>
                        </li>
                        <li>
                            <p>Wellness businesses looking to <strong>stand out</strong> in the crowded industry &amp; reach their <strong>target audience</strong> efficiently.</p>
                        </li>
                        <li>
                            <p>Wellness businesses looking for a reliable agency that can make their company a <strong>priority.</strong></p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ------------------------------------footer----------------------------- -->

<div class="container-fluid relacx_footer">
    <div class="footer_reach_top">
        <div class="footer_boxed">
            <div class="icons">
                <img src="Images/rating-stars.png" alt="Industry Specialists">
            </div>
            <div class="footer_boxed_content">
                <p>Industry Specialists</p>
            </div>
        </div>
        <div class="footer_boxed">
            <div class="icons">
                <img src="Images/images2.png" alt="Measurable Performance">
            </div>
            <div class="footer_boxed_content">
                <p>Measurable Performance</p>
            </div>
        </div>
        <div class="footer_boxed">
            <div class="icons">
                <img src="Images/images3.png" alt="Qualified Leads">
            </div>
            <div class="footer_boxed_content">
                <p>Qualified Leads</p>
            </div>
        </div>
    </div>

    <script src="https://app.aminos.ai/js/chat_plugin.js" data-bot-id="19862"></script>
=======
<?php require("header.php") ?>
<style>
    @media (max-width: 767px) {
}
</style>
<!-- --------------------------Hero Section----------------------- -->
<div class="reach_bannersection">
    <div class="reach_hero">
        <div class="hero_container">
            <div class="container hero_content">
                <p>Effortless Business Growth:</p>
                <h1>We Drive <span>High-Value</span> Customers <br> To Your <span>Wellness</span> Business</h1>
                <p class="hero_tagline">Without Hassle on Your End</p>
            </div>
            <div class="hero_button">
                <a href="#schedule" class="btn hero_btn">
                    <h2>Get More Customers</h2>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- -------------------section-1----------------- -->
<div class="container relax-sct-1">
    <div class="reach_sctonce">
        <h2>Who Are <span> We</span>?</h2>
        <p>We're a social media marketing agency specializing in paid advertising for businesses with a <mark>wellness focus</mark>. With strong reliance on industry expertise and creative craftsmanship, we're delivering <mark>measurable results</mark> through strategic and data-driven advertising campaigns, helping our clients thrive in the digital landscape.</p>
    </div>
<div class="container relax-sct-1">
    <div class="reach_flexible">
        <div class="reach_flexeble_content">
            <h2>Our <span>Process</span></h2>
        </div>
        <div class="reach_flexeble_flex">
            <div class="boxes">
                <div class="number">
                    <h2>1</h2>
                </div>
                <div class="content">
                    <h2>Create Content</h2>
                    <p>In the initial step, we create copy and visuals that highlight your business. These form the foundation of our strategy, serving to attract a greater number of potential clients to your business.</p>
                </div>
            </div>
            <div class="boxes">
                <div class="number">
                    <h2>2</h2>
                </div>
                <div class="content">
                    <h2>Launch Campaign</h2>
                    <p>Next, we prepare and launch ads based on the content we've collected. These ads are strategically designed and placed on the Meta ad network to capture the attention of your clients.</p>
                </div>
            </div>
            <div class="boxes">
                <div class="number">
                    <h2>3</h2>
                </div>
                <div class="content">
                    <h2>Generate Leads</h2>
                    <p>Finally, we collect information from individuals who are genuinely interested in your services, prioritising quote-ready leads and eliminating tire kickers.</p>
                </div>
            </div>
        </div>
    </div>
</div>    
<!--<div class="container relax-sct-1">    
    <div class="reach_sctonce">
        <h2>Our <span> Guarantee</span></h2>

        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-3 pe-0 text-center text-md-end">
                    <img style="max-width: 220px;width: 100%;margin-top: 3rem;" src="Images/gurantee.png?">
                </div>
                <div class="col-md-9 ps-3">
        <p class="text-start mt-sml-0"><strong>Get A Measure Of Our Marketing Expertise</strong><br><br>Take us up on our special guarantee for new clients:<br><br>You either receive <mark>10 new leads</mark> in the first 30 days of advertising with us, or you pay flat out <mark>nothing!</mark><br><br>Just call in and let our representative know that you are interested in the <strong>trial offer</strong>.</p>
        </div></div></div>
    </div>
</div>-->
</div>

<!-- ---------------------------section-3--------------------------->
<div class="containe-fluid">
    <div class="reachprt3">
        <div class="relaxereachprt3 container">
            <div class="row" id="schedule">
                <div class="col-md-8 pe-4">
                    <div class="d-block d-sm-none">
                        <p class="cfs-52 mb-3 text-center" style="padding: 5px; border: 2px solid #fff;">Schedule Your Free Discovery Call</p>
                        <div class="center-on-mobile" style="padding-top:50px"><img src="Images/person1.jpg" alt="Client Success Manager" width="150" class="person-logo mb-3"></div>
                        <p class="cfs-3"><strong>QUMAIL | CLIENT SUCCESS MANAGER</strong></p><br>
                    </div>
                    <p class="d-none d-sm-block cfs-52 mb-3 text-center" style="padding: 10px;border: 2px solid #fff;">Schedule Your Free Discovery Call</p>

                    <div style="width:100%;height:400px;padding-top: 25px; overflow:scroll !important;" id="my-cal-inline"></div>
                    <script type="text/javascript">
                      (function (C, A, L) { let p = function (a, ar) { a.q.push(ar); }; let d = C.document; C.Cal = C.Cal || function () { let cal = C.Cal; let ar = arguments; if (!cal.loaded) { cal.ns = {}; cal.q = cal.q || []; d.head.appendChild(d.createElement("script")).src = A; cal.loaded = true; } if (ar[0] === L) { const api = function () { p(api, arguments); }; const namespace = ar[1]; api.q = api.q || []; if(typeof namespace === "string"){cal.ns[namespace] = cal.ns[namespace] || api;p(cal.ns[namespace], ar);p(cal, ["initNamespace", namespace]);} else p(cal, ar); return;} p(cal, ar); }; })(window, "https://app.cal.com/embed/embed.js", "init");
                    Cal("init",  {origin:"https://cal.com"});
                    
                      Cal("inline", {
                        elementOrSelector:"#my-cal-inline",
                        calLink: "relaxreach/discovery-call",
                        layout: "month_view"
                      });
                    
                      Cal("ui", {"theme":"light","styles":{"branding":{"brandColor":"#50C878"}},"hideEventTypeDetails":false,"layout":"month_view"});
                      </script>
                      <!-- Cal inline embed code ends -->
                    
                      <p class="cfs-2 mb-3 text-center">By the end of this short call, you will have a clear understanding of the next steps you can take for your company to get a <strong>consistent and reliable stream of new customers</strong> with paid online advertising.<br><br></p>
                    
                    </div>
                    
                    
                <div class="col-md-4 ps-4">
                    <div class="d-none d-sm-inline"><div class="text-center"><img src="Images/person1.jpg" alt="Client Success Manager" width="170" class="person-logo"></div><br>
                        <p class="cfs-3"><strong>QUMAIL | CLIENT SUCCESS MANAGER</strong></p><br>
                    </div>
                    <p class="cfs-4 text-center"><strong>THIS 15-MINUTE CALL IS PERFECT FOR:</strong></p><br>
                    <ul class="cfs-1 listc mt-3">
                        <li>
                            <p>Wellness businesses looking to consistently and reliably get <strong> more customers.</strong></p>
                        </li>
                        <li>
                            <p>Wellness businesses looking to take their offline business <strong>online.</strong></p>
                        </li>
                        <li>
                            <p>Wellness businesses looking to <strong>stand out</strong> in the crowded industry &amp; reach their <strong>target audience</strong> efficiently.</p>
                        </li>
                        <li>
                            <p>Wellness businesses looking for a reliable agency that can make their company a <strong>priority.</strong></p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ------------------------------------footer----------------------------- -->

<div class="container-fluid relacx_footer">
    <div class="footer_reach_top">
        <div class="footer_boxed">
            <div class="icons">
                <img src="Images/rating-stars.png" alt="Industry Specialists">
            </div>
            <div class="footer_boxed_content">
                <p>Industry Specialists</p>
            </div>
        </div>
        <div class="footer_boxed">
            <div class="icons">
                <img src="Images/images2.png" alt="Measurable Performance">
            </div>
            <div class="footer_boxed_content">
                <p>Measurable Performance</p>
            </div>
        </div>
        <div class="footer_boxed">
            <div class="icons">
                <img src="Images/images3.png" alt="Qualified Leads">
            </div>
            <div class="footer_boxed_content">
                <p>Qualified Leads</p>
            </div>
        </div>
    </div>
    
    <script src="https://app.aminos.ai/js/chat_plugin.js" data-bot-id="19862"></script>
>>>>>>> master
    <?php require('footer.php') ?>