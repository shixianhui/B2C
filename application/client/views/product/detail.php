<div class="warp">
    <div class="seat">
        <?php echo $location; ?>
        <?php if ($item_info) { echo $item_info['title'];} ?>
    </div>
    <div class="product_detail clearfix">
        <div class="product_picture">
            <div id="tsShopContainer">
                <div id="tsImgS">
                    <a href="<?php if ($attachment_list) { echo $attachment_list[0]['path']; }?>" onclick="return false;"   class="MagicZoom" id="MagicZoom"><img src="<?php if ($attachment_list) { echo $attachment_list[0]['path']; }?>" style="width:430px; height:430px;" id="imgs" />
                    </a>
                </div>
                <img class="MagicZoomLoading" width="16" height="16" src="images/default/loading.gif" alt="Loading..." />
            </div>
            <div class="zoom_scroll" id="zoom_scroll">
                <div class="scrollpic" >
                    <ul id="scrollpic">
                        <?php
                        if ($attachment_list) {
                            foreach ($attachment_list as $item) {
                                ?>
                                <li><a href="#" class="pic" bigimg="<?php echo $item['path']; ?>" smallimg="<?php echo preg_replace('/\./', '_thumb.', $item['path']); ?>"><img src="<?php echo preg_replace('/\./', '_thumb.', $item['path']); ?>" /></a></li>
						    <?php
						    }
						}
						?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="product_info">
            <h2 class="nowrap"><?php if ($item_info) { echo $item_info['title'];}?></h2>
            <div class="desc">
            <?php if ($item_info) { echo $item_info['content_short'];} ?>
            </div>
            <div class="price_box">
                <ul>
                    <li>
                        <div class="fl" style=" margin-top:10px;"><font class="price purple" id="sellPrice"><small>¥</small><?php if ($item_info) {echo $item_info['sell_price'];} ?></font><i class="ml20"><s>¥ <?php if ($item_info) { echo $item_info['market_price'];} ?></s></i>
                        <input type="hidden" id="sell_price" value="<?php if ($item_info) {echo $item_info['sell_price'];} ?>">
                        </div>
                        <div class="fr" style="margin-top:10px;position:relative;"><a href="javascript:void(0);" onclick="add_favorite(<?php echo $item_info['id']; ?>);" class="collect" id="fav-btn"><i class="icon icon-collect <?php if ($favorate_status == 'add') { echo 'active';}?>"></i><span><?php
                                    if ($favorate_status == 'add') {
                                        echo '取消收藏';
                                    } else {
                                        echo '收藏';
                                    }
                                    ?></span></a>
                            <a href="javascript:void(0);" class="share" id="shareShow"><i class="icon icon-share"></i><span>分享</span></a>
                            <div class="share_box" style="position:absolute;top:20px;">
                                <a href="http://www.jiathis.com/send/?webid=qzone&url=<?php echo base_url().getBaseUrl(false,'','product/detail/'.$item_info['id'],$client_index);?>&title=<?php echo $item_info['title'];?>&pic=<?php echo base_url().$item_info['path'];?>"   class="qzone"></a>
                                <a href="http://www.jiathis.com/send/?webid=cqq&url=<?php echo base_url().getBaseUrl(false,'','product/detail/'.$item_info['id'],$client_index);?>&title=<?php echo $item_info['title'];?>&pic=<?php echo base_url().$item_info['path'];?>"   class="qq"></a>
                                <a href="http://www.jiathis.com/send/?webid=weixin&url=<?php echo base_url().getBaseUrl(false,'','product/detail/'.$item_info['id'],$client_index);?>&title=<?php echo $item_info['title'];?>&pic=<?php echo base_url().$item_info['path'];?>"   class="wechat"></a>
                                <a href="http://www.jiathis.com/send/?webid=tsina&url=<?php echo base_url().getBaseUrl(false,'','product/detail/'.$item_info['id'],$client_index);?>&title=<?php echo $item_info['title'];?>&pic=<?php echo base_url().$item_info['path'];?>"   class="weibo"></a>
                            </div>
                        </div>
                        <div style="height:5px;clear:both;"></div>
                        <p style="width:100px;margin-left:46px;text-indent:25px;background:url(images/default/sales.png) no-repeat 0px 0px;background-size:18px 18px;">销量：<?php echo $item_info['sales'];?></p>
                        <p style="width:700px;margin-left:44px;margin-top:8px;"><span class="iconfont" style="font-size:13px;color:#e61d47;padding-right:3px;">&#xe620;</span>赠送：<?php echo $item_info['give_score'];?><?php if ($item_info) {
	                       	if (strtolower($item_info['product_type']) == 'a') {
	                            echo '银象积分';
	                       	} else {
	                       		echo '金象积分';
	                       	}
                        } ?>
                        <span style="margin-left: 20px;color:#999;">（积分换购不赠送积分）</span>
                       </p>
                        <p style="width:700px;margin-left:44px;margin-top:8px;"><span class="iconfont" style="font-size:13px;color:#e61d47;padding-right:3px;">&#xe620;</span>换购：<?php echo $item_info['consume_score'];?><?php if ($item_info) {
                       	if (strtolower($item_info['product_type']) == 'a') {
                            echo '金象积分';
                       	} else {
                       		echo '金/银象积分';
                       	}
                       } ?>
                       <span style="margin-left: 20px;color:#999;">注：金象积分可换购 A、B、C类产品，银象积分可换购B、C类产品</span>
                        </p>
                    </li>
                </ul>
            </div>

            <div class="text_box mt10">
                <ul>
                  <li><span>类型</span><?php if ($item_info) {echo $product_type_arr[$item_info['product_type']];} ?></li>
                    <?php
                      if ($free_postage_setting['is_free']==0) {
                           foreach($postage_way_list as $key=>$ls){
                    ?>
                    <li><span><?php echo $key==0 ? '运费' : '&nbsp;&nbsp;&nbsp;&nbsp;'?></span><font class="free"><?php  echo $ls['title'];?></font> <?php  echo $ls['content'];?></li>
                      <?php }}else{ ?>
                     <li><span>运费</span><font class="free">全国包邮</font> 不包括活动商品</li>
                    <?php  }?>
                </ul>
            </div>
            <style type="text/css">
            	.product_detail .product_info .ncs-key dl dd a {min-width:24px;}
            </style>
            <?php if ($item_info && $item_info['color_size_open']) { ?>
            <div class="ncs-key clearfix">
                <dl id="selectSize">
                    <dt><?php if ($item_info) { echo $item_info['product_size_name']; } ?></dt>
                        <?php if ($size_list) { ?>
                            <?php foreach ($size_list as $key => $value) { ?>
                                <dd><a onclick="javascript:select_size(this, '<?php echo $value['size_id']; ?>');" href="javascript:void(0);" title="<?php echo $value['size_name_hint']; ?>"><?php echo $value['size_name']; ?><i></i></a></dd>
                            <?php }
                        } ?>
                </dl>
                <input type="hidden" id="spec_size_id" value="">
            </div>
            <div class="clear"></div>
            <div class="ncs-key color clearfix">
                <dl id="selectColor" class="clearfix">
                    <dt style="height:100px;"><?php if ($item_info) { echo $item_info['product_color_name'];} ?></dt>
                    <?php if ($color_list) { ?>
                            <?php foreach ($color_list as $key => $value) { ?>
                                <dd><a onclick="javascript:select_color(this, '<?php echo $value['color_id']; ?>');" href="javascript:void(0);" title="<?php echo $value['color_name'] . '-' . $value['color_name_hint']; ?>"><img src="<?php echo preg_replace('/\./', '_thumb.', $value['path']); ?>" width="50" height="50"><i></i></a></dd>
                    <?php }
                        } ?>
                </dl>
                <input type="hidden" id="spec_color_id" value="">
            </div>
            <div class="clear"></div>
            <?php } ?>
            <div class="ncs-buy mt15">
                <span>购买数量</span>
                <div class="ncs-figure-input">
                    <a onclick="javascript:reduce();" href="javascript:void(0)" class="increase" nctype="increase" id="Increase">&nbsp;</a>  <input type="text" name=""  value="1" size="3" maxlength="6" class="input-text" id="buy_num" >
                    <a onclick="javascript:increase();" href="javascript:void(0)" class="decrease" nctype="decrease" id="Reduce">&nbsp;</a> </div><em class="kc ml20" id="stock">库存： <?php if ($item_info) {echo $item_info['stock'];} ?></em>
                    <input value="<?php if ($item_info) {echo $item_info['stock'];} ?>" type="hidden" id="product_stock">
                    <a title="在线咨询" style="margin-left: 30px;" href=" http://wpa.qq.com/msgrd?uin=1269829527&amp;menu=yes" class="kefu_div"  rel="nofollow"  ><img src="images/default/kf.png"></a>
            </div>
            <div class="ncs-btn mt30">
                <a href="javascript:void(0);"  class="buynow t-bg" title="立即购买" onclick="javascript:add_now_cart();">立即购买</a>
                <a href="javascript:void(0);"  class="addcart t-bg" title="加入购物车" id="add-car" onclick="javascript:add_cart();"><i class="icon-cart icon"></i>加入购物车</a>
            </div>
        </div>
    </div>
 <form method="post" action="<?php echo getBaseUrl($html, "", "cart/confirm.html", $client_index); ?>" id="json_form_submit">
    <input type="hidden" id="cart_ids" name="cart_ids[]">
</form>
    <div class="clear"></div>
<?php echo $this->load->view('element/product_detail_tool', '', TRUE); ?>
    <script>
      $("#shareShow,.share_box").hover(function(){
          $(".share_box").show();
      },function(){
          $(".share_box").hide();
      });

      /*********购物**********/
      $("#spec_color_id").val("");
      $("#spec_size_id").val("");
      //选颜色
      function select_color(obj, color_id) {
          $(obj).parent().parent().find('a').removeClass("hovered");
          $(obj).addClass("hovered");
          $("#spec_color_id").val(color_id);

          var size_id = $("#spec_size_id").val();
          if (size_id && color_id) {
              //选定
              $.post(base_url + "index.php/product/get_stock",
                  {
                      "product_id": '<?php if ($item_info) {echo $item_info['id'];} ?>',
                      "size_id": size_id,
                      "color_id": color_id
                  },
                  function (res) {
                      if (res.success) {
                          $('.kc.ml20').html("库存：" + res.data.stock);
                          $("#product_stock").val(res.data.stock);
                          $('.price.purple').html('¥' + res.data.price);
                          //$('#sell_price').val(res.data.price);
                      } else {
                          var d = dialog({
                              fixed: true,
                              title: '提示',
                              content: res.message
                          });
                          d.show();
                          setTimeout(function () {
                              d.close().remove();
                          }, 2000);
                      }
                  },
                  "json"
              );
          }
      }
      //选尺码
      function select_size(obj, size_id) {
          $(obj).parent().parent().find('a').removeClass("hovered");
          $(obj).addClass("hovered");
          $("#spec_size_id").val(size_id);

          var color_id = $("#spec_color_id").val();
          if (size_id && color_id) {
              //选定
              $.post(base_url + "index.php/product/get_stock",
                  {
                      "product_id": '<?php if ($item_info) {echo $item_info['id'];} ?>',
                      "size_id": size_id,
                      "color_id": color_id
                  },
                  function (res) {
                      if (res.success) {
                          $('.kc.ml20').html("库存：" + res.data.stock);
                          $("#product_stock").val(res.data.stock);
                          $('.price.purple').html('¥' + res.data.price);
                          $('#sell_price').val(res.data.price);
                      } else {
                          var d = dialog({
                              fixed: true,
                              title: '提示',
                              content: res.message
                          });
                          d.show();
                          setTimeout(function () {
                              d.close().remove();
                          }, 2000);
                      }
                  },
                  "json"
              );
          }
      }
      //减
      function reduce() {
          //buy_num
          var buy_num = $('#buy_num').val();
          if (buy_num < 2) {
              var d = dialog({
                  fixed: true,
                  title: '提示',
                  content: '购买数量不能再减了'
              });
              d.show();
              setTimeout(function () {
                  d.close().remove();
              }, 2000);
              return false;
          } else {
              $('#buy_num').val(buy_num - 1);
          }
      }

      //加
      function increase() {
          var product_stock = parseInt($('#product_stock').val());
          var buy_num = parseInt($('#buy_num').val());
          if (buy_num >= product_stock) {
              var d = dialog({
                  fixed: true,
                  title: '提示',
                  content: '购买数量不能大于库存'
              });
              d.show();
              setTimeout(function () {
                  d.close().remove();
              }, 2000);
              return false;
          } else {
              buy_num++;
              $('#buy_num').val(buy_num);
          }
      }

      function add_cart() {
          var color_id = $("#spec_color_id").val();
          var size_id = $("#spec_size_id").val();
          var buy_num = $('#buy_num').val();
          <?php if ($item_info && $item_info['color_size_open']) { ?>
          if (!size_id) {
              var d = dialog({
                  fixed: true,
                  title: '提示',
                  content: "请选择<?php if ($item_info) {
                      echo $item_info['product_size_name'];
                  } ?>"
              });
              d.show();
              setTimeout(function () {
                  d.close().remove();
              }, 2000);
              return false;
          }
          if (!color_id) {
              var d = dialog({
                  fixed: true,
                  title: '提示',
                  content: "请选择<?php if ($item_info) {
                      echo $item_info['product_color_name'];
                  } ?>"
              });
              d.show();
              setTimeout(function () {
                  d.close().remove();
              }, 2000);
              return false;
          }
          <?php } ?>
          if (!buy_num) {
              var d = dialog({
                  fixed: true,
                  title: '提示',
                  content: "请填写购买数量"
              });
              d.show();
              setTimeout(function () {
                  d.close().remove();
              }, 2000);
              return false;
          }
          //加入购物车
          $.post(base_url + "index.php/cart/add",
              {
                  "product_id": <?php if ($item_info) {
                  echo $item_info['id'];
              } ?>,
                  "color_id": color_id,
                  "size_id": size_id,
                  "buy_type": 0,
                  "buy_number": buy_num
              },
              function (res) {
                  if (res.success) {
                  	  $('.cartInfo_number').html(res.data.cart_count);
                      $('#g_cart_sum').html(res.data.cart_count);
                      var sell_price = $('#sell_price').val();
                      var total = (sell_price * buy_num).toFixed(2);
                      var path = '<?php if ($item_info) {
                          echo preg_replace('/\./', '_thumb.', $item_info['path']);
                      } ?>';
                      var html = '<table width="100%" border="0">';
                      html += '<tr>';
                      html += '<td style="width:100px;height:80px;vertical-align:middle; text-align:center;" rowspan="3"><a class="pic"><img width="60" height="60" src="' + path + '"></a></td>';
                      html += "<td style='line-height:25px;color:#666;'><strong><?php if ($item_info) {
                          echo clearstring($item_info['title']);
                      } ?></strong></td>";
                      html += ' </tr>';
                      html += '<tr>';
                      html += '<td style="line-height:25px;color:#666;">加入数量：<span style="color:#ff1f1f;">' + buy_num + '</span></td>';
                      html += '</tr>';
                      html += '<tr>';
                      html += ' <td style="line-height:25px;color:#666;">总计金额：<span style="color:#ff1f1f;">¥' + total + '</span></td>';
                      html += '</tr>';
                      html += '</table>';

                      var d = dialog({
                          width: 350,
                          fixed: true,
                          title: '商品已成功加入购物车',
                          content: html,
                          okValue: '去结算',
                          ok: function () {
                              window.location.href = base_url + 'index.php/cart.html';
                          },
                          cancelValue: '继续购物',
                          cancel: function () {
                          }
                      });
                      d.show();
                      return false;
                  } else {
                      if (res.field == 'go_login') {
                          var d = dialog({
                              width: 200,
                              fixed: true,
                              title: '提示',
                              content: res.message,
                              okValue: '登录',
                              ok: function () {
                                  window.location.href = base_url + 'index.php/user/login.html';
                              },
                              cancelValue: '取消',
                              cancel: function () {
                              }
                          });
                          d.show();
                      } else {
                          var d = dialog({
                              fixed: true,
                              title: '提示',
                              content: res.message
                          });
                          d.show();
                          setTimeout(function () {
                              d.close().remove();
                          }, 2000);
                      }
                      return false;
                  }
              },
              "json"
          );
      }
      //立即购买
      function add_now_cart() {
          var color_id = $("#spec_color_id").val();
          var size_id = $("#spec_size_id").val();
          var buy_num = $('#buy_num').val();
          <?php if ($item_info && $item_info['color_size_open']) { ?>
          if (!size_id) {
              var d = dialog({
                  fixed: true,
                  title: '提示',
                  content: "请选择<?php if ($item_info) {
                      echo $item_info['product_size_name'];
                  } ?>"
              });
              d.show();
              setTimeout(function () {
                  d.close().remove();
              }, 2000);
              return false;
          }
          if (!color_id) {
              var d = dialog({
                  fixed: true,
                  title: '提示',
                  content: "请选择<?php if ($item_info) { echo $item_info['product_color_name'];} ?>"
              });
              d.show();
              setTimeout(function () {
                  d.close().remove();
              }, 2000);
              return false;
          }
          <?php } ?>
          if (!buy_num) {
              var d = dialog({
                  fixed: true,
                  title: '提示',
                  content: "请填写购买数量"
              });
              d.show();
              setTimeout(function () {
                  d.close().remove();
              }, 2000);
              return false;
          }
          //加入购物车
          $.post(base_url + "index.php/cart/add",
              {
                  "product_id": <?php if ($item_info) {echo $item_info['id'];} ?>,
                  "color_id": color_id,
                  "size_id": size_id,
                  "buy_type": 1,
                  "buy_number": buy_num
              },
              function (res) {
                  if (res.success) {
                      $('#cart_ids').val(res.data.cart_id);
                      $('#json_form_submit').submit();
                  } else {
                      if (res.field == 'go_login') {
                          var d = dialog({
                              width: 200,
                              fixed: true,
                              title: '提示',
                              content: res.message,
                              okValue: '登录',
                              ok: function () {
                                  window.location.href = base_url + 'index.php/user/login.html';
                              },
                              cancelValue: '取消',
                              cancel: function () {
                              }
                          });
                          d.show();
                      } else {
                          var d = dialog({
                              fixed: true,
                              title: '提示',
                              content: res.message
                          });
                          d.show();
                          setTimeout(function () {
                              d.close().remove();
                          }, 2000);
                      }
                      return false;
                  }
              },
              "json"
          );
      }
        //收藏
        function add_favorite(product_id) {
            if ($("#fav-btn").find(".icon-collect").hasClass('active')) {
                $.post(base_url + "index.php/product/delete_product_favorite",
                        {
                            "product_id": product_id
                        },
                function (res) {
                    if (res.success) {
                        $("#fav-btn").find(".icon-collect").removeClass("active");
                        $("#fav-btn").find("span").text("收藏");
                        var d = dialog({
                            fixed: true,
                            title: '提示',
                            content: '已成功取消收藏'
                        });
                        d.show();
                        setTimeout(function () {
                            d.close().remove();
                        }, 2000);
                        return false;
                    } else {
                        var d = dialog({
                            fixed: true,
                            title: '提示',
                            content: res.message
                        });
                        d.show();
                        setTimeout(function () {
                            d.close().remove();
                        }, 2000);
                        return false;
                    }
                },
                        "json"
                        );
                return false;
            }
            $.post(base_url + "index.php/product/favorite",
                    {"product_id": product_id
                    },
            function (res) {
                if (res.success) {
                    $("#fav-btn").find(".icon-collect").addClass("active");
                    $("#fav-btn").find("span").text("取消收藏");
                    var d = dialog({
                        fixed: true,
                        title: '提示',
                        content: res.message
                    });
                    d.show();
                    setTimeout(function () {
                        d.close().remove();
                    }, 2000);
                    return false;
                } else {
                    var d = dialog({
                        fixed: true,
                        title: '提示',
                        content: res.message
                    });
                    d.show();
                    setTimeout(function () {
                        d.close().remove();
                    }, 2000);
                    return false;
                }
            },
                    "json"
                    );
        }

    </script>