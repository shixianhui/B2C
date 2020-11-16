// pages/cart/order_confirm/order_confirm.js
var app = getApp();
const base_url = app.d.base_url;
var list = [];
var cart_ids = '';
var remark = '';

Page({
  data: {
    list: [],
    product_total: 0,
    address_info: '',
    buy_number: 0,
    postage_price: 0,
    total: 0    
  },
  // 确认订单列表
  confirmCart : function (cart_ids) {
    var that =this;
    console.log('获取订单上传', cart_ids);
    wx.request({
      url: base_url + 'napi/confirm_cart?sid=' + app.d.sid,
      method: 'POST',
      data: {
        cart_ids: cart_ids
      },
      header: {
        'content-type': 'application/x-www-form-urlencoded'
      },
      success: function (res) {
        console.log('获取订单返回',res);
        if (res.data.success) {
          list = that.data.list;
          var buy_number = 0;
          for (var i = 0; i < res.data.data.cartList.length; i++) {
            list.push(res.data.data.cartList[i]);
            buy_number += parseInt(res.data.data.cartList[i].buy_number);
          }
          that.setData({
            list: list,
            buy_number: buy_number,
            address_info: res.data.data.user_address_info,
            postage_price: res.data.data.postage_price,
            total: res.data.data.total,
            product_total: res.data.data.product_total
          });
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

  // 确认订单
  fnAddOrder : function (user_address_id) {
    console.log('确认订单上传', cart_ids, user_address_id, remark);
    wx.request({
      url: base_url + 'napi/add_order?sid=' + app.d.sid,
      method: 'POST',
      data: {
        cart_ids: cart_ids,
        user_address_id: user_address_id,
        use_score: '0',
        remark: remark
      },
      header: {
        'content-type': 'application/x-www-form-urlencoded'
      },
      success: function (res) {
        console.log('确认订单返回',res)
        if (res.data.success) {
          wx.navigateTo({
            url: '../pay/pay?order_info=' + JSON.stringify(res.data.data)
          });
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
  // 选择地址
  choose_address: function (e) {
    wx.navigateTo({
      url: '../../member/m_address/m_address?flag=1'
    });
  },

  // 备注
  input_remark: function (e) {
    remark = e.detail.value;
  },

  // 提交订单
  add_order: function (e) {
    var that = this;
    var user_address_id = that.data.address_info.id;
    that.fnAddOrder(user_address_id);
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    console.log('options', options);
    if (options.cart_ids){
      cart_ids = options.cart_ids;
    }
    this.confirmCart(cart_ids);
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
  
  }
})