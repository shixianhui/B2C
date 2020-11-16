// pages/member/m-phone/m-phone.js
var app = getApp();
const base_url = app.d.base_url;
var timer = 1;
var mobile = '';
var password = '';
var smscode = '';

// 绑定手机号
var changeMobile = function (that) {
  wx.request({
    url: base_url + 'napi/change_mobile?sid=' + app.d.sid,
    data: {
      mobile: mobile,
      smscode: smscode
    },
    method: 'POST',
    header: {
      'content-type': 'application/x-www-form-urlencoded'
    },
    success: function (res) {
      if (res.data.success) {
        var pages = getCurrentPages();
        var prevPage = pages[pages.length - 2];
        wx.navigateBack();
        wx.showToast({
          title: '绑定成功',
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
        title: '网络异常！',
        image: '../../../image/tishi.png',
        duration: 1000
      });
    }
  });
}

// 获取短信验证码
var smsCode = function (that) {
  wx.request({
    url: base_url + 'napi/get_reg_sms_code',
    data: {
      mobile: mobile,
      code: '1234',
      'type': 'change_mobile'
    },
    method: 'POST',
    header: {
      'content-type': 'application/x-www-form-urlencoded'
    },
    success: function (res) {
      if (res.data.success) {
        if (timer == 1) {
          timer = 0;
          var time = 60;
          that.setData({
            cssMsg: "code active"
          });
          var inter = setInterval(function () {
            that.setData({
              sendMsg: time + "s后重新发送",
            })
            time--;
            if (time < 0) {
              timer = 1;
              clearInterval(inter);
              that.setData({
                sendMsg: "获取验证码",
                cssMsg: "code"
              });
            }
          }, 1000);
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
}

Page({

  /**
   * 页面的初始数据
   */
  data: {
    sendMsg: "获取验证码",
    cssMsg: "code"
  },

  //获取用户输入内容
  input_mobile: function (e) {
    mobile = e.detail.value;
  },

  input_password: function (e) {
    password = e.detail.value;
  },

  input_smscode: function (e) {
    smscode = e.detail.value;
  },

  // 绑定
  binding: function(e) {
    if (!mobile) {
      wx.showToast({
        title: '请输入手机号',
        image: '../../../image/tishi.png',
        duration: 1000
      });
      return;
    }
    var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1})|(17[0-9]{1}))+\d{8})$/;
    if (!myreg.test(mobile)) {
      wx.showToast({
        title: '手机号错误',
        image: '../../../image/tishi.png',
        duration: 1000
      });
      return;
    }
    if (!smscode) {
      wx.showToast({
        title: '请输入短信验证',
        image: '../../../image/tishi.png',
        duration: 1000
      });
      return;
    }
    if (!password) {
      wx.showToast({
        title: '请输入密码',
        image: '../../../image/tishi.png',
        duration: 1000
      });
      return;
    }

    var that = this;
    changeMobile(that);
  },

  // 获取短信验证码
  sendmsg: function (e) {
    if (!mobile) {
      wx.showToast({
        title: '请输入手机号',
        image: '../../../image/tishi.png',
        duration: 1000
      });
      return;
    }
    var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1})|(17[0-9]{1}))+\d{8})$/;  
    if (!myreg.test(mobile)) {
      wx.showToast({
        title: '手机号错误',
        image: '../../../image/tishi.png',
        duration: 1000
      });
      return;
    }

    var that = this;
    smsCode(that);
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    mobile = '';
    password = '';
    smscode = '';
    // code = '';
    var that = this;
    timer == 1; 
    that.setData({
      cssMsg: 'code',
      sendMsg: '获取验证码',
      // codeImg: base_url + 'verifycode/index/' + Math.floor(Math.random() * 1000 + 1)
    });
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