<?php
include './file_includes.php';
if ($_SESSION['poll_user']) {
    $userlogin = $_SESSION['poll_user'];
    $login_detailsSQL .= "SELECT b.username, b.name, b.prof_pic, CASE WHEN a.mobile=0 THEN '' ELSE a.mobile END mobile, b.dob, a.email_id ";
    $login_detailsSQL .= "FROM login_access a INNER JOIN user_details b ON a.email_id=b.email_id WHERE a.email_id='$userlogin' OR a.mobile='$userlogin'";
    $login_det = json_decode(ret_json_str($login_detailsSQL));
    foreach ($login_det as $login_val) {
        $username = $login_val->username;
        $name = $login_val->name;
        $dob = $login_val->dob;
        $mobile = $login_val->mobile;
        $email_id = $login_val->email_id;
        $prof_pic = $login_val->prof_pic;
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
                    <li class="breadcrumb-item active" aria-current="page">My Profile</li>
                </ol>
            </nav>
            <!-- contact page breadcrumns -->

            <!-- contact section -->
            <section class="w3l-contact3">
                <div class="contact1-bg section-gap">
                    <div class="container">
                        <div class="col-lg-8 offset-lg-2 col-md-12 col-sm-12 px-lg-3 px-0">
                            <h4 class="section-title"><?php echo $name; ?></h4>

                        </div>
                        <div class="row contact-main mt-5">
                            <div class="col-md-6 ">
                                <div class="column">
                                    <h3 class="header">Username : <?php echo $username; ?>
                                        <span  style="text-transform: lowercase;">@poll</span></h3>
                                    <p class="alert alert-dismissible alert-success" style="display: none;" id="success_msg">
                                        You have successfully updated</p>
                                </div>
                                <div class="column2">
                                    <form action="" method="post" id="sign_up_form">

                                        <div class="form-inline">
                                            <label for="name">NAME : </label>&nbsp;&nbsp;&nbsp;
                                            <input type="text" name="guest_name" id="guest_name" class="form-control" required="required" value="<?php echo $name; ?>" />
                                            <span style="color: red;"> *</span>
                                        </div><br />
                                        <div class="form-inline">
                                            <label for="email">EMAIL : </label>&nbsp;&nbsp;&nbsp;
                                            <input type="email" name="guest_email" id="guest_email" class="form-control" required="required" value="<?php echo $email_id; ?>"/>
                                            <input type="hidden" name="guest_pemail" id="guest_pemail" class="form-control" required="required" value="<?php echo $email_id; ?>"/>
                                            <span style="color: red;"> *</span>
                                        </div><br />
                                        <div class="form-inline">
                                            <label for="mobile">MOBILE : </label>&nbsp;&nbsp;&nbsp;
                                            <input type="tel" name="guest_mobile" id="guest_mobile" class="form-control" value="<?php echo $mobile; ?>"/>
                                        </div><br />
                                        <div class="form-inline">
                                            <label for="dob">DATE OF BIRTH : </label>&nbsp;&nbsp;&nbsp;
                                            <input type="date" name="guest_dob" placeholder="Format ( YYYY-MM-DD )" id="guest_dob" class="form-control" required="required" value="<?php echo $dob; ?>"/>
                                            <span style="color: red;"> </span>
                                        </div><br />

                                        <div class="form-inline">
                                            <button type="button" name="profile_update_btn" id="profile_update_btn" class="btn btn-primary" >
                                                SAVE
                                            </button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                            <div class="col-md-6 ">

                                <?php
                                if (empty($prof_pic)) {
                                    $path = "assets/images/avatar.jpg";
                                } else {
                                    $path = "assets/images/pro_pic/" . $prof_pic;
                                }
                                ?>
                                <div class="column2">
                                    <img src="<?php echo $path; ?>" class="img-thumbnail img-shadow img-fluid" alt="<?php echo $username; ?>" />
                                </div>
                                <form id="pro_pic_form" action="getAPI.php?apiCall=profile_update" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="user_name" value="<?php echo $username; ?>" />
                                    <input type="hidden" name="togg_val" value="2" />
                                    <div class="form-group">
                                        <input type="file" name="pro_pic_img" id="pro_pic_img" class="form-control" /> 
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary" name="pro_pic_save" id="pro_pic_save">
                                            UPLOAD
                                        </button>   
                                    </div>
                                </form>
                                <?php echo $fileErr; ?>
                            </div>
                        </div>
                        <div class="row contact-main mt-5">
                            <div class="col-lg-8 offset-lg-2 col-md-12 col-sm-12 px-lg-3 px-0">
                                <h4 class="section-title">Change Password</h4>
                                <p id="pass_succ_msg" class="alert alert-dismissible alert-success" style="display: none;">
                                    Password successfully changed
                                </p>
                                <br />

                                <form action="" method="post" id="pass_change_form">
                                    <input type="hidden" name="pass_email" id="pass_email" class="form-control" value="<?php echo $email_id; ?>"/>
                                    <div class="form-group" >
                                        <label for="npass">New Password </label>
                                        <input type="password" class="form-control" name="change_npass" id="change_npass" />
                                    </div>
                                    <div class="form-group" >
                                        <label for="pass">Confirm Password </label>
                                        <input type="password" class="form-control" name="change_cpass" id="change_cpass" />
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-primary" name="chnge_pass_btn" id="chnge_pass_btn">
                                            CHANGE PASSWORD
                                        </button>   
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>



             <!-- site footer -->
            <footer id="site-footer">
                
                <?php include 'footer.php';?>
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
                $('#profile_update_btn').on('click', function () {
                    var guest_name = $('#guest_name').val();
                    var guest_email = $('#guest_email').val();
                    var guest_pemail = $('#guest_pemail').val();
                    var guest_mobile = $('#guest_mobile').val();
                    var guest_dob = $('#guest_dob').val();
                    var togg_val = "1";
                    var reg_exp_email = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                    if ((guest_name === "") || (guest_email === "") ) {
                        alert("Provide all the fields");
                    } else if (reg_exp_email.test(guest_email) === false) {
                        alert("Invalid email");
                    } else {
                        if (guest_mobile === "") {
                            guest_mobile = "0";
                        }
                        $.ajax({
                            type: "POST",
                            url: "getAPI.php?apiCall=profile_update",
                            dataType: "json",
                            data: {
                                guest_name: guest_name,
                                guest_email: guest_email,
                                guest_pemail: guest_pemail,
                                guest_mobile: guest_mobile,
                                guest_dob: guest_dob,
                                togg_val: togg_val
                            },
                            success: function (RetVal) {
                                if (RetVal.statusCode === "1") {
                                    $('#success_msg').css("display", "block");
                                } else {
                                    alert("Error");
                                }

                            }
                        });
                    }
                });
                $('#chnge_pass_btn').on('click', function () {
                    var pass_email = $('#pass_email').val();
                    var change_npass = $('#change_npass').val();
                    var change_cpass = $('#change_cpass').val();
                    var togg_val = "3";
                    if ((change_npass === "") || (change_cpass === "")) {
                        alert('Provide new password and confirm password');
                    } else if (change_npass !== change_cpass) {
                        alert("Password not matched");
                    } else {
                        $.ajax({
                            type: "POST",
                            url: "getAPI.php?apiCall=profile_update",
                            dataType: "json",
                            data: {
                                pass_email: pass_email,
                                change_npass: change_npass,
                                togg_val: togg_val
                            },
                            success: function (RetVal) {
                                if (RetVal.statusCode === "1") {
                                    $('#pass_succ_msg').css("display", "block");
                                    $('#change_cpass').val("");
                                    $('#change_npass').val("");
                                } else {
                                    alert("Error");
                                }

                            }
                        });
                    }
                });
            });
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
    <?php
} else {
    header("location:signup_signin.php");
}
?>