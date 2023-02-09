<?php
$page = "create_poll.php";
include './file_includes.php';
if ($_SESSION['poll_user']) {
    $userlogin = $_SESSION['poll_user'];
    $login_detailsSQL .= "SELECT b.username, b.name, b.prof_pic, CASE WHEN a.mobile=0 THEN '' ELSE a.mobile END mobile, b.dob, a.email_id ";
    $login_detailsSQL .= "FROM login_access a INNER JOIN user_details b ON a.email_id=b.email_id WHERE a.email_id='$userlogin' OR a.mobile='$userlogin'";
    $login_det = json_decode(ret_json_str($login_detailsSQL));
    foreach ($login_det as $login_val) {
        $username = $login_val->username;
    }
} else {
    // $username ="guest";
    $username = get_client_ip();
}
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
                <li class="breadcrumb-item active" aria-current="page">Create Poll</li>
            </ol>
        </nav>
        <!-- contact page breadcrumns -->

        <!-- contact section -->
        <section class="w3l-contact3">
            <div class="contact1-bg section-gap">
                <div class="container">
                    <center><h3 class="header">Create Poll</h3></center><br/><br/>
                    <form action="getAPI.php?apiCall=CreatePoll" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="username" id="username" class="form-control" value="<?php echo $username; ?>"/>
                        <div class="row">
                            <div class="col-lg-4">
                                <input type="hidden" name="desc_type" id="desc_type" class="form-control" required="required" value="image"/>
                                <!--
                                <div class="form-group">
                                    <label for="desc_type">POLL TYPE *</label>
                                    <select name="desc_type" id="desc_type" class="form-control" required="required">
                                        <option value="">SELECT POLL TYPE</option>
                                        <option value="image" selected="selected">Image</option>
                                         <option value="text">Text</option>
                                    </select>
                                </div>-->

                                <div class="form-group">
                                    <label for="title">QUESTION *</label>
                                    <input type="text" name="title" id="title" class="form-control" required="required"/>
                                </div>
                                 <div class="form-group" id="description_img">
                                    <label for="img_type">IMAGE TYPE</label>
                                    <select name="img_type" id="img_type" class="form-control">
                                        <option value="single_image" selected="selected">Single image</option>
                                        <option value="multi_image" >Multi image</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="sing_mul">SINGLE / MULTI POLL *</label>
                                    <select name="sing_mul" id="sing_mul" class="form-control" required="required">
                                        <option value="">SELECT SINGLE / MULTI POLL</option>
                                        <option value="Single" selected="selected">Single</option>
                                        <option value="Multi">Multi</option>
                                    </select>
                                </div>
                                <!--
                                <div class="form-group" id="description_text" style="display: none;">
                                    <label for="description">DESCRIPTION</label>
                                    <textarea name="description" id="description" class="form-control" >
                                            
                                    </textarea>
                                </div>-->
                               

                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="category">CATEGORY *</label>
                                    <select name="category" id="category" class="form-control" required="required">
                                        <option value="">SELECT CATEGORY</option>
                                        <?php
                                        $cat_sql = "SELECT id, category_name FROM mas_category ORDER BY id";
                                        $cat_list = json_decode(ret_json_str($cat_sql));
                                        foreach ($cat_list as $cat_val) {
                                            $id = $cat_val->id;
                                            $category_name = $cat_val->category_name;
                                            ?>     
                                            <option value="<?php echo $id; ?>"><?php echo $category_name; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                            </div>

                        </div><br />
                        <center><h3>ANSWERS</h3></center> <br /> 
                        <div class="row">
                            <div class="col-lg-12">
                                <div id="more_text" style="display: none;">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="ans_text">ANSWER 1</label>
                                                <input type="text" name="answer_text[]" id="answer_text" class="form-control" />
                                            </div>
                                            <div class="form-group">
                                                <label for="ans_text">ANSWER 2</label>
                                                <input type="text" name="answer_text[]" id="answer_text" class="form-control" />
                                            </div>
                                            <div class="form-group">
                                                <label for="ans_text">ANSWER 3</label>
                                                <input type="text" name="answer_text[]" id="answer_text" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="ans_text">ANSWER 4</label>
                                                <input type="text" name="answer_text[]" id="answer_text" class="form-control" />
                                            </div>
                                            <div class="form-group">
                                                <label for="ans_text">ANSWER 5</label>
                                                <input type="text" name="answer_text[]" id="answer_text" class="form-control" />
                                            </div>
                                            <div class="form-group">
                                                <label for="ans_text">ANSWER 6</label>
                                                <input type="text" name="answer_text[]" id="answer_text" class="form-control" />
                                            </div>
                                        </div>  
                                    </div>
                                </div>


                                <div id="more_img" style="display: block;">
                                    <div id="single_img_ans">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="choose_file">CHOOSE IMAGE </label>
                                                    <input type="file" id="desc_img" name="desc_img[]" class="form-control-file" />
                                                </div></div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="ans">ANSWER 1</label>
                                                    <input type="text" name="answer[]" id="answer" class="form-control" />
                                                </div>
                                                <div class="form-group">
                                                    <label for="ans">ANSWER 2</label>
                                                    <input type="text" name="answer[]" id="answer" class="form-control" />
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <br/>
                                    <div id="multi_img_ans" style="display: none;">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="image">CHOOSE IMAGE 1</label>
                                                    <input type="file" id="desc_img_multi" name="desc_img_multi[]" class="form-control-file" />
                                                </div>
                                                <div class="form-group">
                                                    <label for="anstext">ANSWER 1</label>
                                                    <input type="text" name="answer_multi[]" id="answer_multi" class="form-control" />
                                                </div>
                                                <div class="form-group">
                                                    <label for="image">CHOOSE IMAGE 2</label>
                                                    <input type="file" id="desc_img_multi" name="desc_img_multi[]" class="form-control-file" />
                                                </div>
                                                <div class="form-group">
                                                    <label for="anstext">ANSWER 2</label>
                                                    <input type="text" name="answer_multi[]" id="answer_multi" class="form-control" />
                                                </div>
                                                <div class="form-group">
                                                    <label for="image">CHOOSE IMAGE 3</label>
                                                    <input type="file" id="desc_img_multi" name="desc_img_multi[]" class="form-control-file" />
                                                </div>
                                                <div class="form-group">
                                                    <label for="anstext">ANSWER 3</label>
                                                    <input type="text" name="answer_multi[]" id="answer_multi" class="form-control" />
                                                </div>

                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="image">CHOOSE IMAGE 4</label>
                                                    <input type="file" id="desc_img_multi" name="desc_img_multi[]" class="form-control-file" />
                                                </div>
                                                <div class="form-group">
                                                    <label for="anstext">ANSWER 4</label>
                                                    <input type="text" name="answer_multi[]" id="answer_multi" class="form-control" />
                                                </div>

                                                <div class="form-group">
                                                    <label for="image">CHOOSE IMAGE 5</label>
                                                    <input type="file" id="desc_img_multi" name="desc_img_multi[]" class="form-control-file" />
                                                </div>
                                                <div class="form-group">
                                                    <label for="anstext">ANSWER 5</label>
                                                    <input type="text" name="answer_multi[]" id="answer_multi" class="form-control" />
                                                </div>
                                                <div class="form-group">
                                                    <label for="image">CHOOSE IMAGE 6</label>
                                                    <input type="file" id="desc_img_multi" name="desc_img_multi[]" class="form-control-file" />
                                                </div>
                                                <div class="form-group">
                                                    <label for="anstext">ANSWER 6</label>
                                                    <input type="text" name="answer_multi[]" id="answer_multi" class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>         
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="valid_upto">VALID UPTO *</label>
                                            <select name="valid_upto" id="valid_upto" class="form-control" required="required">
                                                <option value="">SELECT VALID UPTO</option>
                                                <?php
                                                $time_sql = "SELECT id, time_val, hr_min_sec as time_med FROM mas_time ORDER BY id";
                                                $time_list = json_decode(ret_json_str($time_sql));
                                                foreach ($time_list as $time_value) {
                                                    $id = $time_value->id;
                                                    $time_val = $time_value->time_val;
                                                    $time_med_val = $time_value->time_med;
                                                    ?>     
                                                    <option value="<?php echo $time_val . ' ' . $time_med_val; ?>"><?php echo $time_val . ' ' . $time_med_val; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" id="create_poll" name="create_poll" class="btn btn-primary">
                                                CREATE POLL
                                            </button> </div>  
                                    </div>
                                </div>



                            </div>
                    </form>
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
            $(document).ready(function () {
                count = 1;
                $("#btn_more").on("click", function () {
                    count = count + 1;
                    window.value = count;
                    //alert(window.value);
                    $("<div>").load("get_more_fields.php?count=" + count, function () {
                        $("#more").append($(this).html());
                    });
                });


                $("#desc_type").change(function () {
                    var des_type = $(this).val();
                    //alert(des_type);
                    if (des_type === "image") {
                        $("#description_img").css("display", "block");
                        $("#description_text").css("display", "none");
                        $("#more_img").css("display", "block");
                        $("#more_text").css("display", "none");
                        $("#single_img_ans").css("display", "none");
                    } else {
                        $("#description_text").css("display", "block");
                        $("#description_img").css("display", "none");
                        $("#more_text").css("display", "block");
                        $("#more_img").css("display", "none");
                    }
                });
                $("#img_type").change(function () {
                    var img_type = $(this).val();
                    //alert(des_type);
                    if (img_type === "single_image") {
                        $("#single_img_ans").css("display", "block");
                        $("#multi_img_ans").css("display", "none");
                    } else {
                        $("#single_img_ans").css("display", "none");
                        $("#multi_img_ans").css("display", "block");
                    }
                });
            });
            function remove(id) {

                $("#" + id).remove();
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
