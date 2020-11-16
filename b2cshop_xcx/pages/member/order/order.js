// pages/member/order/order.js
const app = getApp();
const base_url = app.d.base_url;
var s = 'all';
var list = [];
var max_id = 0;
var since_id = 0;
var per_page = 20;
var page = 1;
var id = '';
var thats;
var is_next_page = 0;

// 订单列表
var GetOrderList = function (that) {
  that.setData({
    hidden: false
  });
  console.log('获取上传', s + '/' + max_id + '/' + since_id + '/' + per_page + '/' + page);
  wx.request({
    url: base_url + 'napi/get_order_list/' + s + '/' + max_id + '/' + since_id + '/' + per_page + '/' + page + '?sid=' + app.d.sid,
    method: 'GET',
    header: {
      'content-type': 'application/json'
    },
    success: function (res) {
      console.log('订单列表',res)
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
}

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
          success: function(e) {
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
          duration: 1000
        });
        list = [];
        thats.setData({
          list: list
        });
        page = 1;
        console.log('确认收货',s)
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
var remindDeliverGoods = function(that) {
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
          duration: 1000
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
  });
}

// 取消订单
var closeOrder = function(that) {
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
        page = 1;
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

/**
 * 页面的初始数据
 */
Page({
  data: {
    list: [],
    hidden: true,
    navbar: [{ 'name': '全部', 'value': 'all' }, { 'name': '待付款', 'value': '0' }, { 'name': '待发货', 'value': '1' }, { 'name': '待收货', 'value': '2' }, { 'name': '待评价', 'value': 'pj' }],
    currentTab: 0
  },
  navbarTap: function(e) {
    this.setData({
      currentTab: e.currentTarget.dataset.idx
    });
    s = e.currentTarget.dataset.value;
    page = 1;
    var that = this;
    that.data.list = [];
    GetOrderList(that);
  }, 

  // 支付
  pay: function (e) {
    var item_id = e.currentTarget.dataset.info;
    var newList = this.data.list;
    var order_info = '';
    for (var i = 0; i < newList.length; i++) {
      if (item_id == newList[i].id) {
        var order_info = '{"order_id":' + newList[i].id + ',"order_number":' + newList[i].order_number + ',"total":' + newList[i].total + '}';
        // console.log(order_info);
        wx.navigateTo({
          url: '../../cart/pay/pay?order_info=' + order_info
        });
        return;
      }
    }
  },

  // 评价
  evaluates: function (e) {
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
      content: '您确认已经收到货，进行”确认收货“操作？',
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
  cancel: function(e) {
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

  // 订单详情 
  orderView: function(e) {
    var data = e.currentTarget.dataset.info;
    if (data) {
      wx.navigateTo({
        url: '../order_view/order_view?respone=' + JSON.stringify(data)
      });
    }
  }, 

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    is_next_page = 0;
    var that = this;
    thats = that;
    that.data.list = [];
    if (options) {
      s = options.s;
    } else {
      s = 'pj';
    }
    var index = 0;
    switch (s){
      case 'all': index = 0;
        break;
      case '0': index = 1;
        break;
      case '1': index = 2;
        break;
      case '2': index = 3;
        break;
      case 'pj': index = 4;
        break;      
    };
    // if (s == 'all') {
    //   index = 0;
    // } else if (s == '0') {
    //   index = 1;
    // }
    // else if (s == '1') {
    //   index = 2;
    // }
    // else if (s == '2') {
    //   index = 3;
    // }
    // else if (s == 'pj') {
    //   index = 4;
    // }
    this.setData({
      currentTab: index
    });
    list = [];
    that.data.list = [];
    max_id = 0;
    since_id = 0;
    per_page = 20;
    page = 1;
    GetOrderList(that);
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
    var that = this;
    
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
      GetOrderList(that);
    }
  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {
  
  }
});