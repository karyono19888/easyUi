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
<style type="text/css">
    #fm-dialog_matriks{
        margin:0;
        padding:20px 30px;
    }
    #dlg_btn-dialog_matriks{
        margin:0;
        padding:10px 100px;
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
</style>
<!-- Form -->
    <form id="fm-dialog_matriks" method="post" novalidate buttons="#dlg_btn-dialog_matriks">
        
        <div class="fitem">
                <label for="type">Nama</label>
                <select id="t_evaluasi_peserta" name="t_evaluasi_peserta" class="easyui-combogrid" style="width:250px;" required="true" data-options="
                    panelWidth: 500,
                    idField: 'm_emply_nik',
                    textField: 'm_emply_name',
                    url: '<?php echo site_url('report/matriks/getPeserta'); ?>',
                    method: 'get',
                    mode:'remote',
                    columns: [[
                        {field:'m_emply_nik',title:'NIK',width:40},
                        {field:'m_emply_name',title:'Nama',width:100,sortable:true}
                    ]],
                    onSelect: function(index,row){
                            $('#t_evaluasi_jab').textbox('setValue', row.m_jabatan_id);
                            },
                    fitColumns: true,
                    labelPosition: 'top'
                ">
                </select>
        </div>
        <div class="fitem">
            <label for="type">Jabatan</label>
            <input type="text" id="t_evaluasi_jab" name="t_evaluasi_jab" class="easyui-textbox" readonly="true"/>
        </div> 
        <div class="fitem">
            <label for="type">Tgl Cetak</label>
            <input type="text" id="tanggal_cetak" name="tanggal_cetak" class="easyui-datebox" required="true"/>
        </div> 
    </form>

<!-- Dialog Button -->
<div id="dlg_btn-dialog_matriks">
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-ok" onclick="cetak_matriks();">Cetak</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close');">Batal</a>
</div>


<script type="text/javascript">
    
    
    function cetak_matriks(){
        var isValid = $('#fm-dialog_matriks').form('validate');
        if (isValid){
            var karyawan    = $('#t_evaluasi_peserta').combobox('getValue');
            var jab    = $('#t_evaluasi_jab').textbox('getValue');
            var cetak       = $('#tanggal_cetak').datebox('getValue');
            var url = '<?php echo site_url('report/matriks/cetak'); ?>/'+karyawan+'_'+jab+'_'+cetak;
            var content = '<iframe scrolling="auto" frameborder="0"  src="'+url+'" style="width:100%;height:100%;"></iframe>';
            var title   = 'Cetak Matriks '+karyawan;
            if ($('#tt').tabs('exists', title))
            {
                $('#tt').tabs('select', title);
                $('#fm-dialog_matriks').dialog('close');
            } 
            else 
            {
                $('#tt').tabs('close', title);
                $('#tt').tabs('add',{
                    title:title,
                    content:content,
                    closable:true,
                    iconCls:'icon-print'
                });
                $('#dlg').dialog('close');
            }
        }
         
    }
    
 
    
</script>
    


<!-- End of file v_dialog_proposal.php -->
<!-- Location: ./views/report/proposal/v_dialog_proposal.php -->
