<?php
$page="signup_sign_in.php";
include './file_includes.php';
?>
<html lang="en">
 <?php include './header_files.php'; ?>

    <body>
     <?php include './menu.php';?>

        <!-- contact page breadcrumns -->
        <section class="inner-banner">

        </section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-padding">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Sign up - Sign in</li>
            </ol>
        </nav>
        <!-- contact page breadcrumns -->

        <!-- contact section -->
        <section class="w3l-contact3">
            <div class="contact1-bg section-gap">
                <div class="container">
                    <div class="col-lg-8 offset-lg-2 col-md-12 col-sm-12 px-lg-3 px-0">
                        <h4 class="section-title">Sign up and Sign in</h4>

                    </div>
                    <div class="row contact-main mt-5">
                        <div class="col-md-6 " style="border: 1px solid black">
                            <div class="column">
                                <h3 class="header">Not have an account ? Sign up here</h3>
                                <p class="alert alert-dismissible alert-success" style="display: none;" id="success_msg">
                                    You have successfully registered</p>
                            </div>
                            <div class="column2">
                                <form action="" method="post" id="sign_up_form">
                                    <div class="form-group">
                                        <label for="name">NAME : </label><span style="color: red;"> *</span>
                                        <input type="text" name="guest_name" id="guest_name" class="form-control" required="required" />
                                    </div>
                                    <div class="form-group">
                                        <label for="email">EMAIL : </label><span style="color: red;"> *</span>
                                        <input type="email" name="guest_email" id="guest_email" class="form-control" required="required"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile">MOBILE : </label>
                                        <input type="tel" name="guest_mobile" id="guest_mobile" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label for="pass">PASSWORD : </label> <span style="color: red;"> *</span>
                                        <input type="password" name="guest_pass" id="guest_pass" class="form-control" required="required"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="confirm_pass">CONFIRM PASSWORD : </label> <span style="color: red;"> *</span>
                                        <input type="password" name="guest_cpass" id="guest_cpass" class="form-control" required="required"/>
                                    </div><br />
                                    <div class="form-group">
                                        <button type="button" name="sign_up_btn" id="sign_up_btn" class="btn btn-primary" >
                                            SIGN UP
                                        </button>
                                    </div>
                                </form>
                            </div>

                        </div>
                        <div class="col-md-6 " style="border: 1px solid black">
                            <div class="column">
                                <h3 class="header">Already have an account ? Sign in here</h3>
                           
                            </div>
                            <div class="column2">
                                <form action="" method="post" id="sign_in_form">
                                    <div class="form-group">
                                        <label for="email">EMAIL / MOBILE : </label><span style="color: red;"> *</span>
                                        <input type="text" name="guest_login_cred" id="guest_login_cred" class="form-control" required="required"/>
                                        
                                    </div><br />
                                    <div class="form-group">
                                        <label for="pass">PASSWORD : </label><span style="color: red;"> *</span>
                                        <input type="password" name="guest_login_pass" id="guest_login_pass" class="form-control" required="required"/>
                                    </div><br />
                                    <div class="form-group">
                                        <button type="button" name="sign_in_btn" id="sign_in_btn" class="btn btn-primary" >
                                            SIGN IN
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
                $('#sign_up_btn').on('click', function () {
                    var guest_name = $('#guest_name').val();
                    var guest_email = $('#guest_email').val();
                    var guest_mobile = $('#guest_mobile').val();
                    var guest_pass = $('#guest_pass').val();
                    var guest_cpass = $('#guest_cpass').val();
                    var togg_val = "1";
                    var reg_exp_email = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                    if ((guest_name === "") || (guest_email === "") || (guest_pass === "") || (guest_cpass === "")) {
                        alert("Provide all the fields");
                    } else if (reg_exp_email.test(guest_email) === false) {
                        alert("Invalid email");
                    }else if (guest_pass !== guest_cpass) {
                        alert("Password does not match");
                    } else {
                        if (guest_mobile === "") {
                            guest_mobile = "0";
                        }
                        $.ajax({
                            type: "POST",
                            url: "getAPI.php?apiCall=sign_in_up",
                            dataType: "json",
                            data: {
                                guest_name: guest_name,
                                guest_email: guest_email,
                                guest_mobile: guest_mobile,
                                guest_pass: guest_pass,
                                togg_val: togg_val
                            },
                            success: function (RetVal) {
                                if (RetVal.statusCode === "1") {
                                    $('#guest_name').val("");
                                    $('#guest_email').val("");
                                    $('#guest_mobile').val("");
                                    $('#guest_pass').val("");
                                    $('#guest_cpass').val("");
                                    $('#success_msg').css("display", "block");
                                } else {
                                    alert("Error");
                                }

                            }
                        });
                    }
                });


                $('#sign_in_btn').on('click', function () {
                    var guest_login_cred = $('#guest_login_cred').val();
                    var guest_login_pass = $('#guest_login_pass').val();
                    var togg_val = "2";
                    $.ajax({
                        type: "POST",
                        url: "getAPI.php?apiCall=sign_in_up",
                        dataType: "json",
                        data: {
                            guest_login_cred: guest_login_cred,
                            guest_login_pass: guest_login_pass,
                            togg_val: togg_val
                        },
                        success: function (RetVal) {
                            if (RetVal.statusCode === "1") {
                                window.location.href = "profile.php";
                            } else {
                                alert("Error");
                            }

                        }
                    });
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