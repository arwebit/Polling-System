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
            <title>POLL | Time</title>
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
                                    <h1>Time</h1>
                                </div>
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-sm-right">
                                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                                        <li class="breadcrumb-item active">Time</li>
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
                                        <h3 class="card-title"> Add time &nbsp;&nbsp;&nbsp;
                                            <span class="text-success"><?php echo $success;?></span></h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <form action="" method="post">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                    <label for="time_name">TIME :</label> *
                                                    <input type="number" name="time_name" class="form-control" id="time_name" value="" />
                                                    <b class="text-danger"><?php echo $time_nameErr; ?></b>
                                                </div>
                                                <div class="form-group">
                                                    <button type="submit" name="time_insert" id="time_insert" class="btn btn-primary">
                                                        SAVE
                                                    </button>
                                                </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                    <label for="time_val">TIME VALUE :</label> *
                                                    <select name="time_value" id="time_value" class="form-control">
                                                        <option value="">SELECT</option>
                                                        <option value="days">DAYS</option>
                                                        <option value="hours">HOURS</option>
                                                        <option value="minutes">MINUTES</option>
                                                        
                                                    </select>
                                                   <b class="text-danger"><?php echo $time_valErr; ?></b>
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
                                        <h3 class="card-title">Manage time type</h3>
                                        
                                    </div>

                                    <!-- /.card-header -->
                                    <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Time</th>
                                                    <th>Hr/Min/Sec</th>
                                                    <th>Option</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql_time = "SELECT * FROM mas_time";
                                                $fetch_time = json_decode(ret_json_str($sql_time));
                                                foreach ($fetch_time as $tme_value) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $tme_value->time_val; ?></td>
                                                        <td><?php echo $tme_value->hr_min_sec; ?></td>
                                                        <td><a href="edit_time.php?id=<?php echo $tme_value->id;?>">
                                                                <button class="btn btn-primary" id="edit_time" name="edit_time">
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
