// pages/member/m-collection/m-Collection.js
var app = getApp();
const base_url = app.d.base_url;
var list = [];
var max_id = 0;
var since_id = 0;
var per_page = 20;
var page = 1;
// 收藏列表
var GetOrderList = function (that) {
  that.setData({
    list: [],
    hidden: false
  });
  wx.request({
    url: base_url + 'napi/get_product_favorite_list/' + max_id + '/' + since_id + '/' + per_page + '/' + page,
    method: 'GET',
    header: {
      'content-type': 'application/json'
    },
    data:{
      sid: app.d.sid
    },
    success: function (res) {
      if (res.data.success) {
        list = that.data.list;
        for (var i = 0; i < res.data.data.item_list.length; i++) {
          list.push(res.data.data.item_list[i]);
        }
        for (var i = 0; i < res.data.data.item_list.length; i++) {
          list[i].select = "circle";
        }
        page++;
        that.setData({
          list: list,
          hidden: true
        });
        console.log(that.data.list);
      } else {
        wx.showToast({
          title: res.message,
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
// 删除收藏
var deleteFavorite = function (that, ids, newList) {
  wx.request({
    url: base_url + 'napi/delete_favorite?sid=' + app.d.sid,
    data: {
      favorite_ids: ids
    },
    method: 'POST',
    header: {
      'content-type': 'application/x-www-form-urlencoded'
    },
    success: function (res) {
      if (res.data.success) {
        page = 1;
        GetOrderList(that);
        wx.showToast({
          title: '已删除',
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

Page({
  /**
   * 页面的初始数据
   */
  data: {
    list: [],
    allSelect: "circle",
    marginleft:'-41px;',
    flag:false
  },
  //改变选框状态
  change: function (e) {
    var that = this;
    //得到下标
    var index = e.currentTarget.dataset.index;
    //得到选中状态
    var select = e.currentTarget.dataset.select;

    if (select == "circle") {
      var stype = "success";
    } else {
      var stype = "circle";
    }

    //把新的值给新的数组
    var newList = that.data.list;
    newList[index].select = stype;
    //把新的数组传给前台
    that.setData({
      list: newList
    });
  },

  // 编辑
  bindshow:function(){
    var newList = this.data.list;
    for (var i = 0; i < newList.length; i++) {
      newList[i].select = "circle";
    }
    this.setData({
      marginleft:"0;",
      list: newList,
      allSelect: 'circle',
      flag: true
    });
  },

  // 取消
  bindhide: function () {
    this.setData({
      marginleft: "-41px;",
      flag: false
    })
  },

  //全选
  allSelect: function (e) {
    var that = this;
    var select;
    var allSelect = e.currentTarget.dataset.select;
    var newList = that.data.list;
    if (allSelect == "circle") {
      //先把数组遍历一遍，然后改掉select值
      for (var i = 0; i < newList.length; i++) {
        newList[i].select = "success";
      }
      select = "success";
    } else {
      for (var i = 0; i < newList.length; i++) {
        newList[i].select = "circle";
      }
      select = "circle";
    }
    that.setData({
      list: newList,
      allSelect: select
    });
  },

  // 删除
  binddelete: function () {
    var that = this;
    var ids = '';
    var newList = that.data.list;
    for (var i = 0; i < newList.length; i++) {
      if (newList[i].select == "success") {
        ids += newList[i].id + ',';
      }
    }
    ids = ids.substring(0, ids.length - 1);
    deleteFavorite(that, ids, newList);
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
      allSelect: 'circle',
      list: []
    });
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