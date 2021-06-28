<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script type="text/javascript" src="<?= base_url('assets/easyui/datagrid-scrollview.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/easyui/datagrid-filter.js') ?>"></script>
<script>
    (function($) {
        var combobox = $.fn.combobox.defaults.onChange;
        $.fn.combobox.defaults.onChange = function(newValue, oldValue) {
            $(this).closest('input').trigger('change');
            combobox.call(this, newValue, oldValue);
        };
    })(jQuery);
</script>
<script type="text/javascript">
    var url;

    function transaksiPkwtCreate() {
        $('#dlg-transaksi-pkwt').dialog({
            modal: true
        }).dialog('open').dialog('setTitle', 'Tambah Data');
        $('#fm-transaksi-pkwt').form('clear');
        $('#kk').combobox('enable');
        $('#nm').combobox('enable');
        $('#dp').combobox('enable');
        $('#ps').combobox('enable');
        $('#st').combobox('enable');
        $('#sal').combobox('enable');
        $('#spcsal').numberbox('enable');
        $('#proc').combobox('setValue', 'N');
        url = '<?php echo site_url('transaksi/pkwt/create'); ?>';
    }

    function transaksiPkwtUpdate() {
        var row = $('#grid-transaksi-pkwt').datagrid('getSelected');
        $('#kk').combobox('enable');
        $('#nm').combobox('enable');
        $('#dp').combobox('enable');
        $('#ps').combobox('enable');
        $('#st').combobox('enable');
        $('#sal').combobox('enable');
        $('#spcsal').numberbox('enable');
        if (row) {
            $('#dlg-transaksi-pkwt').dialog({
                modal: true
            }).dialog('open').dialog('setTitle', 'Edit Data');
            $('#fm-transaksi-pkwt').form('load', row);
            url = '<?php echo site_url('transaksi/pkwt/update'); ?>/' + row.pkwt_id;
        }
    }

    function transaksiPkwtSave() {
        $('#fm-transaksi-pkwt').form('submit', {
            url: url,
            onSubmit: function() {
                return $(this).form('validate');
            },
            success: function(result) {
                var result = eval('(' + result + ')');
                if (result.success) {
                    $('#dlg-transaksi-pkwt').dialog('close');
                    $('#grid-transaksi-pkwt').datagrid('reload');
                } else {
                    $.messager.show({
                        title: 'Error',
                        msg: result.msg
                    });
                }
            }
        });
    }

    function transaksiPkwtHapus() {
        var row = $('#grid-transaksi-pkwt').datagrid('getSelected');
        if (row) {
            $.messager.confirm('Konfirmasi', 'Anda yakin ingin menghapus data PKWT ' + row.pkwt_id + ' ?', function(r) {
                if (r) {
                    $.post('<?php echo site_url('transaksi/pkwt/delete'); ?>', {
                        pkwt_id: row.pkwt_id
                    }, function(result) {
                        if (result.success) {
                            $('#grid-transaksi-pkwt').datagrid('reload');
                        } else {
                            $.messager.show({
                                title: 'Error',
                                msg: result.msg
                            });
                        }
                    }, 'json');
                }
            });
        }
    }

    function printPkwt() {
        var row = $('#grid-transaksi-pkwt').datagrid('getSelected');
        var url = '<?php echo site_url('transaksi/pkwt/cetak_pkwt'); ?>/' + row.pkwt_id;
        var content = '<iframe scrolling="auto" frameborder="0"  src="' + url + '" style="width:100%;height:100%;"></iframe>'
        var title = 'PKWT ID ' + row.pkwt_id;
        if ($('#tt').tabs('exists', title)) {
            $('#tt').tabs('select', title);
        } else {
            $('#tt').tabs('add', {
                title: title,
                content: content,
                closable: true,
                iconCls: 'icon-print'
            })
        }
    }

    function printEvaluasi() {
        var row = $('#grid-transaksi-pkwt').datagrid('getSelected');
        var url = '<?php echo site_url('transaksi/pkwt/cetak_evaluasi'); ?>/' + row.pkwt_id;
        var content = '<iframe scrolling="auto" frameborder="0"  src="' + url + '" style="width:100%;height:100%;"></iframe>'
        var title = 'Evaluasi ID ' + row.pkwt_id;
        if ($('#tt').tabs('exists', title)) {
            $('#tt').tabs('select', title);
        } else {
            $('#tt').tabs('add', {
                title: title,
                content: content,
                closable: true,
                iconCls: 'icon-print'
            })
        }
    }
</script>
<style type="text/css">
    #fm-transaksi-pkwt {
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
</style>

<!-- Data Grid -->
<table id="grid-transaksi-pkwt" toolbar="#toolbar-transaksi-pkwt" data-options="pageSize:50, singleSelect:true, fit:true, fitColumns:false">
    <thead>
        <tr>
            <th data-options="field:'pkwt_id'" width="60" align="center" sortable="true">No. PKWT</th>
            <th data-options="field:'pkwt_kk'" width="50" align="center" sortable="true">Kontrak</th>
            <th data-options="field:'emply_name'" width="140" halign="center" sortable="true">Nama</th>
            <th data-options="field:'dept_name'" width="100" halign="center" sortable="true">Bagian</th>
            <th data-options="field:'post_name'" width="100" align="center" sortable="true">Jabatan</th>
            <th data-options="field:'pkwt_status'" width="100" align="center" sortable="true">Status</th>
            <th data-options="field:'pkwt_start'" width="80" align="center" sortable="true">Awal Kontrak</th>
            <th data-options="field:'pkwt_period'" formatter="transaksiPkwtPeriod" width="60" align="center" sortable="true">Jangka</th>
            <th data-options="field:'pkwt_end'" width="80" align="center" sortable="true">Akhir Kontrak</th>
            <th data-options="field:'pkwt_salary'" width="60" align="center" sortable="true">Salary</th>
            <th data-options="field:'pkwt_spc_salary'" formatter="transaksiPkwtSpcSalary" width="60" align="center" sortable="true">SPC Salary</th>
            <th data-options="field:'pkwt_sign'" width="80" align="center" sortable="true">Tanggal PKWT</th>
            <th data-options="field:'pkwt_before'" width="60" align="center" sortable="true">PKWT Sebelumnya</th>
            <th data-options="field:'pkwt_process'" width="50" align="center" sortable="true">Sudah Diproses</th>
            <th data-options="field:'pkwt_manual'" width="50" align="center" sortable="true">Nomor Manual</th>
        </tr>
    </thead>
</table>

<!-- Toolbar -->
<div id="toolbar-transaksi-pkwt">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="transaksiPkwtCreate()">Tambah Data</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="transaksiPkwtUpdate()">Edit Data</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="transaksiPkwtHapus()">Hapus Data</a>
    |
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="printPkwt()">Cetak PKWT</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="printEvaluasi()">Cetak Evaluasi</a>
</div>
<!-- Dialog Form -->
<div id="dlg-transaksi-pkwt" class="easyui-dialog" style="width:420px; height:480px; padding: 10px 20px" closed="true" buttons="#dlg-buttons-transaksi-pkwt">
    <form id="fm-transaksi-pkwt" method="post" novalidate>
        <div class="fitem">
            <label for="type">PKWT Sebelumnya</label>
            <input id="bef" class="easyui-combobox" name="pkwt_before" onchange="transaksiPkwtCont()" data-options="
                url:'<?php echo site_url('transaksi/pkwt/getPkwtBefore'); ?>',
                method:'get', valueField:'pkwt_id', textField:'m_emply_name', panelHeight:'200'" />
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-reload" plain="true" onclick="$('#bef').combobox('reload', '<?php echo site_url('transaksi/pkwt/getPkwtBefore'); ?>')"></a>
        </div>
        <div class="fitem">
            <label for="type">Kontrak</label>
            <input id="kk" class="easyui-combobox" name="pkwt_kk" data-options="
                url:'<?php echo site_url('transaksi/pkwt/enumPkwtKk'); ?>',
                method:'get', valueField:'data', textField:'data', panelHeight:'auto'" />
        </div>
        <div class="fitem">
            <label for="type">Nama</label>
            <input id="nm" class="easyui-combobox" name="pkwt_nik" data-options="
                url:'<?php echo site_url('transaksi/pkwt/getEmply'); ?>',
                method:'get', valueField:'m_emply_nik', textField:'m_emply_name', panelHeight:'300'" />
        </div>

        <div class="fitem">
            <label for="type">Bagian </label>
            <input type="text" id="dp" name="pkwt_dept" style="width:200px;" class="easyui-combobox" required="true" data-options="url:'<?php echo site_url('master/karyawan/getBag'); ?>',
            method:'get', valueField:'departemen_id', groupField:'departemen_idk', textField:'departemen_nama', panelHeight:'150'" />
        </div>
        <div class="fitem">
            <label for="type">Jabatan</label>
            <input id="ps" class="easyui-combobox" name="pkwt_post" data-options="
                url:'<?php echo site_url('transaksi/pkwt/getJab'); ?>',
                method:'get', valueField:'m_jabatan_id', textField:'m_jabatan_nama', panelHeight:'auto'" />
        </div>
        <div class="fitem">
            <label for="type">Status</label>
            <input id="st" class="easyui-combobox" name="pkwt_status" data-options="
                url:'<?php echo site_url('transaksi/pkwt/enumPkwtStatus'); ?>',
                method:'get', valueField:'data', textField:'data', panelHeight:'auto'" />
        </div>
        <div class="fitem">
            <label for="type">Awal Kontrak</label>
            <input name="pkwt_start" class="easyui-datebox" required data-options="
                formatter:transaksiPkwtFormatter, parser:transaksiPkwtParser" />
        </div>
        <div class="fitem">
            <label for="type">Jangka</label>
            <input class="easyui-combobox" name="pkwt_period" required data-options="
                url:'<?php echo site_url('transaksi/pkwt/enumPkwtPeriod'); ?>',
                method:'get', valueField:'data', textField:'data', panelHeight:'auto'" />
        </div>
        <div class="fitem">
            <label for="type">Salary</label>
            <input id="sal" class="easyui-combobox" name="pkwt_salary" onchange="transaksiPkwtSalary()" data-options="
                url:'<?php echo site_url('transaksi/pkwt/getSalary'); ?>',
                method:'get', valueField:'salary_id', textField:'salary_id', panelHeight:'200'" />
        </div>
        <div class="fitem">
            <label for="type">SPC Salary</label>
            <input id="spcsal" name="pkwt_spc_salary" onchange="transaksiPkwtSalary()" class="easyui-numberbox" />
        </div>
        <div class="fitem">
            <label for="type">Tanggal PKWT</label>
            <input name="pkwt_sign" class="easyui-datebox" required data-options="
                formatter:transaksiPkwtFormatter, parser:transaksiPkwtParser" />
        </div>
        <div class="fitem">
            <label for="type">Sudah Diproses</label>
            <input id="proc" class="easyui-combobox" name="pkwt_process" data-options="
                url:'<?php echo site_url('transaksi/pkwt/enumPkwtProcess'); ?>',
                method:'get', valueField:'data', textField:'data', panelHeight:'auto'" />
        </div>
        <div class="fitem">
            <label for="type">No. Manual</label>
            <input type="text" name="pkwt_manual" class="easyui-validatebox" />
        </div>
    </form>
</div>

<script type="text/javascript">
    $('#grid-transaksi-pkwt').datagrid({
        view: scrollview,
        remoteFilter: true,
        url: '<?php echo site_url('transaksi/pkwt/index'); ?>?grid=true'
    }).datagrid('enableFilter');


    function transaksiPkwtFormatter(date) {
        var y = date.getFullYear();
        var m = date.getMonth() + 1;
        var d = date.getDate();
        return y + '-' + (m < 10 ? ('0' + m) : m) + '-' + (d < 10 ? ('0' + d) : d);
    }

    function transaksiPkwtParser(s) {
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

    function transaksiPkwtSpcSalary(value, row, index) {
        return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function transaksiPkwtPeriod(value, row, index) {
        if (value == 0) {
            return value;
        } else {
            return value + ' Bulan';
        }
    }

    function transaksiPkwtCont() {
        var nilai = $('#bef').combobox('getValue');
        if (nilai > 0) {
            urla = '<?php echo site_url('transaksi/pkwt/getPkwtBeforeData'); ?>/' + nilai;
            $.getJSON(urla, function(data) {
                $.each(data, function(i, dat) {
                    $('#kk').combobox('setValue', dat.pkwt_kk);
                    $('#nm').combobox('disable');
                    $('#nm').combobox('setValue', dat.pkwt_nik);
                    //$('#dp').combobox('disable');
                    $('#dp').combobox('setValue', dat.pkwt_dept);
                    //$('#ps').combobox('disable');
                    $('#ps').combobox('setValue', dat.pkwt_post);
                    $('#st').combobox('disable');
                    $('#st').combobox('setValue', dat.pkwt_status);
                })
            })
        } else {
            $('#kk').combobox('enable');
            $('#kk').combobox('setValue', '');
            $('#nm').combobox('enable');
            $('#nm').combobox('setValue', '');
            $('#dp').combobox('enable');
            $('#dp').combobox('setValue', '');
            $('#ps').combobox('enable');
            $('#ps').combobox('setValue', '');
            $('#st').combobox('enable');
            $('#st').combobox('setValue', '');
        }
    }

    function transaksiPkwtSalary() {
        var nilaiSal = $('#sal').combobox('getValue');
        var nilaiSpc = $('#spcsal').numberbox('getValue');

        if (nilaiSal == 0 && nilaiSpc == 0) {
            $('#sal').combobox('enable');
            $('#spcsal').numberbox('enable');
        }
        if (nilaiSpc > 0) {
            $('#sal').combobox('disable');
        }
        if (nilaiSal > 0) {
            $('#spcsal').numberbox('disable');
        }
    }
</script>
<!-- Dialog Button -->
<div id="dlg-buttons-transaksi-pkwt">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="transaksiPkwtSave()">Simpan</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg-transaksi-pkwt').dialog('close')">Batal</a>
</div>