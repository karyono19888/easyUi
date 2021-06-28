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
<style type="text/css">
    #fm-dialog_referensi {
        margin: 0;
        padding: 20px 30px;
    }

    #dlg_btn-dialog_referensi {
        margin: 0;
        padding: 10px 100px;
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
<!-- Form -->
<form id="fm-dialog_referensi" method="post" novalidate buttons="#dlg_btn-dialog_referensi">
    <div class="fitem">
        <label for="type">Nama</label>
        <select id="m_emply_name" name="m_emply_name" class="easyui-combogrid" style="width:250px;" required="true" data-options="
                    panelWidth: 500,
                    idField: 'm_emply_nik',
                    textField: 'm_emply_name',
                    url: '<?php echo site_url('report/referensi/getNama'); ?>',
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
        <label for="type">Tgl Pengunduran</label>
        <input type="text" id="m_emply_end" name="m_emply_end" style="width:250px;" class="easyui-datebox" required="true" />
    </div>
    <div class="fitem">
        <label for="type">Tgl Pengajuan Surat</label>
        <input type="text" id="tgl_pengajuan" name="tgl_pengajuan" style="width:250px;" class="easyui-datebox" required="true" />
    </div>
    <div class="fitem">
        <label for="type">Tgl Cetak</label>
        <input type="text" id="tanggal_cetak_sr" name="tanggal_cetak_sr" style="width:250px;" class="easyui-datebox" required="true" />
    </div>
</form>

<!-- Dialog Button -->
<div id="dlg_btn-dialog_referensi">
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-ok" onclick="cetak_referensi();">Cetak</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close');">Batal</a>
</div>


<script type="text/javascript">
    function cetak_referensi() {
        var isValid = $('#fm-dialog_referensi').form('validate');
        if (isValid) {
            var nama = $('#m_emply_name').combobox('getValue');
            var tgl = $('#m_emply_end').datebox('getValue');
            var tgl_pengajuan = $('#tgl_pengajuan').datebox('getValue');
            var cetak = $('#tanggal_cetak_sr').datebox('getValue');
            var url = '<?php echo site_url('report/referensi/cetak'); ?>/' + nama + '_' + tgl + '_' + tgl_pengajuan + '_' + cetak;
            var content = '<iframe scrolling="auto" frameborder="0"  src="' + url + '" style="width:100%;height:100%;"></iframe>';
            var title = 'Cetak Referensi ' + nama;
            if ($('#tt').tabs('exists', title)) {
                $('#tt').tabs('select', title);
                $('#fm-dialog_referensi').dialog('close');
            } else {
                $('#tt').tabs('close', title);
                $('#tt').tabs('add', {
                    title: title,
                    content: content,
                    closable: true,
                    iconCls: 'icon-print'
                });
                $('#dlg').dialog('close');
            }
        }

    }
</script>



<!-- End of file v_dialog_proposal.php -->
<!-- Location: ./views/report/proposal/v_dialog_proposal.php -->