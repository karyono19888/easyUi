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
<table id="grid-transaksi_pkwt" data-options="pageSize:50, multiSort:true, remoteSort:true, rownumbers:true, singleSelect:true, 
                fit:true, fitColumns:true, toolbar:toolbar_transaksi_pkwt">
    <thead>
        <tr>
            <th data-options="field:'ck',checkbox:true"></th>
            <th data-options="field:'pkwt_id'" width="50" halign="center" align="center" sortable="true">No. PKWT</th>
            <th data-options="field:'pkwt_kk'" width="100" halign="center" align="center" sortable="true">Kontrak</th>
            <th data-options="field:'m_emply_name'" width="300" halign="center" align="left" sortable="true">Nama</th>
            <th data-options="field:'departemen_nama'" width="300" halign="center" align="center" sortable="true">Bagian</th>
            <th data-options="field:'m_jabatan_nama'" width="300" halign="center" align="center" sortable="true">Jabatan</th>
            <th data-options="field:'pkwt_status'" width="300" halign="center" align="center" sortable="true">Status</th>
            <th data-options="field:'pkwt_start'" width="300" halign="center" align="center" sortable="true">Awal Kontrak</th>
            <th data-options="field:'pkwt_period'" width="300" halign="center" align="center" sortable="true">Jangka</th>
            <th data-options="field:'pkwt_end'" width="200" halign="center" align="center" sortable="true">Akhir Kontrak</th>
            <th data-options="field:'pkwt_salary'" width="200" halign="center" align="center" sortable="true">Salary</th>
            <th data-options="field:'pkwt_spc_salary'" width="200" halign="center" align="center" sortable="true">SPC Salary</th>
            <th data-options="field:'pkwt_sign'" width="200" halign="center" align="center" sortable="true">Tanggal PKWT</th>
            <th data-options="field:'pkwt_before'" width="200" halign="center" align="center" sortable="true">PKWT Sebelumnya</th>
            <th data-options="field:'pkwt_process'" width="200" halign="center" align="center" sortable="true">Sudah Diproses</th>
            <th data-options="field:'pkwt_manual'" width="400" halign="center" align="center" sortable="true">Nomor Manual</th>
        </tr>
    </thead>
</table>

<script type="text/javascript">
    var toolbar_transaksi_pkwt = [{
            id: 'transaksi_pkwt-new',
            text: 'New',
            iconCls: 'icon-new_file',
            handler: function() {
                transaksiPkwtCreate();
            }
        }, {
            id: 'transaksi_pkwt-edit',
            text: 'Edit',
            iconCls: 'icon-edit',
            handler: function() {
                transaksiPkwtUpdate();
            }
        }, {
            id: 'transaksi_pkwt-delete',
            text: 'Delete',
            iconCls: 'icon-cancel',
            handler: function() {
                transaksiPkwtHapus();
            }
        }, {
            text: 'Refresh',
            iconCls: 'icon-reload',
            handler: function() {
                transaksiPkwtRefresh();
            }
        }, {
            text: 'Cetak PKWT',
            iconCls: 'icon-reload',
            handler: function() {
                printPkwt();
            }
        }, {
            text: 'Cetak Evaluasi',
            iconCls: 'icon-reload',
            handler: function() {
                printEvaluasi();
            }
        },
        {
            text: 'Cetak Surat Perpanjangan',
            iconCls: 'icon-print',
            handler: function() {
                printSuratP3();
            }
        },
        {
            text: 'Cetak SK',
            iconCls: 'icon-print',
            handler: function() {
                printSK();
            }
        }
    ];

    $('#grid-transaksi_pkwt').datagrid({
            onLoadSuccess: function() {
                $('#transaksi_pkwt-edit').linkbutton('disable');
                $('#transaksi_pkwt-delete').linkbutton('disable');
            },
            onSelect: function() {
                $('#transaksi_pkwt-edit').linkbutton('enable');
                $('#transaksi_pkwt-delete').linkbutton('enable');
            },
            onClickRow: function() {
                $('#transaksi_pkwt-edit').linkbutton('enable');
                $('#transaksi_pkwt-delete').linkbutton('enable');
            },
            onDblClickRow: function() {
                transaksiPesertakpdUpdate();
            },
            rowStyler: function(index, row) {
                if (row['t_pkwt_status'] == '1') {
                    return 'background-color:#D1FFB3;color:#000;';
                }
                if (row['t_pkwt_status'] == '0') {
                    return 'background-color:#FFB6C1;color:#000;';
                }
            },
            view: scrollview,
            remoteFilter: true,
            url: '<?php echo site_url('transaksi/pkwt/index'); ?>?grid=true'
        })
        .datagrid('enableFilter');

    function transaksiPkwtRefresh() {
        $('#transaksi_pkwt-edit').linkbutton('disable');
        $('#transaksi_karawan-delete').linkbutton('disable');
        $('#grid-transaksi_pkwt').datagrid('reload');
    }

    function transaksiPkwtCreate() {
        $('#dlg-transaksi_pkwt').dialog({
            modal: true
        }).dialog('open').dialog('setTitle', 'Tambah Data');
        $('#fm-transaksi_pkwt').form('clear');
        $('#proc').combobox('setValue', 'N');
        url = '<?php echo site_url('transaksi/pkwt/create'); ?>';
    }

    function transaksiPkwtUpdate() {
        var row = $('#grid-transaksi_pkwt').datagrid('getSelected');
        if (row) {
            $('#dlg-transaksi_pkwt').dialog({
                modal: true
            }).dialog('open').dialog('setTitle', 'Edit Data');
            $('#fm-transaksi_pkwt').form('load', row);
            url = '<?php echo site_url('transaksi/pkwt/update'); ?>/' + row.pkwt_id;
            //$('#m_emply_nik').textbox('disable');
        } else {
            $.messager.alert('Info', 'Data belum dipilih !', 'info');
        }
    }

    function transaksiPkwtSave() {
        $('#fm-transaksi_pkwt').form('submit', {
            url: url,
            onSubmit: function() {
                return $(this).form('validate');
            },
            iframe: false,
            onProgress: function(percent) {
                // $('#progressFile').progressbar('setValue', percent);   
                $.messager.progress({
                    title: 'Dagoan Sakedeung',
                    msg: 'Nendeun Data...'
                });
            },
            success: function(result) {
                $.messager.progress('close');
                var result = eval('(' + result + ')');
                if (result.success) {
                    //$('#grid-transaksi_pkwt').datagrid('reload');  
					$('#dlg-transaksi_pkwt').dialog('close');						
                    $('#t_pkwt_peserta').combogrid('clear');
                    transaksiPkwtRefresh();
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




    function transaksiPkwtHapus() {
        $.messager.progress({
            title: 'Dagoan Sakedeung',
            msg: 'Pupus Data...'
        });
        var row = $('#grid-transaksi_pkwt').datagrid('getSelected');
        if (row) {
            var win = $.messager.confirm('Konfirmasi', 'Anda yakin ingin menghapus \n' + row.pkwt_id + ' ?', function(r) {
                if (r) {
                    $.post('<?php echo site_url('transaksi/pkwt/delete'); ?>', {
                        pkwt_id: row.pkwt_id
                    }, function(result) {
                        $.messager.progress('close');
                        if (result.success) {
                            transaksiPkwtRefresh();
                            $.messager.show({
                                title: 'Info',
                                msg: '<div class="messager-icon messager-info"></div><div>Data Berhasil Dihapus</div>'
                            });
                        } else {
                            $.messager.show({
                                title: 'Error',
                                msg: '<div class="messager-icon messager-error"></div><div>Data Gagal Dihapus !</div>' + result.error
                            });
                        }
                    }, 'json');
                }
            });
            win.find('.messager-icon').removeClass('messager-question').addClass('messager-warning');
            win.window('window').addClass('bg-warning');
        } else {
            $.messager.alert('Info', 'Data belum dipilih !', 'info');
        }
    }

    function printPkwt() {
        var row = $('#grid-transaksi_pkwt').datagrid('getSelected');
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
        var row = $('#grid-transaksi_pkwt').datagrid('getSelected');
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



    function printSuratP3() {
        var row = $('#grid-transaksi_pkwt').datagrid('getSelected');
        if (row) {
            $('#dlg-transaksi_pkwt_suratp3').dialog({
                modal: true
            }).dialog('open').dialog('setTitle', 'Pilih Tgl penandatanganan');
            $('#fm-transaksi_pkwt_suratp3').form('load', row);
            urlcetakSurat = '<?php echo site_url('transaksi/pkwt/UpdateTglSurat'); ?>/' + row.pkwt_id;
        } else {
            $.messager.alert('Info', 'Data belum dipilih !', 'info');
        }
    }

    function transaksiPkwtSuratP3Print() {
        $('#fm-transaksi_pkwt_suratp3').form('submit', {
            url: urlcetakSurat,
            onSubmit: function() {
                return $(this).form('validate');
            },
            success: function(result) {
                var result = eval('(' + result + ')');
                if (result.success) {
                    urlcsp3 = '<?php echo site_url('transaksi/pkwt/CetakSuratP3'); ?>/' + result.pkwt_id;
                    var content = '<iframe scrolling="auto" frameborder="0"  src="' + urlcsp3 + '" style="width:100%;height:100%;"></iframe>'
                    var title = 'Cetak Surat Pemberitahuan Perpanjangan ID ' + result.pkwt_id;
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
                    transaksiPkwtRefresh();
                    $('#dlg-transaksi_pkwt_suratp3').dialog('close');

                } else {
                    $.messager.show({
                        title: 'Error',
                        msg: 'Input Data Gagal'
                    });
                }
            }
        });
    }

    function printSK() {
        var row = $('#grid-transaksi_pkwt').datagrid('getSelected');
        if (row) {
            $('#dlg-transaksi_pkwt_sk').dialog({
                modal: true
            }).dialog('open').dialog('setTitle', 'Print Surat Keputusan');
            $('#fm-transaksi_pkwt_sk').form('load', row);
            urlcetakSK = '<?php echo site_url('transaksi/pkwt/UpdateStatusKaryawan'); ?>/' + row.pkwt_id;
        } else {
            $.messager.alert('Info', 'Data belum dipilih !', 'info');
        }
    }

    function transaksiPkwtSKPrint() {
        $('#fm-transaksi_pkwt_sk').form('submit', {
            url: urlcetakSK,
            onSubmit: function() {
                return $(this).form('validate');
            },
            success: function(result) {
                var result = eval('(' + result + ')');
                if (result.success) {
                    urlSK = '<?php echo site_url('transaksi/pkwt/CetakSK'); ?>/' + result.pkwt_id;
                    var content = '<iframe scrolling="auto" frameborder="0"  src="' + urlSK + '" style="width:100%;height:100%;"></iframe>'
                    var title = 'Cetak SK ' + result.pkwt_id;
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
                    transaksiPkwtRefresh();
                    $('#dlg-transaksi_pkwt_sk').dialog('close');

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

    #fm-transaksi_pesertakpd {
        margin: 0;
        padding: 10px 30px;
    }

    #fm-transaksi_pesertakpd-upload {
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
<div id="dlg-transaksi_pkwt" class="easyui-dialog" style="width:600px; height:400px; padding: 10px 20px" closed="true" buttons="#dlg-buttons-transaksi_pkwt">
    <form id="fm-transaksi_pkwt" method="post" novalidate>

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
            <select id="nm" name="pkwt_nik" class="easyui-combogrid" style="width:150px;" data-options="
                    panelWidth: 500,
                    idField: 'm_emply_nik',
                    textField: 'm_emply_name',
                    url: '<?php echo site_url('transaksi/pkwt/getEmply'); ?>',
                    method: 'get',
                    mode:'remote',
                    columns: [[
                        {field:'m_emply_nik',title:'Item ID',width:40},
                        {field:'m_emply_name',title:'Nama Karyawan',width:100}
                    ]],
                    fitColumns: true,
                    labelPosition: 'top'
                ">
            </select>
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

<!-- Dialog Button -->
<div id="dlg-buttons-transaksi_pkwt">
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-ok" onclick="transaksiPkwtSave()">Simpan</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-cancel" onclick="javascript:$('#dlg-transaksi_pkwt').dialog('close')">Batal</a>
</div>


<!-- Dialog Cetak Surat -->
<div id="dlg-transaksi_pkwt_suratp3" class="easyui-dialog" style="width:450px; height:250px; padding: 10px 20px" closed="true" buttons="#dlg-buttons-transaksi_pkwt_suratp3">
    <form id="fm-transaksi_pkwt_suratp3" method="post" novalidate>

        <div class="fitem">
            <label for="type">Tgl Terbit Surat</label>
            <input type="text" id="tgl_terbit" name="tgl_terbit" class="easyui-datebox" required="true" />
        </div>
        <div class="fitem">
            <label for="type">Tgl Penandatanganan</label>
            <input type="text" id="tgl_tandatangan" name="tgl_tandatangan" class="easyui-datebox" required="true" />
        </div>

    </form>
</div>

<div id="dlg-buttons-transaksi_pkwt_suratp3">
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-ok" onclick="transaksiPkwtSuratP3Print()">Simpan</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-cancel" onclick="javascript:$('#dlg-transaksi_pkwt_suratp3').dialog('close')">Batal</a>
</div>


<!-- Dialog Cetak SK -->
<div id="dlg-transaksi_pkwt_sk" class="easyui-dialog" style="width:450px; height:250px; padding: 10px 20px" closed="true" buttons="#dlg-buttons-transaksi_pkwt_sk">
    <form id="fm-transaksi_pkwt_sk" method="post" novalidate>
        <div class="fitem">
            <label for="type">SK Terhitung Sejak Tgl</label>
            <input type="text" id="tgl_berlaku" name="tgl_berlaku" class="easyui-datebox" required="true" />
        </div>
        <div class="fitem">
            <label for="type">Tgl Buat SK</label>
            <input type="text" id="tgl_buat" name="tgl_buat" class="easyui-datebox" required="true" />
        </div>

    </form>
</div>

<div id="dlg-buttons-transaksi_pkwt_sk">
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-ok" onclick="transaksiPkwtSKPrint()">Simpan</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-cancel" onclick="javascript:$('#dlg-transaksi_pkwt_sk').dialog('close')">Batal</a>
</div>
<!-- End of file v_pesertakpd.php -->
<!-- Location: ./application/views/transaksi/v_pesertakpd.php -->