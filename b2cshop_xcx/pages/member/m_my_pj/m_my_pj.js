// pages/member/m_my_pj/m_my_pj.js
var app = getApp();
const base_url = app.d.base_url;
var list = [];
var imgList = [];
var max_id = 0;
var since_id = 0;
var per_page = 20;
var page = 1;
var is_next_page = 0;

// 我的评价列表
var commentList = function (that) {
  that.setData({
    hidden: false
  });

  wx.request({
    url: base_url + 'napi/get_my_comment_list/' + max_id + '/' + since_id + '/' + per_page + '/' + page + '?sid=' + app.d.sid,
    method: 'GET',
    header: {
      'content-type': 'application/json'
    },
    success: function (res) {
      console.log(res);
      if (res.data.success) {
        list = that.data.list;
        is_next_page = res.data.data.is_next_page;
        for (var i = 0; i < res.data.data.item_list.length; i++) {
          list.push(res.data.data.item_list[i]);
        }
        that.setData({
          list: list,
          hidden: true
        });
        page++;
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
    list: [],
    imgList: [],
    stars: [0, 1, 2, 3, 4],
    fullSrc: '../../../image/xingxing2.png',
    freeSrc: '../../../image/xingxing.png'
  },

  previewImage: function (e) {
    var current = e.target.dataset.src;
    var index = e.target.dataset.index;
    wx.previewImage({
      current: current,
      urls: this.data.imgList[index]
    });
  },  

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    list = [];
    max_id = 0;
    since_id = 0;
    per_page = 20;
    page = 1;
    var that = this;
    that.setData({
      list: list
    });
    commentList(that);
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
      commentList(that);
    }
  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {
  
  }
})