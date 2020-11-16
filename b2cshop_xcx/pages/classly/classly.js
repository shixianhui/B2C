// pages/classly/classly.js
var app = getApp();
const base_url = app.d.base_url;

Page({

  /**
   * 页面的初始数据
   */
  data: {
    classly: [],
    curNav: 37,
    curIndex: 0,
    list: []
  },
  //切换分类
  switchRightTab: function (e) {
    let id = e.target.dataset.id,
      index = parseInt(e.target.dataset.index);
    this.setData({
      curNav: id,
      curIndex: index
    });
    this.fnGetProductList();
  },
  fnGetList : function (that) {
    wx.request({
      url: base_url + 'napi/get_category_list',
      header: {
        'content-type': 'application/json'
      },
      success: function (res) {
        console.log('分类',res);
        if (res.data.success) {
          that.setData({
            classly: res.data.data.item_list,
            curNav: res.data.data.item_list[0].id
          })
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
    })
  },
  fnGetProductList:function(){
    let that =this;
    let id = that.data.curNav
    console.log('id',id)
    wx.request({
      url: base_url + 'napi/get_product_list/',
      method: 'POST',
      data:{
        category_id: id,

      },
      header: {
        'content-type': 'application/x-www-form-urlencoded'
      },
      success: function (res) {
        console.log('产品列表', res);
        if (res.data.success) {
          that.setData({
            list: res.data.data.item_list
          })
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
    })
  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this;
    this.fnGetList(that);
    this.fnGetProductList();
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