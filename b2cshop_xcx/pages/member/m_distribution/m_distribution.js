// pages/member/m-distribution/m-distribution.js
var app = getApp();
const base_url = app.d.base_url;
Page({

  /**
   * 页面的初始数据
   */
  data: {
    tg_img:'',
  },
  getdistribuion : function () {
    var that = this;
    that.setData({
      hidden: false
    });

    wx.request({
      url: base_url + 'napi/get_presenter_info?sid=' + app.d.sid,
      method: 'GET',
      header: {
        'content-type': 'application/json'
      },
      success: function (res) {
        // console.log(res);
        if (res.data.success) {
          //  console.log(res.data)
          that.setData({
            content: res.data.data
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
  //获取小程序码
  get_wx_code : function () {
    var that = this;
    wx.request({
      url: base_url + 'napi/get_wx_code?sid=' + app.d.sid,
      method: 'GET',
      header: {
        'content-type': 'application/x-www-form-urlencoded',
        'Cookie': 'ci_session=' + app.d.sid
      },
      success: function (res) {
        console.log(res)
        if (res.data.success) {
          that.setData({
            tg_img: res.data.data,
          })
        } else {
          if (res.data.field == 'login') {
            wx.showModal({
              title: '温馨提示',
              content: res.data.message,
              showCancel: false,
              confirmText: '确定',
              success: function (res) {
                if (res.confirm) {
                  wx.switchTab({
                    url: '/pages/member/member',
                  })
                }
              }
            })
          }
          else {
            wx.showModal({
              title: '温馨提示',
              content: res.data.message,
              showCancel: false,
            })
          }
        }
      },
      fail: function (e) {
        wx.showToast({
          title: '网络异常！',
          image: warnImg,
          duration: 1000
        });
      }
    });
  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this;
    // that.getdistribuion();
    that.get_wx_code();
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
  }
})