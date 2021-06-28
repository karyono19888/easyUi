<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<!-- Data Grid -->
<table id="grid-master_jobspec"
    data-options="pageSize:50, multiSort:true, remoteSort:true, rownumbers:true, singleSelect:true, 
                fit:true, fitColumns:true, toolbar:toolbar_master_jobspec">
    <thead>
        <tr>
            <th data-options="field:'ck',checkbox:true" ></th>
            <th data-options="field:'m_jobspec_id'"    width="100" align="center" sortable="true">Id</th>
            <th data-options="field:'m_jobspec_nama'"  width="400" halign="center" align="left" sortable="true">Nama Jobs</th>
            <th data-options="field:'departemen_nama'"    width="100" align="center" sortable="true">Dept</th>
            <th data-options="field:'m_pendidikan_nama'"  width="400" halign="center" align="left" sortable="true">Std Pendidikan</th>
            <th data-options="field:'m_jobspec_pengalaman_std'"  width="400" halign="center" align="left" sortable="true">Std Pengalaman</th>
        </tr>
    </thead>
</table>

<script type="text/javascript">
    var toolbar_master_jobspec = [{
        id      : 'master_jobspec-new',
        text    : 'New',
        iconCls : 'icon-new_file',
        handler : function(){masterJobspecCreate();}
    },{
        id      : 'master_jobspec-edit',
        text    : 'Edit',
        iconCls : 'icon-edit',
        handler : function(){masterJobspecUpdate();}
    },{
        id      : 'master_jobspec-delete',
        text    : 'Delete',
        iconCls : 'icon-cancel',
        handler : function(){masterJobspecHapus();}
    },{
        text    : 'Refresh',
        iconCls : 'icon-reload',
        handler : function(){masterJobspecRefresh();}
    }];
    
    $('#grid-master_jobspec').datagrid({
        onLoadSuccess   : function(){
            $('#master_jobspec-edit').linkbutton('disable');
            $('#master_jobspec-delete').linkbutton('disable');
        },
        onSelect        : function(){
            $('#master_jobspec-edit').linkbutton('enable');
            $('#master_jobspec-delete').linkbutton('enable');
        },
        onClickRow      : function(){
            $('#master_jobspec-edit').linkbutton('enable');
            $('#master_jobspec-delete').linkbutton('enable');
        },
        onDblClickRow   : function(){
            masterPesertakpdUpdate();
        },
        view            :scrollview,
        remoteFilter    :true,
        url             :'<?php echo site_url('master/jobspec/index'); ?>?grid=true'})
    .datagrid('enableFilter');

    function masterJobspecRefresh() {
        $('#master_jobspec-edit').linkbutton('disable');
        $('#master_karawan-delete').linkbutton('disable');
        $('#grid-master_jobspec').datagrid('reload');
    }
    
    function masterJobspecCreate(){
        $('#dlg-master_jobspec').dialog({modal: true}).dialog('open').dialog('setTitle','Tambah Data');
        $('#fm-master_jobspec').form('clear');
        url = '<?php echo site_url('master/jobspec/create'); ?>';
    }

    function masterJobspecUpdate() {
        var row = $('#grid-master_jobspec').datagrid('getSelected');
        if(row){
            $('#dlg-master_jobspec').dialog({modal: true}).dialog('open').dialog('setTitle','Edit Data');
            $('#fm-master_jobspec').form('load',row);
            url = '<?php echo site_url('master/jobspec/update'); ?>/' + row.m_jobspec_id;
            
        }
        else
        {
             $.messager.alert('Info','Data belum dipilih !','info');
        }
    }
    
    function masterJobspecSave(){
        $.messager.progress({
            title:'Dagoan Sakedeung',
            msg:'Nendeun Data...'
        });
        $('#fm-master_jobspec').form('submit',{
            url: url,
            onSubmit: function(){
                return $(this).form('validate');
            },
            success: function(result){
                $.messager.progress('close');
                var result = eval('('+result+')');
                if(result.success) 
                {
                    $('#dlg-master_jobspec').dialog('close');
                    masterJobspecRefresh();
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
        
   function masterJobspecHapus(){
        $.messager.progress({
            title:'Dagoan Sakedeung',
            msg:'Pupus Data...'
        });
        var row = $('#grid-master_jobspec').datagrid('getSelected');
        if (row){
            var win = $.messager.confirm('Konfirmasi','Anda yakin ingin menghapus \n'+row.m_jobspec_nama+' ?',function(r){
                if (r){
                    $.post('<?php echo site_url('master/jobspec/delete'); ?>',{m_jobspec_id:row.m_jobspec_id},function(result){
                        $.messager.progress('close');
                        if (result.success)
                        {
                            masterJobspecRefresh();
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
<div id="dlg-master_jobspec" class="easyui-dialog" style="width:600px; height:300px; padding: 10px 20px" closed="true" buttons="#dlg-buttons-master_jobspec">
    <form id="fm-master_jobspec" method="post" novalidate>        

        <div class="fitem">
            <label for="type">Nama</label>
            <input type="text" id="m_jobspec_nama" name="m_jobspec_nama" class="easyui-textbox"/>
        </div>
        <div class="fitem">
            <label for="type">Departemen </label>
            <input type="text" id="m_jobspec_dept" name="m_jobspec_dept" style="width:200px;" class="easyui-combobox" required="true"
            data-options="url:'<?php echo site_url('master/jobspec/getDept'); ?>',
            method:'get', valueField:'departemen_id', groupField:'departemen_idk', textField:'departemen_nama', panelHeight:'150'"/>
        </div>
        <div class="fitem">
            <label for="type">Pendidikan </label>
            <input type="text" id="m_jobspec_educ_std" name="m_jobspec_educ_std" style="width:200px;" class="easyui-combobox" required="true"
            data-options="url:'<?php echo site_url('master/jobspec/getEduc'); ?>',
            method:'get', valueField:'m_pendidikan_id', textField:'m_pendidikan_nama', panelHeight:'150'"/>
        </div>
        <div class="fitem">
            <label for="type">Std Pengalaman</label>
            <input type="text" id="m_jobspec_pengalaman_std" name="m_jobspec_pengalaman_std" class="easyui-numberbox"/>
        </div>

    </form>
</div>

<!-- Dialog Button -->
<div id="dlg-buttons-master_jobspec">
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-ok" onclick="masterJobspecSave()">Simpan</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-cancel" onclick="javascript:$('#dlg-master_jobspec').dialog('close')">Batal</a>
</div>

<!-- End of file v_pesertakpd.php -->
<!-- Location: ./application/views/master/v_pesertakpd.php -->