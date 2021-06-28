<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript" src="<?=base_url('assets/easyui/datagrid-scrollview.js')?>"></script>
<script type="text/javascript" src="<?=base_url('assets/easyui/datagrid-filter.js')?>"></script>
<script type="text/javascript">
var url;

function masterUpahCreate(){
    $('#dlg-master-upah').dialog({modal: true}).dialog('open').dialog('setTitle','Tambah Data');
    $('#fm-master-upah').form('clear');
    url = '<?php echo site_url('master/upah/create'); ?>';
}

function  masterUpahUpdate(){
    var row = $('#grid-master-upah').datagrid('getSelected');
    if(row){
        $('#dlg-master-upah').dialog({modal: true}).dialog('open').dialog('setTitle','Edit Data');
        $('#fm-master-upah').form('load',row);
        url = '<?php echo site_url('master/upah/update'); ?>/' + row.salary_id;
    }
}

function  masterUpahSave(){
    $('#fm-master-upah').form('submit',{
        url: url,
        onSubmit: function(){
            return $(this).form('validate');
        },
        success: function(result){
            var result = eval('('+result+')');
            if(result.success){
                $('#dlg-master-upah').dialog('close');
                $('#grid-master-upah').datagrid('reload');
            } else {
                $.messager.show({
                    title: 'Error',
                    msg: result.msg
                });
            }
        }
    });
}

function  masterUpahHapus(){
    var row = $('#grid-master-upah').datagrid('getSelected');
    if (row){
        $.messager.confirm('Konfirmasi','Anda yakin ingin menghapus data ID '+row.salary_id+' ?',function(r){
            if (r){
                $.post('<?php echo site_url('master/upah/delete'); ?>',{salary_id:row.salary_id},function(result){
                    if (result.success){
                        $('#grid-master-upah').datagrid('reload');
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
    #fm-master-upah{
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
<table id="grid-master-upah" toolbar="#toolbar-master-upah"
    data-options="pageSize:50, singleSelect:true, fit:true, fitColumns:false">
    <thead>
        <tr>              
            <th data-options="field:'salary_id'" width="80" align="center" sortable="true">Tahun</th>
            <th data-options="field:'salary_amt'" formatter="masterUpahAmt" halign="center" align="right" width="100" sortable="true">Amount</th>
        </tr>
    </thead>
</table>

<script type="text/javascript">
    $('#grid-master-upah').datagrid({view:scrollview,remoteFilter:true,
        url:'<?php echo site_url('master/upah/index'); ?>?grid=true'}).datagrid('enableFilter');
    
    function masterUpahAmt(value,row,index) {
        return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
</script>

<!-- Toolbar -->
<div id="toolbar-master-upah">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="masterUpahCreate()">Tambah Data</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="masterUpahUpdate()">Edit Data</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" plain="true" onclick="masterUpahHapus()">Hapus Data</a>
</div>

<!-- Dialog Form -->
<div id="dlg-master-upah" class="easyui-dialog" style="width:400px; height:250px; padding: 10px 20px" closed="true" buttons="#dlg-buttons-master-upah">
    <form id="fm-master-upah" method="post" novalidate>        
        <div class="fitem">
            <label for="type">Tahun</label>
            <input type="text" name="salary_id" class="easyui-validatebox" required="true"/>
        </div>
        <div class="fitem">
            <label for="type">Amount</label>
            <input type="text" name="salary_amt" class="easyui-validatebox" required="true"/>
        </div>
    </form>
</div>

<!-- Dialog Button -->
<div id="dlg-buttons-master-upah">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="masterUpahSave()">Simpan</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg-master-upah').dialog('close')">Batal</a>
</div>
