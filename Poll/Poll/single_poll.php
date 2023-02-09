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
    //$poll_res_link = site_url() . "poll_result.php?poll_id=" . $poll_id;
    $poll_res_link = site_url() . "result_poll.php?poll_id=" . $poll_id;
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
                    <li class="breadcrumb-item active" aria-current="page">Single Poll</li>
                </ol>
            </nav>
            <!-- contact page breadcrumns -->

            <!-- contact section -->
            <section class="w3l-contact3" style="background-color: #ececec;">
                <div class="contact1-bg section-gap">
                    <div class="container">

                        <center>
                            <div class="card" style="width: auto; min-height: 350px;">
                                <div class="card-body">
                                    <form action="" method="post">
                                        <?php
                                        $poll_quesSQL .= "SELECT a.id, a.title, a.created_by, a.from_date, a.single_multi, a.description_type, a.to_date FROM ";
                                        $poll_quesSQL .= "poll_question a WHERE MD5(a.id)='$poll_id'";
                                        $poll_fetch = json_decode(ret_json_str($poll_quesSQL));

                                        foreach ($poll_fetch as $poll_val) {
                                            $pol_id = $poll_val->id;
                                            $created_by = $poll_val->created_by;
                                            $from_date = $poll_val->from_date;
                                            $to_date = $poll_val->to_date;
                                            $title = $poll_val->title;
                                            $description_type = $poll_val->description_type;
                                            $single_multi = $poll_val->single_multi;
                                        }
                                        $from_dt = strtotime($from_date);
                                        $to_dt = strtotime($to_date);
                                        $diff = abs($to_dt - $from_dt);
                                        $years = floor($diff / (365*60*60*24));
                                        $months = floor(($diff - $years * 365*60*60*24)/(30*60*60*24));
                                        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                                        $hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24) / (60*60));
                                        $minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60); 
                                        $seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minutes*60));
                                        ?>
                                        <input type="hidden" name="poll_ques_id" id="poll_ques_id" class="form-control" value="<?php echo $pol_id; ?>"/>

                                        <span style="font-family: sans-serif; font-size: 25px; font-weight: bold;">Question : <?php echo $title; ?></span><br/><br/>

                                        <span style="color: #FF0000; font-weight: bold; border: 1px solid black; padding: 5px;">Created on : <?php echo date("d / M / Y h:i:s a", strtotime($from_date)); ?></span><br/><br/>

                                        <span style="color: #FF0000; font-weight: bold; border: 1px solid black; padding:5px;">   Expired on : <?php echo date("d / M / Y h:i:s a", strtotime($to_date)); ?></span><br/><br/>

                                        <span style="color: #FF0000; font-weight: bold; border: 1px solid black; padding:5px;">   Left : <?php echo $months.' months '. $days. ' days '; ?> only</span>
                                        <?php
                                        if ($description_type == "image") {
                                            ?><br/><br/>

                                            <?php
                                            $poll_desc_sql = "SELECT id, description FROM poll_description WHERE MD5(poll_id)='$poll_id'";
                                            $poll_desc_fetch = json_decode(ret_json_str($poll_desc_sql));
                                            foreach ($poll_desc_fetch as $poll_desc_val) {
                                                $desc_id = $poll_desc_val->id;
                                                $description = $poll_desc_val->description;
                                                ?>
                                                <img src="<?php echo $description; ?>" class="img-thumbnail img-responsive" style="width: 60%;"><br/>
                                            <?php }
                                            ?>


                                            <?php
                                        } else {
                                            ?>
                                            <div style="text-align: left;">

                                                <?php
                                                echo "";
                                                $poll_desc_sql = "SELECT id, description FROM poll_description WHERE MD5(poll_id)='$poll_id'";
                                                $poll_desc_fetch = json_decode(ret_json_str($poll_desc_sql));
                                                foreach ($poll_desc_fetch as $poll_desc_val) {
                                                    $desc_id = $poll_desc_val->id;
                                                    $description = $poll_desc_val->description;
                                                }
                                                echo $description;
                                                ?>
                                            </div>
                                            <?php
                                        }
                                        ?>  <br/><br/>
                                        <p id="success_msg" class="alert alert-dismissible alert-success" style="display: none;">
                                            Succeesfully voted
                                        </p>
                                        <input type="hidden" name="single_multi" id="single_multi" class="form-control" value="<?php echo $single_multi; ?>"/>
                                        <input type="hidden" name="username" id="username" class="form-control" value="<?php echo $username; ?>"/>
                                        <center>


                                            <div style="margin-top: 20px;">    
                                                <b style="font-family: Nunito, sans-serif; color: #4A4A4A">
                                                    Choose one answer :
                                                </b><br/><br/>
                                                <?php
                                                $j = 0;
                                                $poll_optionSQL = "SELECT id, poll_ans_text FROM poll_answers WHERE MD5(poll_id)='$poll_id'";
                                                $poll_optionfetch = json_decode(ret_json_str($poll_optionSQL));
                                                foreach ($poll_optionfetch as $poll_optionval) {
                                                    $j++;
                                                    $option_id = $poll_optionval->id;
                                                    $poll_ans = $poll_optionval->poll_ans_text;
                                                    ?>
                                                    <button type="button" class="btn btn-primary" style="min-width: 300px; margin-bottom: 10px;" name="answer" id="ans_opt<?php echo $j; ?>" value="<?php echo $option_id; ?>" onclick="submit_vote('ans_opt<?php echo $j; ?>')">
                                                        <?php echo $poll_ans; ?>
                                                    </button>
                                                    <br/>
                                                    <?php
                                                }
                                                ?></div><br/>
                                            <div id="results" style="display: none;">

                                            </div>
                                        </center><br/>

                                        <div class="row">
                                            <div class="col-lg-4 col-4">
                                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">
                                                    REPORT
                                                </button>     
                                            </div><!--
                                            <div class="col-lg-3 col-3">
                                                <button type="button" id="vote" name="vote" class="btn btn-success" onclick="submit_vote();">
                                                    VOTE
                                                </button>

                                            </div>-->
                                            <div class="col-lg-4 col-4">
                                                <button type="button" id="view_results" name="view_results" class="btn btn-warning" >
                                                    VIEW RESULTS
                                                </button>

                                            </div>
                                            <div class="col-lg-4 col-4">
                                                <a href="#share" >
                                                    <button type="button" id="share" name="share" class="btn btn-info">
                                                        SHARE
                                                    </button>
                                                </a>
                                            </div>
                                        </div>    <br />

                                    </form>



                                </div>
                            </div> 


                            <!-- SHARE THIS POLL-->
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
                            <!-- SHARE THIS POLL-->
                        </center>

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
            <script>
                $(document).ready(function () {
                    $('#report').on('click', function () {
                        $('#report_id').css("display", "block");
                    });
                    setInterval(function () {
                        $("#results").load("<?php echo $poll_res_link; ?>");
                    }, 1000);

                    $('#view_results').on('click', function () {
                        $('#results').css("display", "block");
                    });

                });
            </script>
            <script type="text/javascript">

                function submit_vote(id) {
                    var username = $('#username').val();
                    var poll_ques_id = $('#poll_ques_id').val();
                    var single_multi = $('#single_multi').val();
                    var vote_check = $("#" + id).val();
                    if (vote_check === "") {
                        alert("Select any one");
                    } else {
                        $.ajax({
                            type: "POST",
                            url: "getAPI.php?apiCall=SubmitVote",
                            dataType: "json",
                            data: {
                                username: username,
                                poll_ques_id: poll_ques_id,
                                vote_check: vote_check,
                                single_multi: single_multi,
                                vote_submit: "vote_submit"
                            },
                            success: function (RetVal) {
                                if (RetVal.statusCode === "1") {
                                    $('#results').css("display", "block");
                                } else if (RetVal.statusCode === "-1") {
                                    alert("You have voted already");
                                } else {
                                    alert("Select any one");
                                }

                            }
                        });
                    }
                }
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
            <!-- Modal -->
            <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form action="getAPI.php?apiCall=Submit_report" method="post">
                                        <input type="hidden" name="poll_rep_id" id="poll_rep_id" class="form-control" value="<?php echo $pol_id; ?>"/>
                                        <div class="form-group">
                                            <label for="reports">REPORT</label>
                                            <textarea class="form-control" name="rep" required="required"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary" name="submit_report" id="submit_report">
                                                SUBMIT REPORT
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->
        </body>
    </html>
    <?php
}
?>