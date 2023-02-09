<!-- site header -->
        <header id="site-header" class="fixed-top">
            <nav class="navbar navbar-expand-lg navbar-dark">
                <a class="navbar-brand" href="index.php">
                    <span class="fa fa-shield"></span> POLL
                </a>
                <button class="navbar-toggler bg-gradient" type="button" data-toggle="collapse"
                        data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                        aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav m-auto">
        <li class="nav-item <?php if($page=="index.php"){?> active <?php } ?>">
            <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item <?php if($page=="create_poll.php"){?> active <?php } ?>">
            <a class="nav-link" href="create_poll.php">Create poll</a>
        </li>
          <?php
            if ($_SESSION['poll_user']) {
                ?>
        <li class="nav-item <?php if($page=="profile.php"){?> active <?php } ?>">
            <a class="nav-link" href="profile.php">My profile</a>
        </li> 
         <li class="nav-item <?php if($page=="poll_history.php"){?> active <?php } ?>">
            <a class="nav-link" href="poll_history.php">Poll history</a>
        </li>
 <?php
            }
            ?>
          <li class="nav-item ">
              <a class="nav-link" href="index.php#trending_polls">Trending polls</a>
        </li>
        <li class="nav-item <?php if($page=="#"){?> active <?php } ?>">
            <a class="nav-link" href="#">Contact</a>
        </li>
        
    </ul>
    <ul class="navbar-nav">
        <li class="nav-item">
            <?php
            if ($_SESSION['poll_user']) {
                ?>
                <a href="logout.php" class="btn btn-primary btn-style">Logout</a>
                <?php
            } else {
                ?>
                <a href="signup_signin.php" class="btn btn-primary btn-style">Sign up / Sign In</a>
                <?php
            }
            ?>
        </li>
    </ul>
</div>
            </nav>
        </header>
        <!-- //site header -->