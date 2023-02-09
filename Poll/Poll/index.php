<?php
$page = "index.php";
include './file_includes.php';
$poll_quesSQL = "SELECT from_date, to_date FROM poll_question ";
$poll_fetch = json_decode(ret_json_str($poll_quesSQL));

foreach ($poll_fetch as $poll_val) {
    $from_date = $poll_val->from_date;
    $valid_upto = $poll_val->to_date ;

$updt_poll_statusSQL = "UPDATE poll_question SET status=0 WHERE to_date<=NOW()";
connect_db()->cud($updt_poll_statusSQL);
}
?>
<html lang="en">

    <?php include './header_files.php'; ?>

    <body>
        <?php include './menu.php'; ?>


        <!-- banner section -->
        <section id="home" class="banner">
            <div id="banner-bg-effect" class="banner-effect"></div>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-7 col-md-12 col-sm-12 order-lg-first mt-lg-0 mt-4">
                        <h2 class="mb-4 title" style="color: #FFFFFF;"><strong>Doing </strong>the right thing, <br>at the <strong>right time.</strong>
                        </h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Provident, excepturi.
                            Distinctio accusantium fugit odit? Fugit ipsam nostrum minus alias, expedita voluptatem
                            illo quis id eos quae odio, nobis deleniti delectus? Lorem ipsum dolor sit amet consectetur
                            adipisicing
                            elit.</p>
                        <div class="mt-5">

                            <a class="btn btn-outline btn-outline-style" href="create_poll.php">Create poll </a>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-12 col-sm-12 order-first text-lg-left text-center">
                        <div>
                            <img src="assets/images/banner-round.png" alt="" class="rounded-circle img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- //banner section -->

        <!-- home page about -->
        <section class="w3l-about" style="background-color: #f8f9fa;">
            <div class="container">
                <?php
                $poll_sql .= "SELECT a.id, a.title, a.created_by, a.description_type, a.from_date, a.to_date, b.name, b.prof_pic FROM poll_question a ";
                $poll_sql .= "LEFT JOIN user_details b ON a.created_by=b.username WHERE a.status=1 AND a.from_date<=NOW() ORDER BY a.from_date DESC";
                $poll_fetch = json_decode(ret_json_str($poll_sql));
                foreach ($poll_fetch as $poll_val) {
                    $id = $poll_val->id;
                    $title = $poll_val->title;
                    $description_type = $poll_val->description_type;
                    $from_date = $poll_val->from_date;
                    $valid_upto = $poll_val->to_date ;
                    $created_by = $poll_val->created_by;
                    $name = $poll_val->name;
                    $prof_pic = $poll_val->prof_pic;
                    if (empty($prof_pic)) {
                        $path = "assets/images/avatar.jpg";
                    } else {
                        $path = "assets/images/pro_pic/" . $prof_pic;
                    }
                    ?>
                    <div class="well" style="box-shadow: 1px 1px 1px 1px #ccc; padding: 10px; width: auto;margin-left: auto;background-color: #ffffff;">
                        <a href="single_poll.php?poll_id=<?php echo md5($id); ?>" class="title_poll">

                            <img src="<?php echo $path; ?>" class="img-thumbnail img-shadow img-fluid" width="40" height="40" alt="<?php echo $username; ?>" />
                            <b><?php echo $name; ?>(<?php echo $created_by; ?>@poll)</b><br/>
                            <?php echo $from_date . ' -- valid upto ' . $valid_upto; ?><br/><br/>
                            <span style="font-size: 18px; font-weight: 800;"><?php echo $title; ?></span> </a>
                        <br/><br/>
                        <div style="font-size: 14px;">
                            <?php
                            if ($description_type == "image") {
                                ?><center>
                                        <?php
                                        $poll_desc_sql = "SELECT id, description FROM poll_description WHERE poll_id='$id'";
                                        $poll_desc_fetch = json_decode(ret_json_str($poll_desc_sql));
                                        foreach ($poll_desc_fetch as $poll_desc_val) {
                                            $desc_id = $poll_desc_val->id;
                                            $description = $poll_desc_val->description;
                                            ?>
                                            <img class="img-thumbnail img-responsive" src="<?php echo $description; ?>" style="width: 60%;" />
                                      <br/>  <?php }
                                        ?>

                                       </center>
                                <?php
                            } else {
                                $poll_desc_sql = "SELECT id, description FROM poll_description WHERE poll_id='$id'";
                                $poll_desc_fetch = json_decode(ret_json_str($poll_desc_sql));
                                foreach ($poll_desc_fetch as $poll_desc_val) {
                                    $desc_id = $poll_desc_val->id;
                                    $description = $poll_desc_val->description;
                                }
                                echo $description;
                            }
                            ?><br/><br/>
                            <a href="single_poll.php?poll_id=<?php echo md5($id); ?>" class="title_poll">
                                <button class="btn btn-primary"> VOTE</button></a>
                        </div>
                    </div><br />
                    <?php
                }
                ?>
            </div>
        </section>

        <!-- testimonials section -->
        <section id="trending_poll" class="testimonials">
            <div class="container" id="trending_polls">
                <div class="row align-items-center">
                    <div class="col-lg-8 offset-lg-2 col-md-12 col-sm-12">
                        <h4 class="section-title">Trending polls</h4>

                    </div>
                </div>
                <div class="large-12 columns mt-5">
                    <div class="owl-carousel owl-theme">
                        <?php
                        $tren_poll_sql .= "SELECT s.poll_id, s.title, s.tot_vote FROM (SELECT a.poll_id, b.title,";
                        $tren_poll_sql .= "SUM(a.poll_vote) AS tot_vote FROM poll_answers a INNER JOIN poll_question b ON ";
                        $tren_poll_sql .= "a.poll_id=b.id WHERE b.status=1 AND b.from_date<=NOW() GROUP BY a.poll_id, b.title)s ";
                        $tren_poll_sql .= "ORDER BY s.tot_vote DESC LIMIT 30";
                        $tren_poll_fetch = json_decode(ret_json_str($tren_poll_sql));
                        foreach ($tren_poll_fetch as $tren_poll_val) {
                            $tren_poll_id = $tren_poll_val->poll_id;
                            $title_tren = $tren_poll_val->title;
                            $tot_vote_tren = $tren_poll_val->tot_vote;
                            ?>
                            <div class="item">
                                <div class="w3l-customers-7">
                                    <div class="customers_sur">
                                        <div class="customers-left_sur">
                                            <div class="customers_grid">
                                                <div class="custo-img-res">
                                                    <img src="assets/images/testi2.jpg" alt=" " class="img-fluid">
                                                </div>

                                                <p><?php echo $title_tren; ?></p>
                                                <div class="customers-bottom_sur">
                                                    <div class="custo_grid">
                                                        <h5>Total vote : <?php echo $tot_vote_tren; ?></h5><br/>
                                                        <span><a href="single_poll.php?poll_id=<?php echo md5($tren_poll_id); ?>" class="title_poll">
                                                                <button class="btn btn-primary"> VOTE</button></a></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>
        <!--//testimonials section -->




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

    </body>
</html>
