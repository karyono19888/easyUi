<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript" src="<?=base_url('assets/easyui/datagrid-scrollview.js')?>"></script>
<script type="text/javascript" src="<?=base_url('assets/easyui/datagrid-filter.js')?>"></script>
<script type="text/javascript">
var url;

function masterBankCreate(){
    $('#dlg-master-bank').dialog({modal: true}).dialog('open').dialog('setTitle','Tambah Data');
    $('#fm-master-bank').form('clear');
    url = '<?php echo site_url('master/bank/create'); ?>';
}

function masterBankUpdate(){
    var row = $('#grid-master-bank').datagrid('getSelected');
    if(row){
        $('#dlg-master-bank').dialog({modal: true}).dialog('open').dialog('setTitle','Edit Data');
        $('#fm-master-bank').form('load',row);
        url = '<?php echo site_url('master/bank/update'); ?>/' + row.bank_id;
    }
}

function masterBankSave(){
    $('#fm-master-bank').form('submit',{
        url: url,
        onSubmit: function(){
            return $(this).form('validate');
        },
        success: function(result){
            var result = eval('('+result+')');
            if(result.success){
                $('#dlg-master-bank').dialog('close');
                $('#grid-master-bank').datagrid('reload');
            } else {
                $.messager.show({
                    title: 'Error',
                    msg: result.msg
                });
            }
        }
    });
}

function masterBankHapus(){
    var row = $('#grid-master-bank').datagrid('getSelected');
    if (row){
        $.messager.confirm('Konfirmasi','Anda yakin ingin menghapus data ID '+row.bank_id+' ?',function(r){
            if (r){
                $.post('<?php echo site_url('master/bank/delete'); ?>',{bank_id:row.bank_id},function(result){
                    if (result.success){
                        $('#grid-master-bank').datagrid('reload');
                    } else {
                        $.messager.show({
                            title: 'Error',
                            msg: result.msg
                        });
                    }
                },'json');
            }
        });
    }
}
</script>
<style type="text/css">
    #fm-master-bank{
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
        width:80px;
    }
</style>

<!-- Data Grid -->
<table id="grid-master-bank" toolbar="#toolbar-master-bank"
    data-options="pageSize:50, singleSelect:true, fit:true, fitColumns:false">
    <thead>
        <tr>              
            <th data-options="field:'bank_id'" width="50" align="center" sortable="true">ID</th>
            <th data-options="field:'bank_name'" width="200" halign="center" sortable="true">Nama Bank</th>
        </tr>
    </thead>
</table>

<script type="text/javascript">
    $('#grid-master-bank').datagrid({view:scrollview,remoteFilter:true,
        url:'<?php echo site_url('master/bank/index'); ?>?grid=true'}).datagrid('enableFilter');
</script>
<!-- Toolbar -->
<div id="toolbar-master-bank">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="masterBankCreate()">Tambah Data</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="masterBankUpdate()">Edit Data</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="masterBankHapus()">Hapus Data</a>
</div>

<!-- Dialog Form -->
<div id="dlg-master-bank" class="easyui-dialog" style="width:400px; height:250px; padding: 10px 20px" closed="true" buttons="#dlg-buttons-master-bank">
    <form id="fm-master-bank" method="post" novalidate>        
        <div class="fitem">
            <label for="type">Nama Bank</label>
            <input type="text" name="bank_name" class="easyui-validatebox" required="true"/>
        </div>
    </form>
</div>

<!-- Dialog Button -->
<div id="dlg-buttons-master-bank">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="masterBankSave()">Simpan</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg-master-bank').dialog('close')">Batal</a>
</div>
