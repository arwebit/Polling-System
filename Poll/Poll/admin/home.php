<?php
include './validation.php';
if ($_SESSION['poll_login_admin']) {
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
                                    <h1>Users</h1>
                                </div>
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-sm-right">
                                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                                        <li class="breadcrumb-item active">Users</li>
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
                                        <h3 class="card-title"> Add users &nbsp;&nbsp;&nbsp;
                                            <span class="text-success"><?php echo $success;?></span></h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <form action="" method="post">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                    <label for="name">NAME :</label> *
                                                    <input type="text" name="uname" class="form-control" id="uname" value="" />
                                                    <b class="text-danger"><?php echo $nameErr; ?></b>
                                                </div>
                                                            <div class="form-group">
                                                    <label for="mobile">MOBILE :</label> 
                                                    <input type="number" name="mobile" class="form-control" id="mobile" value="" />
                                                    <b class="text-danger"></b>
                                                </div>
                                                         <div class="form-group">
                                                    <label for="dob">DOB :</label> 
                                                    <input type="date" name="dob" class="form-control" id="dob" value="" />
                                                    <b class="text-danger"></b>
                                                </div>       
                                                <div class="form-group">
                                                    <button type="submit" name="user_insert" id="user_insert" class="btn btn-primary">
                                                        SAVE
                                                    </button>
                                                </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                    <label for="email_id">EMAIL :</label> *
                                                    <input type="email" name="email_id" class="form-control" id="email_id" value="" />
                                                    <b class="text-danger"><?php echo $email_idErr; ?></b>
                                                </div>
                                                <div class="form-group">
                                                    <label for="pass">PASSWORD :</label>  *
                                                    <input type="password" name="pass" class="form-control" id="pass" value="" />
                                                    <b class="text-danger"><?php echo $passErr; ?></b>
                                                </div>
                                                        <div class="form-group">
                                                    <label for="role">ROLE:</label> *
                                                    <select name="role" id="role" class="form-control">
                                                        <option value="">SELECT</option>
                                                        <option value="1">Admin</option>
                                                        <option value="2">User</option>
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
                        <div class="row">
                            <div class="col-12">

                                <!-- /.card -->

                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Manage users</h3>
                                        
                                    </div>

                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Username</th>
                                                    <th>Email</th>
                                                    <th>Mobile</th>
                                                    <th>Role</th>
                                                    <th>Date of birth</th>
                                                    <th>Option</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql_user = "SELECT b.name,b.username, b.email_id, b.dob, a.mobile, a.role FROM login_access a INNER JOIN user_details b ON a.email_id=b.email_id ";
                                                $fetch_msg = json_decode(ret_json_str($sql_user));
                                                foreach ($fetch_msg as $msg_value) {
                                                    if($msg_value->role=="1"){
                                                        $role_name="Admin";
                                                    }else{
                                                        $role_name="User"; 
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $msg_value->name; ?></td>
                                                        <td><?php echo $msg_value->username; ?></td>
                                                        <td><?php echo $msg_value->email_id; ?></td>
                                                        <td><?php echo $msg_value->mobile; ?></td>
                                                        <td><?php echo $role_name; ?></td>
                                                        <td><?php echo $msg_value->dob; ?></td>
                                                       <td><a href="edit_users.php?email_id=<?php echo $msg_value->email_id;?>">
                                                                <button class="btn btn-primary" id="edit_user" name="edit_user">
                                                                    EDIT
                                                                </button>
                                                            </a>
                                                         </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
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
} else {
    ?>
    <script type="text/javascript">
        redirect("login.php");
    </script>
    <?php
}
?>
