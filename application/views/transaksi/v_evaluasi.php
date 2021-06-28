<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
    $.extend($.fn.datebox.defaults,{
        formatter:function(date){
            var y = date.getFullYear();
            var m = date.getMonth()+1;
            var d = date.getDate();
            return y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d);
        },
        parser:function(s){
            if (!s) return new Date();
            var ss = (s.split('-'));
            var y = parseInt(ss[0],10);
            var m = parseInt(ss[1],10);
            var d = parseInt(ss[2],10);
            if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
                return new Date(y,m-1,d);
            } else {
                return new Date();
            }
        }
    });
</script>
<!-- Data Grid -->
<table id="grid-transaksi_evaluasi"
    data-options="pageSize:50, multiSort:true, remoteSort:true, rownumbers:true, singleSelect:true, 
                fit:true, fitColumns:true, toolbar:toolbar_transaksi_evaluasi">
    <thead>
        <tr>
            <th data-options="field:'ck',checkbox:true" ></th>
            <th data-options="field:'t_evaluasi_id'"  width="50" halign="center" align="center" sortable="true">ID</th>
            <th data-options="field:'departemen_nama'"  width="150" halign="center" align="center" sortable="true">Departemen</th>
            <th data-options="field:'m_materi_nama'"  width="300" halign="center" align="center" sortable="true">Materi</th>
            <th data-options="field:'t_evaluasi_tgl_pelatihan'"  width="120" halign="center" align="center" sortable="true">Tgl Pelatihan</th>
            <th data-options="field:'t_evaluasi_tgl_test_tertulis'"  width="120" halign="center" align="center" sortable="true">Tgl Test Tertulis</th>
            <th data-options="field:'m_emply_name'"  width="400" halign="center" align="center" sortable="true">Nama Peserta</th>
            <th data-options="field:'m_standar_nilai_range'"  width="120" halign="center" align="center" sortable="true">Std Nilai</th>
            <th data-options="field:'t_evaluasi_pengetahuan_materi'"  width="120" halign="center" align="center" sortable="true">Pengetahuan Materi</th>
            <th data-options="field:'t_evaluasi_penerapan_lap'"  width="120" halign="center" align="center" sortable="true">Penerapan di Lapangan</th>
            <th data-options="field:'t_evaluasi_peningkatan_kinerja'"  width="120" halign="center" align="center" sortable="true">Peningkatan Kinerja</th>
			  <th data-options="field:'status'"  width="120" halign="center" align="center" sortable="true">Status</th>
            <th data-options="field:'t_evaluasi_keterangan'"  width="200" halign="center" align="center" sortable="true">Keterangan</th>
            
        </tr>
    </thead>
</table>

<script type="text/javascript">
    var toolbar_transaksi_evaluasi = [{
        id      : 'transaksi_evaluasi-edit',
        text    : 'Edit',
        iconCls : 'icon-edit',
        handler : function(){transaksiEvaluasiUpdate();}
    },{
        id      : 'transaksi_evaluasi-updatedatatahunan',
        text    : 'Update Data Tahunan',
        iconCls : 'icon-flow',
        handler : function(){transaksiUpdateDataTahunan();}
    },{
        text    : 'Refresh',
        iconCls : 'icon-reload',
        handler : function(){transaksiEvaluasiRefresh();}
    }];
    
    $('#grid-transaksi_evaluasi').datagrid({
        onLoadSuccess   : function(){
            $('#transaksi_evaluasi-edit').linkbutton('disable');
            $('#transaksi_evaluasi-delete').linkbutton('disable');
        },
        onSelect        : function(){
            $('#transaksi_evaluasi-edit').linkbutton('enable');
            $('#transaksi_evaluasi-delete').linkbutton('enable');
        },
        onClickRow      : function(){
            $('#transaksi_evaluasi-edit').linkbutton('enable');
            $('#transaksi_evaluasi-delete').linkbutton('enable');
        },
        onDblClickRow   : function(){
            transaksiPesertakpdUpdate();
        },
        rowStyler: function(index,row){
            if (row['t_evaluasi_peningkatan_kinerja'] <1){
                return 'background-color:#FFB6C1;color:#000;';
            }
            if (row['t_evaluasi_peningkatan_kinerja'] ){
                return 'background-color:#D1FFB3;color:#000;';
            }
	},
        view            :scrollview,
        remoteFilter    :true,
        url             :'<?php echo site_url('transaksi/evaluasi/index'); ?>?grid=true'})
    .datagrid('enableFilter');
	
	function status(value, row, index) {
        if (row.t_evaluasi_pengetahuan_materi >= row.m_std_nilai_pelatihan_nilai) {
            return "LULUS";
        } else {
            return "GAGAL";
        }
    }

    function transaksiEvaluasiRefresh() {
        $('#transaksi_evaluasi-edit').linkbutton('disable');
        $('#transaksi_karawan-delete').linkbutton('disable');
        $('#grid-transaksi_evaluasi').datagrid('reload');
    }
   
    function transaksiEvaluasiUpdate() {
        var row = $('#grid-transaksi_evaluasi').datagrid('getSelected');
        if(row){
            $('#dlg-transaksi_evaluasi').dialog({modal: true}).dialog('open').dialog('setTitle','Edit Data');
            $('#fm-transaksi_evaluasi').form('load',row);
            
            
            urlupeval = '<?php echo site_url('transaksi/evaluasi/update'); ?>/' + row.t_evaluasi_id;
            //$('#m_emply_name').textbox('disable');
            //$('#t_schedule_proposal').combobox({readonly:true});
        }
        else
        {
             $.messager.alert('Info','Data belum dipilih !','info');
        }
    }
    
    function transaksiEvaluasiSave(){
        $.messager.progress({
            title:'Dagoan Sakedeung',
            msg:'Nendeun Data...'
        });
        $('#fm-transaksi_evaluasi').form('submit',{
            url: urlupeval,
            onSubmit: function(){
                return $(this).form('validate');
            },
            success: function(result){
                $.messager.progress('close');
                var result = eval('('+result+')');
                if(result.success) 
                {
                    $('#dlg-transaksi_evaluasi').dialog('close');
                    transaksiEvaluasiRefresh();
                    $.messager.show({
                        title   : 'Info',
                        msg     : 'Data Berhasil Disimpan'
                    });
                }
                else
                {
                    $.messager.show({
                        title   : 'Error',
                        msg     : 'Input Data Gagal'
                    });
                }
            }
        });
    }
    
    function transaksiUpdateDataTahunan(){
        $('#dlg-transaksi_updatedatathn').dialog({modal: true}).dialog('open').dialog('setTitle','Update Data Tahunan');
        $('#fm-transaksi_updatedatathn').form('clear');
        urlupdatethn = '<?php echo site_url('transaksi/evaluasi/tutuptahun'); ?>';
    }
    
    function transaksiUpdateDataTahunSave(){
        $.messager.progress({
            title:'Dagoan Sakedeung',
            msg:'Nendeun Data...'
        });
        $('#fm-transaksi_updatedatathn').form('submit',{
            url: urlupdatethn,
            onSubmit: function(){
                return $(this).form('validate');
            },
            success: function(result){
                $.messager.progress('close');
                var result = eval('('+result+')');
                if(result.success) 
                {
                    $('#dlg-transaksi_updatedatathn').dialog('close');
                    transaksiEvaluasiRefresh();
                    $.messager.show({
                        title   : 'Info',
                        msg     : 'Data Berhasil Disimpan'
                    });
                }
                else
                {
                    $.messager.show({
                        title   : 'Error',
                        msg     : 'Input Data Gagal'
                    });
                }
            }
        });
    }
  

  function calcEvalFinish(){
		//alert();
                    var mat                = $('#t_evaluasi_pengetahuan_mat').numberbox('getValue');
                    var lap                = $('#t_evaluasi_penerapan_lapang').numberbox('getValue');
                    var kin                = (eval(mat)+eval(lap));
                    $('#t_evaluasi_peningkatan_kin').numberbox('setValue', kin);
                    

    }
    
    function formatPrice(val,row){
        if (row.t_evaluasi_pengetahuan_materi >= row.m_standar_nilai_min){
            return 'LULUS';
        } else {
            return 'GAGAL';
        }
    }

    
</script>

<style type="text/css">
    .bg-error{ 
        background: red;
    }
    .bg-error .panel-title{
        color:#fff;
    }
    .bg-warning{ 
        background: yellow;
    }
    .bg-warning .panel-title{
        color:#000;
    }
    #fm-transaksi_pesertakpd{
        margin:0;
        padding:10px 30px;
    }
    #fm-transaksi_pesertakpd-upload{
        margin:0;
        padding:10px 30px;
    }
    .ftitle{
        font-size:14px;
        font-weight:bold;
        padding:5px 0;
        margin-bottom:10px;
        border-bottom:1px solid #ccc;
    }
    .fitem{
        margin-bottom:5px;
    }
    .fitem label{
        display:inline-block;
        width:100px;
    }
    .fitem input{
        display:inline-block;
        width:150px;
    }
</style>

<!-- ----------- -->
<div id="dlg-transaksi_evaluasi" class="easyui-dialog" style="width:600px; height:400px; padding: 10px 20px" closed="true" buttons="#dlg-buttons-transaksi_evaluasi">
    <form id="fm-transaksi_evaluasi" method="post" novalidate>        
         
        <div class="fitem">
            <label for="type">Pengetahuan Materi</label>
            <input type="text" id="t_evaluasi_pengetahuan_mat" name="t_evaluasi_pengetahuan_materi" class="easyui-numberbox" min=10" max=100"/>
        </div>
        <div class="fitem">
            <label for="type">Penerapan di lapangan</label>
            <input type="text" id="t_evaluasi_penerapan_lapang" name="t_evaluasi_penerapan_lap" class="easyui-numberbox" min=10" max=100"/>
        </div>
        <div class="fitem">
            <label for="type">Peningkatan Kinerja</label>
            <input type="text" id="t_evaluasi_peningkatan_kin" name="t_evaluasi_peningkatan_kinerja" class="easyui-numberbox"/>
             <a id="button_calcEvalFinish" href="javascript:calcEvalFinish()" class="easyui-linkbutton easyui-tooltip"  
                    title="Generate Nilai." iconCls="icon-calculator" plain="true" data-options="position:'right'" onclick=""></a>
        </div>
        <div class="fitem">
            <label for="type"> Keterangan</label>
            <input type="text" id="t_evaluasi_keterangan" name="t_evaluasi_keterangan" class="easyui-textbox"  style="width:50%;height:50px" multiline="true"/>
        </div>
    </form>
</div>

<!-- Dialog Button -->
<div id="dlg-buttons-transaksi_evaluasi">
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-ok" onclick="transaksiEvaluasiSave()">Simpan</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-cancel" onclick="javascript:$('#dlg-transaksi_evaluasi').dialog('close')">Batal</a>
</div>

<!-- Update Data Tahunan -->

<div id="dlg-transaksi_updatedatathn" class="easyui-dialog" style="width:400px; height:150px; padding: 10px 20px" closed="true" buttons="#dlg-buttons-transaksi_updatedatathn">
    <form id="fm-transaksi_updatedatathn" method="post" novalidate>        
         
        <div class="fitem">
            <label for="type">Tahun</label>
            <input type="text" id="tahun" name="tahun" class="easyui-numberspinner" value=<?php echo date("Y"); ?> min=<?php echo date("Y")-2; ?> max=<?php echo date("Y"); ?>/>
        </div>
        
    </form>
</div>

<!-- Dialog Button -->
<div id="dlg-buttons-transaksi_updatedatathn">
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-ok" onclick="transaksiUpdateDataTahunSave()">Simpan</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-cancel" onclick="javascript:$('#dlg-transaksi_updatedatathn').dialog('close')">Batal</a>
</div>

<!-- End of file v_evaluasi.php -->
<!-- Location: ./application/views/transaksi/v_pesertakpd.php -->