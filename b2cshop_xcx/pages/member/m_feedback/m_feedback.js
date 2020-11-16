// pages/member/m_feedback/m_feedback.js
const app = getApp();
const base_url = app.d.base_url;
var content = '';

// 反馈信息
var addDeedback = function (that) {
  wx.request({
    url: base_url + 'napi/add_feedback?sid=' + app.d.sid,
    data: {
      content: content
    },
    method: 'POST',
    header: {
      'content-type': 'application/x-www-form-urlencoded'
    },
    success: function (res) {
      if (res.data.success) {
        var pages = getCurrentPages();
        var prevPage = pages[pages.length - 2];
        wx.navigateBack({
          success: function () {
            prevPage.onLoad(); // 执行前一个页面的onLoad方法  
          }
        });
        wx.showToast({
          title: res.data.message,
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

Page({

  /**
   * 页面的初始数据
   */
  data: {
  
  },

  //获取用户输入内容
  input_content: function (e) {
    content = e.detail.value;
  },

  // 反馈信息
  addFeedbook: function(e) {
    var that = this;
    addDeedback(that);
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    content = '';
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