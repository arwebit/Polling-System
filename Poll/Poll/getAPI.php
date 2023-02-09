<?php

include './file_includes.php';
if ($_GET['apiCall']) {
    $apiCall = $_GET['apiCall'];
    switch ($apiCall) {

        /*         * ************************************** SIGN IN AND SIGN UP STARTS ************************************** */
        case "sign_in_up":
            if (isset($_POST['togg_val'])) {
                $togg_val = trim($_POST['togg_val']);
                switch ($togg_val) {

                    /*                     * ************************************** SIGN UP STARTS ************************************** */
                    case 1:
                        $name = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['guest_name']));
                        $email = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['guest_email']));
                        $mobile = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['guest_mobile']));
                        $pass = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['guest_pass']));
                        $username_sql = "SELECT MAX(username) C FROM user_details";
                        $user_cnt = json_decode(ret_json_str($username_sql));
                        foreach ($user_cnt as $user_val) {
                            $u_count = $user_val->C;
                        }
                        if ($u_count == 0) {
                            $username = "11111";
                        } else {
                            $username = $u_count + 1;
                        }
                        $login_insertSQL = "INSERT INTO login_access VALUES(DEFAULT,'$email','$mobile','$pass',2)";
                        $user_detail_insertSQL = "INSERT INTO user_details VALUES(DEFAULT,'$email',$username,'$name','',null,1)";
                        $login_insertStatus = connect_db()->cud($login_insertSQL);
                        $user_detail_insertStatus = connect_db()->cud($user_detail_insertSQL);
                        if (($login_insertStatus == true) && ($user_detail_insertStatus == true)) {
                            // mkdir('user_folders/' . $username);
                            $retJSON['statusCode'] = "1";
                        } else {
                            $retJSON['statusCode'] = "0";
                        }
                        break;
                    /*                     * ************************************** SIGN UP ENDS ************************************** */

                    /*                     * ************************************** SIGN IN STARTS ************************************** */
                    case 2:
                        $guest_login_cred = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['guest_login_cred']));
                        $guest_login_pass = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['guest_login_pass']));
                        $login_SQL = "SELECT * FROM login_access WHERE password='$guest_login_pass' AND (email_id='$guest_login_cred' OR mobile='$guest_login_cred')";
                        $login_count = connect_db()->countEntries($login_SQL);
                        if ($login_count > 0) {
                            $_SESSION['poll_user'] = $guest_login_cred;
                            $retJSON['statusCode'] = "1";
                        } else {
                            $retJSON['statusCode'] = "0";
                        }
                        break;
                    /*                     * ************************************** SIGN IN ENDS ************************************** */

                    default:
                        $retJSON['statusCode'] = "0";
                        break;
                }
                echo json_encode($retJSON);
            }
            break;
        /*         * ************************************** SIGN IN AND SIGN UP ENDS ************************************** */


        /*         * ************************************** PROFILE UPDATE STARTS ************************************** */
        case "profile_update":
            if (isset($_POST['togg_val'])) {
                $togg_val = trim($_POST['togg_val']);
                switch ($togg_val) {
                    /*                     * ************************************** PROFILE UPDATE STARTS ************************************** */
                    case 1:
                        $name = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['guest_name']));
                        $pemail = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['guest_pemail']));
                        $email = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['guest_email']));
                        $mobile = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['guest_mobile']));
                        $guest_dob = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['guest_dob']));
                        if (empty($guest_dob)) {
                            $guest_dob = "null";
                        } else {
                            $guest_dob = date('Y-m-d', strtotime($guest_dob));
                            $guest_dob = "'$guest_dob'";
                        }
                        $login_updateSQL = "UPDATE login_access SET email_id='$email', mobile='$mobile' WHERE email_id='$pemail'";
                        $user_detail_updateSQL = "UPDATE user_details SET email_id='$email', name='$name', dob=$guest_dob WHERE email_id='$pemail'";
                        $login_updateStatus = connect_db()->cud($login_updateSQL);
                        $user_detail_updateStatus = connect_db()->cud($user_detail_updateSQL);
                        if (($user_detail_updateStatus == true) && ($login_updateStatus == true)) {
                            $retJSON['statusCode'] = "1";
                        } else {
                            $retJSON['statusCode'] = "0";
                        }

                        break;
                    /*                     * ************************************** PROFILE UPDATE ENDS ************************************** */

                    /*                     * ************************************** PROFILE PICTURE UPDATE STARTS ************************************** */
                    case 2:
                        $allowed = array('jpg', 'jpeg', 'JPEG', 'JPG', 'png', 'PNG');
                        $user_name = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['user_name']));
                        define("MAX_SIZE", 102400); // Size limit 100 KB ( Here size is converted to BYTES)
                        if ($_FILES['pro_pic_img']['name']) {
                            $path = "assets/images/pro_pic/";
                            $file_name = basename($_FILES['pro_pic_img']['name']);
                            $file_size = $_FILES['pro_pic_img']['size']; // File size in "BYTES"
                            $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                            if (!(in_array($ext, $allowed))) {
                                $fileErr = "Upload JPEG,JPG images";
                                header("location:profile.php");
                            } else {
                                if ($file_size > MAX_SIZE) {
                                    $fileErr = "Upload less than or equal to 100 kb / file";
                                } else {
                                    $img_name = $user_name . '.' . $ext;
                                    $file_path = $path . $file_name;
                                    if (move_uploaded_file($_FILES['pro_pic_img']['tmp_name'], $path . $img_name)) {
                                        unlink($file_desc);
                                    } else {
                                        unlink($path . $img_name . "." . $ext);
                                        $fileErr = "File cannot be inserted into folder";
                                    }
                                }
                            }
                        } else {
                            $file_path = $file_desc;
                        }

                        if ($fileErr == '') {
                            $user_detail_updateSQL = "UPDATE user_details SET prof_pic='$img_name' WHERE username='$user_name'";
                            $user_detail_updateStatus = connect_db()->cud($user_detail_updateSQL);
                            if ($user_detail_updateStatus == true) {
                                $retJSON['statusCode'] = "1";
                                header("location:profile.php");
                            } else {
                                $retJSON['statusCode'] = "0";
                                header("location:profile.php");
                            }
                        }

                        break;
                    /*                     * ************************************** PROFILE PICTURE UPDATE ENDS ************************************** */

                    /*                     * ************************************** PASSWORD CHANGE STARTS ************************************** */
                    case 3:
                        $change_npass = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['change_npass']));
                        $email = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['pass_email']));

                        $login_updateSQL = "UPDATE login_access SET password='$change_npass' WHERE email_id='$email'";
                        $login_updateStatus = connect_db()->cud($login_updateSQL);
                        if ($login_updateStatus == true) {
                            $retJSON['statusCode'] = "1";
                        } else {
                            $retJSON['statusCode'] = "0";
                        }

                        break;
                    /*                     * ************************************** PASSWORD CHANGE ENDS ************************************** */

                    default:
                        break;
                }
                echo json_encode($retJSON);
            }


            break;
        /*         * ************************************** PROFILE UPDATE ENDS ************************************** */


        /*         * ************************************** CREATE POLL STARTS ************************************** */
        case "CreatePoll":
            if (isset($_POST['create_poll'])) {
                $username = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['username']));
                $category = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['category']));
                $title = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['title']));
                $desc_type = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['desc_type']));
                $img_type = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['img_type']));
                // $from_date = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['from_date']));

                $from_date_fetch = json_decode(curr_date_time());
                foreach ($from_date_fetch as $from_date_val) {
                    $from_date = $from_date_val->CURR_DATE_TIME;
                }
                $valid_upto = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['valid_upto']));
                
                 $increment="+".$valid_upto;
                                        $form_fromdate = date("Y-M-d H:i:s", strtotime($from_date));
                                        $expired1 = strtotime($increment, strtotime($form_fromdate));
                                        $newdate1 = date('Y-M-d H:i:s', $expired1);
                                        $to_date = date("Y-m-d H:i:s", strtotime($newdate1));
                
                // $poll_type = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['poll_type']));
                $poll_type = "text";
                $sing_mul = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['sing_mul']));
                if ($desc_type == "text") {
                    $description = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['description']));
                    if (empty($description)) {
                        $descriptionErr = "";
                    }
                } else if ($desc_type == "image") {
                    if($img_type=="single_image"){
                        $count_files = count(array_filter($_FILES['desc_img']['name']));
                    }else{
                        $count_files = count(array_filter($_FILES['desc_img_multi']['name']));
                    }
                    
                    $allowed_pics = array('jpg', 'jpeg', 'JPEG', 'JPG', 'png', 'PNG');
                    define("MAX_SIZE", 1024000);
                    if ($count_files > 0) {
                        $path = "user_folders/questions/";
                        for ($i = 0; $i < $count_files; $i++) {
                            if($img_type=="single_image"){
                            $file_name[] = basename($_FILES['desc_img']['name'][$i]);
                             $file_size[] = basename($_FILES['desc_img']['size'][$i]);
                            }else{
                            $file_name[] = $_FILES['desc_img_multi']['name'][$i]; // File size in "BYTES"
                            $file_size[] = basename($_FILES['desc_img_multi']['size'][$i]);
                            }
                            $ext[] = strtolower(pathinfo($file_name[$i], PATHINFO_EXTENSION));
                        }
                        for ($p = 0; $p < $count_files; $p++) {
                            if (!(in_array($ext[$p], $allowed_pics))) {
                                $err = 1;
                            } else {
                                if ($file_size[$p] > MAX_SIZE) {
                                    $err = 2;
                                } else {
                                    $err = 0;
                                }
                            }
                        }
                        if ($err == 1) {
                            $descriptionErr = "Upload JPEG,JPG images";
                        }
                        if ($err == 2) {
                            $descriptionErr = "Upload less than or equal to 100 kb / file";
                        }
                        if ($err == 0) {
                            for ($j = 0; $j < $count_files; $j++) {
                                $file_path[] = $path . md5($file_name[$j]) . '.' . $ext[$j];
                                if($img_type=="single_image"){
                                  if (move_uploaded_file($_FILES['desc_img']['tmp_name'][$j], $path . md5($file_name[$j]) . '.' . $ext[$j])) {
                                    $file_move = 1;
                                } else {
                                    $file_move = 0;
                                    unlink($path . $file_name[$j] . "." . $ext[$j]);
                                    $fileErr = "File cannot be inserted into folder";
                                }  
                                }else{
                                   if (move_uploaded_file($_FILES['desc_img_multi']['tmp_name'][$j], $path . md5($file_name[$j]) . '.' . $ext[$j])) {
                                    $file_move = 1;
                                } else {
                                    $file_move = 0;
                                    unlink($path . $file_name[$j] . "." . $ext[$j]);
                                    $fileErr = "File cannot be inserted into folder";
                                }
                                }
                                
                                
                                
                                
                            }
                        }
                    } else {
                        $descriptionErr = "Required";
                    }
                } else {
                    $descriptionErr = "";
                }

                if (empty($category)) {
                    $categoryErr = "Required";
                }
                if (empty($title)) {
                    $titleErr = "Required";
                }
                if (empty($desc_type)) {
                    $desc_typeErr = "";
                }
                if (empty($valid_upto)) {
                    $valid_uptoErr = "Required";
                }
                if (empty($poll_type)) {
                    $poll_typeErr = "Required";
                }
                if (empty($sing_mul)) {
                    $sing_mulErr = "Required";
                }
                if ((($categoryErr == "") && ($titleErr == "") && ($desc_typeErr == "") && ($from_dateErr == "") && ($valid_uptoErr == "") && ($descriptionErr == "") && ($poll_typeErr == "") && ($sing_mulErr == "")) || $file_move == 1) {
                    $poll_insertSQL = "INSERT INTO poll_question VALUES(DEFAULT,'$category','$poll_type','$title','$desc_type','$username','$from_date','$to_date',1,'$sing_mul')";
                    $poll_insertStatus = connect_db()->cud($poll_insertSQL);
                    if ($poll_insertStatus == true) {
                        $poll_id_sql = "SELECT id FROM poll_question ORDER BY id DESC LIMIT 1";
                        $poll_id_fetch = json_decode(ret_json_str($poll_id_sql));
                        foreach ($poll_id_fetch as $poll_id_val) {
                            $poll_id = $poll_id_val->id;
                        }
                        if ($desc_type == "text") {
                            $poll_desc_insertSQL = "INSERT INTO poll_description VALUES(DEFAULT,'$poll_id','$description')";
                            $poll_desc_insertStatus = connect_db()->cud($poll_desc_insertSQL);
                        } else if ($desc_type == "image") {
                            for ($k = 0; $k < $count_files; $k++) {
                                $poll_desc_insertSQL = "INSERT INTO poll_description VALUES(DEFAULT,'$poll_id','$file_path[$k]')";
                                $poll_desc_insertStatus = connect_db()->cud($poll_desc_insertSQL);
                            }
                        } else {
                            $poll_desc_insertStatus = false;
                        }

                        if (($poll_desc_insertStatus == true) || ($poll_desc_insertStatus == false)) {
                            if ($desc_type == "image") {
                                if($img_type=="single_image"){
                                     $count_ans = count(array_filter($_POST['answer']));
                                }else{
                                     $count_ans = count(array_filter($_POST['answer_multi']));
                                }
                               
                            } else {
                                $count_ans = count(array_filter($_POST['answer_text']));
                            }

                            for ($i = 0; $i < $count_ans; $i++) {
                                if ($desc_type == "image") {
                                     if($img_type=="single_image"){
                                     $poll_ans_insertSQL = "INSERT INTO poll_answers VALUES(DEFAULT,'$poll_id','','" . $_POST['answer'][$i] . "',0)";
                                }else{
                                     $poll_ans_insertSQL = "INSERT INTO poll_answers VALUES(DEFAULT,'$poll_id','','" . $_POST['answer_multi'][$i] . "',0)";
                                }
                                    
                                } else {
                                    $poll_ans_insertSQL = "INSERT INTO poll_answers VALUES(DEFAULT,'$poll_id','','" . $_POST['answer_text'][$i] . "',0)";
                                }
                                $poll_ans_insertStatus = connect_db()->cud($poll_ans_insertSQL);
                                if ($poll_ans_insertStatus == true) {
                                    header("location:single_poll.php?poll_id=" . md5($poll_id));
                                }
                            }
                        } else {
                            ?>
                            <script>alert('Provide fields');</script>
                            <?php

                            ///  header("location:create_poll.php");
                        }
                    } else {
                        ?>
                        <script>alert('Provide fields');</script>
                        <?php

                        //   header("location:create_poll.php");
                    }
                } else {
                    ?>
                    <script>alert('Provide fields');</script>
                    <?php

                    header("location:create_poll.php");
                }
            }
            break;
        /*         * ************************************** CREATE POLL ENDS ************************************** */

        /*         * ************************************** SUBMIT VOTE STARTS ************************************** */
        case "SubmitVote":
            if (isset($_POST['vote_submit'])) {
                $username = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['username']));
                $single_multi = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['single_multi']));
                $poll_ques_id = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['poll_ques_id']));
                $vote_check = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['vote_check']));
                if ($single_multi == "Single") {
                    $vote_userSQL = "SELECT * FROM poll_vote WHERE vote_by='$username' AND poll_id='$poll_ques_id'";
                    $count_vote_user = connect_db()->countEntries($vote_userSQL);
                    if ($count_vote_user > 0) {
                        $retJSON['statusCode'] = "-1";
                    } else {
                        $pol_voteSQL = "INSERT INTO poll_vote VALUES(DEFAULT,'$poll_ques_id','$vote_check','$username')";
                        $poll_answer_upSQL = "UPDATE poll_answers SET poll_vote=poll_vote+1 WHERE id='$vote_check'";
                        $pol_voteStatus = connect_db()->cud($pol_voteSQL);
                        $poll_answer_upStatus = connect_db()->cud($poll_answer_upSQL);
                        if (($pol_voteStatus == true) && ($poll_answer_upStatus == true)) {
                            $retJSON['statusCode'] = "1";
                        } else {
                            $retJSON['statusCode'] = "0";
                        }
                    }
                } else {
                    $pol_voteSQL = "INSERT INTO poll_vote VALUES(DEFAULT,'$poll_ques_id','$vote_check','$username')";
                    $poll_answer_upSQL = "UPDATE poll_answers SET poll_vote=poll_vote+1 WHERE id='$vote_check'";
                    $pol_voteStatus = connect_db()->cud($pol_voteSQL);
                    $poll_answer_upStatus = connect_db()->cud($poll_answer_upSQL);
                    if (($pol_voteStatus == true) && ($poll_answer_upStatus == true)) {
                        $retJSON['statusCode'] = "1";
                    } else {
                        $retJSON['statusCode'] = "0";
                    }
                }
                echo json_encode($retJSON);
            }
            break;
        /*         * ************************************** SUBMIT VOTE STARTS ************************************** */



        /*         * ************************************** POLL INACTIVE STARTS ************************************** */
        case "Poll_inactive":
            if (isset($_POST['inactive'])) {
                $poll_id = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['poll_id']));

                $poll_inactiveSQL = "UPDATE poll_question SET status=0 WHERE id='$poll_id'";
                $poll_inactiveStatus = connect_db()->cud($poll_inactiveSQL);
                if ($poll_inactiveStatus == true) {
                    $retJSON['statusCode'] = "1";
                } else {
                    $retJSON['statusCode'] = "0";
                }
                echo json_encode($retJSON);
            }
            break;
        /*         * ************************************** POLL INACTIVE STARTS ************************************** */

        /*         * ************************************** POLL ACTIVE STARTS ************************************** */
        case "Poll_active":
            if (isset($_POST['active'])) {
                $poll_id = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['poll_id']));

                $poll_activeSQL = "UPDATE poll_question SET status=1 WHERE id='$poll_id'";
                $poll_activeStatus = connect_db()->cud($poll_activeSQL);
                if ($poll_activeStatus == true) {
                    $retJSON['statusCode'] = "1";
                } else {
                    $retJSON['statusCode'] = "0";
                }
                echo json_encode($retJSON);
            }
            break;
        /*         * ************************************** POLL ACTIVE STARTS ************************************** */
        /*         * ************************************** SUBMIT REPORT STARTS ************************************** */
        case "Submit_report":
            if (isset($_POST['submit_report'])) {
                $poll_id = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['poll_rep_id']));
                $report = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['rep']));
                $reportInsertSQL = "INSERT INTO report_poll VALUES(DEFAULT,'$poll_id','Report','$report',NOW(),1)";
                $reportStatus = connect_db()->cud($reportInsertSQL);
                if ($reportStatus == true) {
                    header("location:single_poll.php?poll_id=" . md5($poll_id));
                } else {
                    header("location:single_poll.php?poll_id=" . md5($poll_id));
                }
            }
            break;
        /*         * ************************************** SUBMIT REPORT STARTS ************************************** */

        default:
            break;
    }
}
?>

