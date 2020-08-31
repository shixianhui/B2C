<style>
    table{border:1px solid #d9d8d8}
    table td{border:thin solid #d9d8d8;}
</style>
<div class="help_right mt20 clearfix">
                <div class="help_tit"><?php if ($itemInfo){echo $itemInfo['title'];} ?></div>
                <div class="helpmian">
                    <?php if ($itemInfo){echo html($itemInfo['content']);} ?>
                </div>
            </div>