<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<!-- Data Grid -->
<table id="grid-master_materi"
    data-options="pageSize:50, multiSort:true, remoteSort:true, rownumbers:true, singleSelect:true, 
                fit:true, fitColumns:true, toolbar:toolbar_master_materi">
    <thead>
        <tr>
            <th data-options="field:'ck',checkbox:true" ></th>
            <th data-options="field:'m_materi_no'"    width="100" align="center" sortable="true">No</th>
            <th data-options="field:'m_materi_nama'"  width="400" halign="center" align="left" sortable="true">Nama</th>            
        </tr>
    </thead>
</table>

<script type="text/javascript">
    var toolbar_master_materi = [{
        id      : 'master_materi-new',
        text    : 'New',
        iconCls : 'icon-new_file',
        handler : function(){masterMateriCreate();}
    },{
        id      : 'master_materi-edit',
        text    : 'Edit',
        iconCls : 'icon-edit',
        handler : function(){masterMateriUpdate();}
    },{
        id      : 'master_materi-delete',
        text    : 'Delete',
        iconCls : 'icon-cancel',
        handler : function(){masterMateriHapus();}
    },{
        text    : 'Refresh',
        iconCls : 'icon-reload',
        handler : function(){masterMateriRefresh();}
    }];
    
    $('#grid-master_materi').datagrid({
        onLoadSuccess   : function(){
            $('#master_materi-edit').linkbutton('disable');
            $('#master_materi-delete').linkbutton('disable');
        },
        onSelect        : function(){
            $('#master_materi-edit').linkbutton('enable');
            $('#master_materi-delete').linkbutton('enable');
        },
        onClickRow      : function(){
            $('#master_materi-edit').linkbutton('enable');
            $('#master_materi-delete').linkbutton('enable');
        },
        onDblClickRow   : function(){
            masterPesertakpdUpdate();
        },
        view            :scrollview,
        remoteFilter    :true,
        url             :'<?php echo site_url('master/materi/index'); ?>?grid=true'})
    .datagrid('enableFilter');

    function masterMateriRefresh() {
        $('#master_materi-edit').linkbutton('disable');
        $('#master_karawan-delete').linkbutton('disable');
        $('#grid-master_materi').datagrid('reload');
    }
    
    function masterMateriCreate(){
        $('#dlg-master_materi').dialog({modal: true}).dialog('open').dialog('setTitle','Tambah Data');
        $('#fm-master_materi').form('clear');
        url = '<?php echo site_url('master/materi/create'); ?>';
    }

    function masterMateriUpdate() {
        var row = $('#grid-master_materi').datagrid('getSelected');
        if(row){
            $('#dlg-master_materi').dialog({modal: true}).dialog('open').dialog('setTitle','Edit Data');
            $('#fm-master_materi').form('load',row);
            url = '<?php echo site_url('master/materi/update'); ?>/' + row.m_materi_no;
            $('#m_emply_nik').textbox('disable');
        }
        else
        {
             $.messager.alert('Info','Data belum dipilih !','info');
        }
    }
    
    function masterMateriSave(){
        $.messager.progress({
            title:'Dagoan Sakedeung',
            msg:'Nendeun Data...'
        });
        $('#fm-master_materi').form('submit',{
            url: url,
            onSubmit: function(){
                return $(this).form('validate');
            },
            success: function(result){
                $.messager.progress('close');
                var result = eval('('+result+')');
                if(result.success) 
                {
                    $('#dlg-master_materi').dialog('close');
                    masterMateriRefresh();
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
        
   function masterMateriHapus(){
        $.messager.progress({
            title:'Dagoan Sakedeung',
            msg:'Pupus Data...'
        });
        var row = $('#grid-master_materi').datagrid('getSelected');
        if (row){
            var win = $.messager.confirm('Konfirmasi','Anda yakin ingin menghapus \n'+row.m_materi_nama+' ?',function(r){
                if (r){
                    $.post('<?php echo site_url('master/materi/delete'); ?>',{m_materi_no:row.m_materi_no},function(result){
                        $.messager.progress('close');
                        if (result.success)
                        {
                            masterMateriRefresh();
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
<div id="dlg-master_materi" class="easyui-dialog" style="width:600px; height:300px; padding: 10px 20px" closed="true" buttons="#dlg-buttons-master_materi">
    <form id="fm-master_materi" method="post" novalidate>        

        <div class="fitem">
            <label for="type">Nama</label>
            <input type="text" id="m_materi_nama" name="m_materi_nama" class="easyui-textbox"/>
        </div>

    </form>
</div>

<!-- Dialog Button -->
<div id="dlg-buttons-master_materi">
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-ok" onclick="masterMateriSave()">Simpan</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-cancel" onclick="javascript:$('#dlg-master_materi').dialog('close')">Batal</a>
</div>

<!-- End of file v_pesertakpd.php -->
<!-- Location: ./application/views/master/v_pesertakpd.php -->