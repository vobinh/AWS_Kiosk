<script src="<?php echo url::base() ?>js/bpopup/bpopup_min.js"></script>
<link rel="stylesheet" href="<?php echo url::base() ?>js/jquery.poshytip/tip-yellowsimple/tip-yellowsimple.css" type="text/css" />
<script type="text/javascript" src="<?php echo url::base() ?>js/jquery.poshytip/jquery.poshytip.js"></script>
<script src="<?php echo url::base() ?>js/upload.js"></script>
<style>
.viewport{
    width:auto !important;
}
.circle {
    width: 10px;
    height: 10px;
    background: red;
    -moz-border-radius: 5px;
    -webkit-border-radius: 5px;
    border-radius: 5px;
}
div#popup{
    background-color: #fff;
    border-radius: 10px 10px 10px 10px;
    box-shadow: 0 0 25px 5px #999;
    color: #111;
    display: none;
    min-width: 450px;
    padding: 25px;
}
.cm{
    margin-bottom: 0px !important;
}
.overview{
    width: 100% !important;
}
</style>

<?php 
    $this->db->where('member_id',$this->sess_cus['refer_user_id']);
    $company=$this->db->get('company')->result_array(false);
    
?>
<table width="100%">
    <tr>
        <td style="width: 20%;vertical-align: top;">
            <?php if(!empty($company[0]['company_logo'])){ ?><img border="0" src="<?php echo linkS3 ?>company/<?php if(!empty($company)) echo $company[0]['company_logo']; ?>"><?php }else{ echo '';} ?>
            
        </td>
        <td style="width: 20%;font-size: 22px;text-align: center;color:#000"><?php if(!empty($company)) echo $company[0]['company_name']; ?></td>
        <?php if($this->site['site_description']){ ?>
        <td  style="width: 20%;vertical-align: top;">
            <img  style="height: 90px;" src="<?php echo linkS3 ?>site/<?php echo $this->site['site_description']?>" />
        </td>
        <?php } ?>
        <td style="width: 20%;">
            <!-- HELP -->
                <div style="padding-top: 5px; padding-right:1%; margin:auto; color:#000;overflow: hidden;">
                    <div style="float: right;width:265px">
                        <span class="help_text">Need help? Click here.<span class="triangle_right"></span></span>
                        <span class="help_img" onclick="fn_open_help('dashboard_link')">
                            <img style="width: 25px;vertical-align: middle;margin-top: 5px;margin-left: 3px;" src="<?php echo url::base()?>themes/icon/question30.png" alt="">
                        </span>
                    </div>
                </div>
            <!-- END HELP -->
        </td>
        <?php if($this->sess_cus['user_type']){ if($this->sess_cus['user_type'] == 1){ ?>
            <td style="width: 13%;text-align: right;color:#000">
                <?php $version=$this->db->get('version')->result_array(false); ?>
                <p style="margin-top: 0px;margin-bottom: 0px;">A1K1 WDO Module</p>
                <p style="margin-top: 0px;margin-bottom: 0px;">Single Version</p>
                <p style="margin-top: 0px;margin-bottom: 0px;"><?php if(!empty($version[0]['xml_list_file'])) echo $version[0]['xml_list_file'];  ?></p> 
            </td>
        <?php }else{ ?>
            <td style="width: 13%;text-align: right;color:#000">
                <?php $version=$this->db->get('version')->result_array(false); ?>
                <p style="margin-top: 0px;margin-bottom: 0px;">A1K1 WDO Module</p>
                <p style="margin-top: 0px;margin-bottom: 0px;">Enterprise Version</p>
                <p style="margin-top: 0px;margin-bottom: 0px;"><?php if(!empty($version[0]['cur_version'])) echo $version[0]['cur_version'];  ?></p> 
            </td>   
        <?php }} ?>
    </tr>
</table>


<!-- neu la singer ko can check -->
<?php if(isset($this->sess_cus['user_type']) && $this->sess_cus['user_type'] == 1) {
     require_once('dashboard_activity.php');
}else{  //la enterprise
     if(empty($GLOBALS['m_check_license'][0]['block_account']) && empty($GLOBALS['m_check_license'][0]['cancel_subscription'])){ 
        require_once('dashboard_activity.php');
    }else{
        if(!empty($GLOBALS['m_check_license'][0]['block_account']) && $GLOBALS['m_check_license'][0]['block_account'] == 1){
            require_once('dashboard_retry.php');
        }elseif(!empty($GLOBALS['m_check_license'][0]['cancel_subscription']) && $GLOBALS['m_check_license'][0]['cancel_subscription'] == 1){ 
            require_once('dashboard_cancel.php');
        }
    }
}?>

<script type="text/javascript">
    $(document).ready(function() {
        var date_type     = '<?php echo $date_type ?>';
        var date_end      = '<?php echo $date_end ?>';
        var date_start    = '<?php echo $date_start ?>';
        var time_start    = '<?php echo $time_start ?>';
        var time_end      = '<?php echo $time_end ?>';
        var inspections   = '<?php echo $inspections ?>';
        var treatments    = '<?php echo $treatments ?>';
        var address_start = '<?php echo $address_start ?>';
        var id_ins        = '<?php echo $id_ins ?>';
        if(id_ins > 0)
            popup_calendar(date_type,date_end,date_start,time_start,time_end,inspections,treatments,address_start,id_ins);
    });

    function popup_calendar(date_type,date_end,date_start,time_start,time_end,inspections,treatments,address_start,id_ins){
        $.ajax({
            url: '<?php echo url::base()?>calendar/index/'+date_type+'/'+date_end+'/'+date_start+'/'+time_start+'/'+time_end+'/'+inspections+'/'+treatments+'/'+address_start+'/'+id_ins,
            type: 'GET',
        })
        .done(function(data) {
            $("#wap_export_map" ).html(data);
            $("#wap_export_map" ).dialog({
                resizable: false,
                draggable: false,
                modal: true,
                dialogClass: "no-close",
                width: 800,
                height: 'auto',
                autoOpen:true,
                title:"Export Routes to Google Maps",
            });
        });
    }
</script>
       