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
<table id="grid-transaksi_schedule"
    data-options="pageSize:50, multiSort:true, remoteSort:true, rownumbers:true, singleSelect:true, 
                fit:true, fitColumns:true, toolbar:toolbar_transaksi_schedule">
    <thead>
        <tr>
            <th data-options="field:'ck',checkbox:true" ></th>
            <th data-options="field:'t_proposal_tahun'"    width="70" align="center" sortable="true">Tahun</th>
            <th data-options="field:'t_proposal_periode'"  width="70" align="center" align="center" sortable="true">Periode</th>
            <th data-options="field:'t_schedule_tgl'"    width="100" align="center" sortable="true">Tanggal 1</th>
            <th data-options="field:'t_schedule_waktu_dari'"  width="100" align="center" align="center" sortable="true">Waktu 1</th>
            <th data-options="field:'t_schedule_waktu_sampai'"  width="100" align="center" align="center" sortable="true">Sampai 1</th>
            <th data-options="field:'t_schedule_tgl2'"    width="100" align="center" sortable="true">Tanggal 2</th>
            <th data-options="field:'t_schedule_waktu_dari2'"  width="100" align="center" align="center" sortable="true">Waktu 2</th>
            <th data-options="field:'t_schedule_waktu_sampai2'"  width="100" align="center" align="center" sortable="true">Sampai 2</th>
            <th data-options="field:'m_tempat_nama'"  width="100" halign="center" align="center" sortable="true">Tempat</th>
            <th data-options="field:'departemen_nama'"  width="250" halign="center" align="center" sortable="true">Dept</th>
            <th data-options="field:'t_proposal_instruktur'"  width="200" halign="center" align="center" sortable="true">Instruktur</th>
            <th data-options="field:'m_materi_nama'"  width="300" halign="center" align="center" sortable="true">Materi</th>
            <th data-options="field:'m_emply_name'"  width="300" halign="center" align="center" sortable="true">Peserta</th>
            <th data-options="field:'t_schedule_aktual'"  width="120" halign="center" align="center" sortable="true">Aktual</th>
        </tr>
    </thead>
</table>

<script type="text/javascript">
    var toolbar_transaksi_schedule = [{
        id      : 'transaksi_schedule-new',
        text    : 'New',
        iconCls : 'icon-new_file',
        handler : function(){transaksiScheduleCreate();}
    },{
        id      : 'transaksi_schedule-edit',
        text    : 'Edit',
        iconCls : 'icon-edit',
        handler : function(){transaksiScheduleUpdate();}
    },{
        id      : 'transaksi_schedule-delete',
        text    : 'Delete',
        iconCls : 'icon-cancel',
        handler : function(){transaksiScheduleHapus();}
    },{
        id      : 'transaksi_schedule-buat_evaluasi',
        text    : 'Buat Evaluasi',
        iconCls : 'icon-flow',
        handler : function(){transaksiScheduleEvaluasi();}
    },{
        text    : 'Refresh',
        iconCls : 'icon-reload',
        handler : function(){transaksiScheduleRefresh();}
    }];
    
    $('#grid-transaksi_schedule').datagrid({
        onLoadSuccess   : function(){
            $('#transaksi_schedule-edit').linkbutton('disable');
            $('#transaksi_schedule-delete').linkbutton('disable');
            $('#transaksi_schedule-buat_evaluasi').linkbutton('disable');
        },
        onSelect        : function(){
            $('#transaksi_schedule-edit').linkbutton('enable');
            $('#transaksi_schedule-delete').linkbutton('enable');
            $('#transaksi_schedule-buat_evaluasi').linkbutton('enable');
        },
        onClickRow      : function(){
            $('#transaksi_schedule-edit').linkbutton('enable');
            $('#transaksi_schedule-delete').linkbutton('enable');
            $('#transaksi_schedule-buat_evaluasi').linkbutton('enable');
            
        },
        rowStyler: function(index,row){
            if (row['t_schedule_aktual']=='0000-00-00'){
                return 'background-color:#FFB6C1;color:#000;';
            }
            if (row['t_schedule_aktual'] ){
                return 'background-color:#D1FFB3;color:#000;';
            }
	},
        view            :scrollview,
        remoteFilter    :true,
        url             :'<?php echo site_url('transaksi/schedule/index'); ?>?grid=true'})
    .datagrid('enableFilter');

    function transaksiScheduleRefresh() {
        $('#transaksi_schedule-edit').linkbutton('disable');
        $('#transaksi_karawan-delete').linkbutton('disable');
        $('#grid-transaksi_schedule').datagrid('reload');
    }
    
    function transaksiScheduleCreate(){
        $('#dlg-transaksi_schedule').dialog({modal: true}).dialog('open').dialog('setTitle','Tambah Data');
        $('#fm-transaksi_schedule').form('clear');
        url = '<?php echo site_url('transaksi/schedule/create'); ?>';
    }

    function transaksiScheduleUpdate() {
        var row = $('#grid-transaksi_schedule').datagrid('getSelected');
        if(row){
            $('#dlg-edittransaksi_schedule').dialog({modal: true}).dialog('open').dialog('setTitle','Edit Data');
            $('#fm-edittransaksi_schedule').form('load',row);
            urledit = '<?php echo site_url('transaksi/schedule/update'); ?>/' + row.t_schedule_id;
            $('#t_schedule_tgl2').datebox('clear');
            $('#t_schedule_waktu_dari2').timespinner('clear');
            $('#t_schedule_waktu_sampai2').timespinner('clear');
        }
        else
        {
             $.messager.alert('Info','Data belum dipilih !','info');
        }
    }
    
    function transaksiScheduleSave(){
        $.messager.progress({
            title:'Dagoan Sakedeung',
            msg:'Nendeun Data...'
        });
        $('#fm-transaksi_schedule').form('submit',{
            url: url,
            onSubmit: function(){
                return $(this).form('validate');
            },
            success: function(result){
                $.messager.progress('close');
                var result = eval('('+result+')');
                if(result.success) 
                {
                    $('#t_schedule_proposal').combogrid('clear');
                    transaksiScheduleRefresh();
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
    
    function transaksiEditScheduleSave(){
        $.messager.progress({
            title:'Dagoan Sakedeung',
            msg:'Nendeun Data...'
        });
        $('#fm-edittransaksi_schedule').form('submit',{
            url: urledit,
            onSubmit: function(){
                return $(this).form('validate');
            },
            success: function(result){
                $.messager.progress('close');
                var result = eval('('+result+')');
                if(result.success) 
                {
                    $('#dlg-edittransaksi_schedule').dialog('close');
                    transaksiScheduleRefresh();
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
        
   function transaksiScheduleHapus(){
        $.messager.progress({
            title:'Dagoan Sakedeung',
            msg:'Pupus Data...'
        });
        var row = $('#grid-transaksi_schedule').datagrid('getSelected');
        if (row){
            var win = $.messager.confirm('Konfirmasi','Anda yakin ingin menghapus \n'+row.t_schedule_id+' ?',function(r){
                if (r){
                    $.post('<?php echo site_url('transaksi/schedule/delete'); ?>',{t_schedule_id:row.t_schedule_id, t_schedule_proposal:row.t_schedule_proposal},function(result){
                        $.messager.progress('close');
                        if (result.success)
                        {
                            transaksiScheduleRefresh();
                            $.messager.show({
                                title   : 'Info',
                                msg     : '<div class="messager-icon messager-info"></div><div>Data Berhasil Dihapus</div>'
                    });
                        }
                        else
                        {
                            $.messager.show({
                                title   : 'Error',
                                msg     : '<div class="messager-icon messager-error"></div><div>Data Gagal Dihapus !</div>'+result.error
                            });
                        }
                    },'json');
                }
            });
            win.find('.messager-icon').removeClass('messager-question').addClass('messager-warning');
            win.window('window').addClass('bg-warning');
        }
        else
        {
             $.messager.alert('Info','Data belum dipilih !','info');
        }
    }
    
  function ReloadGrid(){
	$('#grid-transaksi_schedule').datagrid('reload');	

    }

    
    function transaksiScheduleEvaluasi() {
        var row = $('#grid-transaksi_schedule').datagrid('getSelected');
        if(row){
            $('#dlg-transaksi_Schedule_evaluasi').dialog({modal: true}).dialog('open').dialog('setTitle','Buat Evaluasi');
            $('#fm-transaksi_Schedule_evaluasi').form('load',row); 
            urleval = '<?php echo site_url('transaksi/schedule/createeval'); ?>/' + row.t_schedule_id+'_'+row.m_emply_nik+'_'+row.m_materi_no; 
        }
        else
        {
             $.messager.alert('Info','Data belum dipilih !','info');
        }
    }
    
  function transaksiScheduleEvaluasiSave(){
        $.messager.progress({
            title:'Dagoan Sakedeung',
            msg:'Nendeun Data...'
        });
        $('#fm-transaksi_Schedule_evaluasi').form('submit',{
            url: urleval,
            onSubmit: function(){
                return $(this).form('validate');
            },
            success: function(result){
                $.messager.progress('close');
                var result = eval('('+result+')');
                if(result.success) 
                {
                    $('#dlg-transaksi_Schedule_evaluasi').dialog('close');
                    transaksiScheduleRefresh();
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
    
    function calcFinishSch(){
		//alert();
                    var materi                = $('#t_evaluasi_pengetahuan_materi').numberbox('getValue');
                    var lapangan              = $('#t_evaluasi_penerapan_lap').numberbox('getValue');
                    var kinerja               = (eval(materi)+eval(lapangan));
                    $('#t_evaluasi_peningkatan_kinerja').numberbox('setValue', kinerja);
                    

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
<div id="dlg-transaksi_schedule" class="easyui-dialog" style="width:600px; height:300px; padding: 10px 20px" closed="true" buttons="#dlg-buttons-transaksi_schedule">
    <form id="fm-transaksi_schedule" method="post" novalidate>        

        <div class="fitem">
            <label for="type">Tanggal 1</label>
            <input type="text" id="t_schedule_tgl" name="t_schedule_tgl" class="easyui-datebox"/>
            <label for="type">Tanggal 2</label>
            <input type="text" id="t_schedule_tgl2" name="t_schedule_tgl2" class="easyui-datebox"/>
        </div>
        <div class="fitem">
            <label for="type">Waktu Dari 1</label>
            <input type="text" id="t_schedule_waktu_dari" name="t_schedule_waktu_dari" class="easyui-timespinner"/>
            <label for="type">Waktu Dari 2</label>
            <input type="text" id="t_schedule_waktu_dari2" name="t_schedule_waktu_dari2" class="easyui-timespinner"/>
        </div>
        <div class="fitem">
            <label for="type">Waktu Sampai 1</label>
            <input type="text" id="t_schedule_waktu_sampai" name="t_schedule_waktu_sampai" class="easyui-timespinner"/>
            <label for="type">Waktu Sampai 2</label>
            <input type="text" id="t_schedule_waktu_sampai2" name="t_schedule_waktu_sampai2" class="easyui-timespinner"/>
        </div>
        <div class="fitem">
            <label for="type">Tempat </label>
            <input type="text" id="t_schedule_tempat" name="t_schedule_tempat" style="width:155px;" class="easyui-combobox" 
            data-options="url:'<?php echo site_url('transaksi/schedule/getTemp'); ?>',
            method:'get', valueField:'m_tempat_id', textField:'m_tempat_nama', panelHeight:'150'"/>
        </div>
        <div class="fitem">
            <label for="type">Peserta</label>
            <select id="t_schedule_proposal" name="t_schedule_proposal" class="easyui-combogrid" style="width:155px;" data-options="
                panelWidth: 800,
                idField: 't_proposal_id',
                textField: 'm_emply_name',
                url: '<?php echo site_url('transaksi/schedule/getProposal'); ?>',
                method: 'get',
                mode:'remote',
                columns: [[
                    {field:'t_proposal_id',title:'ID',width:15},
                    {field:'t_proposal_instruktur',title:'Instruktur',width:100},
                    {field:'m_materi_nama',title:'Materi',width:100},
                    {field:'m_emply_name',title:'Nama Peserta',width:100,sortable:true},
                    {field:'departemen_nama',title:'Departemen',width:100}
                ]],
                fitColumns: true,
                onShowPanel: function(){
                    $('#t_schedule_proposal').combogrid('grid').datagrid('reload');
                }
            ">
            </select>
        </div>

    </form>
</div>

<!-- Dialog Button -->
<div id="dlg-buttons-transaksi_schedule">
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-ok" onclick="transaksiScheduleSave()">Simpan</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-cancel" onclick="javascript:$('#dlg-transaksi_schedule').dialog('close')">Batal</a>
</div>

<!-- Form Edit -->

<div id="dlg-edittransaksi_schedule" class="easyui-dialog" style="width:600px; height:300px; padding: 10px 20px" closed="true" buttons="#dlg-buttons-edittransaksi_schedule">
    <form id="fm-edittransaksi_schedule" method="post" novalidate>        

        <div class="fitem">
            <label for="type">Tanggal 1</label>
            <input type="text" id="t_schedule_tgl" name="t_schedule_tgl" class="easyui-datebox"/>
            <label for="type">Tanggal 2</label>
            <input type="text" id="t_schedule_tgl2" name="t_schedule_tgl2" class="easyui-datebox"/>
        </div>
        <div class="fitem">
            <label for="type">Waktu Dari 1</label>
            <input type="text" id="t_schedule_waktu_dari" name="t_schedule_waktu_dari" class="easyui-timespinner"/>
            <label for="type">Waktu Dari 2</label>
            <input type="text" id="t_schedule_waktu_dari2" name="t_schedule_waktu_dari2" class="easyui-timespinner"/>
        </div>
        <div class="fitem">
            <label for="type">Waktu Sampai 1</label>
            <input type="text" id="t_schedule_waktu_sampai" name="t_schedule_waktu_sampai" class="easyui-timespinner"/>
            <label for="type">Waktu Sampai 2</label>
            <input type="text" id="t_schedule_waktu_sampai2" name="t_schedule_waktu_sampai2" class="easyui-timespinner"/>
        </div>
        <div class="fitem">
            <label for="type">Tempat </label>
            <input type="text" id="t_schedule_tempat" name="t_schedule_tempat" style="width:155px;" class="easyui-combobox" 
            data-options="url:'<?php echo site_url('transaksi/schedule/getTemp'); ?>',
            method:'get', valueField:'m_tempat_id', textField:'m_tempat_nama', panelHeight:'150'"/>
        </div>
    </form>
</div>

<!-- Dialog Button -->
<div id="dlg-buttons-edittransaksi_schedule">
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-ok" onclick="transaksiEditScheduleSave()">Simpan</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-cancel" onclick="javascript:$('#dlg-edittransaksi_schedule').dialog('close')">Batal</a>
</div>

<!-- Dialog Evaluasi -->

<div id="dlg-transaksi_Schedule_evaluasi" class="easyui-dialog" style="width:600px; height:400px; padding: 10px 20px" closed="true" buttons="#dlg-buttons-transaksi_Schedule_evaluasi">
    <form id="fm-transaksi_Schedule_evaluasi" method="post" novalidate>        
        <div class="fitem">
            <label for="type">Tgl Pelatihan</label>
            <input type="text" id="t_evaluasi_tgl_pelatihan" name="t_evaluasi_tgl_pelatihan" class="easyui-datebox"/>
        </div>
        
        <div class="fitem">
            <label for="type">Tgl Test Tertulis</label>
            <input type="text" id="t_evaluasi_tgl_test_tertulis" name="t_evaluasi_tgl_test_tertulis" class="easyui-datebox" required="true"/>
        </div>  
        
        <div class="fitem">
            <label for="type">Pengetahuan Materi</label>
            <input type="text" id="t_evaluasi_pengetahuan_materi" name="t_evaluasi_pengetahuan_materi" class="easyui-numberbox" min=10" max=100"/>
        </div>
        
        <div class="fitem">
            <label for="type">Penerapan di lapangan</label>
            <input type="text" id="t_evaluasi_penerapan_lap" name="t_evaluasi_penerapan_lap" class="easyui-numberbox" min=10" max=100"/>
        </div>
        
        <div class="fitem">
            <label for="type">Peningkatan Kinerja</label>
            <input type="text" id="t_evaluasi_peningkatan_kinerja" name="t_evaluasi_peningkatan_kinerja" class="easyui-numberbox"/>
             <a id="button_calcFinishSch" href="javascript:calcFinishSch()" class="easyui-linkbutton easyui-tooltip"  
                    title="Generate Nilai." iconCls="icon-calculator" plain="true" data-options="position:'right'" onclick=""></a>
        </div>
        
        <div class="fitem">
            <label for="type"> Keterangan</label>
            <input type="text" id="t_evaluasi_keterangan" name="t_evaluasi_keterangan" class="easyui-textbox"  style="width:50%;height:50px" multiline="true"/>
        </div>
    </form>
</div>

<!-- Dialog Button -->
<div id="dlg-buttons-transaksi_Schedule_evaluasi">
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-ok" onclick="transaksiScheduleEvaluasiSave()">Simpan</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-cancel" onclick="javascript:$('#dlg-transaksi_Schedule_evaluasi').dialog('close')">Batal</a>
</div>

<!-- End of file v_pesertakpd.php -->
<!-- Location: ./application/views/transaksi/v_pesertakpd.php -->