// pages/classly/view_pj/view_pj.js
var app = getApp();
const base_url = app.d.base_url;
Page({

  /**
   * 页面的初始数据
   */
  data: {
    list: [],
    stars: [0, 1, 2, 3, 4],
    fullSrc: '../../../image/xingxing2.png',
    freeSrc: '../../../image/xingxing.png'
  },
  // 全部评论
  commentList : function (item_id) {
    var that =this;
    console.log('item_id',item_id);
    wx.request({
      url: base_url + 'napi/get_product_comment_list/' + item_id,
      method: 'GET',
      header: {
        'content-type': 'application/x-www-form-urlencoded'
      },
      success: function (res) {
        console.log('全部评论',res);
        if (res.data.success) {
          that.setData({
            list: res.data.data
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
    })
  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    // console.log(options);
    this.commentList(options.product_id);
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