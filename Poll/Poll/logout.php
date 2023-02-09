<?php

session_start();
unset($_SESSION['poll_user']);
if (isset($_SERVER['HTTP_REFERER'])) {
    ?>
<script type="text/javascript">
window.location.href = "index.php";
</script>
<?php
    } else {
   ?>
<script type="text/javascript">
window.location.href = "index.php";
</script>
<?php
}
exit;
?>