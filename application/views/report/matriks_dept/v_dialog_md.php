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
    #fm-dialog_md{
        margin:0;
        padding:20px 30px;
    }
    #dlg_btn-dialog_md{
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
    <form id="fm-dialog_md" method="post" novalidate buttons="#dlg_btn-dialog_md">
        
       <div class="fitem">
            <label for="type">Departemen </label>
            <input type="text" id="md_dept" name="md_dept" style="width:150px;" class="easyui-combobox" 
            data-options="url:'<?php echo site_url('report/evaluasi/getDept'); ?>',
            method:'get', valueField:'departemen_id', textField:'departemen_nama', panelHeight:'150'"/>
        </div>
        
        <div class="fitem">
            <label for="type">Tahun</label>
            <input type="text" id="md_tahun" name="md_tahun" class="easyui-numberspinner" value=<?php echo date("Y"); ?> min=<?php echo date("Y")-1; ?> max=<?php echo date("Y"); ?>/>
        </div> 
    </form>

<!-- Dialog Button -->
<div id="dlg_btn-dialog_md">
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-ok" onclick="cetak_md();">Cetak</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close');">Batal</a>
</div>


<script type="text/javascript">
    
    
    function cetak_md(){
        var isValid = $('#fm-dialog_md').form('validate');
        if (isValid){
            var dept        = $('#md_dept').combobox('getValue');
            var tahun       = $('#md_tahun').numberspinner('getValue');
            var url = '<?php echo site_url('report/md/cetak'); ?>/'+dept+'_'+tahun;
            var content = '<iframe scrolling="auto" frameborder="0"  src="'+url+'" style="width:100%;height:100%;"></iframe>';
            var title   = 'Cetak Matriks Dept '+dept;
            if ($('#tt').tabs('exists', title))
            {
                $('#tt').tabs('select', title);
                $('#fm-dialog_md').dialog('close');
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
