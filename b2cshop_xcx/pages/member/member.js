// pages/member/member.js
const app = getApp();
const base_url = app.d.base_url;
Page({

  /**
   * 页面的初始数据
   */
  data: {
    allOrderList: '',
    getexchangeList: '',
    userInfo: app.d.userInfo
  },
  // fnLogin:function(){
  //   app.fnDetailLogin();
  // },
  // 获取所有订单
  fnGetOrderList : function (){
    var that =this;
    if (app.d.sid) {
      wx.request({
        url: base_url + 'napi/get_order_list/' + 'all' + '/' + 0 + '/' + 0 + '/' + 999 + '/' + 1 + '?sid=' + app.d.sid,
        method: 'GET',
        header: {
          'content-type': 'application/json'
        },
        success: function (res) {
          if (res.data.success) {
            console.log('订单列表', res.data)
            that.setData({
              allOrderList: res.data.data
            })
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
    }
  },
  // 退换货列表
  fnGetexchangeList : function () {
    var that =this;
    if (app.d.sid){
      wx.request({
        url: base_url + 'napi/get_exchange_list/' + 'all' + '/' + 0 + '/' + 0 + '/' + 99 + '/' + 1 + '?sid=' + app.d.sid,
        method: 'GET',
        header: {
          'content-type': 'application/json'
        },
        success: function (res) {
          if (res.data.success) {
            console.log('退换货列表', res.data);
            that.setData({
              getexchangeList: res.data.data,
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
    }
  },
  //没有登陆跳转登陆
  fnLogin: function () {
    if (!app.d.sid) {
      console.log('[提示] 没有登陆，跳转登陆页')
      wx.navigateTo({
        url: '/pages/login/login'
      })
    }
  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {

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
    this.setData({
      userInfo: app.d.userInfo
    })
    this.fnLogin();
    this.fnGetOrderList();
    this.fnGetexchangeList();
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
  }
})