<?php
include './validation.php';
if ($_SESSION['poll_login_admin']) {
    if ($_GET['email_id']) {
        $email_id= $_GET['email_id'];
        $sql_user = "SELECT b.name, a.mobile, a.email_id, a.role, b.dob FROM login_access a INNER JOIN user_details b ON a.email_id=b.email_id WHERE b.email_id='$email_id'";
        $fetch_user = json_decode(ret_json_str($sql_user));
        foreach ($fetch_user as $usr_val) {
            $name=$usr_val->name;
            $mobile=$usr_val->mobile;
            $email=$usr_val->email_id;
            $role=$usr_val->role;
            $dob=date('d-m-Y',strtotime($usr_val->dob));
        }
        ?>
        <!DOCTYPE html>
        <!DOCTYPE html>
        <html>
            <head>
                <meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <title>POLL | Users</title>
                <!-- Tell the browser to be responsive to screen width -->
                <meta name="viewport" content="width=device-width, initial-scale=1">

                <!-- Font Awesome -->
                <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
                <!-- Ionicons -->
                <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
                <!-- DataTables -->
                <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">
                <!-- Theme style -->
                <link rel="stylesheet" href="dist/css/adminlte.min.css">
                <!-- Google Font: Source Sans Pro -->
                <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
            </head>
            <script type="text/javascript">
                function redirect(page) {
                    window.location.href = page;
                }
            </script>
            <body class="hold-transition sidebar-mini">
                <div class="wrapper">
                    <?php
                    include './menu.php';
                    ?>

                    <!-- Content Wrapper. Contains page content -->
                    <div class="content-wrapper">
                        <!-- Content Header (Page header) -->
                        <section class="content-header">
                            <div class="container-fluid">
                                <div class="row mb-2">
                                    <div class="col-sm-6">
                                        <h1>Edit users</h1>
                                    </div>
                                    <div class="col-sm-6">
                                        <ol class="breadcrumb float-sm-right">
                                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                                            <li class="breadcrumb-item active">Edit users</li>
                                        </ol>
                                    </div>

                                </div>
                            </div><!-- /.container-fluid -->
                        </section>

                        <!-- Main content -->
                        <section class="content">
                            <div class="row">
                                <div class="col-12">

                                    <!-- /.card -->

                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title text-success"><?php echo $success; ?></h3>
                                            
                                           
                                        </div>

                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <form action="" method="post">
                                                <input type="hidden" name="pemail_id" id="pemail_id" value="<?php echo $email_id; ?>" />
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                    <label for="name">NAME :</label> *
                                                    <input type="text" name="uname" class="form-control" id="uname" value="<?php echo $name; ?>" />
                                                    <b class="text-danger"><?php echo $nameErr; ?></b>
                                                </div>
                                                            <div class="form-group">
                                                    <label for="mobile">MOBILE :</label> 
                                                    <input type="number" name="mobile" class="form-control" id="mobile" value="<?php echo $mobile; ?>" />
                                                    <b class="text-danger"></b>
                                                </div>
                                                         <div class="form-group">
                                                    <label for="dob">DOB :</label> 
                                                    <input type="date" name="dob" class="form-control" id="dob" value="<?php echo $dob; ?>" />
                                                    <b class="text-danger"></b>
                                                </div>       
                                                <div class="form-group">
                                                    <button type="submit" name="user_edit" id="user_edit" class="btn btn-primary">
                                                        SAVE
                                                    </button>
                                                </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                    <label for="email_id">EMAIL :</label> *
                                                    <input type="email" name="email_id" class="form-control" id="email_id" value="<?php echo $email; ?>" />
                                                    <b class="text-danger"><?php echo $email_idErr; ?></b>
                                                </div>
                                               
                                                        <div class="form-group">
                                                    <label for="role">ROLE:</label> *
                                                    <select name="role" id="role" class="form-control">
                                                        <option value="" <?php if($role==""){echo "selected='selected'";} ?>>SELECT</option>
                                                        <option value="1" <?php if($role=="1"){echo "selected='selected'";} ?>>Admin</option>
                                                        <option value="2" <?php if($role=="2"){echo "selected='selected'";} ?>>User</option>
                                                    </select>
                                                   <b class="text-danger"><?php echo $roleErr; ?></b>
                                                </div> 
                                                    </div>
                                                </div>
                                                
                                            </form>
                                            
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                    <!-- /.card -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </section>
                        <!-- /.content -->
                    </div>
                    <!-- /.content-wrapper -->
                    <?php include 'footer.php'; ?>

                    <!-- Control Sidebar -->
                    <aside class="control-sidebar control-sidebar-dark">
                        <!-- Control sidebar content goes here -->
                    </aside>
                    <!-- /.control-sidebar -->
                </div>
                <!-- ./wrapper -->

                <!-- jQuery -->
                <script src="plugins/jquery/jquery.min.js"></script>
                <!-- Bootstrap 4 -->
                <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
                <!-- DataTables -->
                <script src="plugins/datatables/jquery.dataTables.js"></script>
                <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
                <!-- AdminLTE App -->
                <script src="dist/js/adminlte.min.js"></script>
                <!-- AdminLTE for demo purposes -->
                <script src="dist/js/demo.js"></script>
                <!-- page script -->
                <script>
                                                    $(function () {
                                                        $("#example1").DataTable();
                                                        $('#example2').DataTable({
                                                            "paging": true,
                                                            "lengthChange": false,
                                                            "searching": false,
                                                            "ordering": true,
                                                            "info": true,
                                                            "autoWidth": false,
                                                        });
                                                    });
                </script>
            </body>
        </html>

        <?php
    }
} else {
    ?>
    <script type="text/javascript">
        redirect("login.php");
    </script>
    <?php
}
?>
