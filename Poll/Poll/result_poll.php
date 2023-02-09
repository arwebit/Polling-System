<?php
include './file_includes.php';
if ($_GET['poll_id']) {
    $poll_id = $_GET['poll_id'];
    $poll_tot_voteSQL = "SELECT sum(poll_vote) AS total_vote FROM poll_answers WHERE MD5(poll_id)='$poll_id'";
    $poll_votefetch = json_decode(ret_json_str($poll_tot_voteSQL));
    foreach ($poll_votefetch as $poll_vote_val) {
      $total_vote=$poll_vote_val->total_vote;
    }
    $poll_ans_countSQL = "SELECT a.poll_ans_text, a.poll_vote FROM poll_answers a WHERE MD5(a.poll_id)='$poll_id'";
    $poll_countfetch = json_decode(ret_json_str($poll_ans_countSQL));
    foreach ($poll_countfetch as $poll_count_val) {
        $per=0;
        $ans = $poll_count_val->poll_ans_text;
        $votecount = $poll_count_val->poll_vote;
        $per=round(($votecount/$total_vote)*100);
        ?>
<?php echo $ans; ?>  (<?php echo $votecount; ?>)
 <div class="progress">
        <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $per; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $per; ?>%;">
           <?php echo $per; ?> %
        </div>
    
    </div><br/>
        
        <?php
    }
    ?>
   
    
    </div>
    <?php
}
?>