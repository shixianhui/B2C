// pages/member/m_account_security_modify /m_account_security_modify.js
var app = getApp();
const base_url = app.d.base_url;
var new_password = '';
var con_password = '';

// 修改支付密码
var setPayPwd = function (that) {
  wx.request({
    url: base_url + 'napi/set_pay_password?sid=' + app.d.sid,
    method: 'POST',
    data: {
      new_password: new_password,
      con_password: con_password
    },
    header: {
      'content-type': 'application/x-www-form-urlencoded'
    },
    success: function (res) {
      if (res.data.success) {
        wx.navigateBack();
        wx.showToast({
          title: '修改成功',
          duration: 1000
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
        image: '../../../image/tishi.png',
        title: '网络异常！',
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
  
  },

  // 获取输入的值
  input_newPwd: function (e) {
    new_password = e.detail.value;
  },

  input_conPwd: function (e) {
    con_password = e.detail.value;
  },

  // 修改支付密码
  modifPayPwd: function (e) {
    if (!new_password) {
      wx.showToast({
        image: '../../../image/tishi.png',
        title: '请输入密码',
        duration: 1000
      });
      return;
    }
    if (!con_password) {
      wx.showToast({
        image: '../../../image/tishi.png',
        title: '请输入确认密码',
        duration: 1000
      });
      return;
    }
    if (new_password != con_password) {
      wx.showToast({
        image: '../../../image/tishi.png',
        title: '密码不一致',
        duration: 1000
      });
    }
    setPayPwd(this);
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