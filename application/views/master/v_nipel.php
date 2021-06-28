<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<!-- Data Grid -->
<table id="grid-std_nilai_pelatihan"
    data-options="pageSize:50, multiSort:true, remoteSort:true, rownumbers:true, singleSelect:true, 
                fit:true, fitColumns:true, toolbar:toolbar_master_standar_nilai">
    <thead>
        <tr>
            <th data-options="field:'ck',checkbox:true" ></th>
            <th data-options="field:'m_std_nilai_pelatihan_id'"    width="50" align="center" sortable="true">ID</th>
            <th data-options="field:'b.departemen_nama'"  width="400" halign="center" align="left" sortable="true">Departemen</th>
            <th data-options="field:'a.departemen_nama'"  width="400" halign="center" align="left" sortable="true">Bagian</th>
            <th data-options="field:'m_jabatan_nama'"  width="400" halign="center" align="left" sortable="true">Jabatan</th>
            <th data-options="field:'m_materi_nama'"  width="400" halign="center" align="left" sortable="true">Materi</th>
            <th data-options="field:'m_std_nilai_pelatihan_nilai'"  width="400" halign="center" align="left" sortable="true">Std Nilai</th>
        </tr>
    </thead>
</table>

<script type="text/javascript">
    var toolbar_master_standar_nilai = [{
        id      : 'std_nilai_pelatihan-new',
        text    : 'New',
        iconCls : 'icon-new_file',
        handler : function(){masterStdNilaiPelCreate();}
    },{
        id      : 'std_nilai_pelatihan-edit',
        text    : 'Edit',
        iconCls : 'icon-edit',
        handler : function(){masterStdNilaiPelUpdate();}
    },{
        id      : 'std_nilai_pelatihan-delete',
        text    : 'Delete',
        iconCls : 'icon-cancel',
        handler : function(){masterStdNilaiPelHapus();}
    },{
        text    : 'Refresh',
        iconCls : 'icon-reload',
        handler : function(){masterStdNilaiPelRefresh();}
    }];
    
    $('#grid-std_nilai_pelatihan').datagrid({
        onLoadSuccess   : function(){
            $('#std_nilai_pelatihan-edit').linkbutton('disable');
            $('#std_nilai_pelatihan-delete').linkbutton('disable');
        },
        onSelect        : function(){
            $('#std_nilai_pelatihan-edit').linkbutton('enable');
            $('#std_nilai_pelatihan-delete').linkbutton('enable');
        },
        onClickRow      : function(){
            $('#std_nilai_pelatihan-edit').linkbutton('enable');
            $('#std_nilai_pelatihan-delete').linkbutton('enable');
        },
        onDblClickRow   : function(){
            masterPesertakpdUpdate();
        },
        view            :scrollview,
        remoteFilter    :true,
        url             :'<?php echo site_url('master/nipel/index'); ?>?grid=true'})
    .datagrid('enableFilter');

    function masterStdNilaiPelRefresh() {
        $('#std_nilai_pelatihan-edit').linkbutton('disable');
        $('#master_karawan-delete').linkbutton('disable');
        $('#grid-std_nilai_pelatihan').datagrid('reload');
    }
    
    function masterStdNilaiPelCreate(){
        $('#dlg-std_nilai_pelatihan').dialog({modal: true}).dialog('open').dialog('setTitle','Tambah Data');
        $('#fm-std_nilai_pelatihan').form('clear');
        url = '<?php echo site_url('master/nipel/create'); ?>';
    }

    function masterStdNilaiPelUpdate() {
        var row = $('#grid-std_nilai_pelatihan').datagrid('getSelected');
        if(row){
            $('#dlg-std_nilai_pelatihan').dialog({modal: true}).dialog('open').dialog('setTitle','Edit Data');
            $('#fm-std_nilai_pelatihan').form('load',row);
            url = '<?php echo site_url('master/nipel/update'); ?>/' + row.m_std_nilai_pelatihan_id;
            
        }
        else
        {
             $.messager.alert('Info','Data belum dipilih !','info');
        }
    }
    
    function masterStdNilaiPelSave(){
        $.messager.progress({
            title:'Dagoan Sakedeung',
            msg:'Nendeun Data...'
        });
        $('#fm-std_nilai_pelatihan').form('submit',{
            url: url,
            onSubmit: function(){
                return $(this).form('validate');
            },
            success: function(result){
                $.messager.progress('close');
                var result = eval('('+result+')');
                if(result.success) 
                {
                    //$('#dlg-std_nilai_pelatihan').dialog('close');
                    masterStdNilaiPelRefresh();
                    $.messager.show({
                        title   : 'Info',
                        msg     : 'Data Berhasil Disimpan'
                    });
                }
                else
                {
                    $.messager.show({
                        title   : 'Error',
                        msg     : 'Input Data Gagal/Data Duplikat'
                    });
                }
            }
        });
    }
        
   function masterStdNilaiPelHapus(){
        $.messager.progress({
            title:'Dagoan Sakedeung',
            msg:'Pupus Data...'
        });
        var row = $('#grid-std_nilai_pelatihan').datagrid('getSelected');
        if (row){
            var win = $.messager.confirm('Konfirmasi','Anda yakin ingin menghapus \n'+row.m_std_nilai_pelatihan_id+' ?',function(r){
                if (r){
                    $.post('<?php echo site_url('master/nipel/delete'); ?>',{m_std_nilai_pelatihan_id:row.m_std_nilai_pelatihan_id},function(result){
                        $.messager.progress('close');
                        if (result.success)
                        {
                            masterStdNilaiPelRefresh();
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
    #fm-master_pesertakpd{
        margin:0;
        padding:10px 30px;
    }
    #fm-master_pesertakpd-upload{
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
<div id="dlg-std_nilai_pelatihan" class="easyui-dialog" style="width:600px; height:300px; padding: 10px 20px" closed="true" buttons="#dlg-buttons-std_nilai_pelatihan">
    <form id="fm-std_nilai_pelatihan" method="post" novalidate>        

        <div class="fitem">
            <label for="type">Bagian </label>
            <input type="text" id="m_std_nilai_pelatihan_bag" name="m_std_nilai_pelatihan_bag" style="width:200px;" class="easyui-combobox" required="true"
            data-options="url:'<?php echo site_url('master/nipel/getBag'); ?>',
            method:'get', valueField:'departemen_id', groupField:'departemen_idk', textField:'departemen_nama', panelHeight:'150'"/>
        </div>
        
        <div class="fitem">
            <label for="type">Materi </label>
            <input type="text" id="m_std_nilai_pelatihan_materi" name="m_std_nilai_pelatihan_materi" style="width:200px;" class="easyui-combobox" required="true"
            data-options="url:'<?php echo site_url('master/nipel/getMat'); ?>',
            method:'get', valueField:'m_materi_no', textField:'m_materi_nama', panelHeight:'150'"/>
        </div>
        <div class="fitem">
            <label for="type">Jabatan </label>
            <input type="text" id="m_std_nilai_pelatihan_jab" name="m_std_nilai_pelatihan_jab" style="width:200px;" class="easyui-combobox" required="true"
            data-options="url:'<?php echo site_url('master/nipel/getJab'); ?>',
            method:'get', valueField:'m_jabatan_id', textField:'m_jabatan_nama', panelHeight:'150'"/>
        </div>

        <div class="fitem">
            <label for="type">Std Nilai </label>
            <input type="text" id="m_std_nilai_pelatihan_nilai" name="m_std_nilai_pelatihan_nilai" style="width:200px;" class="easyui-combobox" required="true"
            data-options="url:'<?php echo site_url('master/nipel/getStd'); ?>',
            method:'get', valueField:'m_standar_nilai_min', textField:'m_standar_nilai_min', panelHeight:'150'"/>
        </div>

    </form>
</div>

<!-- Dialog Button -->
<div id="dlg-buttons-std_nilai_pelatihan">
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-ok" onclick="masterStdNilaiPelSave()">Simpan</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-cancel" onclick="javascript:$('#dlg-std_nilai_pelatihan').dialog('close')">Batal</a>
</div>

<!-- End of file v_pesertakpd.php -->
<!-- Location: ./application/views/master/v_pesertakpd.php -->