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
    #fm-dialog_matalldept{
        margin:0;
        padding:20px 30px;
    }
    #dlg_btn-dialog_matalldept{
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
    <form id="fm-dialog_matalldept" method="post" novalidate buttons="#dlg_btn-dialog_matalldept">
        <div class="fitem">
            <label for="type">Tahun</label>
            <input type="text" id="matalldept_tahun" name="matalldept_tahun" class="easyui-numberspinner" value=<?php echo date("Y"); ?> min=<?php echo date("Y")-1; ?> max=<?php echo date("Y"); ?>/>
        </div> 
    </form>

<!-- Dialog Button -->
<div id="dlg_btn-dialog_matalldept">
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-ok" onclick="cetak_matalldept();">Cetak</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="width:75" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close');">Batal</a>
</div>


<script type="text/javascript">
    
    
    function cetak_matalldept(){
        var isValid = $('#fm-dialog_matalldept').form('validate');
        if (isValid){
            var tahun       = $('#matalldept_tahun').numberspinner('getValue');
            var url = '<?php echo site_url('report/matalldept/cetak'); ?>/'+tahun;
            var content = '<iframe scrolling="auto" frameborder="0"  src="'+url+'" style="width:100%;height:100%;"></iframe>';
            var title   = 'Cetak Matriks All Departemen ';
            if ($('#tt').tabs('exists', title))
            {
                $('#tt').tabs('select', title);
                $('#fm-dialog_matalldept').dialog('close');
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
