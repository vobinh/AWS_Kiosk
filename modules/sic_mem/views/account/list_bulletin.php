<!-- Get data bulletin -->
<?php
    $this->db->join('member',array('member.uid'=>'announcements.user_id'));
    $this->db->where('announcements.refer_user_id', $this->sess_cus['refer_user_id']);
    $this->db->orderby('date','desc');
    $this->db->select('announcements.*','member.member_fname','member.member_lname');
    $data_bulletin = $this->db->get('announcements')->result_array(false);
    if(!empty($data_bulletin)){
        foreach ($data_bulletin as $key => $item_bulletin) {
?>
    <div id="div_item_bulletin_<?php echo $item_bulletin['id'] ?>" style="margin-bottom: 5px;width: auto;overflow: hidden;border: 2px solid #AFC4DB;border-top-left-radius: 6px;border-top-right-radius: 6px;padding: 5px;">
        <div style="width: 100%;overflow: hidden;border-bottom: 2px solid #AFC4DB;line-height: 26px;">
            <?php echo date('m/d/Y H:i A',$item_bulletin['date'])?> - <?php echo !empty($item_bulletin['member_fname'])?$item_bulletin['member_fname'].' ':''; ?><?php echo !empty($item_bulletin['member_lname'])?$item_bulletin['member_lname']:''; ?>
            <?php if($this->sess_cus['id'] == $item_bulletin['refer_user_id'] || $this->sess_cus['id'] == $item_bulletin['user_id']) {?>
            <span class="btn_pen" style="cursor: pointer;width:25px;height: 25px;display: block;background-size: 25px 25px;float:right;" onclick="fn_edit_bulletin(<?php echo $item_bulletin['id'] ?>)"></span>
            <?php }?>
        </div>
        <div>
            <p style="font-weight: bold;margin: 2px auto;line-height: 1.1em;">
                <?php echo !empty($item_bulletin['title'])?$item_bulletin['title']:''; ?>
            </p>
            <p style="margin: 2px auto;line-height: 1.1em;">
                <?php echo !empty($item_bulletin['content'])?$item_bulletin['content']:''; ?>
            </p>
        </div>
    </div>
<?php }}?> <!-- if data bulletin -->

<script type="text/javascript">
   $(function(){
        $(".demo").customScrollbar("resize", true);
        //$(".demo").customScrollbar("scrollTo", $(".demo #sp_btom"));
    });
</script>