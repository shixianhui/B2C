// pages/member/friends/friends.js
var app = getApp();
var base_url = app.d.base_url;
var warnImg = '/image/tishi.png';
var per_page = 16;
var page = 1;
var max_id = 0
var since_id = 0
var is_next_page = 0;
var list = [];

Page({

  /**
   * 页面的初始数据
   */
  data: {
    prompt: 'a',
    list: [],
  },
  //按钮切换
  prompt: function (e) {
    var that = this;
    var id = e.currentTarget.id;
    that.setData({
      prompt: id,
      list: [],
    })
    page = 1;
    that.get_subordinate_list(id);
  },
  //我的好友
  get_subordinate_list : function (type) {
    var that = this;
    wx.request({
      url: base_url + 'napi/get_dis_list/' + type + '/' + max_id + '/' + since_id + '/' + per_page + '/' + page +'?sid=' + app.d.sid,
      data: {},
      method: 'POST',
      header: {
        'content-type': 'application/x-www-form-urlencoded',
        'Cookie': 'ci_session=' + app.d.sid
      },
      success: function (res) {
        console.log(res)
        if (res.data.success) {
          var list = that.data.list;
          res.data.data.item_list.forEach(function(i){
            list.push(i);
          })
          that.setData({
            list: list
          });
          is_next_page = res.data.data.is_nex_page;
        } else {
          wx.showToast({
            title: res.data.message,
            image: warnImg,
            duration: 1000
          });
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
    that.setData({
      list:[],
    })
    page = 1;
    that.get_subordinate_list('a');
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
    var that = this;
    if (is_next_page == '1'){
      page++;
      var type = that.data.prompt;
      that.get_subordinate_list(type);
    }
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