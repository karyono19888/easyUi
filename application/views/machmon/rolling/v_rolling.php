<!DOCTYPE html>
<html>
<body class="hold-transition sidebar-mini" onload="wsConnect();" onunload="ws.disconnect();">
<div class="wrapper">

  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
              <li class="breadcrumb-item"><a href="<?php echo base_url('Machmon/rolling/rolling'); ?>">Home</a></li>
              <li class="breadcrumb-item active"><?php echo 'rolling '.$rolling ?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- Main content -->
     
    <section class="content">
      <div class="container-fluid">
        <!-- atas -->
        <div class="row">
          <div class="col-md-6">
        <!-- =========================================================== -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">STATUS</h3>
              </div>
              <div class="card-body">
                <ul class="nav flex-column">
                  <li class="nav-item">
                    <a class="nav-link">
                      Date & Time <span id="datetime" class="float-right badge ">n/a</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link">
                      Product <span id="product" class="float-right badge ">n/a</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link">
                      LOT <span id="product" class="float-right badge ">n/a</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link">
                      Total Time <span id="totaltime" class="float-right badge ">n/a</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link">
                      Run Time <span id="runtime" class="float-right badge ">n/a</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link">
                      Down Time <span id="downtime" class="float-right badge ">n/a</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link">
                      Status  <span id="status" float-right badge bg-danger>n/a</span>
                    </a>
                  </li>
                </ul>
              </div>
              <!-- /.card-body -->
            </div>
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">MACHINE</h3>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-4 text-center">
                    <div class="knob-label">Voltage (Std. 380~400 V)</div>
                    <input type="text" id=""  class="knob" data-angleArc="250" data-angleOffset="-125"
                      value="n/a" data-width="120" data-height="120" data-fgColor="#f56954">
                  </div>
                  <div class="col-md-4 text-center">
                    <div class="knob-label">Voltage (Std. 380~400 V)</div>
                    <input type="text" id=""  class="knob" data-angleArc="250" data-angleOffset="-125"
                      value="n/a" data-width="120" data-height="120" data-fgColor="#f56954">
                  </div>
                  <div class="col-md-4 text-center">
                    <div class="knob-label">Voltage (Std. 380~400 V)</div>
                    <input type="text" id=""  class="knob" data-angleArc="250" data-angleOffset="-125"
                      value="n/a" data-width="120" data-height="120" data-fgColor="#f56954">
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            
          </div>
          <!-- /.kiri -->

          <!-- kanan -->
          <div class="col-md-6">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">PRODUCTION</h3>
              </div>
              <div class="card-body">
                <ul class="nav flex-column">
                  <li class="nav-item">
                    <a class="nav-link">
                      Total Pcs <span id="totalpcs" class="float-right badge ">n/a</span>
                    </a>
                  </li>
                   <li class="nav-item">

                   </li>
                    <br>
                    <li class="nav-item">
                    <a class="nav-link">
                      Total Box <span id="totalbox" class="float-right badge ">n/a</span>
                    </a>
                  </li><br>
                    </a>
                  </li>
                  
                </ul>
                <div class="row">
                  <div class="col-md-4 text-center">
                    <div id="stdbox" class="knob-label">n/a</div>
                    <input id="pcsbox" type="text" class="knob" value="n/a" data-min="0" data-width="120" data-height="120"
                          data-fgColor="#f56954">
                  </div>
                   <div class="col-md-4 text-center">
                    <div id="stdbox" class="knob-label">Cycle Time</div>
                    <input type="text" id="average"  class="knob" data-max="20" data-angleArc="250" data-angleOffset="-125"
                      value="n/a" data-width="120" data-height="120" data-fgColor="#f56954">
                  </div>
                   <div class="col-md-4 text-center">
                    <div id="stdbox" class="knob-label">Qty/Minute</div>
                    <input type="text" id="average"  class="knob" data-max="20" data-angleArc="250" data-angleOffset="-125"
                      value="n/a" data-width="120" data-height="120" data-fgColor="#f56954">
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">MAINTENANCE</h3>
              </div>
              <div class="card-body">
                <ul class="nav flex-column">
                  <li class="nav-item">
                    <a class="nav-link">
                      Status  <span class="float-right badge bg-success">OK</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link">
                      Down Time <span class="float-right badge ">00:00:00</span>
                    </a>
                  </li>
                </ul>
                <br><br><br><br>
              </div>
              <!-- /.card-body -->
            </div>
         </div>

         <?php
              /* Mengambil query report*/
              function mobile_detect()
              {
                  $is_mobile = false;
                   
                  $iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
                  $android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
                  $palmpre = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
                  $berry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
                  $ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
                   
                  if ($iphone || $android || $palmpre || $ipod || $berry == true)
                  {
                  $is_mobile = true;
                  }else{
                  $is_mobile = false;
                  }
                  return $is_mobile;
              }

              foreach($chart_oee as $result1){
                  $bulan[] = $result1->t_oee_tanggal; //t_productivity_tanggal t_oee_tanggal
                  $value[] = (float) $result1->t_oee_value; //t_productivity_value t_oee_value
              }
              /* end mengambil query*/
               
          ?>

          <!------  OEE  ------->
          <div class="col-md-6">
            <?php
                  if (mobile_detect() == true){
                  ?>
            <div class="card card-primary">
              <div class="card-header border-0">
                <h3 class="card-title">
                    OEE
                </h3>
                <div id="#collapse" class="card-tools">
                  <button class="btn btn-primary btn-sm" 
                          type="button" 
                          data-card-widget="collapse"
                          data-toggle="collapse" 
                          data-target="#collapse_oee" 
                          aria-expanded="false" 
                          aria-controls="collapse_oee">
                  <i class="fas fa-minus"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <div class="collapse" id="collapse_oee">
                <div class="card-body">
                  <div id="highcharts" style="height: 250px; width: 100%;"></div>
                </div>
              </div>
              <!-- /.card-body-->
            </div>
                <?php
              }else{ 
                ?>
            <div class="card card-primary">
              <div class="card-header border-0">
                <h3 class="card-title">
                    OEE
                </h3>
                <!-- card tools -->
                <div class="card-tools">
                  <button type="button"
                          class="btn btn-primary btn-sm"
                          data-card-widget="collapse"
                          data-toggle="tooltip"
                          title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <div class="card-body">
                <div id="highcharts" style="height: 250px; width: 100%;"></div>
              </div>
              <!-- /.card-body-->
            </div>
                <?php
              }
              ?>
          </div>

      <!----- PRODUCTIVITY  ------->

        <?php
              /* Mengambil query report*/
              foreach($chart_prod as $result2){
                  $bulan_p[] = $result2->t_productivity_tanggal; //t_productivity_tanggal t_oee_tanggal
                  $value_p[] = (float) $result2->t_productivity_value; //t_productivity_value t_oee_value
              }
              /* end mengambil query*/
               
          ?>

        <div class="col-md-6">
            <?php
                  if (mobile_detect() == true){
                  ?>
            <div class="card card-primary">
              <div class="card-header border-0">
                <h3 class="card-title">
                    Productivity
                </h3>
                <div id="#collapse" class="card-tools">
                  <button class="btn btn-primary btn-sm" 
                          type="button" 
                          data-card-widget="collapse"
                          data-toggle="collapse" 
                          data-target="#collapse_p" 
                          aria-expanded="false" 
                          aria-controls="collapse_p">
                  <i class="fas fa-minus"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <div class="collapse" id="collapse_p">
                <div class="card-body">
                  <div id="highcharts_p" style="height: 250px; width: 100%;"></div>
                </div>
              </div>
              <!-- /.card-body-->
            </div>
                <?php
              }else{ 
                ?>
            <div class="card card-primary">
              <div class="card-header border-0">
                <h3 class="card-title">
                    Productivity
                </h3>
                <!-- card tools -->
                <div class="card-tools">
                  <button type="button"
                          class="btn btn-primary btn-sm"
                          data-card-widget="collapse"
                          data-toggle="tooltip"
                          title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <div class="card-body">
                <div id="highcharts_p" style="height: 250px; width: 100%;"></div>
              </div>
              <!-- /.card-body-->
            </div>
                <?php
              }
              ?>
          </div>

        <!-----  OUTPUT  --------->

        <?php
              /* Mengambil query report*/
              foreach($chart_output as $result3){
                  $bulan_o[] = $result3->t_output_tanggal; //t_productivity_tanggal t_oee_tanggal
                  $value_o[] = (float) $result3->t_output_value; //t_productivity_value t_oee_value
              }
              /* end mengambil query*/
               
          ?>

        <div class="col-md-6">
            <?php
                  if (mobile_detect() == true){
                  ?>
            <div class="card card-primary">
              <div class="card-header border-0">
                <h3 class="card-title">
                    Output
                </h3>
                <div id="#collapse" class="card-tools">
                  <button class="btn btn-primary btn-sm" 
                          type="button" 
                          data-card-widget="collapse"
                          data-toggle="collapse" 
                          data-target="#collapse_output" 
                          aria-expanded="false" 
                          aria-controls="collapse_output">
                  <i class="fas fa-minus"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <div class="collapse" id="collapse_output">
                <div class="card-body">
                  <div id="highcharts_output" style="height: 250px; width: 100%;"></div>
                </div>
              </div>
              <!-- /.card-body-->
            </div>
                <?php
              }else{ 
                ?>
            <div class="card card-primary">
              <div class="card-header border-0">
                <h3 class="card-title">
                    Output
                </h3>
                <!-- card tools -->
                <div class="card-tools">
                  <button type="button"
                          class="btn btn-primary btn-sm"
                          data-card-widget="collapse"
                          data-toggle="tooltip"
                          title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <div class="card-body">
                <div id="highcharts_output" style="height: 250px; width: 100%;"></div>
              </div>
              <!-- /.card-body-->
            </div>
                <?php
              }
              ?>
          </div>

      <!-----  WORKING HOUR  ---------->

        <?php
              /* Mengambil query report*/
              foreach($chart_wh as $result4){
                  $bulan_wh[] = $result4->t_working_hour_tanggal; //t_productivity_tanggal t_oee_tanggal
                  $value_wh[] = (int) $result4->t_working_hour_value; //t_productivity_value t_oee_value
              }
              /* end mengambil query*/
               
          ?>

        <div class="col-md-6">
            <?php
                  if (mobile_detect() == true){
                  ?>
            <div class="card card-primary">
              <div class="card-header border-0">
                <h3 class="card-title">
                    Working Hour
                </h3>
                <div id="#collapse" class="card-tools">
                  <button class="btn btn-primary btn-sm" 
                          type="button" 
                          data-card-widget="collapse"
                          data-toggle="collapse" 
                          data-target="#collapse_wh" 
                          aria-expanded="false" 
                          aria-controls="collapse_wh">
                  <i class="fas fa-minus"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <div class="collapse" id="collapse_wh">
                <div class="card-body">
                  <div id="highcharts_wh" style="height: 250px; width: 100%;"></div>
                </div>
              </div>
              <!-- /.card-body-->
            </div>
                <?php
              }else{ 
                ?>
            <div class="card card-primary">
              <div class="card-header border-0">
                <h3 class="card-title">
                    Working Hour
                </h3>
                <!-- card tools -->
                <div class="card-tools">
                  <button type="button"
                          class="btn btn-primary btn-sm"
                          data-card-widget="collapse"
                          data-toggle="tooltip"
                          title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <div class="card-body">
                <div id="highcharts_wh" style="height: 250px; width: 100%;"></div>
              </div>
              <!-- /.card-body-->
            </div>
                <?php
              }
              ?>
          </div>
<!-- /.container-fluid -->
    </section>

    <!-- /.content -->

    <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a>
  </div>
  <!-- /.content-wrapper -->



  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->


<!-- Page script -->
<script>
  
  $(function () {
    /* jQueryKnob */

    $('.knob').knob({
      /*change : function (value) {
       //console.log("change : " + value);
       },
       release : function (value) {
       console.log("release : " + value);
       },
       cancel : function () {
       console.log("cancel : " + this.value);
       },*/
      draw: function () {

        // "tron" case
        if (this.$.data('skin') == 'tron') {

          var a   = this.angle(this.cv)  // Angle
            ,
              sa  = this.startAngle          // Previous start angle
            ,
              sat = this.startAngle         // Start angle
            ,
              ea                            // Previous end angle
            ,
              eat = sat + a                 // End angle
            ,
              r   = true

          this.g.lineWidth = this.lineWidth

          this.o.cursor
          && (sat = eat - 0.3)
          && (eat = eat + 0.3)

          if (this.o.displayPrevious) {
            ea = this.startAngle + this.angle(this.value)
            this.o.cursor
            && (sa = ea - 0.3)
            && (ea = ea + 0.3)
            this.g.beginPath()
            this.g.strokeStyle = this.previousColor
            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false)
            this.g.stroke()
          }

          this.g.beginPath()
          this.g.strokeStyle = r ? this.o.fgColor : this.fgColor
          this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false)
          this.g.stroke()

          this.g.lineWidth = 2
          this.g.beginPath()
          this.g.strokeStyle = this.o.fgColor
          this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false)
          this.g.stroke()

          return true
        }
      }
    }).trigger(
        'configure',
        {
            "cursor":false,
            "readonly":true
        }
    )
    /* END JQUERY KNOB */

        
    /*
     * Flot Interactive Chart
     * -----------------------
     */
     var options = {
      grid: {
        borderColor: '#f3f3f3',
        borderWidth: 1,
        tickColor: '#f3f3f3'
      },
      series: {
        color: '#3c8dbc',
        lines: {
          show: true,
          fill: true,
          step:true
        },
      },
      yaxis: {
        min: 0,
        max: 100,
        show: true
      },
      xaxis: {
        mode: "categories",
        showTicks: false,
        gridLines: false
      }
    };
     data2 = [];
      alreadyFetched = {};

      $.plot("#interactive2", data2, options);

      var iteration = 0;

      function fetchData() {

        ++iteration;

        function onDataReceived(series) {

          // Load all the data in one pass; if we only got partial
          // data we could merge it with what we already have.

          data2 = [ series ];
          $.plot("#interactive2", data2, options);
        }

        // Normally we call the same URL - a script connected to a
        // database - but in this case we only have static example
        // files, so we need to modify the URL.

        $.ajax({
          url: "http://10.3.6.2/data/main/hd_1",
          type: "GET",
          dataType: "json",
          success: onDataReceived
        });

        if (iteration < 1) {
          setTimeout(fetchData, 1000);
        } else {
          data2 = [];
          alreadyFetched = {};
        }
      }

      setTimeout(fetchData, 1000);
    // We use an inline data source in the example, usually data would
    // be fetched from a server
    var data        = [],
        totalPoints = 100

    function getRandomData() {

      if (data.length > 0) {
        data = data.slice(1)
      }

      // Do a random walk
      while (data.length < totalPoints) {

        var prev = data.length > 0 ? data[data.length - 1] : 50,
            y    = prev + Math.random() * 10 - 5

        if (y < 0) {
          y = 0
        } else if (y > 100) {
          y = 100
        }

        data.push(y)
      }

      // Zip the generated y values with the x values
      var res = []
      for (var i = 0; i < data.length; ++i) {
        res.push([i, data[i]])
      }

      return res
    }

    var interactive_plot = $.plot('#interactive', [
        {
          data: getRandomData(),
        }
      ],
      {
        grid: {
          borderColor: '#f3f3f3',
          borderWidth: 1,
          tickColor: '#f3f3f3'
        },
        series: {
          color: '#3c8dbc',
          lines: {
            lineWidth: 2,
            show: true,
            fill: false,
          },
        },
        yaxis: {
          min: 0,
          max: 100,
          show: true
        },
        xaxis: {
          show: true
        }
      }
    )

    var updateInterval = 1000 //Fetch data ever x milliseconds
    var realtime       = 'on' //If == to on then fetch data every x seconds. else stop fetching
    function update() {

      interactive_plot.setData([getRandomData()])

      // Since the axes don't change, we don't need to call plot.setupGrid()
      interactive_plot.draw()
      if (realtime === 'on') {
        setTimeout(update, updateInterval)
      }
    }

    //INITIALIZE REALTIME DATA FETCHING
    if (realtime === 'on') {
      update()
    }
    /*
     * END INTERACTIVE CHART
     */

     


  })




/////////////////var
  //var oee = <?php echo $result1->t_oee_id ?>;
  //var pr  = <?php echo $result2->t_productivity_id ?>;
  //var out = <?php echo $result3->t_output_id ?>;
  var mc  = <?php echo $rolling ?>;
  var ws;
  var wsUria = "ws://10.3.6.2:1880";   //change with your ip node red
  var loc = window.location;
  console.log(loc);
  if (loc.protocol === "https:") { wsUria = "wss:"; }
  // This needs to point to the web socket in the Node-RED flow
  // ... in this case it's ws/simple
  //wsUri += "//" + loc.host + loc.pathname.replace("simple","ws/simple");
  wsUri = wsUria+"/"+("rl"+mc,"ws/rl"+mc); //wsUri = wsUria+"/"+("hd2","ws/hd2"); wsUri = wsUria+"/"+("rl1","ws/rl1");
  function wsConnect() {
      console.log("connect",wsUri);
      ws = new WebSocket(wsUri);
      //var line = "";    // either uncomment this for a building list of messages
      ws.onmessage = function(msg) {
          var line = "";  // or uncomment this to overwrite the existing message
          // parse the incoming message as a JSON object
          var data = msg.data;
          var obj = JSON.parse(data);
          //console.log(msg);
          // build the output from the topic and payload parts of the object
          line += "<p>"+obj.datetime+"</p>";
          // replace the messages div with the new "line"
          document.getElementById('datetime').innerHTML = obj.datetime;
          document.getElementById('totaltime').innerHTML = obj.totaltime;
          document.getElementById('runtime').innerHTML = obj.runtime;
          document.getElementById('downtime').innerHTML = obj.downtime;
          if(obj.status=="RUNNING"){
            document.getElementById('status').innerHTML = obj.status;
            document.getElementById('status').className = "float-right badge bg-success";
          }
          else if(obj.status=="STOP"){
            document.getElementById('status').innerHTML = obj.status;
            document.getElementById('status').className = "float-right badge bg-danger";
          }
          else{
            document.getElementById('status').innerHTML = obj.status;
            document.getElementById('status').className = "float-right badge bg-warning";
          }
          document.getElementById('totalpcs').innerHTML = obj.totalpcs.toLocaleString("id-ID");
          document.getElementById('totalbox').innerHTML = obj.totalbox.toLocaleString("id-ID");
          document.getElementById('stdbox').innerHTML = 'Qty ('+obj.stdbox.toLocaleString("id-ID")+' Pcs/Box)';
          $("#pcsbox").trigger('configure',{"max":obj.stdbox});
          document.getElementById('pcsbox').value = obj.pcsbox;
         // $("#pcsbox").trigger('change');
          document.getElementById('average').value = obj.average;
          document.getElementById('product').innerHTML = obj.product;
          
          $("input.knob").trigger('change');
          //ws.send(JSON.stringify({data:data}));
      }
      ws.onopen = function() {
          // update the status div with the connection status
          //document.getElementById('status').innerHTML = "connected";
          //document.getElementById('status').className = "info-box-icon bg-success";
          //ws.send("Open for data");
          console.log("connected");
      }
      ws.onclose = function() {
          // update the status div with the connection status
          //document.getElementById('status').innerHTML = "not connected";
          //document.getElementById('status').className = "info-box-icon bg-danger";
          // in case of lost connection tries to reconnect every 3 secs
          setTimeout(wsConnect,3000);
      }

      
  }
  
  function doit(m) {
      if (ws) { ws.send(m); }
  }

////////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////-------------OCC----------//////////////////////////////////////////////

// HIGHCHARTS BAR 

Highcharts.setOptions({
    lang: {
        decimalPoint: ',',
        thousandsSep: '.'
    }
});
var chart = new Highcharts.chart('highcharts', {
    title: {
      text: 'Daily'
    },
    xAxis: {
            categories:  <?php echo json_encode($bulan);?>
    },
    yAxis: {
      title: {
        text: '%'
      }
    },
    exporting: { 
            enabled: false 
    },
    series: [{
      type: 'column',
      name: 'ACTUAL',
      data: <?php echo json_encode($value);?>,
            shadow : true,
            dataLabels: {
                enabled: true,
                color: '#045396',
                align: 'center',
                formatter: function() {
                     return Highcharts.numberFormat(this.y, 1);
                }, // one decimal
                y: -25, // 10 pixels down from the top
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
    }, {
      type: 'line',
      name: 'TARGET',
      data: [80, 80, 80, 80, 80],
      marker: {
        lineWidth: 2,
        lineColor: Highcharts.getOptions().colors[3],
        fillColor: 'white'
      }
    }, {
      type: 'line',
      name: 'IDEAL',
      data: [85, 85, 85, 85, 85],
      marker: {
        lineWidth: 2,
        lineColor: Highcharts.getOptions().colors[3],
        fillColor: 'white'
      }
    }]
  });



//////////////////////////////////////////--------- PRODUCTIVITY----------------///////////////////////////////////////////

Highcharts.setOptions({
    lang: {
        decimalPoint: ',',
        thousandsSep: '.'
    }
});
var chart = new Highcharts.chart('highcharts_p', {
    title: {
      text: 'Daily'
    },
    xAxis: {
            categories:  <?php echo json_encode($bulan_p);?>
    },
    yAxis: {
      title: {
        text: '%'
      }
    },
    exporting: { 
            enabled: false 
    },
    series: [{
      type: 'column',
      name: 'ACTUAL',
      data: <?php echo json_encode($value_p);?>,
            shadow : true,
            dataLabels: {
                enabled: true,
                color: '#045396',
                align: 'center',
                formatter: function() {
                     return Highcharts.numberFormat(this.y, 1);
                }, // one decimal
                y: -25, // 10 pixels down from the top
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
    }, {
      type: 'line',
      name: 'TARGET',
      data: [5.2, 5.2, 5.2, 5.1, 5.2],
      marker: {
        lineWidth: 2,
        lineColor: Highcharts.getOptions().colors[3],
        fillColor: 'white'
      }
    }, {
      type: 'line',
      name: 'IDEAL',
      data: [5.7, 5.7, 5.7, 5.7, 5.7],
      marker: {
        lineWidth: 2,
        lineColor: Highcharts.getOptions().colors[3],
        fillColor: 'white'
      }
    }]
  });
//////////////////////////////////------------- OUTPUT -------------------////////////////////////////////////////

Highcharts.setOptions({
    lang: {
        decimalPoint: ',',
        thousandsSep: '.'
    }
});
var chart = new Highcharts.chart('highcharts_output', {
    title: {
      text: 'Daily'
    },
    xAxis: {
            categories:  <?php echo json_encode($bulan_o);?>
    },
    yAxis: {
      title: {
        text: '%'
      }
    },
    exporting: { 
            enabled: false 
    },
    series: [{
      type: 'column',
      name: 'ACTUAL',
      data: <?php echo json_encode($value_o);?>,
            shadow : true,
            dataLabels: {
                enabled: true,
                color: '#045396',
                align: 'center',
                formatter: function() {
                     return Highcharts.numberFormat(this.y, 1);
                }, // one decimal
                y: -25, // 10 pixels down from the top
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
    }, {
      type: 'line',
      name: 'TARGET',
      data: [5.2, 5.2, 5.2, 5.1, 5.2],
      marker: {
        lineWidth: 2,
        lineColor: Highcharts.getOptions().colors[3],
        fillColor: 'white'
      }
    }, {
      type: 'line',
      name: 'IDEAL',
      data: [5.7, 5.7, 5.7, 5.7, 5.7],
      marker: {
        lineWidth: 2,
        lineColor: Highcharts.getOptions().colors[3],
        fillColor: 'white'
      }
    }]
  });
//////////////////////////////////------------- WORKING HOUR -------------------////////////////////////////////////////

Highcharts.setOptions({
    lang: {
        decimalPoint: ',',
        thousandsSep: '.'
    }
});
var chart = new Highcharts.chart('highcharts_wh', {
    title: {
      text: 'Daily'
    },
    xAxis: {
            categories:  <?php echo json_encode($bulan_wh);?>
    },
    yAxis: {
      title: {
        text: '%'
      }
    },
    exporting: { 
            enabled: false 
    },
    series: [{
      type: 'column',
      name: 'ACTUAL',
      data: <?php echo json_encode($value_wh);?>,
            shadow : true,
            dataLabels: {
                enabled: true,
                color: '#045396',
                align: 'center',
                formatter: function() {
                     return Highcharts.numberFormat(this.y, 1);
                }, // one decimal
                y: -25, // 10 pixels down from the top
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
    }, {
      type: 'line',
      name: 'TARGET',
      data: [5.2, 5.2, 5.2, 5.1, 5.2],
      marker: {
        lineWidth: 2,
        lineColor: Highcharts.getOptions().colors[3],
        fillColor: 'white'
      }
    }, {
      type: 'line',
      name: 'IDEAL',
      data: [5.7, 5.7, 5.7, 5.7, 5.7],
      marker: {
        lineWidth: 2,
        lineColor: Highcharts.getOptions().colors[3],
        fillColor: 'white'
      }
    }]
  });
//////////////////////////////////////////////////////////////////////////////////////////////////////


$(document).ready(function(){
    $(function() {
        setInterval( function(){
        var $active = $('#accordion .collapse.in');
        var $parent = $active.closest('.panel');
        $active.collapse('hide');
        if ($parent.is('#accordion .panel:last')) {
            $('#accordion .panel:first').find('.collapse').collapse('toggle');
        } else {
            $parent.next().find('.collapse').collapse('toggle');
        }
        }, 10000 );
    }); 
});

</script>
</body>
</html>