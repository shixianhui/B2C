// pages/cart/pay/pay.js
var app = getApp();
const base_url = app.d.base_url;
var order_info;
var pay_password = '';
var order_id = '';

// 余额支付
var payOrder = function (that) {
  console.log('余额支付上传', order_id);
  wx.request({
    url: base_url + 'napi/order_yue_pay?sid=' + app.d.sid,
    method: 'POST',
    data: {
      order_id: order_id,
      pay_password: pay_password
    },
    header: {
      'content-type': 'application/x-www-form-urlencoded'
    },
    success: function (res) {
      console.log('余额支付返回');
      if (res.data.success) {
        wx.navigateTo({
          url: '../pay_succeed/pay_succeed?order_num=' + res.data.data.order_number
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
}

Page({

  /**
   * 页面的初始数据
   */
  data: {
    passWord: '',
    passWordArr: [],
    animationData: "",
    showModalStatus: false
  },
  //微信支付
  fnWXPay:function(){
    var that = this;
    wx.login({
      success: function (res) {
        var code = res.code;
        that.fnPayOrderInfo(order_id, code);
      }
    });
  },
  //微信支付
  fnPayOrderInfo: function (order_id, code){
    var that =this;
    console.log('微信1上传',order_id, code, app.d.sid);
    wx.request({
      url: base_url + 'napi/order_xcx_wx_pay/' + order_id + '?sid=' + app.d.sid,
      method: 'POST',
      data: {
        code: code
      },
      header: {
        'content-type': 'application/x-www-form-urlencoded'
      },
      success: function (res) {
        console.log('微信1返回',res)
        if (res.data.success) {
          var data = res.data.data;
          wx.hideLoading();
          wx.requestPayment({
            'timeStamp': data.timeStamp,
            'nonceStr': data.nonceStr,
            'package': data.package,
            'signType': data.signType,
            'paySign': data.paySign,
            'success': function (res) {
              console.log('付款成功', res);
              that.fnPayOk();
              wx.navigateTo({
                url: '../pay_succeed/pay_succeed?order_num=' + that.data.order.order_number
              });
            },
            'fail': function (res) {
            }
          })
        } else {
          wx.showModal({
            title: '温馨提示',
            content: res.data.message,
            showCancel: false,
          })
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
  fnPayOk:function(){
    console.log('付款成功调用');
  },
  //下拉刷新
  fnPayRefresh: function () {
    var that = this;
    console.log('刷新上传', order_id);
    wx.request({
      url: base_url + 'napi/get_order_detail/' + order_id + '?sid=' + app.d.sid,
      method: 'GET',
      header: {
        'content-type': 'application/json'
      },
      success: function (res) {
        console.log('刷新返回', res)
        if (res.data.success) {
          if (res.data.data.total) {
            let total = parseFloat(res.data.data.total);
            let i = 'order.total';
            that.setData({
              [i]: total
            })
          }
          wx.stopPullDownRefresh();
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
  // 显示遮罩层
  showModal: function (e) {
    this.setData({
      showModalStatus: true
    });
  },

  // 隐藏遮罩层  
  hideModal: function () {
    this.setData({
      showModalStatus: false
    });
  },   
  //跳转改支付密码
  fnToGMM:function(){
    wx.navigateTo({
      url: '/pages/member/m_account_security/m_account_security'
    });
  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    pay_password = ''; 
    order_info = JSON.parse(options.order_info);
    order_id = order_info.order_id;
    // console.log(order_info);
    if (app.globalData.userInfo) {
      this.setData({
        user: app.globalData.userInfo,
        order: order_info
      });
    }
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
    this.fnPayRefresh();
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
  
  },
 
  // 输入密码
  onChangeInput: function (e) {
    let that = this;
    if (e.detail.value.length > 6) {
      return;
    } else if (e.detail.value.length == 6) {
      pay_password = e.detail.value;
      payOrder(that);
    }
    if (e.detail.value.length > that.data.passWord.length) {
      that.data.passWordArr.push(true);
    } else if (e.detail.value.length < that.data.passWord.length) {
      that.data.passWordArr.pop();
    }
    that.setData({
      passWord: e.detail.value,
      passWordArr: that.data.passWordArr
    });
  }
})