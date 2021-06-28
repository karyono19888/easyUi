<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!-- Data Grid -->
<table id="grid-std_nilai_pemantauan_pekerjaan" data-options="pageSize:50, multiSort:true, remoteSort:true, rownumbers:true, singleSelect:true, 
                fit:true, fitColumns:true, toolbar:toolbar_master_standar_nilai">
    <thead>
        <tr>
            <th data-options="field:'ck',checkbox:true"></th>
            <th data-options="field:'m_std_nilai_eval_pekerjaan_id'" width="50" align="center" sortable="true">ID</th>
            <th data-options="field:'b.departemen_nama'" width="400" halign="center" align="left" sortable="true">Departemen</th>
            <th data-options="field:'a.departemen_nama'" width="400" halign="center" align="left" sortable="true">Bagian</th>
            <th data-options="field:'m_std_nilai_eval_pekerjaan_kriteria'" width="400" halign="center" align="left" sortable="true">Kriteria</th>
        </tr>
    </thead>
</table>

<script type="text/javascript">
    var toolbar_master_standar_nilai = [{
        id: 'std_nilai_pemantauan_pekerjaan-new',
        text: 'New',
        iconCls: 'icon-new_file',
        handler: function() {
            masterStdNilaiPemPekCreate();
        }
    }, {
        id: 'std_nilai_pemantauan_pekerjaan-edit',
        text: 'Edit',
        iconCls: 'icon-edit',
        handler: function() {
            masterStdNilaiPemPekUpdate();
        }
    }, {
        id: 'std_nilai_pemantauan_pekerjaan-delete',
        text: 'Delete',
        iconCls: 'icon-cancel',
        handler: function() {
            masterStdNilaiPemPekHapus();
        }
    }, {
        text: 'Refresh',
        iconCls: 'icon-reload',
        handler: function() {
            masterStdNilaiPemPekRefresh();
        }
    }];

    $('#grid-std_nilai_pemantauan_pekerjaan').datagrid({
            onLoadSuccess: function() {
                $('#std_nilai_pemantauan_pekerjaan-edit').linkbutton('disable');
                $('#std_nilai_pemantauan_pekerjaan-delete').linkbutton('disable');
            },
            onSelect: function() {
                $('#std_nilai_pemantauan_pekerjaan-edit').linkbutton('enable');
                $('#std_nilai_pemantauan_pekerjaan-delete').linkbutton('enable');
            },
            onClickRow: function() {
                $('#std_nilai_pemantauan_pekerjaan-edit').linkbutton('enable');
                $('#std_nilai_pemantauan_pekerjaan-delete').linkbutton('enable');
            },
            onDblClickRow: function() {
                masterPesertakpdUpdate();
            },
            view: scrollview,
            remoteFilter: true,
            url: '<?php echo site_url('master/stdpempek/index'); ?>?grid=true'
        })
        .datagrid('enableFilter');

    function masterStdNilaiPemPekRefresh() {
        $('#std_nilai_pemantauan_pekerjaan-edit').linkbutton('disable');
        $('#master_karawan-delete').linkbutton('disable');
        $('#grid-std_nilai_pemantauan_pekerjaan').datagrid('reload');
    }

    function masterStdNilaiPemPekCreate() {
        $('#dlg-std_nilai_pemantauan_pekerjaan').dialog({
            modal: true
        }).dialog('open').dialog('setTitle', 'Tambah Data');
        $('#fm-std_nilai_pemantauan_pekerjaan').form('clear');
        url = '<?php echo site_url('master/stdpempek/create'); ?>';
    }

    function masterStdNilaiPemPekUpdate() {
        var row = $('#grid-std_nilai_pemantauan_pekerjaan').datagrid('getSelected');
        if (row) {
            $('#dlg-std_nilai_pemantauan_pekerjaan').dialog({
                modal: true
            }).dialog('open').dialog('setTitle', 'Edit Data');
            $('#fm-std_nilai_pemantauan_pekerjaan').form('load', row);
            url = '<?php echo site_url('master/stdpempek/update'); ?>/' + row.m_std_nilai_eval_pekerjaan_id;

        } else {
            $.messager.alert('Info', 'Data belum dipilih !', 'info');
        }
    }

    function masterStdNilaiPemPekSave() {
        $.messager.progress({
            title: 'Dagoan Sakedeung',
            msg: 'Nendeun Data...'
        });
        $('#fm-std_nilai_pemantauan_pekerjaan').form('submit', {
            url: url,
            onSubmit: function() {
                return $(this).form('validate');
            },
            success: function(result) {
                $.messager.progress('close');
                var result = eval('(' + result + ')');
                if (result.success) {
                    //$('#dlg-std_nilai_pemantauan_pekerjaan').dialog('close');
                    masterStdNilaiPemPekRefresh();
                    $.messager.show({
                        title: 'Info',
                        msg: 'Data Berhasil Disimpan'
                    });
                } else {
                    $.messager.show({
                        title: 'Error',
                        msg: 'Input Data Gagal/Data Duplikat'
                    });
                }
            }
        });
    }

    function masterStdNilaiPemPekHapus() {
        $.messager.progress({
            title: 'Dagoan Sakedeung',
            msg: 'Pupus Data...'
        });
        var row = $('#grid-std_nilai_pemantauan_pekerjaan').datagrid('getSelected');
        if (row) {
            var win = $.messager.confirm('Konfirmasi', 'Anda yakin ingin menghapus \n' + row.m_std_nilai_eval_pekerjaan_id + ' ?', function(r) {
                if (r) {
                    $.post('<?php echo site_url('master/stdpempek/delete'); ?>', {
                        m_std_nilai_eval_pekerjaan_id: row.m_std_nilai_eval_pekerjaan_id
                    }, function(result) {
                        $.messager.progress('close');
                        if (result.success) {
                            masterStdNilaiPemPekRefresh();
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

    #fm-master_pesertakpd {
        margin: 0;
        padding: 10px 30px;
    }

    #fm-master_pesertakpd-upload {
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
<div id="dlg-std_nilai_pemantauan_pekerjaan" class="easyui-dialog" style="width:600px; height:300px; padding: 10px 20px" closed="true" buttons="#dlg-buttons-std_nilai_pemantauan_pekerjaan">
    <form id="fm-std_nilai_pemantauan_pekerjaan" method="post" novalidate>

        <div class="fitem">
            <label for="type">Bagian </label>
            <input type="text" id="m_std_nilai_eval_pekerjaan_bag" name="m_std_nilai_eval_pekerjaan_bag" style="width:400px;" class="easyui-combobox" required="true" data-options="url:'<?php echo site_url('master/stdpempek/getBag'); ?>',
            method:'get', valueField:'departemen_id', groupField:'departemen_idk', textField:'departemen_nama', panelHeight:'150'" />
        </div>

        <div class="fitem">
            <label for="type">Kriteria Penilaian </label>
            <input type="text" id="m_std_nilai_eval_pekerjaan_kriteria" name="m_std_nilai_eval_pekerjaan_kriteria" style="width:400px;" class="easyui-textbox" required="true" />
        </div>

    </form>
</div>

<!-- Dialog Button -->
<div id="dlg-buttons-std_nilai_pemantauan_pekerjaan">
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-ok" onclick="masterStdNilaiPemPekSave()">Simpan</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-cancel" onclick="javascript:$('#dlg-std_nilai_pemantauan_pekerjaan').dialog('close')">Batal</a>
</div>

<!-- End of file v_pesertakpd.php -->
<!-- Location: ./application/views/master/v_pesertakpd.php -->