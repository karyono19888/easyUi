<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | DataTables</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../assets/adminlte/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../../assets/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../assets/adminlte/dist/css/adminlte.min.css">
  <!-- sweatalert -->
  <link rel="stylesheet" href="../../assets/adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- sweatalert -->
  <link rel="stylesheet" href="../../assets/adminlte/dist/sweetalert.css">
  <!-- datetime picker -->
  <link rel="stylesheet" href="../../assets/adminlte/plugins/datetimepicker/bootstrap-datetimepicker.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
      </ul>


      <!-- Right navbar links -->

    </nav>
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="" class="brand-link">
        <img src="../../assets/adminlte/dist/img/PT SAGATEKNINDO SEJATI.png" height="100" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">PORTAL SPK IT</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="../../assets/adminlte/dist/img/default.jpg" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block"><?php echo $this->session->userdata('nama'); ?></a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                SPK IT
              </p>
            </a>
          </ul>
        </nav>
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <a href="<?= base_url('Main/logout'); ?>" class="nav-link">
              <i class="fas fa-sign-out-alt"></i>
              <p>
                Log Out
              </p>
            </a>
          </ul>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->

      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-12">
            <div class="card-header bg-gray-dark color-palette text-center">
              <a class="col-sm-12 text-center">DAFTAR SPK</a>
            </div>
            <div style=" padding-top: 10px; padding-bottom:10 10px;padding-left: 20px;">
              <button type="button" class="btn bg-primary color-palette " data-toggle="modal" data-target="#ModalCretaed" data-whatever="@getbootstrap">Add data</button>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
              <table id="example2" class="table table-bordered table-striped ">
                <thead>
                  <tr>
                    <th style="text-align:center">ID</th>
                    <th style="text-align:center">JENIS</th>
                    <th style="text-align:center">EKSEKUTOR</th>
                    <th style="text-align:center">DESKRIPSI</th>
                    <th style="text-align:center">DUE DATE</th>
                    <th style="text-align:center">OPTION</th>
                  </tr>
                </thead>
                <tbody id="show_data">

                </tbody>

              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->


          <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>

  <!-- Modal -->
  <div class=" modal fade" id="ModalCretaed" tabindex="-1" role="dialog" aria-labelledby="newSubMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form id="Buat_Spk" method="post">
          <div class="modal-body">

            <div class="form-group">
              <select name="t_spk_jenis" id="t_spk_jenis" class="form-control">
                <option value="HARDWARE">Hardware</option>
                <option value="SOFTWARE">Software</option>
              </select>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" id="t_spk_user" name="t_spk_user" value="<?php echo $this->session->userdata('namauser'); ?>">
            </div>

            <div class="form-group">
              <textarea type="text" class="form-control" id="t_spk_uraian" name="t_spk_uraian" rows="3" placeholder="Deskripsi masalah..?"></textarea>
            </div>
            <div class="form-group date form_datetime">
              <input class="form-control" size="16" type="text" id="t_spk_duedate" name="t_spk_duedate" value="" placeholder="Tanggal selesai.." readonly>
              <span class="add-on"><i class="icon-th"></i></span>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="btn_simpan">Add</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- /.Modal Edit-->
  <div class="modal fade" id="ModalaEdit" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Update SPK</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form class="form-horizontal">
          <div class="modal-body">
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">ID SPK</label>
              <div class="col-sm-10">
                <input type="text" id="edit_id" name="edit_id" class="form-control" value="" placeholder="Deskripsi" readonly>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Deskripsi</label>
              <div class="col-sm-10">
                <input type="text" id="edit_uraian" name="edit_uraian" class="form-control" value="" placeholder="Deskripsi" required>
              </div>
            </div>
            <div class="form-group row date form_datetime">
              <label class="col-sm-2 col-form-label">Target Selesai</label>
              <div class="col-sm-10">
                <input class="form-control" size="16" type="text" id="edit_duedate" name="edit_duedate" value="" readonly>
                <span class="add-on"><i class="icon-th"></i></span>
              </div>
            </div>

          </div>

          <div class="modal-footer">
            <button class="btn btn-secondary" data-dismiss="modal" aria-hidden="true">Tutup</button>
            <button class="btn btn-info" id="btn_update">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>



  <!-- Modal Delete Package-->

  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy; <?= date('Y '); ?><a href="https://www.sagateknindo.co.id/">Sagatek</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="../../assets/adminlte/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../../assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- DataTables -->
  <script src="../../assets/adminlte/plugins/datatables/jquery.dataTables.js"></script>
  <script src="../../assets/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
  <!-- date-time-picker -->
  <script src="../../assets/adminlte/plugins/datetimepicker/bootstrap-datetimepicker.js"></script>
  <!-- AdminLTE App -->
  <script src="../../assets/adminlte/dist/js/adminlte.min.js"></script>
  <!-- Toastr -->
  <script src="../../assets/adminlte/plugins/sweetalert2/sweetalert2.min.js"></script>
  <script src="../../assets/adminlte/dist/sweetalert.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="../../assets/adminlte/dist/js/demo.js"></script>
  <!-- page script -->

  <script type="text/javascript">
    $(".form_datetime").datetimepicker({
      format: "  yyyy-mm-dd hh:ii",
      autoclose: true,
      todayBtn: true,
      pickerPosition: "bottom-center"
    });
  </script>
  <script type="text/javascript">
    $(function() {});
    $(document).ready(function() {
      tampil_data_spk(); //pemanggilan fungsi tampil data SPK.

      //fungsi tampil data SPK
      function tampil_data_spk() {
        $.ajax({
          type: 'GET',
          url: '<?php echo base_url() ?>spk/spk/spk',
          async: true,
          dataType: 'json',
          success: function(data) {
            var html = '';
            var i;
            for (i = 0; i < data.length; i++) {
              html += '<tr>' +
                '<td style="text-align:center">' + data[i].t_spk_id + '</td>' +
                '<td style="text-align:center">' + data[i].t_spk_jenis + '</td>' +
                '<td style="text-align:center">' + data[i].t_spk_man + '</td>' +
                '<td style="text-align:center">' + data[i].t_spk_uraian + '</td>' +
                '<td style="text-align:center">' + data[i].t_spk_duedate + '</td>' +
                '<td style="text-align:center;">' +
                '<a href="javascript:;" class="btn badge-primary item_edit" data="' + data[i].t_spk_id + '">Edit</a>' + ' ' +
                '<a href="javascript:;" class="btn badge-danger item_hapus" dataid="' + data[i].t_spk_id + '">Hapus</a>' +

                '</td>' +
                '</tr>';
            }
            $('#show_data').html(html);
            $('#example2').DataTable({
              "paging": true,
              "lengthChange": false,
              "searching": true,
              "ordering": true,
              "info": true,
              "autoWidth": false,
            });
          }

        });

      }



      //Create
      $('#btn_simpan').on('click', function() {
        var t_spk_jenis = $('#t_spk_jenis').val();
        var t_spk_user = $('#t_spk_user').val();
        var t_spk_uraian = $('#t_spk_uraian').val();
        var t_spk_duedate = $('#t_spk_duedate').val();
        $.ajax({
          type: "POST",
          url: "<?php echo base_url('spk/spk/buatspk') ?>",
          dataType: "JSON",
          data: {
            t_spk_jenis: t_spk_jenis,
            t_spk_user: t_spk_user,
            t_spk_uraian: t_spk_uraian,
            t_spk_duedate: t_spk_duedate
          },
          success: function(data) {
            $('[name="t_spk_jenis"]').val("");
            $('[name="t_spk_user"]').val("");
            $('[name="t_spk_uraian"]').val("");
            $('[name="t_spk_duedate"]').val("");
            $('#ModalCretaed').modal('hide');
            swal({
              type: 'success',
              title: 'Buat SPK',
              text: 'Anda Berhasil Membuat SPK'

            });
            //tampil_data_spk();
            window.location.reload();
          }
        });
        return false;
      });

      //GET UPDATE
      $('#show_data').on('click', '.item_edit', function() {
        var id = $(this).attr('data');
        $.ajax({
          type: "GET",
          url: "<?php echo base_url('spk/spk/get_id') ?>",
          dataType: "JSON",
          data: {
            id: id
          },
          success: function(data) {
            $.each(data, function(t_spk_id, t_spk_uraian, t_spk_duedate) {
              $('#ModalaEdit').modal('show');
              $('[name="edit_id"]').val(data.t_spk_id);
              $('[name="edit_uraian"]').val(data.t_spk_uraian);
              $('[name="edit_duedate"]').val(data.t_spk_duedate);
            });
          }
        });
        return false;
      });

      //Update SPK
      $('#btn_update').on('click', function() {
        var id = $('#edit_id').val();
        var deskripsi = $('#edit_uraian').val();
        var target = $('#edit_duedate').val();
        $.ajax({
          type: "POST",
          url: "<?php echo base_url('spk/spk/updatespk') ?>",
          dataType: "JSON",
          data: {
            id: id,
            deskripsi: deskripsi,
            target: target
          },
          success: function(data) {
            $('[name="edit_id"]').val("");
            $('[name="edit_uraian"]').val("");
            $('[name="edit_duedate"]').val("");
            swal({
              type: 'success',
              title: 'Update SPK',
              text: 'Anda Berhasil Mengubah Data SPK'

            });
            window.location.reload()
            $('#ModalaEdit').modal('hide');
            table.destroy();
            //tampil_data_spk();
            // window.location.reload()
          }
        });
        return false;
      });



      // DELETE
      $('#show_data').on('click', '.item_hapus', function() {
        var t_spk_id = $(this).attr('dataid');
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: 'btn-danger',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: "No, cancel plx!",
            closeOnConfirm: false,
            closeOnCancel: false
          },
          function(isConfirm) {
            if (isConfirm) {
              $.ajax({
                url: '<?php echo site_url('spk/spk/deletespk'); ?>',
                method: 'post',
                dataType: "JSON",
                data: {
                  t_spk_id: t_spk_id
                },
                error: function() {
                  alert('Something is wrong');
                },
                success: function(data) {
                  swal("Deleted!", "Your imaginary file has been deleted.", "success");
                  tampil_data_spk();
                }
              });
              return false;
            } else {
              swal("Cancelled", "Your imaginary file is safe :)", "error");
            }
          });
      });

    });
  </script>

</body>

</html>