// pages/member/m_service/m_service.js
var app = getApp();
const base_url = app.d.base_url; 
var GetList = function (that) {
  /*广告*/
  that.setData({
    hidden: false
  });

  wx.request({
    url: base_url + 'napi/get_menu_for_help_list',
    method: 'GET',
    header: {
      'content-type': 'application/json'
    },
    success: function (res) {
      // console.log(res.data.data.item_list)
      if (res.data.success) {
        that.setData({
          list: res.data.data.item_list,
        })
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
    var that=this;
    // GetList(that);
  },
  to_servicelist:function(e){
    var data = e.currentTarget.dataset.info;
    wx.navigateTo({
      url: '../m_service_list/m_service_list?respone=' + JSON.stringify(data),
    })
  },
  makePhoneCall: function (e) {
    wx.makePhoneCall({
      phoneNumber: e.currentTarget.dataset.phone,
      success: function () {
        console.log("成功拨打电话")
      }
    })
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