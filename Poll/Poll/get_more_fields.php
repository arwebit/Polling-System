<?php
if($_GET['count']){
?>

<div id="more_input<?php echo $_GET['count'];?>">
   Answer <?php echo $_GET['count'];?>  :  <input type=text name=answer[] id="answer" class=form-control /> &nbsp;&nbsp;
   <button type="button" class="btn btn-danger" id="btn_remove<?php echo $_GET['count'];?>" onclick="remove('more_input<?php echo $_GET['count'];?>');">Remove</button>
</div>
<?php
}
?>

