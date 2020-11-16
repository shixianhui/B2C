// pages/index/index.js
const app = getApp();
const base_url = app.base_url;
const updateManager = wx.getUpdateManager();

var max_id = 0;
var since_id = 0;
var per_page =20;
var page =1;
var list=[];
var is_next_page = 0;
Page({
  data: {
    imgUrls: [],
    news_list: [],
    item_list: [],
    list: [],

    hidden: true,
  },
  /*头条*/
  fnGetPageList:function(){
    let that =this;
    wx.request({
      url: base_url + 'napi/get_page_list/263/0/0/5/1',
      method: 'get',
      header: {
        'content-type': 'application/json'
      },
      success: function (res) {
        if (res.data.success) {
          that.setData({
            news_list: res.data.data.item_list,
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
  /*分类推荐*/
  fnGetCategoryRecommend:function(){
    let that = this;
    wx.request({
      url: base_url + 'napi/get_category_recommend',
      method: 'get',
      header: {
        'content-type': 'application/json'
      },
      success: function (res) {
        console.log('分类返回',res)
        if (res.data.success) {
          that.setData({
            item_list: res.data.data.item_list,
          })
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
  /*精品推荐*/
  fnGetPrimeProductList:function(){
    let that =this;
    wx.request({
      url: base_url + 'napi/get_prime_product_list/' + max_id + '/' + since_id + '/' + per_page + '/' + page,
      method: 'get',
      header: {
        'content-type': 'application/json'
      },
      success: function (res) {
        console.log('精品推荐', res)
        if (res.data.success) {
          is_next_page = res.data.data.is_next_page;
          list = that.data.list;
          for (var i = 0; i < res.data.data.item_list.length; i++) {
            list.push(res.data.data.item_list[i]);
          }
          that.setData({
            list: list,
          })
          page++;
          that.setData({
            hidden: true
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
    console.log('页面传值',options);
    if (options && options.scene) {
      app.d.parent_id = decodeURIComponent(options.scene)
    } else {
      app.d.parent_id = options.parent_id
    }
    let that = this;
    //get首页banner
    app.fnGetAdList(41, 6).then(function (data) {that.setData({imgUrls: data })});
    /*头条*/
    that.fnGetPageList();
    /*分类推荐*/
    that.fnGetCategoryRecommend();
    /*精品推荐*/
    that.fnGetPrimeProductList();
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
  },

})
updateManager.onCheckForUpdate(function (res) {
  // 请求完新版本信息的回调
  // console.log(res.hasUpdate)
})
updateManager.onUpdateReady(function () {
  wx.showModal({
    title: '温馨提示',
    content: '有新的版本哦！点击确定重启应用',
    success: function (res) {
      if (res.confirm) {
        // 新的版本已经下载好，调用 applyUpdate 应用新版本并重启
        updateManager.applyUpdate()
      }
    }
  })
})
updateManager.onUpdateFailed(function () {
  // 新的版本下载失败
  wx.showToast({
    title: '版本更新失败',
    image: '/image/icon/tishi.png',
    duration: 1000
  });
})



