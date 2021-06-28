<!DOCTYPE html>
<html>
<body class="hold-transition sidebar-mini" onload="wsConnect();" onunload="wsa.disconnect();">
<div class="wrapper">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">cutting</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
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
                foreach($cutting as $u){
            ?>
            <div class="col-md-3 col-sm-6 col-xs-12">
             <a href="<?php echo base_url('Machmon/cutting/subcutting/').$u->m_cutting_id; ?>">
              <div id="rl1_status" class="info-box bg-success">
                <div class="info-box-content">
                  <span class="info-box-text"><?php echo $u->m_cutting_nama ?></span>
                  <span id="ct1_pcsbox" class="info-box-number">n/a</span>

                  <div class="progress">
                    <div class="progress-bar" style="width: 70%"></div>
                  </div>
                  <span class="progress-description">
                    70% Increase in 30 Days
                  </span>
                </div>
              </div>
              </a><!-- /.info-box -->
            </div>
            <?php } ?><!-- /.col -->
          </div><!-- /.row -->
        </div>
      </div><!-- /.container-fluid -->
    </section>
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
        if (obj.ct1_status == "RUNNING") {
          //document.getElementById('ct1_status').innerHTML = obj.ct1_status;
          document.getElementById('ct1_status').className = "info-box bg-success";
        }
        if (obj.ct1_status == "IDLE") {
          //document.getElementById('hd1_status').innerHTML = obj.ct1_status;
          document.getElementById('ct1_status').className = "info-box bg-warning";
        }
        document.getElementById('ct1_pcsbox').innerHTML = obj.ct1_pcsbox+' of '+'2300';
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