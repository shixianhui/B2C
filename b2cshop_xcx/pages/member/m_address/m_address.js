// pages/member/m-address/m-address.js
var app = getApp();
const base_url = app.d.base_url;
var list = [];
var address_ids = '';
var thats = '';
var address_id = '';
var flag = 0;

Page({

  /**
   * 页面的初始数据
   */
  data: {
    list:[]
  },
  // 获取收货地址列表
  fnGetList:function (that) {
    that.setData({
      hidden: false
    });
    wx.request({
      url: base_url + 'napi/get_user_address_list?sid=' + app.d.sid,
      method: 'GET',
      data: {},
      header: {
        'content-type': 'application/x-www-form-urlencoded'
      },
      success: function (res) {
        console.log('收货地址列表',res);
        if (res.data.success) {
          list = that.data.list;
          for (var i = 0; i < res.data.data.item_list.length; i++) {
            list.push(res.data.data.item_list[i]);
          }
          that.setData({
            list: list,
          })

          that.setData({
            hidden: true
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
  },

  // 删除收货地址
  deleteUserAddress : function (that) {
    var that =this;
    wx.request({
      url: base_url + 'napi/delete_user_address?sid=' + app.d.sid,
      method: 'POST',
      data: {
        address_ids: address_ids
      },
      header: {
        'content-type': 'application/x-www-form-urlencoded'
      },
      success: function (res) {
        if (res.data.success) {
          list = [];
          thats.setData({
            list: list,
          });
          that.fnGetList(thats);
          wx.showToast({
            title: '已删除',
            duration: 1000
          });
          that.onLoad;
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
  },

  // 设为默认
  defaultUserAddress : function (that) {
    var that =this;
    wx.request({
      url: base_url + 'napi/set_default_user_address?sid=' + app.d.sid,
      method: 'POST',
      data: {
        id: address_id
      },
      header: {
        'content-type': 'application/x-www-form-urlencoded'
      },
      success: function (res) {
        if (res.data.success) {
          list = [];
          thats.setData({
            list: list,
          });
          that.fnGetList(thats);
          wx.showToast({
            title: '设置成功',
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
  },
  // 设置默认 
  setDefault: function (e) {
    address_id = e.currentTarget.dataset.info;
    if (address_id) {
      var that = this;
      this.defaultUserAddress(that);
    }
  },

  // 编辑地址
  edit: function (e) {
    var data = e.currentTarget.dataset.info;
    if (data) {
      wx.navigateTo({
        url: '../m_address_save/m_address_save?respone=' + JSON.stringify(data),
        success: function (res) {

        },
      });
    }
  },

  // 删除地址
  delete: function (e) {
    var that = this;
    address_ids = e.currentTarget.dataset.info;
    if (address_ids) {
      wx.showModal({
        title: '提示',
        content: '您确定要删除该地址吗？',
        success: function (res) {
          if (res.confirm) {
            console.log('用户点击确定');
            that.deleteUserAddress(that);
          } else {
            console.log('用户取消删除');
          }

        }
      });
    }
  },

  // 选择地址
  choose_address: function (e) {
    if (flag) {
      var that = this;
      var id = e.currentTarget.dataset.id;
      var newList = that.data.list;
      for (var i = 0; i < newList.length; i++) {
        if (newList[i].id == id) {
          var pages = getCurrentPages();
          var prevPage = pages[pages.length - 2];
          prevPage.setData({
            address_info: newList[i]
          });
          wx.navigateBack();
        }
      }
    }
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    flag = 0;
    console.log('1',flag);
    if (options && options.flag) {
      flag = options.flag;
    }
    console.log('2',flag);
    list = [];
    var that = this;
    thats = that;
    that.setData({
      list: list
    });
    this.fnGetList(that);
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