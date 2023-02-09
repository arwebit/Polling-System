<?php
$page="create_poll.php";
include './file_includes.php';
if ($_SESSION['poll_user']) {
    $userlogin = $_SESSION['poll_user'];
    $login_detailsSQL .= "SELECT b.username, b.name, b.prof_pic, CASE WHEN a.mobile=0 THEN '' ELSE a.mobile END mobile, b.dob, a.email_id ";
    $login_detailsSQL .= "FROM login_access a INNER JOIN user_details b ON a.email_id=b.email_id WHERE a.email_id='$userlogin' OR a.mobile='$userlogin'";
    $login_det = json_decode(ret_json_str($login_detailsSQL));
    foreach ($login_det as $login_val) {
        $username = $login_val->username;
    }
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
                    <li class="breadcrumb-item active" aria-current="page">Create Poll</li>
                </ol>
            </nav>
            <!-- contact page breadcrumns -->

            <!-- contact section -->
            <section class="w3l-contact3">
                <div class="contact1-bg section-gap">
                    <div class="container">
                        <center><h3 class="header">Poll history</h3></center><br/><br/>
                        <p class="alert alert-dismissible alert-danger" id="inactive_msg" style="display: none;">
                            Successfully inactivated
                        </p>
                         <p class="alert alert-dismissible alert-success" id="active_msg" style="display: none;">
                            Successfully activated
                        </p>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>From date</th>
                                    <th>Valid upto</th>
                                     <th>Status</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody>
                                 <?php
                                 $i=0;
                                $poll_quesSQL .= "SELECT a.id, a.title, a.from_date, a.status, c.time_val, c.hr_min_sec FROM poll_question a ";
                                $poll_quesSQL .=" INNER JOIN mas_time c ON a.upto=c.id WHERE a.created_by='$username' ORDER BY a.from_date DESC";
                                $poll_fetch = json_decode(ret_json_str($poll_quesSQL));

                                foreach ($poll_fetch as $poll_val) {
                                    $i++;
                                    $poll_id=$poll_val->id;
                                    $title = $poll_val->title;
                                    $from_date = $poll_val->from_date;
                                    $upto= $poll_val->time_val.' '.$poll_val->hr_min_sec;
                                    $status=$poll_val->status;
                                ?>
                                <tr>
                                    <td><?php echo $poll_id; ?></td>
                                   <td><?php echo $title; ?></td>
                                    <td><?php echo $from_date; ?></td>
                                    <td><?php echo $upto; ?></td>
                                     <th><?php echo $status; ?></th>
                                    <td>
                                        <?php
                                        if($status==1){
                                            ?>
                                        <button type="button" id="poll_<?php echo $i; ?>" name="poll_inactive" class="btn btn-primary" value="<?php echo $poll_id; ?>" onclick="inactive_active('inactive','poll_<?php echo $i; ?>');">
                                            Inactive
                                        </button> 
                                        <?php
                                        }else{
                                          ?>
                                         <button type="button" id="poll_<?php echo $i; ?>" name="poll_active" class="btn btn-primary" value="<?php echo $poll_id; ?>" onclick="inactive_active('active','poll_<?php echo $i; ?>');">
                                           Active
                                        </button>
                                        <?php
                                        }
                                        ?>
                                       
                                        
                                         <a href="single_poll.php?poll_id=<?php echo md5($poll_id); ?>">
                                        <button type="button" id="poll_inactive" name="poll_view" class="btn btn-info">
                                            View
                                        </button></a>
                                    </td>
                                </tr>
                                 <?php
                                }
                                ?>
                            </tbody>
                        </table>

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
                    });
                });
                
                
            </script>
            
             <script>
                 
               function inactive_active(togg,id)  {
                   //var btn=$("#"+id);
                   var poll_id =$("#"+id).val();
                   if(togg==="inactive"){
                         $.ajax({
                        type: "POST",
                        url: "getAPI.php?apiCall=Poll_inactive",
                        dataType: "json",
                        data: {
                            poll_id: poll_id,
                            inactive:"inactive"
                        },
                        success: function (RetVal) {
                            if (RetVal.statusCode === "1") {
                             $('#inactive_msg').css("display", "block");
                            } else {
                                alert("Error");
                            }

                        }
                    }); 
                   }else{
                     $.ajax({
                        type: "POST",
                        url: "getAPI.php?apiCall=Poll_active",
                        dataType: "json",
                        data: {
                            poll_id: poll_id,
                            active:"active"
                        },
                        success: function (RetVal) {
                            if (RetVal.statusCode === "1") {
                             $('#active_msg').css("display", "block");
                            } else {
                                alert("Error");
                            }

                        }
                    });
                   }
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
    <?php
} else {
    header("location:signup_signin.php");
}
?>