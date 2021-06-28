<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript" src="<?=base_url('assets/easyui/datagrid-scrollview.js')?>"></script>
<script type="text/javascript" src="<?=base_url('assets/easyui/datagrid-filter.js')?>"></script>
<script type="text/javascript">
var url;
var urls;
function masterJam_kerjaCreate(){
    $('#dlg-master-jam_kerja').dialog({modal: true}).dialog('open').dialog('setTitle','Tambah Data');
    $('#fm-master-jam_kerja').form('clear');
    url = '<?php echo site_url('master/jam_kerja/create'); ?>';
    
}

function masterJam_kerjaUpdate(){
    var row = $('#grid-master-jam_kerja').datagrid('getSelected');
    if(row){
        $('#dlg-master-jam_kerja').dialog({modal: true}).dialog('open').dialog('setTitle','Edit Data');
        $('#fm-master-jam_kerja').form('load',row);
        url = '<?php echo site_url('master/jam_kerja/update'); ?>/' + row.workday_id;        
    }
}

function masterJam_kerjaSave(){
    $('#fm-master-jam_kerja').form('submit',{
        url: url,
        onSubmit: function(){
            return $(this).form('validate');
        },
        success: function(result){
            var result = eval('('+result+')');
            if(result.success){
                $('#dlg-master-jam_kerja').dialog('close');
                $('#grid-master-jam_kerja').datagrid('reload');
            } else {
                $.messager.show({
                    title: 'Error',
                    msg: result.msg
                });
            }
        }
    });
}

function masterJam_kerjaHapus(){
    var row = $('#grid-master-jam_kerja').datagrid('getSelected');
    if (row){
        $.messager.confirm('Konfirmasi','Anda yakin ingin menghapus data ID '+row.workday_id+' ?',function(r){
            if (r){
                $.post('<?php echo site_url('master/jam_kerja/delete'); ?>',
                {workday_id:row.workday_id, workday_path:row.workday_path},function(result){
                    if (result.success){
                        $('#grid-master-jam_kerja').datagrid('reload');
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

function UploadJadwal()
{
    var row = $('#grid-master-jam_kerja').datagrid('getSelected');
    if(row){
        $('#dlg-master-jam_kerja-upload').dialog({modal: true}).dialog('open').dialog('setTitle','Upload Jadwal');   
        //$('#fm-master-jam_kerja-upload').form('load',row);
        $('#fm-master-jam_kerja-upload').form('reset');
        urls = '<?php echo site_url('master/jam_kerja/upload'); ?>/' + row.workday_id;        
    }
}
    
function masterJam_kerjaSaveUpload(){
    $('#fm-master-jam_kerja-upload').form('submit',{
        url: urls,
        onSubmit: function(){
            return $(this).form('validate');
        },
        success: function(result){
            var result = eval('('+result+')');
            if(result.success){
                $('#dlg-master-jam_kerja-upload').dialog('close');
                $('#grid-master-jam_kerja').datagrid('reload');
            } else if (result.ada) {
                $.messager.show({
                    title: 'Error',
                    msg: 'Duplicate File Exists'
                });
            } else {
                $.messager.show({
                    title: 'Error',
                    msg: result.msg
                });
            }
        }
    });
}

</script>
<style type="text/css">
    #fm-master-jam_kerja{
        margin:0;
        padding:10px 30px;
    }
    #fm-master-jam_kerja-upload{
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
<table id="grid-master-jam_kerja" toolbar="#toolbar-master-jam_kerja"
    data-options="pageSize:50, singleSelect:true, fit:true, fitColumns:true">
    <thead>
        <tr>              
            <th data-options="field:'workday_id'" width="30" align="center" sortable="true">ID</th>
            <th data-options="field:'workday_name'" width="150" halign="center" sortable="true">Jenis Hari Kerja</th>
            <th data-options="field:'workday_path'" width="150" halign="center" sortable="true">File</th>
            <th data-options="field:'workday_I_top'" width="60" align="center" sortable="true">Batas Atas I</th>
            <th data-options="field:'workday_I_bottom'" width="60" align="center" sortable="true">Batas Bawah I</th>
            <th data-options="field:'workday_P_top'" width="60" align="center" sortable="true">Batas Atas P</th>
            <th data-options="field:'workday_P_bottom'" width="60" align="center" sortable="true">Batas Bawah P</th>
            <th data-options="field:'workday_II_top'" width="60" align="center" sortable="true">Batas Atas II</th>
            <th data-options="field:'workday_II_bottom'" width="60" align="center" sortable="true">Batas Bawah II</th>
        </tr>
    </thead>
</table>

<script type="text/javascript">
    $('#grid-master-jam_kerja').datagrid({view:scrollview,remoteFilter:true,
        url:'<?php echo site_url('master/jam_kerja/index'); ?>?grid=true'}).datagrid('enableFilter');
</script>
<!-- Toolbar -->
<div id="toolbar-master-jam_kerja">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="masterJam_kerjaCreate()">Tambah Data</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="masterJam_kerjaUpdate()">Edit Data</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" plain="true" onclick="masterJam_kerjaHapus()">Hapus Data</a>
    |
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-upload" plain="true" onclick="UploadJadwal()">Upload Jadwal</a>
</div>

<!-- Dialog Form -->
<div id="dlg-master-jam_kerja" class="easyui-dialog" style="width:400px; height:400px; padding: 10px 20px" closed="true" buttons="#dlg-buttons-master-jam_kerja">
    <form id="fm-master-jam_kerja" method="post" novalidate>        
        <div class="fitem">
            <label for="type">Jenis Hari Kerja</label>
            <input type="text" name="workday_name" class="easyui-validatebox" required="true"/>
        </div>
        <div class="fitem">
            <label for="type">Batas Atas I</label>
            <input name="workday_I_top" class="easyui-numberbox" precision="1" />
        </div>
        <div class="fitem">
            <label for="type">Batas Bawah I</label>
            <input name="workday_I_bottom" class="easyui-numberbox" precision="1" />
        </div>
        <div class="fitem">
            <label for="type">Batas Atas P</label>
            <input name="workday_P_top" class="easyui-numberbox" precision="1" />
        </div>
        <div class="fitem">
            <label for="type">Batas Bawah P</label>
            <input name="workday_P_bottom" class="easyui-numberbox" precision="1" />
        </div>
        <div class="fitem">
            <label for="type">Batas Atas II</label>
            <input name="workday_II_top" class="easyui-numberbox" precision="1" />
        </div>
        <div class="fitem">
            <label for="type">Batas Bawah II</label>
            <input name="workday_II_bottom" class="easyui-numberbox" precision="1" />
        </div>
    </form>
</div>

<!-- Dialog Form -->
<div id="dlg-master-jam_kerja-upload" class="easyui-dialog" style="width:500px; height:150px; padding: 10px 20px" closed="true" buttons="#dlg-buttons-master-jam_kerja-upload">
    <form id="fm-master-jam_kerja-upload" method="post" enctype="multipart/form-data" novalidate>        
        <div class="fitem">
            <label for="type">File</label>
            <input type="file" id="path" name="workday_path" class="easyui-validatebox" required="true"/>
        </div>        
    </form>
</div>
<!-- Dialog Button -->
<div id="dlg-buttons-master-jam_kerja">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="masterJam_kerjaSave()">Simpan</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg-master-jam_kerja').dialog('close')">Batal</a>
</div>
<!-- Dialog Button -->
<div id="dlg-buttons-master-jam_kerja-upload">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="masterJam_kerjaSaveUpload()">Simpan</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg-master-jam_kerja-upload').dialog('close')">Batal</a>
</div>
