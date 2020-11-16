// pages/login/login.js
const app = getApp();
const base_url = app.base_url;
Page({

  /**
   * 页面的初始数据
   */
  data: {

  },
  fnLogin: function () {
    let that =this;
    wx.getUserInfo({
      success: res => {
        app.globalData.userInfo = res.userInfo
        app.d.userInfo = res.userInfo
        let encryptedData = res.encryptedData;
        let iv = res.iv;
        //调用登录接口获取code
        console.log('userInfo', res.userInfo)
        wx.login({
          success: function (res) {
            let code = res.code;
            //登录
            that.fnLogins(code, iv, encryptedData);
          }, fail: function (res) {
            console.log(JSON.stringify(res));
          }
        });
      }
    })
  },
  // 登录
  fnLogins: function (code, iv, encryptedData) {
    console.log('登陆上传', code, iv, encryptedData, app.d.parent_id)
    var that = this;
    wx.request({
      url: base_url + 'napi/wx_login',
      method: 'POST',
      data: {
        code: code,
        iv: iv,
        encryptedData: encryptedData,
        parent_id: app.d.parent_id
      },
      header: {
        'content-type': 'application/x-www-form-urlencoded'
      },
      success: function (res) {
        console.log('登陆返回', res)
        if (res.data.success) {

          var data = res.data.data;
          app.d.sid = data.session_id;
          app.d.user_id = data.id;
          app.d.userInfo['sid'] = data.session_id;
          app.d.userInfo['id'] = res.data.data.id;
          app.d.userInfo['nickname'] = res.data.data.nickname;
          app.d.userInfo['path_thumb'] = res.data.data.path_thumb;
          app.d.userInfo['path'] = res.data.data.path;
          app.d.userInfo['total'] = res.data.data.total;
          app.d.userInfo['sex'] = res.data.data.sex;
          app.d.userInfo['score'] = res.data.data.score;
          app.d.userInfo['mobile'] = res.data.data.mobile;
          app.d.userInfo['username'] = res.data.data.username;
          app.d.userInfo['store_id'] = res.data.data.store_id;
          app.d.userInfo['store_display'] = res.data.data.store_display;
          //登陆-写入完成-返回
          wx.navigateBack({
            delta: 1
          })
        } else {
          wx.showToast({
            title: res.data.message,
            image: '/image/tishi.png',
            duration: 1000
          });
        }
      },
      fail: function () {
        wx.showToast({
          title: '网络异常！',
          image: '/image/tishi.png',
          duration: 1000
        });
      }
    });
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