<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<!-- Data Grid -->
<table id="grid-master_jabatan"
    data-options="pageSize:50, multiSort:true, remoteSort:true, rownumbers:true, singleSelect:true, 
                fit:true, fitColumns:true, toolbar:toolbar_master_jabatan">
    <thead>
        <tr>
            <th data-options="field:'ck',checkbox:true" ></th>
            <th data-options="field:'m_jabatan_id'"    width="100" align="center" sortable="true">ID</th>
            <th data-options="field:'m_jabatan_nama'"  width="400" halign="center" align="left" sortable="true">Nama Jabatan</th>
            <th data-options="field:'m_standar_nilai_grade'"  width="400" halign="center" align="left" sortable="true">Nilai</th> 
        </tr>
    </thead>
</table>

<script type="text/javascript">
    var toolbar_master_jabatan = [{
        id      : 'master_jabatan-new',
        text    : 'New',
        iconCls : 'icon-new_file',
        handler : function(){masterJabatanCreate();}
    },{
        id      : 'master_jabatan-edit',
        text    : 'Edit',
        iconCls : 'icon-edit',
        handler : function(){masterJabatanUpdate();}
    },{
        id      : 'master_jabatan-delete',
        text    : 'Delete',
        iconCls : 'icon-cancel',
        handler : function(){masterJabatanHapus();}
    },{
        text    : 'Refresh',
        iconCls : 'icon-reload',
        handler : function(){masterJabatanRefresh();}
    }];
    
    $('#grid-master_jabatan').datagrid({
        onLoadSuccess   : function(){
            $('#master_jabatan-edit').linkbutton('disable');
            $('#master_jabatan-delete').linkbutton('disable');
        },
        onSelect        : function(){
            $('#master_jabatan-edit').linkbutton('enable');
            $('#master_jabatan-delete').linkbutton('enable');
        },
        onClickRow      : function(){
            $('#master_jabatan-edit').linkbutton('enable');
            $('#master_jabatan-delete').linkbutton('enable');
        },
        onDblClickRow   : function(){
            masterPesertakpdUpdate();
        },
        view            :scrollview,
        remoteFilter    :true,
        url             :'<?php echo site_url('master/jabatan/index'); ?>?grid=true'})
    .datagrid('enableFilter');

    function masterJabatanRefresh() {
        $('#master_jabatan-edit').linkbutton('disable');
        $('#master_karawan-delete').linkbutton('disable');
        $('#grid-master_jabatan').datagrid('reload');
    }
    
    function masterJabatanCreate(){
        $('#dlg-master_jabatan').dialog({modal: true}).dialog('open').dialog('setTitle','Tambah Data');
        $('#fm-master_jabatan').form('clear');
        url = '<?php echo site_url('master/jabatan/create'); ?>';
    }

    function masterJabatanUpdate() {
        var row = $('#grid-master_jabatan').datagrid('getSelected');
        if(row){
            $('#dlg-master_jabatan').dialog({modal: true}).dialog('open').dialog('setTitle','Edit Data');
            $('#fm-master_jabatan').form('load',row);
            url = '<?php echo site_url('master/jabatan/update'); ?>/' + row.m_jabatan_id;
            $('#m_emply_nik').textbox('disable');
        }
        else
        {
             $.messager.alert('Info','Data belum dipilih !','info');
        }
    }
    
    function masterJabatanSave(){
        $.messager.progress({
            title:'Dagoan Sakedeung',
            msg:'Nendeun Data...'
        });
        $('#fm-master_jabatan').form('submit',{
            url: url,
            onSubmit: function(){
                return $(this).form('validate');
            },
            success: function(result){
                $.messager.progress('close');
                var result = eval('('+result+')');
                if(result.success) 
                {
                    $('#dlg-master_jabatan').dialog('close');
                    masterJabatanRefresh();
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
        
   function masterJabatanHapus(){
        $.messager.progress({
            title:'Dagoan Sakedeung',
            msg:'Pupus Data...'
        });
        var row = $('#grid-master_jabatan').datagrid('getSelected');
        if (row){
            var win = $.messager.confirm('Konfirmasi','Anda yakin ingin menghapus \n'+row.m_jabatan_nama+' ?',function(r){
                if (r){
                    $.post('<?php echo site_url('master/jabatan/delete'); ?>',{m_jabatan_id:row.m_jabatan_id},function(result){
                        $.messager.progress('close');
                        if (result.success)
                        {
                            masterJabatanRefresh();
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
<div id="dlg-master_jabatan" class="easyui-dialog" style="width:600px; height:300px; padding: 10px 20px" closed="true" buttons="#dlg-buttons-master_jabatan">
    <form id="fm-master_jabatan" method="post" novalidate>        

        <div class="fitem">
            <label for="type">Nama Jabatan</label>
            <input type="text" id="m_jabatan_nama" name="m_jabatan_nama" class="easyui-textbox"/>
        </div>
        <div class="fitem">
            <label for="type">Nilai </label>
            <input type="text" id="m_jabatan_grade" name="m_jabatan_grade" style="width:200px;" class="easyui-combobox" required="true"
            data-options="url:'<?php echo site_url('master/jabatan/getGrade'); ?>',
            method:'get', valueField:'m_standar_nilai_grade', textField:'m_standar_nilai_grade', panelHeight:'150'"/>
        </div>
    </form>
</div>

<!-- Dialog Button -->
<div id="dlg-buttons-master_jabatan">
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-ok" onclick="masterJabatanSave()">Simpan</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-cancel" onclick="javascript:$('#dlg-master_jabatan').dialog('close')">Batal</a>
</div>

<!-- End of file v_pesertakpd.php -->
<!-- Location: ./application/views/master/v_pesertakpd.php -->