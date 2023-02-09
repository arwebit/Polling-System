<?php

session_start();
unset($_SESSION['poll_login_admin']);
if (isset($_SERVER['HTTP_REFERER'])) {
    ?>
<script type="text/javascript">
window.location.href = "login.php";
</script>
<?php
    } else {
   ?>
<script type="text/javascript">
window.location.href = "login.php";
</script>
<?php
}
exit;
?>