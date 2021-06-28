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
    #fm-dialog_tok{
        margin:0;
        padding:20px 30px;
    }
    #dlg_btn-dialog_tok{
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
        width:120px;
    }
</style>
<!-- Form -->
    <form id="fm-dialog_tok" method="post" novalidate buttons="#dlg_btn-dialog_tok">
        <div class="fitem">
            <label for="type">Tahun</label>
            <input type="text" id="t_proposal_tahun" name="t_proposal_tahun" class="easyui-numberspinner" value="<?php echo date("Y"); ?>"/>
        </div>
        <div class="fitem">
             <label for="type">Periode</label>
             <select id="t_proposal_periode" name="t_proposal_periode" class="easyui-combobox" style="width:173px" data-options="panelHeight:'auto'" required="true">
             <option value="1">1</option>
             <option value="2">2</option>
             </select>
        </div>
        <div class="fitem">
            <label for="type">Tok Dari Tgl </label>
            <input type="text" id="tglStart" name="tglStart" class="easyui-datebox" required="true"/>
        </div>
        <div class="fitem">
            <label for="type">Tok Sampai Tgl </label>
            <input type="text" id="tglEnd" name="tglEnd" class="easyui-datebox" required="true"/>
        </div>
        <div class="fitem">
            <label for="type">Tgl Cetak</label>
            <input type="text" id="tanggal_cetak" name="tanggal_cetak" class="easyui-datebox" required="true"/>
        </div> 
    </form>

<!-- Dialog Button -->
<div id="dlg_btn-dialog_tok">
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-ok" onclick="cetak_tok();">Cetak</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close');">Batal</a>
</div>


<script type="text/javascript">
    
    
    function cetak_tok(){
        var isValid = $('#fm-dialog_tok').form('validate');
        if (isValid){
            var tahun       = $('#t_proposal_tahun').numberbox('getValue');
            var periode     = $('#t_proposal_periode').combobox('getValue');
            var tglStart    = $('#tglStart').datebox('getValue');
            var tglEnd      = $('#tglEnd').datebox('getValue');
            var cetak       = $('#tanggal_cetak').datebox('getValue'); 
            var url = '<?php echo site_url('report/tok/cetak'); ?>/'+tahun+'_'+periode+'_'+tglStart+'_'+tglEnd+'_'+cetak;
            var content = '<iframe scrolling="auto" frameborder="0"  src="'+url+'" style="width:100%;height:100%;"></iframe>';
            var title   = 'Cetak Tok '+tahun;
            if ($('#tt').tabs('exists', title))
            {
                $('#tt').tabs('select', title);
                $('#fm-dialog_tok').dialog('close');
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
    


<!-- End of file v_dialog_tok.php -->
<!-- Location: ./views/report/tok/v_dialog_tok.php -->
