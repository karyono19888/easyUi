<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<!-- Data Grid -->
<table id="grid-transaksi_proposal"
    data-options="pageSize:50, multiSort:true, remoteSort:true, rownumbers:true, singleSelect:true, 
                fit:true, fitColumns:true, toolbar:toolbar_transaksi_proposal">
    <thead>
        <tr>
            <th data-options="field:'ck',checkbox:true" ></th>
            <th data-options="field:'departemen_nama'"    width="200" halign="center" align="center" sortable="true">Departemen</th>
            <th data-options="field:'t_proposal_periode'"  width="50" halign="center" align="center" sortable="true">Periode</th>
            <th data-options="field:'t_proposal_tahun'"  width="100" halign="center" align="center" sortable="true">Tahun</th>
            <th data-options="field:'t_proposal_jenis'"  width="100" halign="center" align="center" sortable="true">Jenis</th>
            <th data-options="field:'m_materi_nama'"  width="200" halign="center" align="center" sortable="true">Materi</th>
            <th data-options="field:'m_emply_name'"  width="300" halign="center" align="center" sortable="true">Peserta</th>
            <th data-options="field:'t_proposal_instruktur'"  width="300" halign="center" align="center" sortable="true">Instruktur</th>
            <th data-options="field:'t_proposal_keterangan'"  width="400" halign="center" align="center" sortable="true">Keterangan</th>
            <th data-options="field:'t_proposal_status'"  width="50" halign="center" align="center" sortable="true">Status</th>
        </tr>
    </thead>
</table>

<script type="text/javascript">
    var toolbar_transaksi_proposal = [{
        id      : 'transaksi_proposal-new',
        text    : 'New',
        iconCls : 'icon-new_file',
        handler : function(){transaksiProposalCreate();}
    },{
        id      : 'transaksi_proposal-edit',
        text    : 'Edit',
        iconCls : 'icon-edit',
        handler : function(){transaksiProposalUpdate();}
    },{
        id      : 'transaksi_proposal-delete',
        text    : 'Delete',
        iconCls : 'icon-cancel',
        handler : function(){transaksiProposalHapus();}
    },{
        text    : 'Refresh',
        iconCls : 'icon-reload',
        handler : function(){transaksiProposalRefresh();}
    }];
    
    $('#grid-transaksi_proposal').datagrid({
        onLoadSuccess   : function(){
            $('#transaksi_proposal-edit').linkbutton('disable');
            $('#transaksi_proposal-delete').linkbutton('disable');
        },
        onSelect        : function(){
            $('#transaksi_proposal-edit').linkbutton('enable');
            $('#transaksi_proposal-delete').linkbutton('enable');
        },
        onClickRow      : function(){
            $('#transaksi_proposal-edit').linkbutton('enable');
            $('#transaksi_proposal-delete').linkbutton('enable');
        },
        onDblClickRow   : function(){
            transaksiPesertakpdUpdate();
        },
        rowStyler: function(index,row){
            if (row['t_proposal_status']=='1'){
                return 'background-color:#D1FFB3;color:#000;';
            }
            if (row['t_proposal_status']=='0'){
                return 'background-color:#FFB6C1;color:#000;';
            }
	},
        view            :scrollview,
        remoteFilter    :true,
        url             :'<?php echo site_url('transaksi/proposal/index'); ?>?grid=true'})
    .datagrid('enableFilter');

    function transaksiProposalRefresh() {
        $('#transaksi_proposal-edit').linkbutton('disable');
        $('#transaksi_karawan-delete').linkbutton('disable');
        $('#grid-transaksi_proposal').datagrid('reload');
    }
    
    function transaksiProposalCreate(){
        $('#dlg-transaksi_proposal').dialog({modal: true}).dialog('open').dialog('setTitle','Tambah Data');
        $('#fm-transaksi_proposal').form('clear');
        $('#t_proposal_tahun').numberspinner('setValue',<?php echo date("Y"); ?>);
        url = '<?php echo site_url('transaksi/proposal/create'); ?>';
    }

    function transaksiProposalUpdate() {
        var row = $('#grid-transaksi_proposal').datagrid('getSelected');
        if(row){
            $('#dlg-transaksi_proposal_update').dialog({modal: true}).dialog('open').dialog('setTitle','Edit Data');
            $('#fm-transaksi_proposal_update').form('load',row);
            urlupdate = '<?php echo site_url('transaksi/proposal/update'); ?>/' + row.t_proposal_id;
            //$('#m_emply_nik').textbox('disable');
        }
        else
        {
             $.messager.alert('Info','Data belum dipilih !','info');
        }
    }
    
    function transaksiProposalSave(){
        $('#fm-transaksi_proposal').form('submit',{
            url: url,
            onSubmit: function(){
                return $(this).form('validate');
            },
            iframe: false,
            onProgress: function(percent){
               // $('#progressFile').progressbar('setValue', percent);   
                $.messager.progress({
                        title:'Dagoan Sakedeung',
                        msg:'Nendeun Data...'
                    });
            },
            success: function(result){
                $.messager.progress('close');
                var result = eval('('+result+')');
                if(result.success) {
                    //$('#grid-transaksi_proposal').datagrid('reload');      
                    $('#t_proposal_peserta').combogrid('clear');
                    transaksiProposalRefresh();
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
    
    function transaksiProposalUpdateSave(){
        $('#fm-transaksi_proposal_update').form('submit',{
            url: urlupdate,
            onSubmit: function(){
                return $(this).form('validate');
            },
            iframe: false,
            onProgress: function(percent){
               // $('#progressFile').progressbar('setValue', percent);   
                $.messager.progress({
                        title:'Dagoan Sakedeung',
                        msg:'Nendeun Data...'
                    });
            },
            success: function(result){
                $.messager.progress('close');
                var result = eval('('+result+')');
                if(result.success) {
                    //$('#grid-transaksi_proposal').datagrid('reload');      
                    $('#t_proposal_peserta').combogrid('clear');
                    transaksiProposalRefresh();
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
    
        
   function transaksiProposalHapus(){
        $.messager.progress({
            title:'Dagoan Sakedeung',
            msg:'Pupus Data...'
        });
        var row = $('#grid-transaksi_proposal').datagrid('getSelected');
        if (row){
            var win = $.messager.confirm('Konfirmasi','Anda yakin ingin menghapus \n'+row.t_proposal_id+' ?',function(r){
                if (r){
                    $.post('<?php echo site_url('transaksi/proposal/delete'); ?>',{t_proposal_id:row.t_proposal_id},function(result){
                        $.messager.progress('close');
                        if (result.success)
                        {
                            transaksiProposalRefresh();
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

    
 id_dept = 0;
    
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
    #fm-transaksi_pesertakpd{
        margin:0;
        padding:10px 30px;
    }
    #fm-transaksi_pesertakpd-upload{
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
<div id="dlg-transaksi_proposal" class="easyui-dialog" style="width:600px; height:400px; padding: 10px 20px" closed="true" buttons="#dlg-buttons-transaksi_proposal">
    <form id="fm-transaksi_proposal" method="post" novalidate>        

        
        <div class="fitem">
            <label for="type">Departemen </label>
            <input type="text" id="t_proposal_dept" name="t_proposal_dept" style="width:150px;" class="easyui-combobox" required="true" 
            data-options="url:'<?php echo site_url('transaksi/proposal/getDept'); ?>',
            method:'get', valueField:'departemen_id', textField:'departemen_nama', panelHeight:'150',
            onSelect: function(rec){
                id_dept = rec.departemen_id;
                var url2 = '<?php echo site_url('transaksi/proposal/getPeserta'); ?>/'+id_dept;
                $('#t_proposal_peserta').combogrid('grid').datagrid('reload', url2);
                $('#t_proposal_peserta').combogrid('setValue', '');
            }
            "/>
        </div>
        
        <div class="fitem">
             <label for="type">Periode</label>
             <select id="t_proposal_periode" name="t_proposal_periode" class="easyui-combobox" style="width:150px" data-options="panelHeight:'auto'" required="true">
             <option value="1">1</option>
             <option value="2">2</option>
             </select>
        </div>
        <div class="fitem">
            <label for="type">Tahun</label>
            <input type="text" id="t_proposal_tahun" name="t_proposal_tahun" class="easyui-numberspinner" value="<?php echo date("Y"); ?>"/>
        </div>
        
        <div class="fitem">
             <label for="type">Jenis Training</label>
             <select id="t_proposal_jenis" name="t_proposal_jenis" class="easyui-combobox" style="width:150px" data-options="panelHeight:'auto'" required="true">
             <option value="INTERNAL">INTERNAL</option>
             <option value="EKSTERNAL">EKSTERNAL</option>
             </select>
        </div>
        
        <div class="fitem">
            <label for="type">Materi </label>
            <input type="text" id="t_proposal_materi" name="t_proposal_materi" style="width:250px;" class="easyui-combobox" required="true"
            data-options="url:'<?php echo site_url('transaksi/proposal/getMateri'); ?>',
            method:'get', valueField:'m_materi_no', textField:'m_materi_nama', panelHeight:'150'"/>
        </div>
        <div class="fitem">
                <label for="type">Peserta</label>
                <select id="t_proposal_peserta" name="t_proposal_peserta" class="easyui-combogrid" style="width:250px;" required="true" data-options="
                    panelWidth: 500,
                    idField: 'm_emply_nik',
                    textField: 'm_emply_name',
                    url: '<?php echo site_url('transaksi/proposal/getPeserta'); ?>/'+id_dept,
                    method: 'get',
                    mode:'remote',
                    columns: [[
                        {field:'m_emply_nik',title:'NIK',width:40},
                        {field:'m_emply_name',title:'Nama',width:100,sortable:true}
                    ]],
                    fitColumns: true,
                    labelPosition: 'top'
                ">
                </select>
        </div>
        <div class="fitem">
            <label for="type">Instruktur </label>
            <input type="text" id="t_proposal_instruktur" name="t_proposal_instruktur" style="width:250px;" class="easyui-combobox" required="true"
            data-options="method:'get', valueField:'t_proposal_instruktur', textField:'t_proposal_instruktur', panelHeight:'150', hasDownArrow: false,
                        onShowPanel:function(){
                        var url = '<?php echo site_url('transaksi/proposal/getInstruktur'); ?>';
                        $('#t_proposal_instruktur').combobox('reload', url);
                        }"/>
        </div>
        <div class="fitem">
            <label for="type"> Keterangan</label>
            <input type="text" id="t_proposal_keterangan" name="t_proposal_keterangan" class="easyui-textbox"  style="width:50%;height:50px" multiline="true"/>
        </div>
    </form>
</div>

<!-- Dialog Button -->
<div id="dlg-buttons-transaksi_proposal">
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-ok" onclick="transaksiProposalSave()">Simpan</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-cancel" onclick="javascript:$('#dlg-transaksi_proposal').dialog('close')">Batal</a>
</div>

<div id="dlg-transaksi_proposal_update" class="easyui-dialog" style="width:600px; height:400px; padding: 10px 20px" closed="true" buttons="#dlg-buttons-transaksi_proposal_update">
    <form id="fm-transaksi_proposal_update" method="post" novalidate>        

        
        <div class="fitem">
            <label for="type">Departemen </label>
            <input type="text" id="t_proposal_dept" name="t_proposal_dept" style="width:150px;" class="easyui-combobox" required="true" 
            data-options="url:'<?php echo site_url('transaksi/proposal/getProp'); ?>',
            method:'get', valueField:'departemen_id', textField:'departemen_nama', panelHeight:'150'"/>
        </div>
        
        <div class="fitem">
             <label for="type">Periode</label>
             <select id="t_proposal_periode" name="t_proposal_periode" class="easyui-combobox" style="width:150px" data-options="panelHeight:'auto'" required="true">
             <option value="1">1</option>
             <option value="2">2</option>
             </select>
        </div>
        <div class="fitem">
            <label for="type">Tahun</label>
            <input type="text" id="t_proposal_tahun" name="t_proposal_tahun" class="easyui-numberspinner" value="<?php echo date("Y"); ?>"/>
        </div>
        
        <div class="fitem">
             <label for="type">Jenis Training</label>
             <select id="t_proposal_jenis" name="t_proposal_jenis" class="easyui-combobox" style="width:150px" data-options="panelHeight:'auto'" required="true">
             <option value="INTERNAL">INTERNAL</option>
             <option value="EKSTERNAL">EKSTERNAL</option>
             </select>
        </div>
        
        <div class="fitem">
            <label for="type">Materi </label>
            <input type="text" id="t_proposal_materi" name="t_proposal_materi" style="width:250px;" class="easyui-combobox" required="true"
            data-options="url:'<?php echo site_url('transaksi/proposal/getMateri'); ?>',
            method:'get', valueField:'m_materi_no', textField:'m_materi_nama', panelHeight:'150'"/>
        </div>
        <div class="fitem">
                <label for="type">Peserta</label>
                <select id="t_proposal_peserta" name="t_proposal_peserta" class="easyui-combogrid" style="width:250px;" required="true" data-options="
                    panelWidth: 500,
                    idField: 'm_emply_nik',
                    textField: 'm_emply_name',
                    url: '<?php echo site_url('transaksi/proposal/getPesertaU'); ?>',
                    method: 'get',
                    mode:'remote',
                    columns: [[
                        {field:'m_emply_nik',title:'NIK',width:40},
                        {field:'m_emply_name',title:'Nama',width:100,sortable:true}
                    ]],
                    fitColumns: true,
                    labelPosition: 'top'
                ">
                </select>
        </div>
        <div class="fitem">
            <label for="type">Instruktur </label>
            <input type="text" id="t_proposal_instruktur" name="t_proposal_instruktur" style="width:250px;" class="easyui-combobox" required="true"
            data-options="method:'get', valueField:'t_proposal_instruktur', textField:'t_proposal_instruktur', panelHeight:'150', hasDownArrow: false,
                        onShowPanel:function(){
                        var url = '<?php echo site_url('transaksi/proposal/getInstruktur'); ?>';
                        $('#t_proposal_instruktur').combobox('reload', url);
                        }"/>
        </div>
        <div class="fitem">
            <label for="type"> Keterangan</label>
            <input type="text" id="t_proposal_keterangan" name="t_proposal_keterangan" class="easyui-textbox"  style="width:50%;height:50px" multiline="true"/>
        </div>
    </form>
</div>

<!-- Dialog Button -->
<div id="dlg-buttons-transaksi_proposal_update">
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-ok" onclick="transaksiProposalUpdateSave()">Simpan</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-cancel" onclick="javascript:$('#dlg-transaksi_proposal_update').dialog('close')">Batal</a>
</div>
<!-- End of file v_pesertakpd.php -->
<!-- Location: ./application/views/transaksi/v_pesertakpd.php -->