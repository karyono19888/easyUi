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
<table id="grid-master_karyawan" data-options="pageSize:50, multiSort:true, remoteSort:true, rownumbers:true, singleSelect:true, 
                fit:true, fitColumns:false, toolbar:toolbar_master_karyawan">
    <thead data-options="frozen:true">
        <tr>
            <th data-options="field:'ck',checkbox:true"></th>
            <th data-options="field:'m_emply_nik'" width="100" align="center" sortable="true">NIK</th>
            <th data-options="field:'m_emply_name'" width="200" halign="center" align="left" sortable="true">Nama</th>
        </tr>
    </thead>
    <thead>
        <tr>
            <th data-options="field:'m_emply_sex'" width="100" halign="center" align="center" sortable="true">L/P</th>
            <th data-options="field:'m_emply_bop'" width="100" halign="center" align="center" sortable="true">Kelahiran</th>
            <th data-options="field:'m_emply_bod'" width="100" halign="center" align="center" sortable="true">TTL</th>
            <th data-options="field:'m_emply_relig'" width="100" halign="center" align="center" sortable="true">Agama</th>
            <th data-options="field:'m_emply_marital'" width="100" halign="center" align="center" sortable="true">Status</th>
            <th data-options="field:'m_emply_ktp'" width="130" halign="center" align="center" sortable="true">KTP</th>
            <th data-options="field:'m_emply_cell'" width="100" halign="center" align="center" sortable="true">No Telp</th>
            <th data-options="field:'m_emply_add'" width="400" halign="center" align="left" sortable="true">Domisili</th>
            <th data-options="field:'m_emply_start'" width="100" halign="center" align="center" sortable="true">Tgl Masuk</th>
            <th data-options="field:'m_emply_status'" width="100" halign="center" align="center" sortable="true">Status Karyawan</th>
            <th data-options="field:'m_pendidikan_nama'" width="100" halign="center" align="center" sortable="true">Pendidikan</th>
            <th data-options="field:'b.departemen_nama'" width="100" halign="center" align="center" sortable="true">Dept</th>
            <th data-options="field:'a.departemen_nama'" width="100" halign="center" align="center" sortable="true">Bagian</th>
            <th data-options="field:'m_jabatan_nama'" width="100" halign="center" align="center" sortable="true">Jabatan</th>
            <th data-options="field:'m_emply_end'" width="100" halign="center" align="center" sortable="true">Tgl Keluar</th>

        </tr>
    </thead>
</table>
<div id="dlg-master_karyawan_view_image"></div>
<script type="text/javascript">
    var toolbar_master_karyawan = [{
        id      : 'master_karyawan-new',
        text    : 'New',
        iconCls : 'icon-new_file',
        handler : function(){masterKaryawanCreate();}
    },{
        id      : 'master_karyawan-edit',
        text    : 'Edit',
        iconCls : 'icon-edit',
        handler : function(){masterKaryawanUpdate();}
    },{
        id      : 'master_karyawan-delete',
        text    : 'Delete',
        iconCls : 'icon-cancel',
        handler : function(){masterKaryawanHapus();}
    },{
        text    : 'Refresh',
        iconCls : 'icon-reload',
        handler : function(){masterKaryawanRefresh();}
    },{
        text    : 'Upload Foto',
        iconCls : 'icon-upload',
        handler : function(){masterKaryawanUpload();}
    },{
        id      : 'master_karyawan_view-image',
        text    : 'View Image',
        iconCls : 'icon-picture',
        handler : function(){masterKaryawanViewImage();}
    },{
        id      : 'master_karyawan_delete-image',
        text    : 'Delete Image',
        iconCls : 'icon-cancel',
        handler : function(){masterKaryawanDeleteImage();}
    }];
    
    $('#grid-master_karyawan').datagrid({
        onLoadSuccess   : function(){
            $('#master_karyawan-edit').linkbutton('disable');
            $('#master_karyawan-delete').linkbutton('disable');
        },
        onSelect        : function(){
            $('#master_karyawan-edit').linkbutton('enable');
            $('#master_karyawan-delete').linkbutton('enable');
        },
        onClickRow      : function(){
            $('#master_karyawan-edit').linkbutton('enable');
            $('#master_karyawan-delete').linkbutton('enable');
        },
        onDblClickRow   : function(){
            masterPesertakpdUpdate();
        },
        view            :scrollview,
        remoteFilter    :true,
        url             :'<?php echo site_url('master/karyawan/index'); ?>?grid=true'})
    .datagrid('enableFilter');

    function masterKaryawanRefresh() {
        $('#master_karyawan-edit').linkbutton('disable');
        $('#master_karawan-delete').linkbutton('disable');
        $('#grid-master_karyawan').datagrid('reload');
    }
    
    function masterKaryawanCreate(){
        $('#dlg-master_karyawan').dialog({modal: true}).dialog('open').dialog('setTitle','Tambah Data');
        $('#fm-master_karyawan').form('clear');
        url = '<?php echo site_url('master/karyawan/create'); ?>';
    }

    function masterKaryawanUpdate() {
        var row = $('#grid-master_karyawan').datagrid('getSelected');
        if(row){
            $('#dlg-master_karyawan').dialog({modal: true}).dialog('open').dialog('setTitle','Edit Data');
            $('#fm-master_karyawan').form('load',row);
            url = '<?php echo site_url('master/karyawan/update'); ?>/' + row.m_emply_nik;
            //$('#m_emply_nik').textbox('disable');
        }
        else
        {
             $.messager.alert('Info','Data belum dipilih !','info');
        }
    }
    
    function masterKaryawanSave(){
        $('#fm-master_karyawan').form('submit',{
            url: url,
            onSubmit: function(){
                var valid = $(this).form('validate');
                if(valid){
                    return true;
                    $.messager.progress({
                        title:'Please wait',
                        msg:'Saving Data...'
                    });
                    $('#bt_save-master_karyawan').linkbutton('disable');                    
                }
                else{
                    return false;
                }
            },
            success: function(result){
                var result = eval('('+result+')');
                if(result.success) 
                {
                    $('#dlg-master_karyawan').dialog('close');
                    masterKaryawanRefresh();
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
        
   function masterKaryawanHapus(){
        var row = $('#grid-master_karyawan').datagrid('getSelected');
        if (row){
            var win = $.messager.confirm('Konfirmasi','Anda yakin ingin menghapus \n'+row.m_emply_nama+' ?',function(r){
                if (r){
                    $.post('<?php echo site_url('master/karyawan/delete'); ?>',{m_emply_nik:row.m_emply_nik},function(result){
                        if (result.success)
                        {
                            masterKaryawanRefresh();
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
    
    function masterKaryawanUpload() {
        var row = $('#grid-master_karyawan').datagrid('getSelected');
        if(row){
            $('#dlg-master_karyawan_upload').dialog({modal: true}).dialog('open').dialog('setTitle','Upload Data');
            $('#fm-master_karyawan_upload').form('load',row);
            urlupload = '<?php echo site_url('master/karyawan/upload'); ?>/' + row.m_emply_nik;
        }
        else
        {
             $.messager.alert('Info','Data belum dipilih !','info');
        }
    }
    
    function masterKaryawanUploadSave(){
        $.messager.progress({
            title:'Dagoan Sakedeung',
            msg:'Nendeun Data...'
        });
        $('#fm-master_karyawan_upload').form('submit',{
            url: urlupload,
            onSubmit: function(){
                return $(this).form('validate');
            },
            success: function(result){
                $.messager.progress('close');
                var result = eval('('+result+')');
                if(result.success) 
                {
                    $('#dlg-master_karyawan_upload').dialog('close');
                    masterKaryawanRefresh();
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
    
    function masterKaryawanViewImage() {
        var rowImage = $('#grid-master_karyawan').datagrid('getSelected');
        if (rowImage){
            $.post('<?php echo site_url('master/karyawan/viewImage'); ?>',{id:rowImage.m_emply_nik},function(result){
                if (result.success){
                    var content = '<iframe scrolling="auto" frameborder="0"  src="'+result.img+'" style="width:100%;height:100%;"></iframe>';
                    $('#dlg-master_karyawan_view_image').dialog({
                        title   : 'ID : '+rowImage.m_emply_nik,
                        content : content,
                        modal   : true,
                        iconCls : 'icon-picture',
                        plain   : true,
                        width   : '80%',
                        height  : '80%'
                    });
                } else {
                    $.messager.show({
                        title: 'Error',
                        msg: 'Gambar Tidak Ditemukan'
                    });
                }
            },'json');
        }
        else{
            $.messager.alert('Info','Data belum dipilih !','info');
        }
    }
    
    function masterKaryawanDeleteImage(){
        var row = $('#grid-master_karyawan').datagrid('getSelected');
        if (row){
            var win = $.messager.confirm('Konfirmasi','Anda yakin ingin menghapus Foto sebelumnya \n'+row.m_emply_nik+' ?',function(r){
                if (r){
                    $.post('<?php echo site_url('master/karyawan/deleteImage'); ?>',{m_emply_nik:row.m_emply_nik},function(result){
                        if (result.success)
                        {
                            masterKaryawanRefresh();
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
    
    function tambahJobSpec(){
        $('#dlg-master_jobspec').dialog({modal: true}).dialog('open').dialog('setTitle','Tambah Data');
        $('#fm-master_jobspec').form('clear');
        urljobspec = '<?php echo site_url('master/jobspec/create'); ?>';
       // $('#m_cust_id').textbox('enable');
        
    } 
    
     function masterJobSpecSave(){
        $('#fm-master_jobspec').form('submit',{
            url: urljobspec,
            onSubmit: function(){
                var valid = $(this).form('validate');
                if(valid){
                    return true;
                    $.messager.progress({
                        title:'Please wait',
                        msg:'Saving Data...'
                    });
                    $('#bt_save-master_jobspec').linkbutton('disable');                    
                }
                else{
                    return false;
                }
            },
            success: function(result){
                $.messager.progress('close');
                $('#bt_save-master_jobspec').linkbutton('enable');
                var result = eval('('+result+')');
                if(result.success) 
                {
                    $('#dlg-master_jobspec').dialog('close');
                    $('#m_emply_job_spec').combogrid('reload');
                  //  masterLabelRefresh();
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
<div id="dlg-master_karyawan" class="easyui-dialog" style="width:600px; height:630px; padding: 10px 20px" closed="true" buttons="#dlg-buttons-master_karyawan">
    <form id="fm-master_karyawan" method="post" novalidate>        
        <div class="fitem">
            <label for="type">NIK</label>
            <input type="text" id="m_emply_nik" name="m_emply_nik" class="easyui-textbox" required="true"/>
        </div>
        <div class="fitem">
            <label for="type">Nama</label>
            <input type="text" id="m_emply_name" name="m_emply_name" class="easyui-textbox"/>
        </div>
        <div class="fitem">
             <label for="type">Jenis Kelamin</label>
             <select id="m_emply_sex" name="m_emply_sex" class="easyui-combobox" style="width:200px" data-options="panelHeight:'auto'" required="true">
             <option value="Laki-Laki">Laki Laki</option>
             <option value="Perempuan">Perempuan</option>
             </select>
        </div>
        <div class="fitem">
            <label for="type">Kelahiran</label>
            <input type="text" id="m_emply_bop" name="m_emply_bop" class="easyui-textbox"/>
        </div>
        <div class="fitem">
            <label for="type">TTL</label>
            <input type="text" id="m_emply_bod" name="m_emply_bod" class="easyui-datebox"/>
        </div>
        <div class="fitem">
             <label for="type">Agama</label>
             <select id="m_emply_relig" name="m_emply_relig" class="easyui-combobox" style="width:200px" data-options="panelHeight:'auto'" required="true">
             <option value="Islam">Islam</option>
             <option value="Kristen">Kristen</option>
             <option value="Katolik">Katolik</option>
             <option value="Budha">Budha</option>
             <option value="Hindu">Hindu</option>
             </select>
        </div>
        <div class="fitem">
             <label for="type">Status</label>
             <select id="m_emply_marital" name="m_emply_marital" class="easyui-combobox" style="width:200px" data-options="panelHeight:'auto'" required="true">
             <option value="Lajang">Lajang</option>
             <option value="Nikah">Nikah</option>
             <option value="Cerai">Cerai</option>
             </select>
        </div>
        <div class="fitem">
            <label for="type">KTP</label>
            <input type="text" id="m_emply_ktp" name="m_emply_ktp" class="easyui-textbox"/>
        </div>
        <div class="fitem">
            <label for="type">Domisili</label>
            <input type="text" id="m_emply_add" name="m_emply_add" class="easyui-textbox"/>
        </div>
        <div class="fitem">
            <label for="type">Kota</label>
            <input type="text" id="m_emply_city" name="m_emply_city" class="easyui-textbox"/>
        </div>
        <div class="fitem">
            <label for="type">Kode Pos</label>
            <input type="text" id="m_emply_zip" name="m_emply_zip" class="easyui-textbox"/>
        </div>
        <div class="fitem">
            <label for="type">No HP</label>
            <input type="text" id="m_emply_cell" name="m_emply_cell" class="easyui-textbox"/>
        </div>
        <div class="fitem">
            <label for="type">Tgl Masuk</label>
            <input type="text" id="m_emply_start" name="m_emply_start" class="easyui-datebox"/>
        </div>
        <div class="fitem">
             <label for="type">Status Karyawan</label>
             <select id="m_emply_status" name="m_emply_status" class="easyui-combobox" style="width:200px" data-options="panelHeight:'auto'" required="true">
             <option value="Kontrak">Kontrak</option>
             <option value="Tetap">Tetap</option>
             </select>
        </div>  
        <div class="fitem">
            <label for="type">Bagian </label>
            <input type="text" id="m_emply_dept" name="m_emply_dept" style="width:200px;" class="easyui-combobox" required="true"
            data-options="url:'<?php echo site_url('master/karyawan/getBag'); ?>',
            method:'get', valueField:'departemen_id', groupField:'departemen_idk', textField:'departemen_nama', panelHeight:'150'"/>
        </div>
        <div class="fitem">
            <label for="type">Pendidikan </label>
            <input type="text" id="m_emply_educ" name="m_emply_educ" style="width:200px;" class="easyui-combobox" required="true"
            data-options="url:'<?php echo site_url('master/karyawan/getEduc'); ?>',
            method:'get', valueField:'m_pendidikan_id', textField:'m_pendidikan_nama', panelHeight:'150'"/>
        </div> 
        <div class="fitem">
            <label for="type">Jabatan </label>
            <input type="text" id="m_emply_jabatan" name="m_emply_jabatan" style="width:200px;" class="easyui-combobox" required="true"
            data-options="url:'<?php echo site_url('master/karyawan/getJab'); ?>',
            method:'get', valueField:'m_jabatan_id', textField:'m_jabatan_nama', panelHeight:'150'"/>
        </div> 
        <div class="fitem">
                <label for="type">Job Spec</label>
                <select id="m_emply_job_spec" name="m_emply_job_spec" class="easyui-combogrid" style="width:150px;" data-options="
                    panelWidth: 500,
                    idField: 'm_jobspec_id',
                    textField: 'm_jobspec_nama',
                    url: '<?php echo site_url('master/karyawan/getExp'); ?>',
                    method: 'get',
                    mode:'remote',
                    columns: [[
                        {field:'m_jobspec_id',title:'Item ID',width:40},
                        {field:'m_jobspec_nama',title:'Nama',width:100,sortable:true},
                        {field:'departemen_nama',title:'Dept',width:100},
                        {field:'m_jobspec_educ_std',title:'Pendidikan',width:100},
                        {field:'m_jobspec_pengalaman_std',title:'Pengalaman',width:100}
                    ]],
                    fitColumns: true,
                    labelPosition: 'top',
                    onShowPanel: function(){
                    $('#m_emply_job_spec').combogrid('grid').datagrid('reload');
                }
                ">
                </select>
                <a id="button_addJobSpec" href="javascript:tambahJobSpec()" class="easyui-linkbutton easyui-tooltip"  
            title="Tambah Job Spec." iconCls="icon-add" plain="true" data-options="position:'right'" onclick=""></a>
          </div>
        <div class="fitem">
            <label for="type">Tgl Keluar</label>
            <input type="text" id="m_emply_end" name="m_emply_end" class="easyui-datebox"/>
        </div>
    </form>
</div>

<!-- Dialog Button -->
<div id="dlg-buttons-master_karyawan">
    <a href="javascript:void(0)" id="bt_save-master_karyawan" class="easyui-linkbutton" data-options="width:75" iconCls="icon-ok" onclick="masterKaryawanSave()">Simpan</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-cancel" onclick="javascript:$('#dlg-master_karyawan').dialog('close')">Batal</a>
</div>


<!-- Dialog Upload -->
<div id="dlg-master_karyawan_upload" class="easyui-dialog" style="width:400px; height:250px; padding: 10px 20px" closed="true" buttons="#dlg-buttons-master_karyawan_upload">
    <form id="fm-master_karyawan_upload" method="post" enctype="multipart/form-data" novalidate>        
        <div class="fitem">
            <label for="type">Upload Foto</label>
            <input type="text" id="filea" name="filea" style="width:300px;" class="easyui-filebox"/>
        </div>
    </form>
</div>

<!-- Dialog Button -->
<div id="dlg-buttons-master_karyawan_upload">
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-ok" onclick="masterKaryawanUploadSave()">Simpan</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-cancel" onclick="javascript:$('#dlg-master_karyawan_upload').dialog('close')">Batal</a>
</div>

<!-- Form Add Jobspec -->

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
    <a href="javascript:void(0)" id="bt_save-master_jobspec" class="easyui-linkbutton" data-options="width:75" iconCls="icon-ok" onclick="masterJobSpecSave()">Simpan</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-cancel" onclick="javascript:$('#dlg-master_jobspec').dialog('close')">Batal</a>
</div>

<!-- End of file v_pesertakpd.php -->
<!-- Location: ./application/views/master/v_pesertakpd.php -->