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
            <title>POLL | Category</title>
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
                                    <h1>Category</h1>
                                </div>
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-sm-right">
                                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                                        <li class="breadcrumb-item active">Category</li>
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
                                        <h3 class="card-title"> Add category &nbsp;&nbsp;&nbsp;
                                            <span class="text-success"><?php echo $success;?></span></h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <form action="" method="post">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                    <label for="cat_name">CATEGORY NAME :</label> *
                                                    <input type="text" name="cat_name" class="form-control" id="cat_name" value="" />
                                                    <b class="text-danger"><?php echo $categoryErr; ?></b>
                                                </div>
                                                <div class="form-group">
                                                    <button type="submit" name="cat_insert" id="cat_insert" class="btn btn-primary">
                                                        SAVE
                                                    </button>
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
                                        <h3 class="card-title">Manage category</h3>
                                        
                                    </div>

                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Category</th>
                                                    <th>Option</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql_cat = "SELECT * FROM mas_category ";
                                                $fetch_msg = json_decode(ret_json_str($sql_cat));
                                                foreach ($fetch_msg as $msg_value) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $msg_value->category_name; ?></td>
                                                        <td><a href="edit_category.php?id=<?php echo $msg_value->id;?>">
                                                                <button class="btn btn-primary" id="edit_cat" name="edit_cat">
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
