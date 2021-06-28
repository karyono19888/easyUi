<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<!-- Data Grid -->
<table id="grid-master_standar_nilai"
    data-options="pageSize:50, multiSort:true, remoteSort:true, rownumbers:true, singleSelect:true, 
                fit:true, fitColumns:true, toolbar:toolbar_master_standar_nilai">
    <thead>
        <tr>
            <th data-options="field:'ck',checkbox:true" ></th>
            <th data-options="field:'m_standar_nilai_grade'"    width="100" align="center" sortable="true">Grade</th>
            <th data-options="field:'m_standar_nilai_skala'"  width="400" halign="center" align="left" sortable="true">Skala</th>
            <th data-options="field:'m_standar_nilai_min'"  width="400" halign="center" align="left" sortable="true">Nilai Minimal</th>
            <th data-options="field:'m_standar_nilai_range'"  width="400" halign="center" align="left" sortable="true">Range</th>
        </tr>
    </thead>
</table>

<script type="text/javascript">
    var toolbar_master_standar_nilai = [{
        id      : 'master_standar_nilai-new',
        text    : 'New',
        iconCls : 'icon-new_file',
        handler : function(){masterStandar_nilaiCreate();}
    },{
        id      : 'master_standar_nilai-edit',
        text    : 'Edit',
        iconCls : 'icon-edit',
        handler : function(){masterStandar_nilaiUpdate();}
    },{
        id      : 'master_standar_nilai-delete',
        text    : 'Delete',
        iconCls : 'icon-cancel',
        handler : function(){masterStandar_nilaiHapus();}
    },{
        text    : 'Refresh',
        iconCls : 'icon-reload',
        handler : function(){masterStandar_nilaiRefresh();}
    }];
    
    $('#grid-master_standar_nilai').datagrid({
        onLoadSuccess   : function(){
            $('#master_standar_nilai-edit').linkbutton('disable');
            $('#master_standar_nilai-delete').linkbutton('disable');
        },
        onSelect        : function(){
            $('#master_standar_nilai-edit').linkbutton('enable');
            $('#master_standar_nilai-delete').linkbutton('enable');
        },
        onClickRow      : function(){
            $('#master_standar_nilai-edit').linkbutton('enable');
            $('#master_standar_nilai-delete').linkbutton('enable');
        },
        onDblClickRow   : function(){
            masterPesertakpdUpdate();
        },
        view            :scrollview,
        remoteFilter    :true,
        url             :'<?php echo site_url('master/nilai/index'); ?>?grid=true'})
    .datagrid('enableFilter');

    function masterStandar_nilaiRefresh() {
        $('#master_standar_nilai-edit').linkbutton('disable');
        $('#master_karawan-delete').linkbutton('disable');
        $('#grid-master_standar_nilai').datagrid('reload');
    }
    
    function masterStandar_nilaiCreate(){
        $('#dlg-master_standar_nilai').dialog({modal: true}).dialog('open').dialog('setTitle','Tambah Data');
        $('#fm-master_standar_nilai').form('clear');
        url = '<?php echo site_url('master/nilai/create'); ?>';
    }

    function masterStandar_nilaiUpdate() {
        var row = $('#grid-master_standar_nilai').datagrid('getSelected');
        if(row){
            $('#dlg-master_standar_nilai').dialog({modal: true}).dialog('open').dialog('setTitle','Edit Data');
            $('#fm-master_standar_nilai').form('load',row);
            url = '<?php echo site_url('master/nilai/update'); ?>/' + row.m_standar_nilai_grade;
            $('#m_emply_nik').textbox('disable');
        }
        else
        {
             $.messager.alert('Info','Data belum dipilih !','info');
        }
    }
    
    function masterStandar_nilaiSave(){
        $.messager.progress({
            title:'Dagoan Sakedeung',
            msg:'Nendeun Data...'
        });
        $('#fm-master_standar_nilai').form('submit',{
            url: url,
            onSubmit: function(){
                return $(this).form('validate');
            },
            success: function(result){
                $.messager.progress('close');
                var result = eval('('+result+')');
                if(result.success) 
                {
                    $('#dlg-master_standar_nilai').dialog('close');
                    masterStandar_nilaiRefresh();
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
        
   function masterStandar_nilaiHapus(){
        $.messager.progress({
            title:'Dagoan Sakedeung',
            msg:'Pupus Data...'
        });
        var row = $('#grid-master_standar_nilai').datagrid('getSelected');
        if (row){
            var win = $.messager.confirm('Konfirmasi','Anda yakin ingin menghapus \n'+row.m_standar_nilai_nama+' ?',function(r){
                if (r){
                    $.post('<?php echo site_url('master/nilai/delete'); ?>',{m_standar_nilai_grade:row.m_standar_nilai_grade},function(result){
                        $.messager.progress('close');
                        if (result.success)
                        {
                            masterStandar_nilaiRefresh();
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
<div id="dlg-master_standar_nilai" class="easyui-dialog" style="width:600px; height:300px; padding: 10px 20px" closed="true" buttons="#dlg-buttons-master_standar_nilai">
    <form id="fm-master_standar_nilai" method="post" novalidate>        

        <div class="fitem">
            <label for="type">Grade</label>
            <input type="text" id="m_standar_nilai_grade" name="m_standar_nilai_grade" class="easyui-textbox"/>
        </div>
        
        <div class="fitem">
            <label for="type">Skala</label>
            <input type="text" id="m_standar_nilai_skala" name="m_standar_nilai_skala" class="easyui-numberbox"/>
        </div>
        <div class="fitem">
            <label for="type">Nilai Min</label>
            <input type="text" id="m_standar_nilai_min" name="m_standar_nilai_min" class="easyui-numberbox"/>
        </div>
        <div class="fitem">
            <label for="type">Range</label>
            <input type="text" id="m_standar_nilai_range" name="m_standar_nilai_range" class="easyui-textbox"/>
        </div>

    </form>
</div>

<!-- Dialog Button -->
<div id="dlg-buttons-master_standar_nilai">
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-ok" onclick="masterStandar_nilaiSave()">Simpan</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-cancel" onclick="javascript:$('#dlg-master_standar_nilai').dialog('close')">Batal</a>
</div>

<!-- End of file v_pesertakpd.php -->
<!-- Location: ./application/views/master/v_pesertakpd.php -->