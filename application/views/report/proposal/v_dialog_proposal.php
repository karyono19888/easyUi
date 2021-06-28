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
    #fm-dialog_proposal{
        margin:0;
        padding:20px 30px;
    }
    #dlg_btn-dialog_proposal{
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
    <form id="fm-dialog_proposal" method="post" novalidate buttons="#dlg_btn-dialog_proposal">
        <div class="fitem">
            <label for="type">Departemen </label>
            <input type="text" id="t_proposal_dept" name="t_proposal_dept" style="width:172px;" class="easyui-combobox" required="true"
            data-options="url:'<?php echo site_url('report/proposal/getProp'); ?>',
            method:'get', valueField:'departemen_id', textField:'departemen_nama', panelHeight:'150'"/>
        </div>
        <div class="fitem">
            <label for="type">Tahun</label>
            <input type="text" id="t_proposal_tahun" name="t_proposal_tahun" class="easyui-numberspinner" value="<?php echo date("Y"); ?>" required="true"/>
        </div>
        <div class="fitem">
             <label for="type">Periode</label>
             <select id="t_proposal_periode" name="t_proposal_periode" class="easyui-combobox" style="width:172px" data-options="panelHeight:'auto'" required="true">
             <option value="1">1</option>
             <option value="2">2</option>
             </select>
        </div>
        <div class="fitem">
            <label for="type">Tgl Cetak</label>
            <input type="text" id="tanggal_cetak" name="tanggal_cetak" class="easyui-datebox" required="true"/>
        </div> 
    </form>

<!-- Dialog Button -->
<div id="dlg_btn-dialog_proposal">
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-ok" onclick="cetak_proposal();">Cetak</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close');">Batal</a>
</div>


<script type="text/javascript">
    
    
    function cetak_proposal(){
        var isValid = $('#fm-dialog_proposal').form('validate');
        if (isValid){
            var dept    = $('#t_proposal_dept').combobox('getValue');
            var tahun   = $('#t_proposal_tahun').numberbox('getValue');
            var periode = $('#t_proposal_periode').combobox('getValue');
            var cetak   = $('#tanggal_cetak').datebox('getValue');
            var url = '<?php echo site_url('report/proposal/cetak'); ?>/'+dept+'_'+tahun+'_'+periode+'_'+cetak;
            var content = '<iframe scrolling="auto" frameborder="0"  src="'+url+'" style="width:100%;height:100%;"></iframe>';
            var title   = 'Cetak Propsal '+dept;
            if ($('#tt').tabs('exists', title))
            {
                $('#tt').tabs('select', title);
                $('#fm-dialog_proposal').dialog('close');
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
