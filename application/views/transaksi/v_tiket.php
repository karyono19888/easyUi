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
<table id="grid-transaksi_tiket" data-options="pageSize:50, multiSort:true, remoteSort:true, rownumbers:true, singleSelect:true, 
                fit:true, fitColumns:false, toolbar:toolbar_transaksi_tiket">
    <thead>
        <tr>
            <th data-options="field:'ck',checkbox:true"></th>
            <th data-options="field:'t_spk_id'" width="50" align="center" sortable="true">ID</th>
            <th data-options="field:'t_spk_respontime'" width="100" align="center" sortable="true">Respon Time</th>
            <th data-options="field:'t_spk_jenis'" width="100" align="center" sortable="true">JENIS</th>
            <th data-options="field:'t_spk_man'" width="100" align="center" sortable="true">EXECUTOR</th>
            <th data-options="field:'t_spk_user'" width="100" align="center" sortable="true">USER</th>
            <th data-options="field:'departemen_nama'" width="100" align="center" sortable="true">DEPT</th>
            <th data-options="field:'t_spk_uraian'" width="300" align="left" sortable="true">DESKRIPSI</th>
            <th data-options="field:'t_spk_duedate'" width="120" align="center" sortable="true">DUEDATE</th>
            <th data-options="field:'t_spk_closed'" width="120" align="center" sortable="true">TGL CLOSE</th>
            <th data-options="field:'t_spk_perbaikan'" width="350" align="left" sortable="true">DESKRIPSI</th>
            <th data-options="field:'t_spk_tgl_pembuatan'" width="120" align="center" sortable="true">TGL BUAT</th>
            <th data-options="field:'Keterangan'" width="120" align="center" sortable="true">Status</th>
            <th data-options="field:'Selisih'" width="120" align="center" sortable="true">Remainder</th>
        </tr>
    </thead>
</table>

<script type="text/javascript">
    var toolbar_transaksi_tiket = [{
        id: 'transaksi_tiket-new',
        text: 'New',
        iconCls: 'icon-new_file',
        handler: function() {
            transaksitiketCreate();
        }
    }, {
        id: 'transaksi_tiket-edit',
        text: 'Edit',
        iconCls: 'icon-edit',
        handler: function() {
            transaksitiketUpdate();
        }
    }, {
        text: 'Refresh',
        iconCls: 'icon-reload',
        handler: function() {
            transaksitiketRefresh();
        }
    }, {
        id: 'transaksi_tiket-ceklis',
        text: 'Ceklis SPK',
        iconCls: 'icon-ok',
        handler: function() {
            transaksitiketCeklis();
        }
    }, {
        text: 'Export Excel',
        iconCls: 'icon-excel',
        handler: function() {
            transaksitiketExcel();
        }
    }];

    $('#grid-transaksi_tiket').datagrid({
            onLoadSuccess: function() {
                $('#transaksi_tiket-edit').linkbutton('disable');
                $('#transaksi_tiket-ceklis').linkbutton('disable');
            },
            onSelect: function() {
                $('#transaksi_tiket-edit').linkbutton('enable');
                $('#transaksi_tiket-ceklis').linkbutton('enable');
            },
            onClickRow: function() {
                $('#transaksi_tiket-edit').linkbutton('enable');
                $('#transaksi_tiket-ceklis').linkbutton('enable');
            },
            onDblClickRow: function() {
                transaksitiketUpdate();
            },
            rowStyler: function(index, row) {
                if (row['Keterangan'] == 'TIDAK TERCAPAI') {
                    return 'background-color:#FFB6C1;color:#000;';
                }
                if (row['t_spk_closed'] == '0000-00-00 00:00:00') {

                    return 'background-color:#00000;color:#000;';
                }
                if (row['Keterangan'] == 'OK') {
                    return 'background-color:#D1FFB3;color:#000;';
                }
            },
            view: scrollview,
            remoteFilter: true,
            url: '<?php echo site_url('transaksi/tiket/index'); ?>?grid=true'
        })
        .datagrid('enableFilter');

    function transaksitiketRefresh() {
        $('#transaksi_tiket-edit').linkbutton('disable');
        $('#transaksi_tiket-ceklis').linkbutton('disable');
        $('#grid-transaksi_tiket').datagrid('reload');
    }

    function transaksitiketCreate() {
        $('#dlg-transaksi_tiket').dialog({
            modal: true
        }).dialog('open').dialog('setTitle', 'Buat SPK');
        $('#fm-transaksi_tiket').form('clear');
        url = '<?php echo site_url('transaksi/tiket/create'); ?>';
        $('#m_cust_id').textbox('enable');
    }

    function transaksitiketUpdate() {
        var row = $('#grid-transaksi_tiket').datagrid('getSelected');
        if (row) {
            $('#dlg-transaksi_tiket').dialog({
                modal: true
            }).dialog('open').dialog('setTitle', 'Edit Data');
            $('#fm-transaksi_tiket').form('load', row);
            url = '<?php echo site_url('transaksi/tiket/update'); ?>/' + row.t_spk_id;
            $('#m_cust_id').textbox('disable');
        } else {
            $.messager.alert('Info', 'Data belum dipilih !', 'info');
        }
    }

    function transaksitiketSave() {
        $('#fm-transaksi_tiket').form('submit', {
            url: url,
            onSubmit: function() {
                return $(this).form('validate');
            },
            success: function(result) {
                var result = eval('(' + result + ')');
                if (result.success) {
                    $('#dlg-transaksi_tiket').dialog('close');
                    transaksitiketRefresh();
                    $.messager.show({
                        title: 'Info',
                        msg: 'Data Berhasil Disimpan'
                    });
                } else {
                    $.messager.show({
                        title: 'Error',
                        msg: 'Input Data Gagal'
                    });
                }
            }
        });
    }

    function transaksitiketCeklis() {
        var row = $('#grid-transaksi_tiket').datagrid('getSelected');
        if (row) {
            $('#dlg-transaksi_selesai').dialog({
                modal: true
            }).dialog('open').dialog('setTitle', 'Ceklis Aktual Selesai');
            $('#fm-transaksi_selesai').form('load', row);
            urlcekspk = '<?php echo site_url('transaksi/tiket/ceklis_spk'); ?>/' + row.t_spk_id;
        } else {
            $.messager.alert('Info', 'Data belum dipilih !', 'info');
        }
    }

    function transaksiCeklisSPKSave() {
        $('#fm-transaksi_selesai').form('submit', {
            url: urlcekspk,
            onSubmit: function() {
                return $(this).form('validate');
            },
            success: function(result) {
                var result = eval('(' + result + ')');
                if (result.success) {
                    $('#dlg-transaksi_selesai').dialog('close');
                    $('#grid-transaksi_tiket').datagrid('reload');
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

    function transaksitiketExcel() {
        $('#dlg-transaksi_tiket_export').dialog({
            modal: true
        }).dialog('open').dialog('setTitle', 'Buat SPK');
        $('#fm-transaksi_tiket_export').form('clear');
        urlexport = '<?php echo site_url('transaksi/tiket/exportExcel'); ?>';

    }

    function transaksiTiketExportSave() {
        $('#fm-transaksi_tiket_export').form('submit', {
            url: urlexport,
            onSubmit: function() {
                return $(this).form('validate');
            },
            success: function(result) {
                var result = eval('(' + result + ')');
                if (result.success) {
                    window.open(url);
                } else {
                    $.messager.show({
                        title: 'Error',
                        msg: 'Export Data Gagal'
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

    #fm-transaksi_tiket {
        margin: 0;
        padding: 10px 30px;
    }

    #fm-transaksi_tiket-upload {
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

<!-- ----------- -->
<div id="dlg-transaksi_tiket" class="easyui-dialog" style="width:600px; height:600px; padding: 10px 20px" closed="true" buttons="#dlg-buttons-transaksi_tiket">
    <form id="fm-transaksi_tiket" method="post" novalidate>

        <div class="fitem">
            <label for="type">Waktu Respon</label>
            <input type="text" id="t_spk_respontime" name="t_spk_respontime" style="width:220px" class="easyui-datetimebox" required="true" />
            <a <label for="type">Target < 5 Menit </label> </a> </div> <div class="fitem">
                    <label for="type">Jenis</label>
                    <select id="t_spk_jenis" name="t_spk_jenis" class="easyui-combobox" style="width:220px" data-options="panelHeight:'auto'" required="true">
                        <option value="HARDWARE">HARDWARE</option>
                        <option value="SOFTWARE">SOFTWARE</option>
                    </select>
        </div>

        <div class="fitem">
            <label for="type">Executor</label>
            <select id="t_spk_man" name="t_spk_man" class="easyui-combobox" style="width:220px" data-options="panelHeight:'auto'">
                <option value="AGUS">AGUS</option>
                <option value="FERI">FERI</option>
                <option value="RIFAI">RIFAI</option>
                <option value="SUGIYANTO">SUGIYANTO</option>
                <option value="IQRAM">IQRAM</option>
                <option value="FERDI">FERDI</option>
            </select>
        </div>
        <div class="fitem">
            <label for="type"> User</label>
            <input type="text" id="t_spk_user" name="t_spk_user" class="easyui-textbox" style="width:220px;" required="true" />
        </div>
        <div class="fitem">
            <label for="type">Departemen</label>
            <select id="t_spk_dept" name="t_spk_dept" class="easyui-combogrid" style="width:155px;" required="true" data-options=" 
                    panelWidth: 500,
                    idField: 'departemen_id',
                    textField: 'departemen_nama',
                    url: '<?php echo site_url('transaksi/tiket/getDept'); ?>',
                    method: 'get',
                    mode:'remote',
                    columns: [[
                        {field:'departemen_id',title:'ID',width:40},
                        {field:'departemen_pt',title:'PT',width:100},
                        {field:'departemen_nama',title:'Bagian',width:100}
                        
                    ]],
                    fitColumns: true,
                    labelPosition: 'top',
                    onSelect: function(index,row){
                     var pt = row.departemen_pt    
                     $('#t_spk_pt').textbox('setValue', pt);
                    }
                ">
            </select>
        </div>
        <div class="fitem">
            <label for="type"> Perusahaan</label>
            <input type="text" id="t_spk_pt" name="t_spk_pt" class="easyui-textbox" style="width:220px;" readonly="true" />
        </div>
        <div class="fitem">
            <label for="type"> Permasalahan</label>
            <input type="text" id="t_spk_uraian" name="t_spk_uraian" class="easyui-textbox" style="width:50%;height:60px" multiline="true" required="true" />
        </div>

        <div class="fitem">
            <label for="type">Target Selesai</label>
            <input type="text" id="t_spk_duedate" name="t_spk_duedate" style="width:220px" class="easyui-datetimebox" required="true" />
        </div>

    </form>
</div>

<!-- Dialog Button -->
<div id="dlg-buttons-transaksi_tiket">
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-ok" onclick="transaksitiketSave()">Simpan</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-cancel" onclick="javascript:$('#dlg-transaksi_tiket').dialog('close')">Batal</a>
</div>

<!-- Dialog Form Ceklis Closed-->
<div id="dlg-transaksi_selesai" class="easyui-dialog" style="width:550px; height:330px; padding: 10px 20px" closed="true" buttons="#dlg-buttons-transaksi_selesai">
    <form id="fm-transaksi_selesai" method="post" novalidate>

        <div class="fitem">
            <label for="type">Aktual Selesai</label>
            <input type="text" id="t_spk_closed" name="t_spk_closed" class="easyui-datetimebox" required="true" />
        </div>
        <div class="fitem">
            <label for="type"> Tindakan Perbaikan</label>
            <input type="text" id="t_spk_perbaikan" name="t_spk_perbaikan" class="easyui-textbox" style="width:50%;height:60px" multiline="true" required="true" />
        </div>

    </form>
</div>

<!-- Dialog Button -->
<div id="dlg-buttons-transaksi_selesai">
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-ok" onclick="transaksiCeklisSPKSave();">Simpan</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-cancel" onclick="javascript:$('#dlg-transaksi_selesai').dialog('close');">Batal</a>
</div>

<!-- Dialog Form Ceklis Closed-->
<div id="dlg-transaksi_tiket_export" class="easyui-dialog" style="width:550px; height:330px; padding: 10px 20px" closed="true" buttons="#dlg-buttons-transaksi_tiket_export">
    <form id="fm-transaksi_tiket_export" method="post" novalidate>

        <div class="fitem">
            <label for="type">Dari</label>
            <input type="text" id="t_spk_tgl_start" name="t_spk_tgl_start" class="easyui-datebox" required="true" />
        </div>
        <div class="fitem">
            <label for="type"> Sampai</label>
            <input type="text" id="t_spk_tgl_end" name="t_spk_tgl_end" class="easyui-datebox" required="true" />
        </div>

    </form>
</div>

<!-- Dialog Button -->
<div id="dlg-buttons-transaksi_tiket_export">
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-ok" onclick="transaksiTiketExportSave();">Simpan</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-cancel" onclick="javascript:$('#dlg-transaksi_tiket_export').dialog('close');">Batal</a>
</div>
<!-- End of file v_tiket.php -->
<!-- Location: ./application/views/transaksi/v_tiket.php -->