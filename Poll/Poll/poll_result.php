<?php
$page = "single_poll.php";
include './file_includes.php';
if ($_GET['poll_id']) {

    if ($_SESSION['poll_user']) {
        $username = $_SESSION['poll_user'];
    } else {
        /// $username = $_SERVER['REMOTE_ADDR'];
        $username = get_client_ip();
    }
    $poll_id = $_GET['poll_id'];
    $link = site_url() . "single_poll.php?poll_id=" . $poll_id;
    $poll_res_link = site_url() . "poll_result.php?poll_id=" . $poll_id;
    ?>
    <html lang="en">
        <?php include './header_files.php'; ?>

        <body>
            <?php include './menu.php'; ?>

            <!-- contact page breadcrumns -->
            <section class="inner-banner">

            </section>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-padding">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Poll result</li>
                </ol>
            </nav>
            <!-- contact page breadcrumns -->

            <!-- contact section -->
            <section class="w3l-contact3" style="background-color: #ececec;">
                <div class="contact1-bg section-gap">
                    <div class="container">
                        <div class="container">
                            <p id="success_msg" class="alert alert-dismissible alert-success" style="display: none;">
                                Succeesfully voted
                            </p>
                            <center>
                                <div class="card" style="width: auto; min-height: 500px;">
                                    <div class="card-body">
                                        <form action="" method="post">
                                            <?php
                                            $poll_quesSQL = "SELECT a.id, a.title, a.single_multi, a.created_by, a.from_date, a.description_type FROM poll_question a WHERE MD5(a.id)='$poll_id'";
                                            $poll_fetch = json_decode(ret_json_str($poll_quesSQL));

                                            foreach ($poll_fetch as $poll_val) {
                                                $pol_id = $poll_val->id;
                                                $created_by = $poll_val->created_by;
                                                $from_date = $poll_val->from_date;
                                                $title = $poll_val->title;
                                                $description_type = $poll_val->description_type;
                                                $single_multi = $poll_val->single_multi;
                                            }
                                            ?>
                                            <input type="hidden" name="poll_ques_id" id="poll_ques_id" class="form-control" value="<?php echo $pol_id; ?>"/>
                                            <span style="font-family: sans-serif; font-size: 25px; font-weight: bold;"><?php echo $title; ?></span><br/>
                                            <span style="color: #797979;">by <?php echo $created_by; ?>@poll on <?php echo date("jS F, Y", strtotime($from_date)); ?></span>
                                            <div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
                                            <script type="text/javascript">
                                                Highcharts.chart('container', {
                                                    chart: {
                                                        plotBackgroundColor: null,
                                                        plotBorderWidth: null,
                                                        plotShadow: false,
                                                        type: 'pie'
                                                    },
                                                    title: {
                                                        text: ''
                                                    },
                                                    tooltip: {
                                                        pointFormat: '{series.name}: <b>{point.percentage:.1f}</b>%'
                                                    },
                                                    plotOptions: {
                                                        pie: {
                                                            allowPointSelect: true,
                                                            cursor: 'pointer',
                                                            dataLabels: {
                                                                enabled: true,
                                                                format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                                                            }
                                                        }
                                                    },
                                                    series: [{
                                                            name: 'Brands',
                                                            colorByPoint: true,
                                                            data: [
    <?php
    $poll_resSQL = "SELECT a.poll_ans_text, a.poll_vote FROM poll_answers a WHERE MD5(a.poll_id)='$poll_id'";
    $poll_res_fetch = json_decode(ret_json_str($poll_resSQL));
    foreach ($poll_res_fetch as $poll_res_val) {
        $poll_ans_text = $poll_res_val->poll_ans_text;
        $poll_vote = $poll_res_val->poll_vote;
        ?>
                                                                    {
                                                                        name: "<?php echo $poll_ans_text; ?>",
                                                                        y: <?php echo $poll_vote; ?>
                                                                    },
    <?php }
    ?>
                                                            ]
                                                        }]
                                                });
                                            </script>

                                            <br/><br/>
                                            <input type="hidden" name="single_multi" id="single_multi" class="form-control" value="<?php echo $single_multi; ?>"/>
                                            <div style="text-align: left; margin-top: 20px;">    
                                                <b style="font-family: Nunito, sans-serif; color: #4A4A4A">
                                                    Total voted :
                                                </b><br/><br/>
                                                <?php
                                                $poll_ans_countSQL = "SELECT a.poll_ans_text, a.poll_vote FROM poll_answers a WHERE MD5(a.poll_id)='$poll_id'";
                                                $poll_countfetch = json_decode(ret_json_str($poll_ans_countSQL));
                                                foreach ($poll_countfetch as $poll_count_val) {

                                                    $ans = $poll_count_val->poll_ans_text;
                                                    $votecount = $poll_count_val->poll_vote;
                                                    ?>
                                                    <?php echo $ans; ?> ---- <?php echo $votecount; ?><br/><br/>
                                                    <?php
                                                }
                                                ?></div><br/>
                                            <div class="row">
                                                <div class="col-lg-4 col-4">
                                                    <button type="button" disabled="disabled" id="create_vote" name="create_vote" class="btn btn-success">
                                                        REFRESH
                                                    </button>   
                                                </div>
                                                <div class="col-lg-4 col-4">
                                                    <a href="<?php echo $link; ?>" >
                                                        <button type="button" id="vote" name="vote" class="btn btn-warning">
                                                            VOTE
                                                        </button>
                                                    </a>
                                                    </a>
                                                </div>
                                                <div class="col-lg-4 col-4">
                                                    <a href="#share" >
                                                        <button type="button" id="share" name="share" class="btn btn-info">
                                                            SHARE
                                                        </button>
                                                    </a>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>



                                <div class="card" style="width: auto; min-height: 100px; margin-top: 30px;">
                                    <div class="card-body">
                                        <div id="share" style="color: #363636;">
                                            <h3>Share this poll</h3> <br/><br/>
                                            <input type="text" name="copy_text" id="copy_text" readonly="readonly" value="<?php echo $link; ?>" />
                                            <button type="button" name="copy_btn" id="copy_btn" class="btn btn-info" onclick="cpy_text(document.getElementById('copy_text'));">
                                                Copy link</button>
                                            <br/><br/>
                                            <a role="button" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $link; ?>" target="_blank" rel="noopener"> 
                                                <span class="fa fa-facebook-f"></span>
                                            </a>  
                                            &nbsp;&nbsp;
                                            <a role="button" href="https://api.whatsapp.com/send?text=test - <?php echo $link; ?>" target="_blank" rel="noopener"> 
                                                <span class="fa fa-whatsapp"></span>
                                            </a>  
                                            &nbsp;&nbsp;
                                            <a role="button" href="http://www.twitter.com/share?text=test&url=<?php echo $link; ?>" target="_blank" rel="noopener"> 
                                                <span class="fa fa-twitter"></span>
                                            </a>  
                                            &nbsp;&nbsp;
                                            <a href="" onclick="cpy_text(document.getElementById('embed_link'));">
                                                <img src="assets/images/embed.png" width="20" height="20" />
                                            </a>
                                            <textarea id="embed_link" name="embed_link" style="display: none;">
                                                                                    <iframe width="620" height="620" src="<?php echo $link; ?>" frameborder="0" allowfullscreen></iframe>
                                            </textarea>
                                        </div>
                                    </div>
                                </div>
                            </center>

                        </div>
                    </div>
                </div>
            </section>

            <!-- site footer -->
            <footer id="site-footer">

                <?php include 'footer.php'; ?>
            </footer>
            <!-- //site footer -->

            <!-- move top -->
            <button onclick="topFunction()" id="movetop" class="bg-primary" title="Go to top">
                <span class="fa fa-angle-up"></span>
            </button>

            <script>
                // When the user scrolls down 20px from the top of the document, show the button
                window.onscroll = function () {
                    scrollFunction()
                };
                function scrollFunction() {
                    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                        document.getElementById("movetop").style.display = "block";
                    } else {
                        document.getElementById("movetop").style.display = "none";
                    }
                }
                // When the user clicks on the button, scroll to the top of the document
                function topFunction() {
                    document.body.scrollTop = 0;
                    document.documentElement.scrollTop = 0;
                }
            </script>
            <!-- //move top -->

            <!-- javascript -->
            <script src="assets/js/jquery-3.3.1.min.js"></script>

            <!-- libhtbox -->
            <script src="assets/js/lightbox-plus-jquery.min.js"></script>

            <!-- particles -->
            <script src='assets/js/particles.min.js'></script>
            <script src="assets/js/script.js"></script>
            <script src="assets/js/jquery.min.js"></script>
            <!-- //particles -->

            <!-- owl carousel -->
            <script src="assets/js/owl.carousel.js"></script>
            <script>
                $(document).ready(function () {
                    var owl = $('.owl-carousel');
                    owl.owlCarousel({
                        margin: 10,
                        nav: true,
                        loop: false,
                        responsive: {
                            0: {
                                items: 1
                            },
                            767: {
                                items: 2
                            },
                            1000: {
                                items: 3
                            }
                        }
                    })
                })
            </script>
            <script type="text/javascript">

                function cpy_text(a) {
                    var copyText = a;

                    /* Select the text field */
                    copyText.select();
                    copyText.setSelectionRange(0, 99999); /*For mobile devices*/

                    /* Copy the text inside the text field */
                    document.execCommand("copy");

                    /* Alert the copied text */
                    alert("Copied the text: " + copyText.value);
                }

            </script>
            <!-- disable body scroll which navbar is in active -->
            <script>
                $(function () {
                    $('.navbar-toggler').click(function () {
                        $('body').toggleClass('noscroll');
                    })
                });
            </script>
            <!-- disable body scroll which navbar is in active -->

            <!-- bootstrap -->
            <script src="assets/js/bootstrap.min.js"></script>
            <script>
                var slideIndex = 1;
                showDivs(slideIndex);

                function plusDivs(n) {
                    showDivs(slideIndex += n);
                }

                function showDivs(n) {
                    var i;
                    var x = document.getElementsByClassName("mySlides");
                    if (n > x.length) {
                        slideIndex = 1
                    }
                    if (n < 1) {
                        slideIndex = x.length
                    }
                    for (i = 0; i < x.length; i++) {
                        x[i].style.display = "none";
                    }
                    x[slideIndex - 1].style.display = "block";
                }
            </script>
        </body>
    </html>
    <?php
}
?>