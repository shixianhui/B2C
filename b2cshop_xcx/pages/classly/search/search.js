// pages/classly/search/search.js
var app = getApp();
const base_url = app.d.base_url;
var hotList = [];
var keyword = '';

// 热门搜索
var getHotList = function (that) {
  wx.request({
    url: base_url + 'napi/get_hot_keyword_list',
    method: 'GET',
    header: {
      'content-type': 'application/json'
    },
    success: function (res) {
      if (res.data.success) {
        hotList = res.data.data.item_list;
        that.setData({
          hotList: hotList
        });
      } else {
        wx.showToast({
          title: res.data.message,
          image: '../../image/tishi.png',
          duration: 1000
        });
      }
    },
    fail: function (e) {
      wx.showToast({
        title: '网络异常！',
        image: '../../image/tishi.png',
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
    flag: true,
    hotList: []
  },

  // 搜索
  search: function (e) {
    if (keyword) {
      wx.navigateTo({
        url: '../product/product?keyword=' + keyword
      });
    } else {
      wx.showToast({
        image: '../../../image/tishi.png',
        title: '请输入关键字',
        duration: 1000
      });
    }
  },

  // 输入关键字
  input_keyword: function (e) {
    var that = this;
    keyword = e.detail.value;
    if (keyword) {
      that.setData({
        flag: false
      });
    } else {
      that.setData({
        flag: true
      });
    }
  },
 
  // 选择热门
  chooseHot: function (e) {
    var text = e.currentTarget.dataset.text;
    if (text) {
      wx.navigateTo({
        url: '../product/product?keyword=' + text
      });
    } else {
      wx.showToast({
        image: '../../../image/tishi.png',
        title: '请选择热门',
        duration: 1000
      });
    }
  },

  // 换一批
  changeHot: function (e) {
    var that = this;
    getHotList(that);
  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this;
    that.setData({
      hotList: []
    });
    getHotList(that);
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