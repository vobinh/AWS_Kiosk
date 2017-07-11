<p style="margin-bottom: 5px;"><strong>Today's Schedule</strong></p>
<div style="height:385px; text-align:left; border:#afc4db 4px solid; position:relative; text-align:left">
    <p style="text-align:center;font-weight: bold;margin: 10px;" ><?php echo date('m/d/Y');?></p>
    <span style="border-top: 4px solid #afc4db;display: block;"></span>
    <div class="default-skin demo scrollable" style="height:285px; text-align:left; position:relative; text-align:left; overflow: hidden;">
         <span style=" padding:2%; display:table; width:96%">
            <table style="width: 100%;">
                <tbody>
                    <?php if(!empty($mschedule)) {?>
                    <?php foreach ($mschedule as $value) {?>
                        <tr>
                            <td style="width: 30%;">
                                <span style="font-size: 13px"><?php echo $value['time_start'] ?></span>
                            </td>
                            <td style="border: 1px solid #<?php if($value['type_event'] == 2){echo '000';}else{echo isset($value['rgb'])?$value['rgb']:'000';} ?>;border-radius: 5px; background:#<?php echo isset($value['rgb'])?$value['rgb']:'fff';?>">
                                <span style="font-size: 13px"><?php echo $value['content']?></span>
                            </td>
                        </tr>
                    <?php }} ?>
                </tbody>
            </table>
        </span>
    </div>
   
    <div class="default-skin demo scrollable" style="padding:5px 2% 5px 15px; width:93%;text-align:right;border-top: 2px solid #808080;overflow: hidden;height: 40px;">
        <?php if(!empty($m_ins)) {?>
            <?php foreach ($m_ins as $value) {?>
            <div style="float: left; padding-right: 10px; height: 20px;">
                <p class="circle" style="margin-top: 5px;margin-bottom: 5px;float: left; background:#<?php echo $value['rgb'] ?>"></p>
                <span  style="float: left; line-height: 20px; padding-left: 5px;" ><b><?php echo $value['ins_name'] ?></b></span>
            </div>           
        <?php }} ?>
    </div>
</div>
<div style="padding:5px 2% 5px 0;  background:#afc4db; float:right; width:98%; text-align:right;">
    <button class="btn" type="button" onclick="openCalendar()" style="margin:0"><a class="btn" style="color:#fff; text-decoration:none"  href="javascript:void(0)">View Calendar</a></button>
</div>
<script type="text/javascript">
 $(function(){
     $(".demo").customScrollbar();
 });
</script>