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
<table id="grid-master_notebook"
    data-options="pageSize:50, multiSort:true, remoteSort:true, rownumbers:true, singleSelect:true, 
                fit:true, fitColumns:true, toolbar:toolbar_master_notebook">
    <thead>
        <tr>
            <th data-options="field:'ck',checkbox:true" ></th>
            <th data-options="field:'m_notebook_hostname'"    width="100" align="center" sortable="true">Hostname </th>
            <th data-options="field:'m_departemen_pt'"    width="100" align="center" sortable="true">Perusahaan</th>
            <th data-options="field:'m_departemen_dept'"    width="100" align="center" sortable="true">Departemen</th>
            <th data-options="field:'m_notebook_user'"  width="200" halign="center" align="left" sortable="true">Nama User</th>
            <th data-options="field:'m_notebook_masuk'"    width="100" align="center" sortable="true">Tanggal Masuk</th>
            <th data-options="field:'m_notebook_keluar'"    width="100" align="center" sortable="true">Tanggal Keluar</th>
            <th data-options="field:'m_notebook_input'"    width="100" align="center" sortable="true">Tanggal Input</th>
            <th data-options="field:'m_notebook_keterangan'"    width="400" align="center" sortable="true">Keterangan</th>
        </tr>
    </thead>
</table>

<script type="text/javascript">
    var toolbar_master_notebook = [{
        id      : 'master_notebook-new',
        text    : 'New',
        iconCls : 'icon-new_file',
        handler : function(){masterNotebookCreate();}
    },{
        id      : 'master_notebook-edit',
        text    : 'Edit',
        iconCls : 'icon-edit',
        handler : function(){masterNotebookUpdate();}
    },{
        text    : 'Refresh',
        iconCls : 'icon-reload',
        handler : function(){masterNotebookRefresh();}
    },{
        id      : 'master_item_notebook_cetak',
        text    : 'Cetak Asset Notebook',
        iconCls : 'icon-print',
        handler : function(){masterNotebookCetak();}
    }
        ];
    $('#grid-master_notebook').datagrid({
        onLoadSuccess   : function(){
            $('#master_notebook-edit').linkbutton('disable');
            $('#master_notebook-delete').linkbutton('disable');
        },
        onSelect        : function(){
            $('#master_notebook-edit').linkbutton('enable');
            $('#master_notebook-delete').linkbutton('enable');
        },
        onDblClickRow   : function(){
            masterNotebookUpdate();
        },
        view            :scrollview,
        remoteFilter    :true,
        url             :'<?php echo site_url('master/notebook/index'); ?>?grid=true'})
    .datagrid('enableFilter');
     function masterNotebookRefresh() {
        $('#master_notebook-edit').linkbutton('disable');
        $('#master_notebook-delete').linkbutton('disable');
        $('#grid-master_notebook').datagrid('reload');
    }
    function masterNotebookCreate(){
        $('#dlg-master_notebook').dialog({modal: true}).dialog('open').dialog('setTitle','Tambah Data');
        $('#fm-master_notebook').form('clear');
        url = '<?php echo site_url('master/notebook/create'); ?>';
        $('#m_departemen_pt').textbox('enable');
        $('#m_notebook_keluar').textbox('disable');
    }
    function masterNotebookUpdate() {
        var row = $('#grid-master_notebook').datagrid('getSelected');
        if(row){
            $('#dlg-master_notebook').dialog({modal: true}).dialog('open').dialog('setTitle','Edit Data');
            $('#fm-master_notebook').form('load',row);
            url = '<?php echo site_url('master/notebook/update'); ?>/' + row.m_notebook_id;
            $('#m_departemen_pt').textbox('disable');
            $('#m_notebook_pt').textbox('enable');
        }
        else
        {
             $.messager.alert('Info','Data belum dipilih !','info');
        }
    }
    function masterNotebookSave(){
        var a =50
        $('#fm-master_notebook').form('submit',{
            url: url,
            onSubmit: function(){
                return $(this).form('validate');
            },
            success: function(result){
                var result = eval('('+result+')');
                if(result.success) 
                {
                    $('#dlg-master_notebook').dialog('close');
                    $('#grid-master_notebook').datagrid('reload');
                    $.messager.show({
                        title   : 'Info',
                        msg     : 'Data Berhasil Disimpan'
                    });
                    //alert(result.ok);
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
    #fm-master_notebook{
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
<div id="dlg-master_notebook" class="easyui-dialog" style="width:600px; height:300px; padding: 10px 20px" closed="true" buttons="#dlg-buttons-master_notebook">
    <form id="fm-master_notebook" method="post" novalidate>
        
        <div class="fitem">
            <label for="type">Perusahaan</label>
            <input type="text" id="m_departemen_pt" name="m_departemen_pt" style="width:150px;" class="easyui-combobox" required="true"
                   data-options="url:'<?php echo site_url('master/notebook/enumPt'); ?>',
                   method:'get', valueField:'data', textField:'data', 
                   onSelect: function(rec){
                        var url = '<?php echo site_url('master/notebook/getDept'); ?>/'+rec.data;
                        $('#m_notebook_dept').combobox('reload', url);
                    }, panelHeight:'auto'" />
        </div>
        
        <div class="fitem">
            <label for="type">Departemen</label>
            <input type="text" id="m_notebook_dept" name="m_notebook_dept" style="width:150px;" class="easyui-combobox" required="true"
                data-options="valueField:'m_departemen_id', textField:'m_departemen_dept', panelHeight:'150'"/>
        </div>
        
        <div class="fitem">
            <label for="type">Nama User </label>
            <input type="text" id="m_notebook_user" name="m_notebook_user" class="easyui-textbox" required="true"/>
        </div>
        
        <div class="fitem">
            <label for="type">Tanggal Masuk</label>
            <input type="text" id="m_notebook_masuk" name="m_notebook_masuk" class="easyui-datebox" required="true"/>
        </div>
        <div class="fitem">
            <label for="type">Tanggal Keluar</label>
            <input type="text" id="m_notebook_keluar" name="m_notebook_keluar" class="easyui-datebox" required="true"/>
        </div>
        
        <div class="fitem">
            <label for="type"> Keterangan</label>
            <input type="text" id="m_notebook_keterangan" name="m_notebook_keterangan" class="easyui-textbox" required="true" style="width:50%;height:60px" multiline="true"/>
        </div>
        
    </form>
</div>

<!-- Dialog Button -->
<div id="dlg-buttons-master_notebook">
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-ok" onclick="masterNotebookSave()">Simpan</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-cancel" onclick="javascript:$('#dlg-master_notebook').dialog('close')">Batal</a>
</div>

<script type="text/javascript">
    function masterNotebookCetak(){
        $('#dlg-master_notebook_cetak').dialog({modal: true}).dialog('open').dialog('setTitle','Cetak Asset');
        $('#fm-master_notebook_cetak').form('clear');
        $('#m_departemen_pt_cetak').combobox('setValue', '');
        $('#m_notebook_dept_cetak').combobox('setValue', '');
    }
    
    function masterNotebookCetakOK(){
        var isValid = $('#fm-master_notebook_cetak').form('validate');
        if (isValid){
            var pt = $('#m_departemen_pt_cetak').combobox('getValue');
            var dept = $('#m_notebook_dept_cetak').combobox('getValue');
            var url = '<?php echo site_url('master/notebook/cetak'); ?>/' + pt+'-'+dept;
            var content = '<iframe scrolling="auto" frameborder="0"  src="'+url+'" style="width:100%;height:100%;"></iframe>';
            var title   = 'Asset Notebook '+pt+' '+dept;
            if ($('#tt').tabs('exists', title))
            {
                $('#tt').tabs('select', title);
                $('#dlg-master_notebook_cetak').dialog('close');
            } 
            else 
            {
                $('#tt').tabs('add',{
                    title:title,
                    content:content,
                    closable:true,
                    iconCls:'icon-print'
                });
                $('#dlg-master_notebook_cetak').dialog('close');
            }
        }
    }
    
    
</script>
<div id="dlg-master_notebook_cetak" class="easyui-dialog" style="width:350px; height:200px; padding: 10px 20px" closed="true" buttons="#dlg-buttons-master_notebook_cetak">
    <form id="fm-master_item_notebook_cetak" method="post" novalidate>       
       <div class="fitem">
            <label for="type">Perusahaan</label>
            <input type="text" id="m_departemen_pt_cetak" name="m_departemen_pt_cetak" style="width:150px;" class="easyui-combobox" required="true"
                   data-options="url:'<?php echo site_url('master/notebook/enumPt'); ?>',
                   method:'get', valueField:'data', textField:'data', 
                   onSelect: function(rec){
                        var url = '<?php echo site_url('master/notebook/getDept'); ?>/'+rec.data;
                        $('#m_notebook_dept_cetak').combobox('reload', url);
                    }, panelHeight:'auto'" />
        </div>
       
        <div class="fitem">
            <label for="type">Departemen</label>
            <input type="text" id="m_notebook_dept_cetak" name="m_notebook_dept_cetak" style="width:150px;" class="easyui-combobox"
                data-options="valueField:'m_departemen_id', textField:'m_departemen_dept', panelHeight:'150'"/>
        </div>
    </form>
</div>
<!-- Button Cetak Asset -->
<div id="dlg-buttons-master_notebook_cetak">
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-print" onclick="masterNotebookCetakOK();">Print</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-cancel" onclick="javascript:$('#dlg-master_notebook_cetak').dialog('close')">Batal</a>
</div>

<!-- End of file v_customer.php -->
<!-- Location: ./application/views/master/v_customer.php -->