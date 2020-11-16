// pages/classly/view/view.js
const app = getApp();
const base_url = app.d.base_url;
var content = [];
var imgUrls=[];
var color_list = [];
var size_list = [];
var color_id = 0;
var size_id = 0;
var buy_number = 1;
var buy_type = 0;
var stock = 0;
var item_id = "";
var product_id = "";
var color_size_open = '';
var urls = [];

Page({

  /**
   * 页面的初始数据
   */
  data: {
    contents: '',
    imgUrls: [],
    content:[],
    comment_list: [],
    item_id: 0,
    flag: false,
    collection: "collection",
    specifications_show: false,
    specifications_style: "",
    color_num:0,
    size_num:0,
    buy_number:1,
    //新增
    choose_size: '',
    choose_color: '',
    img_color: '',
    stock: 0,
    price: '',
    mb: '0',
    //评价数量
    comment_count: '',
    //开启规格
    color_size_open: '',
    ///收藏状态
    is_favorite: 0,
    //规格name
    product_size_name: '',
    //颜色name
    product_color_name: '',
  },
  //商品详情
  fnGetList:function () {
    let that = this;
    console.log('获取详情传ID', item_id, app.d.sid);
    wx.request({
      url: base_url + 'napi/get_product_info/' + item_id + '?sid=' + app.d.sid,
      method: 'GET',
      header: {
        'content-type': 'application/x-www-form-urlencoded'
      },
      success: function (res) {
        console.log('商品详情', res)
        if (res.data.success) {
          var data = res.data.data
          product_id = data.item_info.id;
          color_size_open = data.item_info.color_size_open;
          if (data.item_info.attachment_list){
            for (var i = 0; i < data.item_info.attachment_list.length; i++) {
              urls.push(data.item_info.attachment_list[i].path);
            }
          }
          // 价格范围
          if (data.price_info){
            let max_p = Number(data.price_info.max_price);
            let min_p = Number(data.price_info.min_price);
            if (max_p == min_p){
              var price = min_p;
            }else{
              var price = min_p + '-￥' + max_p
            }
          }
          that.setData({
            comment_count: data.comment_count,
            imgUrls: data.item_info.attachment_list,
            img_color: data.item_info.attachment_list[0].path,
            content: data.item_info,
            color_list: data.color_list,
            size_list: data.size_list,
            comment_list: data.comment_list,
            price: price, 
            color_size_open: data.item_info.color_size_open,
            is_favorite: data.item_info.is_favorite,
            product_color_name: data.item_info.product_color_name,
            product_size_name: data.item_info.product_size_name,
          });
          //没有开启规格获取库存
          if (color_size_open == '0') {
            that.setData({
              stock: data.item_info.stock
            })
          }
          stock = data.item_info.stock;
          var content = that.data.content.content;
          that.setData({
            contents: content
          })
        } else {
          wx.showToast({
            title: res.data.message,
            image: '../../../image/tishi.png',
            duration: 1000
          });
        }
      },
      fail: function (e) {
        wx.showToast({
          title: '网络异常！',
          image: '../../../image/tishi.png',
          duration: 1000
        });
      }
    });
  },
  // 开启选择规格
  fnOpenSpec: function (e) {
    var mb = e.currentTarget.dataset.open;
    this.setData({
      mb:mb
    });
  },
  // 加入购物车
  fnSetCart:function (buyNow) {
    console.log('加入购物车上传', item_id, color_id, size_id, buy_number, buy_type)
    wx.request({
      url: base_url + 'napi/add_cart?sid=' + app.d.sid,
      method: 'POST',
      header: {
        'content-type': 'application/x-www-form-urlencoded'
      },
      data: {
        product_id: item_id,
        color_id: color_id,
        size_id: size_id,
        buy_number: buy_number,
        buy_type: buy_type
      },
      success: function (res) {
        console.log('加入购物车返回',res)
        if (res.data.success) {
          wx.showToast({
            title: '已加入购物车',
            duration: 1000
          });
          if (buyNow == '1') {
            var ids = res.data.data.cart_id;
            wx.navigateTo({
              url: '../../cart/order_confirm/order_confirm?cart_ids=' + ids,
            });
          }
        } else {
          wx.showToast({
            title: res.data.message,
            image: '../../../image/tishi.png',
            duration: 1000
          });
        }
      },
      fail: function (e) {
        wx.showToast({
          title: '网络异常！',
          image: '../../../image/tishi.png',
          duration: 1000
        });
      }
    });
  },
  // 加收藏 
  fnSaveFavorite : function () {
    var that = this;
    that.setData({
      hidden: false
    });
    wx.request({
      url: base_url + 'napi/save_product_favorite?sid=' + app.d.sid,
      method: 'POST',
      header: {
        'content-type': 'application/x-www-form-urlencoded'
      },
      data: {
        product_id: product_id
      },
      success: function (res) {
        if (res.data.success) {
          console.log('加入收藏')
        } else {
          wx.showToast({
            title: res.data.message,
            image: '/image/tishi.png',
            duration: 1000
          });
        }
      },
      fail: function (e) {
        wx.showToast({
          title: '网络异常！',
          image: '/image/tishi.png',
          duration: 1000
        });
      }
    });
  },
  // 取消收藏 
  fnDeleFavorite: function () {
    var that = this;
    console.log('运行!')
    wx.request({
      url: base_url + 'napi/delete_product_favorite?sid=' + app.d.sid,
      method: 'POST',
      header: {
        'content-type': 'application/x-www-form-urlencoded'
      },
      data: {
        product_id: product_id
      },
      success: function (res) {
        console.log(res);
        if (res.data.success) {
          console.log('取消收藏')
        } else {
          wx.showToast({
            title: res.data.message,
            image: '/image/tishi.png',
            duration: 1000
          });
        }
      },
      fail: function (e) {
        wx.showToast({
          title: '网络异常！',
          image: '/image/tishi.png',
          duration: 1000
        });
      }
    });
  },
  //确定
  fnEndBuy:function(){
    var that = this;
    if (color_size_open == '1'){
      if (color_id == 0){
        wx.showToast({
          title: '请选择颜色',
          image: '/image/tishi.png',
          duration: 1000
        });
      } else if (size_id == 0){
        wx.showToast({
          title: '请选择规格',
          image: '/image/tishi.png',
          duration: 1000
        });
      }else{
        this.setData({
          mb: 0
        });
      }
    }else{
      this.setData({
        mb: 0
      });
    }
  },
  // 立即购买
  newBuy: function () {
    var that = this;
    if (color_size_open == '1'){
      //开启了规格 但没有选规格和颜色->弹出规格
      if (color_id != 0 && size_id != 0){
        console.log('选了规格，跳购物车');
        that.fnSetCart('1');
      }else{
        this.setData({
          mb: 1
        });
      }
    }else{
      that.fnSetCart('1');
    }
  },
  // 加入购物车
  bindtocart: function () {
    var that = this;
    if (color_size_open == '1') {
      //没有选规格颜色->弹出 
      if (color_id != 0 && size_id != 0) {
        console.log('选了规格，加入购物车');
        that.fnSetCart();
      } else {
        this.setData({
          mb: 1
        });
      }
    }else{
      that.fnSetCart();
    } 
  },

  // 颜色选择
  fnColorTap: function (e) {
    var that = this;
    color_id = e.currentTarget.dataset.color_id;
    if (that.data.color_list){
      that.data.color_list.forEach(function(index,i){
        if (that.data.color_list[i].color_id == color_id){
          that.setData({
            choose_color: that.data.color_list[i].color_name,
            img_color: that.data.color_list[i].path
          })
        }
      });
    };
    this.setData({
      color_num: e.currentTarget.dataset.color_id,
    });
    if (that.data.size_num != 0) {
      console.log('选了尺寸，获取价格!')
      that.fnGetPrice();
    };
  },

  // 尺寸选择
  fnSizeTap: function (e) {
    var that = this;
    size_id = e.currentTarget.dataset.size_id;
    if (that.data.size_list) {
      that.data.size_list.forEach(function (index, i) {
        if (that.data.size_list[i].size_id == size_id) {
          that.setData({
            choose_size: that.data.size_list[i].size_name
          })
        }
      });
    };
    this.setData({
      size_num: e.currentTarget.dataset.size_id
    });
    if (that.data.color_num != 0){
      console.log('选了颜色，获取价格!')
      that.fnGetPrice();
    };
  },
  //传-规格/颜色获取价格
  fnGetPrice:function(){
    var that = this;
    console.log('获取价格传', item_id + '/' + size_id + '/' + color_id);
    wx.request({
      url: base_url + 'napi/get_product_stock/' + item_id + '/' + size_id + '/' + color_id,
      method: 'GET',
      header: {
        'content-type': 'application/x-www-form-urlencoded'
      },
      success: function (res) {
        console.log('获取价格回', res);
        if (res.data.success) {
          var price = '';
          var stock = '';
          if (res.data.data){
            price = res.data.data.price;
            stock = res.data.data.stock;
          }
          that.setData({
            price: price,
            stock: stock,
          });
        } else {
          wx.showToast({
            title: res.data.message,
            image: '/image/tishi.png',
            duration: 1000
          });
        }
      },
      fail: function (e) {
        wx.showToast({
          title: '网络异常！',
          image: '/image/tishi.png',
          duration: 1000
        });
      }
    });
    
  },
  // 加收藏
  fnAddFavorite:function(){
    var that = this;
    if(app.d.sid){
      that.setData({
        is_favorite: 1
      });
    }
    that.fnSaveFavorite();
  },
  //取消收藏 
  fnDelFavorite:function(){
    var that = this;
    that.setData({
      is_favorite: 0
    });
    that.fnDeleFavorite();
  },
  //放大banner图
  fnPreviewImg:function(e){
    var index = e.currentTarget.dataset.index;
    wx.previewImage({
      current: index,
      urls: urls
    });
  },
  /**
   * 生命周期函数--监听页面加载
   */

  onLoad: function (options) {
     console.log('options', options)
    item_id = options.item_id;
    //轮播图放大
    urls = [];
    wx.setNavigationBarTitle({
      title: options.title
    })

    color_id = 0;
    size_id = 0;
    
    this.setData({
      item_id: item_id
    });

    var that = this;
    this.fnGetList();
    
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {

  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {

  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {

  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {

  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {

  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {

  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {
    return {
      title: '博和商城',
      path: 'pages/index/index?parent_id=' + app.d.user_id
    }
  },


  //加法
  addtion: function (e) {
    var that = this
    //得到点击的值
    var num = buy_number
    //默认99件最多
    num++
    if (stock > 99) {
      if (num > 99) {
        num = 99;
        wx.showToast({
          title: '不能大于99件',
          image: '/image/tishi.png',
          duration: 1000
        })
      }
    } else {
      if (num > stock) {
        num = stock;
        wx.showToast({
          title: '不能大于库存',
          image: '/image/tishi.png',
          duration: 1000
        })
      }
    }
    //把新的数组传给前台
    buy_number = num;
    that.setData({
      buy_number: num
    })
  },
  bindblur: function (e) {
    var that = this
    //得到点击的值
    var num = buy_number
    //默认99件最多
    num = e.detail.value;
    if (stock>99){
      if (num > 99) {
        num = 99;
        wx.showToast({
          title: '不能大于99件',
          image: '/image/tishi.png',
          duration: 1000
        })
      }
    }else{
      if (num > stock){
        num = stock;
        wx.showToast({
          title: '不能大于库存',
          image: '/image/tishi.png',
          duration: 1000
        })
      }
    }
    
    if (num < 1) {
      num = 1;
      wx.showToast({
        title: '不能少于一件',
        image: '/image/tishi.png',
        duration: 1000
      })
    }
    buy_number = num;
    that.setData({
      buy_number: num
    })
  },
  //减法
  subtraction: function (e) {
    var that = this
    //得到点击的值
    var num = buy_number
    //当1件时，点击移除
    if (num == 1) {
      // newList.splice(index, 1)
      wx.showToast({
        title: '不能少于一件',
        image: '/image/tishi.png',
        duration: 1000
      })
    } else {
      num--
    }

    //把新的数组传给前台
    buy_number = num;
    that.setData({
      buy_number: num
    })
  },
})