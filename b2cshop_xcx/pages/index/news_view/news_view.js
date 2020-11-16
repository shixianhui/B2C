// pages/index/news_view/news_view.js
var WxParse = require('../../../wxParse/wxParse.js');
var app = getApp();
const base_url = app.d.base_url;
var item_id = "";
var GetList = function (that) {
  /*广告*/
  that.setData({
    hidden: false
  });

  wx.request({
    url: base_url + 'napi/get_page_info/' + item_id,
    method: 'GET',
    header: {
      'content-type': 'application/json'
    },
    success: function (res) {
      console.log(res.data.data);
      if (res.data.success) {
        wx.setNavigationBarTitle({
          title: res.data.data.title,
        })
        var content = res.data.data.content;
        WxParse.wxParse('article', 'html', content, that, 5);
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
  })
}
Page({

  /**
   * 页面的初始数据
   */
  data: {
  
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    item_id = options.item_id;
    var that = this;
    GetList(that);
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