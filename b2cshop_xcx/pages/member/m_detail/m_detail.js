// pages/member/m_detail/m_detail.js
var app = getApp();
const base_url = app.d.base_url;
var list = [];
var max_id = 0;
var since_id = 0;
var per_page = 15;
var page = 1;
var page_score_list = 1;
var is_nex_page = '0';
var is_next_page = 0;
Page({

  /**
   * 页面的初始数据
   */
  data: {
    list: [],
    tg_list:[],
    menu_box_flag: '0',
  },
  //消费列表
  getFinancialList : function () {
    console.log('获取列表上传; m', max_id + '/s' + since_id + '/pe' + per_page + '/pa' + page)
    var that = this;
    that.setData({
      hidden: false
    });
    wx.request({
      url: base_url + 'napi/get_financial_list/' + max_id + '/' + since_id + '/' + per_page + '/' + page + '?sid=' + app.d.sid,
      method: 'GET',
      header: {
        'content-type': 'application/json'
      },
      success: function (res) {
        console.log(res);
        if (res.data.success) {
          list = that.data.list;
          for (var i = 0; i < res.data.data.item_list.length; i++) {
            list.push(res.data.data.item_list[i]);
          }
          that.setData({
            list: list,
            hidden: true
          });
          is_next_page = res.data.data.is_next_page;
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
    });
  },
  //推广列表
  fngetScoreList:function(){
    var that = this;
    wx.request({
      url: base_url + 'napi/get_score_list/gold/' + max_id + '/' + since_id + '/' + per_page + '/' + page_score_list + '?sid=' + app.d.sid,
      method: 'GET',
      header: {
        'content-type': 'application/json'
      },
      success: function (res) {
        console.log(res);
        if (res.data.success) {
          if (res.data.data.item_list){
            var list = that.data.tg_list;
            res.data.data.item_list.forEach(function(i){
              list.push(i);
            })
            that.setData({
              tg_list: list,
            })
            is_nex_page = res.data.data.is_nex_page;
          }
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
    });
  },
  fnmenu:function(e){
    var id = e.currentTarget.id;
    var that = this;
    that.setData({
      menu_box_flag: id,
    })
  },
  fnMenu2: function (e) {
    var that = this;
    that.setData({
      menu_box_flag: e.detail.current
    })
  },
  bindDownLoad1:function(){
    var that = this;
    console.log('上拉触底1')
    if (is_nex_page == '1') {
      page_score_list++;
      that.fngetScoreList();
    } else {
      wx.showToast({
        title: '没有更多了',
        image: '/image/tishi.png',
        duration: 1000
      });
    }
  },
  bindDownLoad2: function () {
    var that = this;
    console.log('上拉触底2')
    if (is_next_page == '1') {
      page++;
      that.getFinancialList();
    } else {
      wx.showToast({
        title: '没有更多了',
        image: '/image/tishi.png',
        duration: 1000
      });
    }
  },
  // scroll: function (e) {
  //   console.log('2', e)
  // },
  // bindscrolltoupper: function (e) {
  //   console.log('3', e)
  // },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this;
    page = 1;
    page_score_list = 1;
    that.data.list = [];
    that.getFinancialList();
    that.fngetScoreList();
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