// pages/index/news_list/news_list.js
var app = getApp();
const base_url = app.d.base_url;
var max_id = 0;
var since_id = 0;
var per_page = 20;
var page = 1;
var news_list = [];
var is_next_page = 0;
var GetList = function (that) {

  /*新闻*/
  wx.request({
    url: base_url + 'napi/get_page_list/263/' + max_id + '/' + since_id + '/' + per_page + '/' + page,
    method: 'get',
    header: {
      'content-type': 'application/json'
    },
    success: function (res) {
      if (res.data.success) {
        is_next_page = res.data.data.is_next_page;
        news_list = that.data.list;
        for (var i = 0; i < res.data.data.item_list.length; i++) {
          news_list.push(res.data.data.item_list[i]);
        }
        that.setData({
          news_list: news_list,
        })
        page++;

        that.setData({
          hidden: true
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
  })
}
Page({

  /**
   * 页面的初始数据
   */
  data: {
    list: []
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    page = 1;
    var that = this;
    GetList(that)
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
    if (is_next_page == '1') {
      wx.showNavigationBarLoading() //在标题栏中显示加载

      // //模拟加载
      setTimeout(function () {
        // complete
        wx.hideNavigationBarLoading() //完成停止加载
        wx.stopPullDownRefresh() //停止下拉刷新
      }, 1000);
    }
  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {
    if (is_next_page == '1') {
      var that = this;
      GetList(that);
    }
  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {
  
  }
})