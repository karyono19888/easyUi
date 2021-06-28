<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script type="text/javascript">
    $.extend($.fn.datebox.defaults, {
        formatter: function(date) {
            var y = date.getFullYear();
            var m = date.getMonth() + 1;
            var d = date.getDate();
            return y + '-' + (m < 10 ? ('0' + m) : m) + '-' + (d < 10 ? ('0' + d) : d);
        },
        parser: function(s) {
            if (!s) return new Date();
            var ss = (s.split('-'));
            var y = parseInt(ss[0], 10);
            var m = parseInt(ss[1], 10);
            var d = parseInt(ss[2], 10);
            if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
                return new Date(y, m - 1, d);
            } else {
                return new Date();
            }
        }
    });
</script>
<!-- Data Grid -->
<table id="grid-master_komputer" data-options="pageSize:50, multiSort:true, remoteSort:true, rownumbers:true, singleSelect:true, 
                fit:true, fitColumns:true, toolbar:toolbar_master_komputer">
    <thead>
        <tr>
            <th data-options="field:'ck',checkbox:true"></th>
            <th data-options="field:'m_komputer_hostname'" width="100" align="center" sortable="true">Hostname </th>
            <th data-options="field:'m_departemen_pt'" width="100" align="center" sortable="true">Perusahaan</th>
            <th data-options="field:'m_departemen_dept'" width="100" align="center" sortable="true">Departemen</th>
            <th data-options="field:'m_komputer_user'" width="200" halign="center" align="left" sortable="true">Nama User</th>
            <th data-options="field:'m_komputer_masuk'" width="100" align="center" sortable="true">Tanggal Masuk</th>
            <th data-options="field:'m_komputer_keluar'" width="100" align="center" sortable="true">Tanggal Keluar</th>
            <th data-options="field:'m_komputer_input'" width="100" align="center" sortable="true">Tanggal Input</th>
            <th data-options="field:'m_komputer_keterangan'" width="400" align="center" sortable="true">Keterangan</th>
        </tr>
    </thead>
</table>

<script type="text/javascript">
    var toolbar_master_komputer = [{
        id: 'master_komputer-new',
        text: 'New',
        iconCls: 'icon-new_file',
        handler: function() {
            masterKomputerCreate();
        }
    }, {
        id: 'master_komputer-edit',
        text: 'Edit',
        iconCls: 'icon-edit',
        handler: function() {
            masterKomputerUpdate();
        }
    }, {
        text: 'Refresh',
        iconCls: 'icon-reload',
        handler: function() {
            masterKomputerRefresh();
        }
    }, {
        id: 'master_item_komputer_cetak',
        text: 'Cetak Asset Komputer',
        iconCls: 'icon-print',
        handler: function() {
            masterKomputerCetak();
        }
    }];
    $('#grid-master_komputer').datagrid({
            onLoadSuccess: function() {
                $('#master_komputer-edit').linkbutton('disable');
                $('#master_komputer-delete').linkbutton('disable');
            },
            onSelect: function() {
                $('#master_komputer-edit').linkbutton('enable');
                $('#master_komputer-delete').linkbutton('enable');
            },
            onDblClickRow: function() {
                masterKomputerUpdate();
            },
            view: scrollview,
            remoteFilter: true,
            url: '<?php echo site_url('master/komputer/index'); ?>?grid=true'
        })
        .datagrid('enableFilter');

    function masterKomputerRefresh() {
        $('#master_komputer-edit').linkbutton('disable');
        $('#master_komputer-delete').linkbutton('disable');
        $('#grid-master_komputer').datagrid('reload');
    }

    function masterKomputerCreate() {
        $('#dlg-master_komputer').dialog({
            modal: true
        }).dialog('open').dialog('setTitle', 'Tambah Data');
        $('#fm-master_komputer').form('clear');
        url = '<?php echo site_url('master/komputer/create'); ?>';
        $('#m_departemen_pt').textbox('enable');
        $('#m_komputer_keluar').textbox('disable');
    }

    function masterKomputerUpdate() {
        var row = $('#grid-master_komputer').datagrid('getSelected');
        if (row) {
            $('#dlg-master_komputer').dialog({
                modal: true
            }).dialog('open').dialog('setTitle', 'Edit Data');
            $('#fm-master_komputer').form('load', row);
            url = '<?php echo site_url('master/komputer/update'); ?>/' + row.m_komputer_id;
            $('#m_departemen_pt').textbox('disable');
            $('#m_komputer_pt').textbox('enable');
        } else {
            $.messager.alert('Info', 'Data belum dipilih !', 'info');
        }
    }

    function masterKomputerSave() {
        var a = 50
        $('#fm-master_komputer').form('submit', {
            url: url,
            onSubmit: function() {
                return $(this).form('validate');
            },
            success: function(result) {
                var result = eval('(' + result + ')');
                if (result.success) {
                    $('#dlg-master_komputer').dialog('close');
                    $('#grid-master_komputer').datagrid('reload');
                    $.messager.show({
                        title: 'Info',
                        msg: 'Data Berhasil Disimpan'
                    });
                    //alert(result.ok);
                } else {
                    $.messager.show({
                        title: 'Error',
                        msg: 'Input Data Gagal'
                    });
                }
            }
        });
    }
</script>
<style type="text/css">
    .bg-error {
        background: red;
    }

    .bg-error .panel-title {
        color: #fff;
    }

    .bg-warning {
        background: yellow;
    }

    .bg-warning .panel-title {
        color: #000;
    }

    #fm-master_komputer {
        margin: 0;
        padding: 10px 30px;
    }

    .ftitle {
        font-size: 14px;
        font-weight: bold;
        padding: 5px 0;
        margin-bottom: 10px;
        border-bottom: 1px solid #ccc;
    }

    .fitem {
        margin-bottom: 5px;
    }

    .fitem label {
        display: inline-block;
        width: 100px;
    }

    .fitem input {
        display: inline-block;
        width: 150px;
    }
</style>
<div id="dlg-master_komputer" class="easyui-dialog" style="width:600px; height:300px; padding: 10px 20px" closed="true" buttons="#dlg-buttons-master_komputer">
    <form id="fm-master_komputer" method="post" novalidate>

        <div class="fitem">
            <label for="type">Departemen </label>
            <input type="text" id="t_cetak_head_cus_man" name="t_cetak_head_cus_man" style="width:250px;" class="easyui-combobox" required="true" data-options="url:'<?php echo site_url('report/labelmanual/getCust'); ?>',
                    method:'get', valueField:'m_cust_item_cust', textField:'m_cust_name', panelHeight:'150',
                    onSelect: function(rec){
                        cust = rec.m_cust_item_cust;
                        var url2man = '<?php echo site_url('report/labelmanual/getItem'); ?>/'+cust;
                        $('#t_cetak_head_item_id_man').combobox('reload', url2man);
                        $('#t_cetak_head_item_id_man').combobox('setValue', '');
                        $('#t_cetak_head_item_id_man').next().find('input').focus();
                    }
                    " />
        </div>
        <div class="fitem">
            <label for="type">Perusahaan</label>
            <input type="text" id="m_departemen_pt" name="m_departemen_pt" style="width:150px;" class="easyui-combobox" required="true" data-options="url:'<?php echo site_url('master/komputer/enumPt'); ?>',
                   method:'get', valueField:'data', textField:'data', 
                   onSelect: function(rec){
                        var url = '<?php echo site_url('master/komputer/getDept'); ?>/'+rec.data;
                        $('#m_komputer_dept').combobox('reload', url);
                    }, panelHeight:'auto'" />
        </div>

        <div class="fitem">
            <label for="type">Departemen</label>
            <input type="text" id="m_komputer_dept" name="m_komputer_dept" style="width:150px;" class="easyui-combobox" required="true" data-options="valueField:'m_departemen_id', textField:'m_departemen_dept', panelHeight:'150'" />
        </div>

        <div class="fitem">
            <label for="type">Nama User </label>
            <input type="text" id="m_komputer_user" name="m_komputer_user" class="easyui-textbox" required="true" />
        </div>

        <div class="fitem">
            <label for="type">Tanggal Masuk</label>
            <input type="text" id="m_komputer_masuk" name="m_komputer_masuk" class="easyui-datebox" required="true" />
        </div>
        <div class="fitem">
            <label for="type">Tanggal Keluar</label>
            <input type="text" id="m_komputer_keluar" name="m_komputer_keluar" class="easyui-datebox" />
        </div>

        <div class="fitem">
            <label for="type"> Keterangan</label>
            <input type="text" id="m_komputer_keterangan" name="m_komputer_keterangan" class="easyui-textbox" style="width:50%;height:60px" multiline="true" />
        </div>

    </form>
</div>

<!-- Dialog Button -->
<div id="dlg-buttons-master_komputer">
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-ok" onclick="masterKomputerSave()">Simpan</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-cancel" onclick="javascript:$('#dlg-master_komputer').dialog('close')">Batal</a>
</div>

<script type="text/javascript">
    function masterKomputerCetak() {
        $('#dlg-master_komputer_cetak').dialog({
            modal: true
        }).dialog('open').dialog('setTitle', 'Cetak Asset');
        $('#fm-master_komputer_cetak').form('clear');
        $('#m_departemen_pt_cetak').combobox('setValue', '');
        $('#m_komputer_dept_cetak').combobox('setValue', '');
    }

    function masterKomputerCetakOK() {
        var isValid = $('#fm-master_komputer_cetak').form('validate');
        if (isValid) {
            var pt = $('#m_departemen_pt_cetak').combobox('getValue');
            var dept = $('#m_komputer_dept_cetak').combobox('getValue');
            var url = '<?php echo site_url('master/komputer/cetak'); ?>/' + pt + '-' + dept;
            var content = '<iframe scrolling="auto" frameborder="0"  src="' + url + '" style="width:100%;height:100%;"></iframe>';
            var title = 'Asset Komputer ' + pt + ' ' + dept;
            if ($('#tt').tabs('exists', title)) {
                $('#tt').tabs('select', title);
                $('#dlg-master_komputer_cetak').dialog('close');
            } else {
                $('#tt').tabs('add', {
                    title: title,
                    content: content,
                    closable: true,
                    iconCls: 'icon-print'
                });
                $('#dlg-master_komputer_cetak').dialog('close');
            }
        }
    }
</script>
<div id="dlg-master_komputer_cetak" class="easyui-dialog" style="width:350px; height:200px; padding: 10px 20px" closed="true" buttons="#dlg-buttons-master_komputer_cetak">
    <form id="fm-master_item_komputer_cetak" method="post" novalidate>
        <div class="fitem">
            <label for="type">Perusahaan</label>
            <input type="text" id="m_departemen_pt_cetak" name="m_departemen_pt_cetak" style="width:150px;" class="easyui-combobox" required="true" data-options="url:'<?php echo site_url('master/komputer/enumPt'); ?>',
                   method:'get', valueField:'data', textField:'data', 
                   onSelect: function(rec){
                        var url = '<?php echo site_url('master/komputer/getDept'); ?>/'+rec.data;
                        $('#m_komputer_dept_cetak').combobox('reload', url);
                    }, panelHeight:'auto'" />
        </div>

        <div class="fitem">
            <label for="type">Departemen</label>
            <input type="text" id="m_komputer_dept_cetak" name="m_komputer_dept_cetak" style="width:150px;" class="easyui-combobox" data-options="valueField:'m_departemen_id', textField:'m_departemen_dept', panelHeight:'150'" />
        </div>
    </form>
</div>
<!-- Button Cetak Asset -->
<div id="dlg-buttons-master_komputer_cetak">
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-print" onclick="masterKomputerCetakOK();">Print</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-cancel" onclick="javascript:$('#dlg-master_komputer_cetak').dialog('close')">Batal</a>
</div>

<!-- End of file v_customer.php -->
<!-- Location: ./application/views/master/v_customer.php -->