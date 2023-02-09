<?php

error_reporting(1);
session_start();
ob_start();
define("ROOTFOLDER", 'Poll/admin/');
include '../classes/DBOperation.php';

function connect_db() {
  $dboperation = new DBOperation("localhost", "root", "", "poll");
   // $dboperation = new DBOperation("localhost", "u578272534_poll", "Poll@123", "u578272534_poll");
    return $dboperation;
}

function ret_json_str($sql) {
    $ret_val = json_encode(connect_db()->fetchData($sql));
    return $ret_val;
}
 function site_url() {

  $link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/".ROOTFOLDER;

  return $link;

}
/* * ************************************* LOGIN STARTS ******************************************** */
if (isset($_POST['login_btn'])) {
    $user = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['email']));
    $pass = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['password']));
    if ((empty($user)) || (empty($pass))) {
        $login_error = "Provide all the fields";
    } else {
        $login_sql = "SELECT * FROM login_access WHERE email_id='$user' AND password='$pass' and role=1";
        $count = connect_db()->countEntries($login_sql);
        if ($count > 0) {
            $_SESSION['poll_login_admin'] = $user;
            ?>
            <script type="text/javascript">
                window.location.href = "home.php";
            </script>
            <?php

        } else {
            $login_error = "Wrong username and password";
        }
    }
}
$sql_fetch_role = "SELECT a.role FROM login_access a WHERE a.email_id='".$_SESSION['poll_login_admin']."' OR a.mobile='".$_SESSION['poll_login_admin']."'";
$fetch_role= json_decode(ret_json_str($sql_fetch_role));
foreach ($fetch_role as $role_val) {
    $user_role = $role_val->role;
}
/* * ************************************* LOGIN ENDS ******************************************** */

/* * ************************************* INSERT CATEGORY STARTS ******************************************** */
if (isset($_POST['cat_insert'])) {
    $cat_name = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['cat_name']));
    if (empty($cat_name)) {
        $categoryErr = "Required";
    }
    if ($categoryErr == "") {
        $insert_cat_sql = "INSERT INTO mas_category VALUES(DEFAULT,'$cat_name',1)";
        $insert_catStatus = connect_db()->cud($insert_cat_sql);
        if ($insert_catStatus == true) {
            $success = "Successfully inserted";
        } else {
            $err = "Data saving error";
        }
    } else {
        $err = "Recoorect errors";
    }
}
/* * ************************************* INSERT CATEGORY  ENDS ******************************************** */

/* * ************************************* EDIT CATEGORY STARTS ******************************************** */
if (isset($_POST['cat_edit'])) {
    $cat_id = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['cat_id']));
    $cat_name = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['cat_name']));
    if (empty($cat_name)) {
        $categoryErr = "Required";
    }
    if ($categoryErr == "") {
        $edit_cat_sql = "UPDATE mas_category SET category_name='$cat_name' WHERE id='$cat_id'";
        $edit_catStatus = connect_db()->cud($edit_cat_sql);
        if ($edit_catStatus == true) {
            $success = "Successfully updated";
        } else {
            $err = "Data saving error";
        }
    } else {
        $err = "Recoorect errors";
    }
}
/* * ************************************* EDIT CATEGORY  ENDS ******************************************** */
/* * ************************************* INSERT TIME STARTS ******************************************** */
if (isset($_POST['time_insert'])) {
    $time_name = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['time_name']));
    $time_value = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['time_value']));
    if (empty($time_name)) {
        $time_nameErr = "Required";
    }
    if (empty($time_value)) {
        $time_valErr = "Required";
    }
    if (($time_nameErr == "") && ($time_valErr == "")) {
        $insert_time_sql = "INSERT INTO mas_time VALUES(DEFAULT,'$time_name','$time_value')";
        $insert_timeStatus = connect_db()->cud($insert_time_sql);
        if ($insert_timeStatus == true) {
            $success = "Successfully inserted";
        } else {
            $err = "Data saving error";
        }
    } else {
        $err = "Recoorect errors";
    }
}
/* * ************************************* INSERT TIME  ENDS ******************************************** */

/* * ************************************* EDIT TIME STARTS ******************************************** */
if (isset($_POST['time_edit'])) {
    $time_id = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['time_id']));
    $time_name = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['time_name']));
    $time_value = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['time_value']));
    if (empty($time_name)) {
        $time_nameErr = "Required";
    }
    if (empty($time_value)) {
        $time_valErr = "Required";
    }
    if (($time_nameErr == "") && ($time_valErr == "")) {
        $edit_tme_sql = "UPDATE mas_time SET time_val='$time_name', hr_min_sec='$time_value' WHERE id='$time_id'";
        $edit_tmeStatus = connect_db()->cud($edit_tme_sql);
        if ($edit_tmeStatus == true) {
            $success = "Successfully updated";
        } else {
            $err = "Data saving error";
        }
    } else {
        $err = "Recoorect errors";
    }
}
/* * ************************************* EDIT TIME  ENDS ******************************************** */


/* * ************************************* INSERT USER STARTS ******************************************** */
if (isset($_POST['user_insert'])) {
    $name = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['uname']));
    $email = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['email_id']));
    $mobile = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['mobile']));
    $pass = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['pass']));
    $dob = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['dob']));
    $role = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['role']));
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
    if (empty($name)) {
        $nameErr = "Required";
    }
    if (empty($email)) {
        $email_idErr = "Required";
    }
    if (empty($mobile)) {
        $mobile = "0";
    }
    if (empty($pass)) {
        $passErr = "Required";
    }
    if (empty($dob)) {
        $dob = "null";
    } else {
        $dob = date('Y-m-d', strtotime($dob));
    }
    if (empty($role)) {
        $roleErr = "Required";
    }
    if (($nameErr == "") || ($emailErr == "") || ($passErr == "") || ($roleErr == "")) {
        $login_insertSQL = "INSERT INTO login_access VALUES(DEFAULT,'$email','$mobile','$pass','$role')";
        $user_detail_insertSQL = "INSERT INTO user_details VALUES(DEFAULT,'$email',$username,'$name','',null,1)";
        $login_insertStatus = connect_db()->cud($login_insertSQL);
        $user_detail_insertStatus = connect_db()->cud($user_detail_insertSQL);
        if (($login_insertStatus == true) && ($user_detail_insertStatus == true)) {
            $success = "Successfully inserted";
        } else {
            $err = "Data saving error";
        }
    } else {
        $error = "Recorrect all";
    }
}
/* * ************************************* INSERT USER  ENDS ******************************************** */

/* * ************************************* EDIT USER STARTS ******************************************** */
if (isset($_POST['user_edit'])) {
    $name = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['uname']));
    $pemail = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['pemail_id']));
    $email = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['email_id']));
    $mobile = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['mobile']));
    $dob = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['dob']));
    $role = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['role']));

    if (empty($name)) {
        $nameErr = "Required";
    }
    if (empty($email)) {
        $email_idErr = "Required";
    }
    if (empty($mobile)) {
        $mobile = "0";
    }
    if (empty($dob)) {
        $dob = "null";
    } else {
        $dob = date('Y-m-d', strtotime($dob));
        $dob = "'" . $dob . "'";
    }
    if (empty($role)) {
        $roleErr = "Required";
    }
    if (($nameErr == "") || ($emailErr == "") || ($roleErr == "")) {
        $login_updateSQL = "UPDATE login_access SET email_id='$email', mobile='$mobile', role='$role' WHERE email_id='$pemail'";
        $user_detail_updateSQL = "UPDATE user_details SET email_id='$email', name='$name', dob=$dob WHERE email_id='$pemail'";
        $login_updateStatus = connect_db()->cud($login_updateSQL);
        $user_detail_updateStatus = connect_db()->cud($user_detail_updateSQL);
        if (($login_updateStatus == true) && ($user_detail_updateStatus == true)) {
            $success = "Successfully updated";
        } else {
            $err = "Data saving error";
        }
    } else {
        $error = "Recorrect all";
    }
}
/* * ************************************* EDIT USER  ENDS ******************************************** */





ob_flush();


