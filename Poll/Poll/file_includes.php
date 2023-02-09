<?php
error_reporting(1);
session_start();
ob_start();
define("ROOTFOLDER", 'Poll/');
include './classes/DBOperation.php';
include './classes/Details.php';
date_default_timezone_set("Asia/Kolkata");
function connect_db() {
     $dboperation = new DBOperation("localhost", "root", "", "poll");
   // $dboperation = new DBOperation("localhost", "u578272534_poll", "Poll@123", "u578272534_poll");
    return $dboperation;
}

function details() {
    $details = new Details();
    return $details;
}

function ret_json_str($sql) {
    $ret_val = json_encode(connect_db()->fetchData($sql));
    return $ret_val;
}
function curr_date_time() {
    $dt_timeSQL="SELECT NOW() CURR_DATE_TIME FROM DUAL";
    $date_time_val = json_encode(connect_db()->fetchData($dt_timeSQL));
    return $date_time_val;
}
function get_client_ip() {
$localIP = getHostByName(getHostName());
    return $localIP;
}
 function site_url() {

  $link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/".ROOTFOLDER;

  return $link;

}
ob_flush();
?>

