<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<!-- Data Grid -->
<table id="grid-master_pendidikan"
    data-options="pageSize:50, multiSort:true, remoteSort:true, rownumbers:true, singleSelect:true, 
                fit:true, fitColumns:true, toolbar:toolbar_master_pendidikan">
    <thead>
        <tr>
            <th data-options="field:'ck',checkbox:true" ></th>
            <th data-options="field:'m_pendidikan_id'"    width="100" align="center" sortable="true">ID</th>
            <th data-options="field:'m_pendidikan_nama'"  width="400" halign="center" align="left" sortable="true">Nama Pendidikan</th>
            <th data-options="field:'m_pendidikan_tk'"  width="400" halign="center" align="left" sortable="true">Nilai</th> 
        </tr>
    </thead>
</table>

<script type="text/javascript">
    var toolbar_master_pendidikan = [{
        id      : 'master_pendidikan-new',
        text    : 'New',
        iconCls : 'icon-new_file',
        handler : function(){masterPendidikanCreate();}
    },{
        id      : 'master_pendidikan-edit',
        text    : 'Edit',
        iconCls : 'icon-edit',
        handler : function(){masterPendidikanUpdate();}
    },{
        id      : 'master_pendidikan-delete',
        text    : 'Delete',
        iconCls : 'icon-cancel',
        handler : function(){masterPendidikanHapus();}
    },{
        text    : 'Refresh',
        iconCls : 'icon-reload',
        handler : function(){masterPendidikanRefresh();}
    }];
    
    $('#grid-master_pendidikan').datagrid({
        onLoadSuccess   : function(){
            $('#master_pendidikan-edit').linkbutton('disable');
            $('#master_pendidikan-delete').linkbutton('disable');
        },
        onSelect        : function(){
            $('#master_pendidikan-edit').linkbutton('enable');
            $('#master_pendidikan-delete').linkbutton('enable');
        },
        onClickRow      : function(){
            $('#master_pendidikan-edit').linkbutton('enable');
            $('#master_pendidikan-delete').linkbutton('enable');
        },
        onDblClickRow   : function(){
            masterPesertakpdUpdate();
        },
        view            :scrollview,
        remoteFilter    :true,
        url             :'<?php echo site_url('master/pendidikan/index'); ?>?grid=true'})
    .datagrid('enableFilter');

    function masterPendidikanRefresh() {
        $('#master_pendidikan-edit').linkbutton('disable');
        $('#master_karawan-delete').linkbutton('disable');
        $('#grid-master_pendidikan').datagrid('reload');
    }
    
    function masterPendidikanCreate(){
        $('#dlg-master_pendidikan').dialog({modal: true}).dialog('open').dialog('setTitle','Tambah Data');
        $('#fm-master_pendidikan').form('clear');
        url = '<?php echo site_url('master/pendidikan/create'); ?>';
    }

    function masterPendidikanUpdate() {
        var row = $('#grid-master_pendidikan').datagrid('getSelected');
        if(row){
            $('#dlg-master_pendidikan').dialog({modal: true}).dialog('open').dialog('setTitle','Edit Data');
            $('#fm-master_pendidikan').form('load',row);
            url = '<?php echo site_url('master/pendidikan/update'); ?>/' + row.m_pendidikan_id;
            $('#m_emply_nik').textbox('disable');
        }
        else
        {
             $.messager.alert('Info','Data belum dipilih !','info');
        }
    }
    
    function masterPendidikanSave(){
        $.messager.progress({
            title:'Dagoan Sakedeung',
            msg:'Nendeun Data...'
        });
        $('#fm-master_pendidikan').form('submit',{
            url: url,
            onSubmit: function(){
                return $(this).form('validate');
            },
            success: function(result){
                $.messager.progress('close');
                var result = eval('('+result+')');
                if(result.success) 
                {
                    $('#dlg-master_pendidikan').dialog('close');
                    masterPendidikanRefresh();
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
        
   function masterPendidikanHapus(){
        $.messager.progress({
            title:'Dagoan Sakedeung',
            msg:'Pupus Data...'
        });
        var row = $('#grid-master_pendidikan').datagrid('getSelected');
        if (row){
            var win = $.messager.confirm('Konfirmasi','Anda yakin ingin menghapus \n'+row.m_pendidikan_nama+' ?',function(r){
                if (r){
                    $.post('<?php echo site_url('master/pendidikan/delete'); ?>',{m_pendidikan_id:row.m_pendidikan_id},function(result){
                        $.messager.progress('close');
                        if (result.success)
                        {
                            masterPendidikanRefresh();
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
<div id="dlg-master_pendidikan" class="easyui-dialog" style="width:600px; height:300px; padding: 10px 20px" closed="true" buttons="#dlg-buttons-master_pendidikan">
    <form id="fm-master_pendidikan" method="post" novalidate>        

        <div class="fitem">
            <label for="type">Nama Pendidikan</label>
            <input type="text" id="m_pendidikan_nama" name="m_pendidikan_nama" class="easyui-textbox"/>
        </div>
        <div class="fitem">
            <label for="type">Tingkatan</label>
            <input type="text" id="m_pendidikan_tk" name="m_pendidikan_tk" class="easyui-numberbox"/>
        </div>
    </form>
</div>

<!-- Dialog Button -->
<div id="dlg-buttons-master_pendidikan">
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-ok" onclick="masterPendidikanSave()">Simpan</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-cancel" onclick="javascript:$('#dlg-master_pendidikan').dialog('close')">Batal</a>
</div>

<!-- End of file v_pesertakpd.php -->
<!-- Location: ./application/views/master/v_pesertakpd.php -->