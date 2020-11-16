// pages/member/order-view/order-view.js
const app = getApp();
const base_url = app.d.base_url;
var respone = new Object();
var content = new Object();
var id = '';

// 再次购买
var buyAgain = function (that) {
  wx.request({
    url: base_url + 'napi/buy_again?sid=' + app.d.sid,
    data: {
      order_id: id
    },
    method: 'POST',
    header: {
      'content-type': 'application/x-www-form-urlencoded'
    },
    success: function (res) {
      if (res.data.success) {
        wx.switchTab({
          url: '../../cart/cart',
          success: function (e) {
            var page = getCurrentPages().pop();
            if (page == undefined || page == null) return;
            page.onLoad();
          }
        });
        wx.showToast({
          title: '已加入购物车',
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

// 确认收货
var receivingOrder = function (that) {
  wx.request({
    url: base_url + 'napi/receiving_order?sid=' + app.d.sid,
    data: {
      id: id
    },
    method: 'POST',
    header: {
      'content-type': 'application/x-www-form-urlencoded'
    },
    success: function (res) {
      if (res.data.success) {
        wx.showToast({
          title: res.data.message,
          image: '../../../image/tishi.png',
          duration: 1000
        });
        list = [];
        thats.setData({
          list: list
        });
        GetOrderList(thats);
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

// 提醒发货
var remindDeliverGoods = function (that) {
  wx.request({
    url: base_url + 'napi/remind_deliver_goods?sid=' + app.d.sid,
    data: {
      order_id: id
    },
    method: 'POST',
    header: {
      'content-type': 'application/x-www-form-urlencoded'
    },
    success: function (res) {
      if (res.data.success) {
        wx.showToast({
          title: res.data.message,
          image: '../../../image/tishi.png',
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

// 取消订单
var closeOrder = function (that) {
  wx.request({
    url: base_url + 'napi/close_order?sid=' + app.d.sid,
    data: {
      id: id,
      cancel_cause: '6'
    },
    method: 'POST',
    header: {
      'content-type': 'application/x-www-form-urlencoded'
    },
    success: function (res) {
      if (res.data.success) {
        wx.showToast({
          title: '已取消',
          duration: 1000
        });
        list = [];
        thats.setData({
          list: list
        });
        GetOrderList(thats);
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
    content: []
  },

  // 评价
  evaluate: function (e) {
    var item_id = e.currentTarget.dataset.info;
    if (item_id) {
      wx.navigateTo({
        url: '../order_pj/order_pj?item_id=' + item_id
      });
    }
  },

  // 确认收货
  confirmGoods: function (e) {
    id = e.currentTarget.dataset.info;
    wx.showModal({
      title: '提示',
      content: '您确认已经收到货，进行“确认收货”操作？',
      success: function (res) {
        if (res.confirm) {
          var that = this;
          receivingOrder(that);
        }
      }
    });
  },

  // 再次购买
  againBuy: function (e) {
    id = e.currentTarget.dataset.info;
    var that = this;
    buyAgain(that);
  },

  // 提醒发货
  remindGoods: function (e) {
    id = e.currentTarget.dataset.info;
    var that = this;
    remindDeliverGoods(that);
  },

  // 取消订单
  cancel: function (e) {
    id = e.currentTarget.dataset.info;
    wx.showModal({
      title: '提示',
      content: '您确定要取消订单吗？',
      success: function (res) {
        if (res.confirm) {
          var that = this;
          closeOrder(that);
        }
      }
    });
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    respone = options.respone; 
    respone = JSON.parse(respone);
    var that = this;
    that.setData({
      content: respone
    });
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