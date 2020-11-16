// pages/classly/product/product.js
var app = getApp();
const base_url = app.d.base_url;
var max_id = 0;
var since_id = 0;
var per_page = 20;
var page = 1;
var list = [];
var category_id = '';
var brand_id = '';
var keyword = '';
var size_id = '';
var order = '';
var by = '';
var is_next_page = 0;

// 获取商品列表
var GetList = function (that) {
  that.setData({
    hidden: false,
    list: []
  });

  wx.request({
    url: base_url + 'napi/get_product_list/' + max_id + '/' + since_id + '/' + per_page + '/' + page,
    method: 'POST',
    data:{
      category_id: category_id,
      brand_id: brand_id,
      keyword: keyword,
      size_id: size_id,
      order: order,
      by: by
    },
    header: {
      'content-type': 'application/x-www-form-urlencoded'
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

// 筛选列表
var productSelect = function (that) {
  wx.request({
    url: base_url + 'napi/product_select/0',
    method: 'GET',
    data: {},
    header: {
      'content-type': 'application/x-www-form-urlencoded'
    },
    success: function (res) {
      if (res.data.success) {
        var ckecklist = res.data.data.brand_list;
        that.setData({
          ckecklist: ckecklist
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
    hidden: true,
    searchName: '请输入搜索关键字',
    ckecklistshow: false,
    chooselist: 1,
    ckecklist: [],
    firstIndex: 0,
    secondIndex: 0,
    saleSort: 0,
    priceSort: 0
  },

  // 价格
  sellPrice: function (e) {
    var priceSort = 0;
    if (order != 'sell_price') {
      order = 'sell_price';
      by = 'asc';
      priceSort = 1;
    } else {
      by = by == 'asc' ? 'desc' : 'asc';
      priceSort = by == 'asc' ? 1 : 2;
    }
    var that = this;
    that.setData({
      chooselist: 3,
      priceSort: priceSort,
      saleSort: 0
    });
    page = 1;
    GetList(that);
  },

  // 销量
  sales: function (e) {
    var saleSort = 0;
    if (order != 'sales') {
      order = 'sales';
      by = 'asc';
      saleSort = 1;
    } else {
      by = by == 'asc' ? 'desc' : 'asc';
      saleSort = by == 'asc' ? 1 : 2;
    }
    var that = this;
    that.setData({
      chooselist: 2,
      saleSort: saleSort,
      priceSort: 0
    });
    page = 1;
    GetList(that);
  },

  // 综合
  synthesis: function (e) {
    order = '';
    by = '';
    var that = this;
    that.setData({
      chooselist: 1,
      saleSort: 0,
      priceSort: 0
    });
    page = 1;
    GetList(that);
  },

  // 弹出筛选
  popovershow: function () {
    this.setData({
      ckecklistshow: true
    });
  },

  // 筛选
  ckecklistTap: function (e) {
    brand_id = e.currentTarget.dataset.id;
    var firstIndex = e.currentTarget.dataset.firstIndex;
    var secondIndex = e.currentTarget.dataset.secondIndex;
    this.setData({
      firstIndex: firstIndex,
      secondIndex: secondIndex
    });
  }, 

  // 确定筛选
  submit: function (e) {
    order = '';
    by = '';
    category_id = '';
    var that = this;
    that.setData({
      chooselist: 1,
      ckecklistshow: false
    });
    page = 1;
    GetList(that);
  }, 

  // 重置筛选
  reset: function (e) {
    category_id = '';
    keyword = '';
    brand_id = '';
    size_id = '';
    order = '';
    by = '';
    var that = this;
    that.setData({
      chooselist: 1,
      ckecklistshow: false,
      firstIndex: -1,
      secondIndex: -1
    });
    GetList(that);
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    console.log(options);
    is_next_page = 0;
    category_id = '';
    keyword = '';
    brand_id = '';
    size_id = '';
    order = '';
    by = '';
    var res = wx.getSystemInfoSync();
    var listimage_height = res.windowWidth * 0.48;
    this.setData({
      listimage_height: listimage_height,
      searchName: '请输入搜索关键字',
      firstIndex: -1,
      secondIndex: -1
    });
    if (options.item_id) {
      category_id = options.item_id;
    } else {
      category_id = '';
    }
    if (options.keyword) {
      keyword = options.keyword;
      this.setData({
        searchName: keyword
      });
    }
    
    var that = this;
    page = 1;
    GetList(that);
    productSelect(that);
  },


  // 隐藏遮罩层  
  hideModal: function () {
    this.setData({
      ckecklistshow: false
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
      GetList(that);
    }
  },

  bindDownLoad: function () {

  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {
  
  }
})
