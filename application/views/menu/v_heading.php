<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Smart Factory</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="plugins/ionicons/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="plugins/googleapis/css.css" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini" onload="wsConnect();" onunload="wsa.disconnect();">
<div class="wrapper">

  

  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Heading</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('Menu/heading'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
           <?php 
                $no = 1;
                foreach($heading as $u){
            ?>
           <div class="col-md-3 col-sm-6 col-xs-12">
             <a href="<?php echo base_url('Machmon/Heading/subheading/').$u->m_heading_id ?>">
              <div id="hd1_status" class="info-box bg-success">
                <div class="info-box-content">
                  <span class="info-box-text"><?php echo $u->m_heading_nama ?></span>
                  <span id="hd1_pcsbox" class="info-box-number">n/a</span>

                  <div class="progress">
                    <div class="progress-bar" style="width: 70%"></div>
                  </div>
                  <span class="progress-description">
                    70% Increase in 30 Days
                  </span>
                </div>
              </div>
              </a>
           </div>
          <?php } ?>
        </div>
      </div><!-- /.container-fluid -->
    </section>
  </div>
</div>
<script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
  <!-- jQuery Knob -->
  <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- Sparkline -->
  <script src="plugins/sparkline/jquery.sparkline.min.js"></script>
  <!-- page script -->
  <script src="plugins/flot/jquery.flot.js"></script>
  <!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
  <script src="plugins/flot-old/jquery.flot.resize.min.js"></script>
  <!-- FLOT PIE PLUGIN - also used to draw donut charts -->
  <script src="plugins/flot-old/jquery.flot.pie.min.js"></script>
  <!-- Page script -->
  <script>
    var wsa;
    var wsUria = "ws://10.3.6.2:1880";   //change with your ip node red
    var loc = window.location;
    console.log(loc);
    if (loc.protocol === "https:") { wsUria = "wss:"; }
    wsUri = wsUria + "/" + ("machine/all", "ws/machine/all");
    function wsConnect() {
      console.log("connect", wsUri);
      wsa = new WebSocket(wsUri);
      wsa.onmessage = function (msg) {
        var data = msg.data;
        var obj = JSON.parse(data);
        if (obj.hd1_status == "RUNNING") {
          //document.getElementById('hd1_status').innerHTML = obj.hd1_status;
          document.getElementById('hd1_status').className = "info-box bg-success";
        }
        if (obj.hd1_status == "IDLE") {
          //document.getElementById('hd1_status').innerHTML = obj.hd1_status;
          document.getElementById('hd1_status').className = "info-box bg-warning";
        }
        document.getElementById('hd1_pcsbox').innerHTML = obj.hd1_pcsbox+' of '+'2000';
      }
      wsa.onopen = function () {
        console.log("connected");
      }
      wsa.onclose = function () {
        setTimeout(wsConnect, 3000);
      }
    }

    function doit(m) {
      if (wsa) { wsa.send(m); }
    }
  </script>
</body>
</html>
