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
<table id="grid-transaksi_matriksup"
    data-options="pageSize:50, multiSort:true, remoteSort:true, rownumbers:true, singleSelect:true, 
                fit:true, fitColumns:true, toolbar:toolbar_transaksi_matriksup">
    <thead>
        <tr>
            <th data-options="field:'ck',checkbox:true" ></th>
            <th data-options="field:'t_evaluasi_id'"width="60" align="center" sortable="true">Id </th>
            <th data-options="field:'m_emply_name'"    width="200" halign="center" align="center" sortable="true">Peserta</th>
            <th data-options="field:'departemen_nama'"  width="50" halign="center" align="center" sortable="true">Dept</th>
            <th data-options="field:'m_materi_nama'"  width="100" halign="center" align="center" sortable="true">Materi</th>
            <th data-options="field:'m_standar_nilai_min'"  width="100" halign="center" align="center" sortable="true">Std Nilai</th>
            <th data-options="field:'t_evaluasi_peningkatan_kinerja'"  width="100" halign="center" align="center" sortable="true">Nilai</th>
        </tr>
    </thead>
</table>

<script type="text/javascript">
    var toolbar_transaksi_matriksup = [{
        id      : 'transaksi_matriksup-new',
        text    : 'New',
        iconCls : 'icon-new_file',
        handler : function(){transaksiMatriksupCreate();}
    },{
        id      : 'transaksi_matriksup-edit',
        text    : 'Edit',
        iconCls : 'icon-edit',
        handler : function(){transaksiMatriksupUpdate();}
    },{
        id      : 'transaksi_matriksup-delete',
        text    : 'Delete',
        iconCls : 'icon-cancel',
        handler : function(){transaksiMatriksupHapus();}
    },{
        text    : 'Refresh',
        iconCls : 'icon-reload',
        handler : function(){transaksiMatriksupRefresh();}
    }];
    
    $('#grid-transaksi_matriksup').datagrid({
        onLoadSuccess   : function(){
            $('#transaksi_matriksup-edit').linkbutton('disable');
            $('#transaksi_matriksup-delete').linkbutton('disable');
        },
        onSelect        : function(){
            $('#transaksi_matriksup-edit').linkbutton('enable');
            $('#transaksi_matriksup-delete').linkbutton('enable');
        },
        onClickRow      : function(){
            $('#transaksi_matriksup-edit').linkbutton('enable');
            $('#transaksi_matriksup-delete').linkbutton('enable');
        },
        onDblClickRow   : function(){
            transaksiPesertakpdUpdate();
        },
        
        view            :scrollview,
        remoteFilter    :true,
        url             :'<?php echo site_url('transaksi/matriksup/index'); ?>?grid=true'})
    .datagrid('enableFilter');

    function transaksiMatriksupRefresh() {
        $('#transaksi_matriksup-edit').linkbutton('disable');
        $('#transaksi_karawan-delete').linkbutton('disable');
        $('#grid-transaksi_matriksup').datagrid('reload');
    }
    
    function transaksiMatriksupCreate(){
        $('#dlg-transaksi_matriksup').dialog({modal: true}).dialog('open').dialog('setTitle','Tambah Data');
        $('#fm-transaksi_matriksup').form('clear');
        $('#t_matriksup_tahun').numberspinner('setValue',<?php echo date("Y"); ?>);
        url = '<?php echo site_url('transaksi/matriksup/create'); ?>';
    }

    function transaksiMatriksupUpdate() {
        var row = $('#grid-transaksi_matriksup').datagrid('getSelected');
        if(row){
            $('#dlg-transaksi_matriksup_update').dialog({modal: true}).dialog('open').dialog('setTitle','Edit Data');
            $('#fm-transaksi_matriksup_update').form('load',row);
            urlupdate = '<?php echo site_url('transaksi/matriksup/update'); ?>/' + row.t_evaluasi_id;
            //$('#m_emply_nik').textbox('disable');
        }
        else
        {
             $.messager.alert('Info','Data belum dipilih !','info');
        }
    }
    
    function transaksiMatriksupSave(){
        $('#fm-transaksi_matriksup').form('submit',{
            url: url,
            onSubmit: function(){
                return $(this).form('validate');
            },
            iframe: false,
            onProgress: function(percent){
               // $('#progressFile').progressbar('setValue', percent);   
                $.messager.progress({
                        title:'Dagoan Sakedeung',
                        msg:'Nendeun Data...'
                    });
            },
            success: function(result){
                $.messager.progress('close');
                var result = eval('('+result+')');
                if(result.success) {
                    //$('#grid-transaksi_matriksup').datagrid('reload');      
                    $('#t_matriksup_materi').combobox('clear');
                    $('#t_matriksup_peningkatan_kinerja').numberbox('clear');
                    transaksiMatriksupRefresh();
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
    
    function transaksiMatriksupUpdateSave(){
        $('#fm-transaksi_matriksup_update').form('submit',{
            url: urlupdate,
            onSubmit: function(){
                return $(this).form('validate');
            },
            iframe: false,
            onProgress: function(percent){
               // $('#progressFile').progressbar('setValue', percent);   
                $.messager.progress({
                        title:'Dagoan Sakedeung',
                        msg:'Nendeun Data...'
                    });
            },
            success: function(result){
                $.messager.progress('close');
                var result = eval('('+result+')');
                if(result.success) {
                    $('#dlg-transaksi_matriksup_update').dialog('close');
                    transaksiMatriksupRefresh();
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
    
        
   function transaksiMatriksupHapus(){
        $.messager.progress({
            title:'Dagoan Sakedeung',
            msg:'Pupus Data...'
        });
        var row = $('#grid-transaksi_matriksup').datagrid('getSelected');
        if (row){
            var win = $.messager.confirm('Konfirmasi','Anda yakin ingin menghapus \n'+row.t_evaluasi_id+' ?',function(r){
                if (r){
                    $.post('<?php echo site_url('transaksi/matriksup/delete'); ?>',{t_evaluasi_id:row.t_evaluasi_id},function(result){
                        $.messager.progress('close');
                        if (result.success)
                        {
                            transaksiMatriksupRefresh();
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

    
 id_dept = 0;
    
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
<div id="dlg-transaksi_matriksup" class="easyui-dialog" style="width:600px; height:400px; padding: 10px 20px" closed="true" buttons="#dlg-buttons-transaksi_matriksup">
    <form id="fm-transaksi_matriksup" method="post" novalidate>        
        <div class="fitem">
            <label for="type">Karyawan </label>
            <input type="text" id="t_matriksup_peserta" name="t_matriksup_peserta" style="width:150px;" class="easyui-combobox" required="true" 
            data-options="url:'<?php echo site_url('transaksi/matriksup/getKar'); ?>',
            method:'get', valueField:'m_emply_nik', textField:'m_emply_name', panelHeight:'150',
            onSelect: function(rec){
                    $.post('<?php echo site_url('transaksi/matriksup/EvaCheck'); ?>',{m_emply_nik:rec.m_emply_nik},function(result){
                        if (result.berhasil){ 
                            $('#m_emply_dept').textbox('setValue', result.departemen_nama);
                            $('#m_emply_jabatan').textbox('setValue',result.m_jabatan_nama);
                            $('#m_standar_nilai_min').numberbox('setValue',result.m_standar_nilai_min);
                            
                        }
                    },'json');
                }
            "/>
        </div>

        <div class="fitem">
            <label for="type">Departemen</label>
            <input type="text" id="m_emply_dept" name="m_emply_dept" class="easyui-textbox" readonly="true"/>
        </div>
        <div class="fitem">
            <label for="type">Jabatan</label>
            <input type="text" id="m_emply_jabatan" name="m_emply_jabatan" class="easyui-textbox" readonly="true"/>
        </div>
        <div class="fitem">
            <label for="type">Standar Nilai</label>
            <input type="text" id="m_standar_nilai_min" name="m_standar_nilai_min" class="easyui-numberbox" readonly="true"/>
        </div>
        <div class="fitem">
            <label for="type">Tgl Pelatihan</label>
            <input type="text" id="t_matriksup_tgl_pelatihan" name="t_matriksup_tgl_pelatihan" class="easyui-datebox"/>
        </div>
        <div class="fitem">
            <label for="type">Tgl Test Tertulis</label>
            <input type="text" id="t_matriksup_tgl_test_tertulis" name="t_matriksup_tgl_test_tertulis" class="easyui-datebox"/>
        </div>
        <div class="fitem">
            <label for="type">Materi </label>
            <input type="text" id="t_matriksup_materi" name="t_matriksup_materi" style="width:250px;" class="easyui-combobox" required="true"
            data-options="url:'<?php echo site_url('transaksi/matriksup/getMateri'); ?>',
            method:'get', valueField:'m_materi_no', textField:'m_materi_nama', panelHeight:'150'"/>
        </div>
        <div class="fitem">
            <label for="type">Nilai</label>
            <input type="text" id="t_matriksup_peningkatan_kinerja" name="t_matriksup_peningkatan_kinerja" class="easyui-numberbox"/>
        </div>

    </form>
</div>

<!-- Dialog Button -->
<div id="dlg-buttons-transaksi_matriksup">
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-ok" onclick="transaksiMatriksupSave()">Simpan</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-cancel" onclick="javascript:$('#dlg-transaksi_matriksup').dialog('close')">Batal</a>
</div>

<div id="dlg-transaksi_matriksup_update" class="easyui-dialog" style="width:600px; height:400px; padding: 10px 20px" closed="true" buttons="#dlg-buttons-transaksi_matriksup_update">
    <form id="fm-transaksi_matriksup_update" method="post" novalidate>        
        <div class="fitem">
            <label for="type">Tgl Pelatihan</label>
            <input type="text" id="t_evaluasi_tgl_pelatihan" name="t_evaluasi_tgl_pelatihan" class="easyui-datebox"/>
        </div>
        <div class="fitem">
            <label for="type">Tgl Test Tertulis</label>
            <input type="text" id="t_evaluasi_tgl_test_tertulis" name="t_evaluasi_tgl_test_tertulis" class="easyui-datebox"/>
        </div>
        <div class="fitem">
            <label for="type">Nilai</label>
            <input type="text" id="t_evaluasi_peningkatan_kinerja" name="t_evaluasi_peningkatan_kinerja" class="easyui-numberbox"/>
        </div>
       
    </form>
</div>

<!-- Dialog Button -->
<div id="dlg-buttons-transaksi_matriksup_update">
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-ok" onclick="transaksiMatriksupUpdateSave()">Simpan</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-cancel" onclick="javascript:$('#dlg-transaksi_matriksup_update').dialog('close')">Batal</a>
</div>
<!-- End of file v_pesertakpd.php -->
<!-- Location: ./application/views/transaksi/v_pesertakpd.php -->