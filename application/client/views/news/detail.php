<div class="maincat mp ">
  <div class="Location ">
    <ul>
      <li><?php if ($location){echo $location;} ?> <?php if ($itemInfo){ echo $itemInfo['title'];} ?></li>
    </ul>
  </div>
  <div class="cate-l f mr11">
    <div class="cate-le bor bgwhite">
    <div class="goods-title d">
    <dl>
    <dt><?php if ($itemInfo){ echo $itemInfo['title'];} ?></dt>
    <dd>来源：<?php if ($itemInfo){ echo $itemInfo['source'];} ?>&nbsp;&nbsp;&nbsp;更新日期：<?php if ($itemInfo){ echo date('Y-m-d H:i', $itemInfo['add_time']);} ?>&nbsp;&nbsp;&nbsp;点击：<?php if ($itemInfo){ echo $itemInfo['hits'];} ?>次</dd>
    </dl>
    </div>
    <div class="mune " id="article">
    <?php if ($itemInfo){ echo html($itemInfo['content']);} ?>
    </div>
    <div class="article_pro">
        <div class="fl">
        <div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_qzone" data-cmd="qzone"></a><a href="#" class="bds_tsina" data-cmd="tsina"></a><a href="#" class="bds_tqq" data-cmd="tqq"></a><a href="#" class="bds_renren" data-cmd="renren"></a><a href="#" class="bds_weixin" data-cmd="weixin"></a></div>
        <script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdPic":"","bdStyle":"0","bdSize":"16"},"share":{},"image":{"viewList":["qzone","tsina","tqq","renren","weixin"],"viewText":"分享到：","viewSize":"16"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["qzone","tsina","tqq","renren","weixin"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
        </div>
        <div class="fr">
      转载请注明出处：<a title="<?php if ($itemInfo){ echo clearstring($itemInfo['title']);} ?>"   href="<?php echo base_url().getBaseUrl($html, "", "{$template}/detail/{$id}.html", $client_index); ?>"><?php echo base_url().getBaseUrl($html, "", "{$template}/detail/{$id}.html", $client_index); ?></a>
       </div>
     </div>
     <div class="article_next">
            <div class="fl">
            上一篇：<?php if($prvInfo) {
				$url = getBaseUrl($html, "{$prvInfo['html_path']}/{$prvInfo['id']}.html", "{$template}/detail/{$prvInfo['id']}.html", $client_index);
			    ?>
    <a href='<?php echo $url; ?>' title="<?php echo clearstring($prvInfo['title']); ?>"><?php echo $prvInfo['title']; ?></a>
    <?php } else {echo '<a>没有了</a>';} ?>
            </div>
           <div class="fr">
            下一篇：<?php if($nextInfo){
	$url = getBaseUrl($html, "{$nextInfo['html_path']}/{$nextInfo['id']}.html", "{$template}/detail/{$nextInfo['id']}.html", $client_index);
    ?>           
                <a title="<?php echo clearstring($nextInfo['title']); ?>" href="<?php echo $url; ?>"><?php echo $nextInfo['title']; ?></a>
    <?php } else {echo '<a>没有了</a>';} ?>
            </div>
          	</div>
          
    </div>
    <div class="cate-l bgwhite pad messagebody">
    <div class="messagewidth">
    	<div sid="1946" id="SOHUCS">
    	<div id="SOHU_MAIN">
    	<div class="module-hot-topic clear-g" node-type="hot-topic">
    	<div class="reset-g section-newslist-w">
    <div class="newslist-title-w"><h3 class="title-name-w">相关文章</h3></div>
    <div class="newslist-conts-w clear-g">
        <ul class="conts-col conts-col-1 clear-g">
        <?php if ($relationList) { ?>
		<?php foreach ($relationList as $item) {
			      $url = getBaseUrl($html, "{$item['html_path']}/{$item['id']}.html", "{$template}/detail/{$item['id']}.html", $client_index);
		?>
                <li style="width:253.33333333333331px;white-space:nowrap;overflow:hidden;float:left;"><a title="<?php echo clearstring($item['title']); ?>"   href="<?php echo $url; ?>"><?php echo my_substr($item['title'], 50); ?></a></li>
       <?php }} ?>
          </ul>
    </div>
</div>
</div>
</div>
</div>
</div>
    </div>
</div>
  <?php echo $this->load->view('element/news_right_tool', '', TRUE); ?>  
</div>
<?php echo $this->load->view('element/service_bottom_tool', '', TRUE); ?>