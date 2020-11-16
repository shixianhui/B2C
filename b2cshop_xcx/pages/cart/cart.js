// pages/cart/cart.js

var app = getApp();
const base_url = app.d.base_url;
var list = [];

// 购物车列表
var carList = function (that) {
  if (app.d.sid){
    wx.request({
      url: base_url + 'napi/get_cart_list?sid=' + app.d.sid,
      method: 'GET',
      data: {},
      header: {
        'content-type': 'application/x-www-form-urlencoded'
      },
      success: function (res) {
        console.log(res);
        if (res.data.success) {
          list = that.data.list;
          for (var i = 0; i < res.data.data.item_list.length; i++) {
            list.push(res.data.data.item_list[i]);
          }
          for (var i = 0; i < res.data.data.item_list.length; i++) {
            list[i].select = "circle";
          }
          that.setData({
            list: list,
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
}

// 修改购物车商品数量
var changeCartNumber = function (that, buy_number, cart_id, ids, index) {
  wx.request({
    url: base_url + 'napi/change_cart_number?sid=' + app.d.sid,
    method: 'POST',
    data: {
      buy_number: buy_number,
      cart_id: cart_id,
      ids: ids
    },
    header: {
      'content-type': 'application/x-www-form-urlencoded'
    },
    success: function (res) {
      console.log(app.d.sid)
      if (res.data.success) {
        var newList = that.data.list;
        newList[index].buy_number = buy_number;
        that.setData({
          list: newList
        });

        //计算金额
        that.count();
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
  });
}

// 删除购物车中的商品
var deleteCartProduct = function (that, ids, newList) {
  wx.request({
    url: base_url + 'napi/batch_delete_cart_product?sid=' + app.d.sid,
    method: 'POST',
    data: {
      delete_ids: ids
    },
    header: {
      'content-type': 'application/x-www-form-urlencoded'
    },
    success: function (res) {
      if (res.data.success) {
        that.setData({
          list: []
        });
        carList(that);
        wx.showToast({
          title: '已删除',
          allSelect: 'circle',
          duration: 1000
        });
        that.count();
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
  });
}

Page({

  /**
   * 页面的初始数据
   */
  data: {
    list:[],
    count: 0,
    allSelect: "circle",
    dropColor: false,
  },
  //改变选框状态
  change: function (e) {
    var that = this;
    var index = e.currentTarget.dataset.index;
    var select = e.currentTarget.dataset.select;
    var newList = that.data.list;
    if (select == "circle") {
      var stype = "success";
      newList[index].select = stype;
      that.setData({
        list: newList
      });
      this.fnAllDisplay(1);
    } else {
      var stype = "circle";
      newList[index].select = stype;
      that.setData({
        list: newList
      });
      this.fnAllDisplay(0);
    }
    
    
    //删除按钮颜色控制
    that.fnDropColor();
    //计算金额
    that.count();
  },
  //改变全选状态
  fnAllDisplay:function(i){
    //取消选中》取消全选
    var that = this;
    // console.log('运行');
    if(i){
      var newList = that.data.list;
      var info = 1;
      // 遍历是否都选中了
      // console.log(newList);
      for (var i = 0; i < newList.length; i++) {
        // console.log(newList[i].select);
        if (newList[i].select == "circle"){
          info = 0;
        }
      }
      // console.log(info);
      if (info){
        that.setData({
          allSelect: 'success'
        });
      }
    }else{
      that.setData({
        allSelect: 'circle'
      });
    }
  },
  fnDropColor:function(){
    var that  =this;
    var list = that.data.list;
    that.setData({
      dropColor: false,
    })
    if(list){
      list.forEach(function(i,index){
        if (i.select == "success"){
          that.setData({
            dropColor: true,
          })
        }
        
      })
      
    }
  },
  //减法
  subtraction: function (e) {
    var that = this;
    var index = e.currentTarget.dataset.index;
    var num = e.currentTarget.dataset.num;
    var newList = that.data.list;
    if (num == 1) {
      wx.showToast({
        title: '不能少于一件',
        image: '../../image/tishi.png'
      });
    } else {
      var ids = '';
      for (var i = 0; i < newList.length; i++) {
        ids += newList[i].id + ',';
      }
      ids = ids.substring(0, ids.length - 1);
      num--;
      console.log(num, newList[index].id, ids, index);
      changeCartNumber(that, num, newList[index].id, ids, index);
    }
  },

  // 删除
  binddelete: function (e) {
    var that = this;
    var newList = that.data.list;
    var ids = '';
    for (var i = 0; i < newList.length; i++) {
      if (newList[i].select == "success") {
        ids += newList[i].id + ',';
      }
    }
    ids = ids.substring(0, ids.length - 1);
    deleteCartProduct(that, ids);
  },

  //加法
  addtion: function (e) {
    var that = this;
    var index = e.currentTarget.dataset.index;
    var num = e.currentTarget.dataset.num;
    var newList = that.data.list;
    if (num < 100) {
      var ids = '';
      for (var i = 0; i < newList.length; i++) {
        ids += newList[i].id + ',';
      }
      ids = ids.substring(0, ids.length - 1);
      num++;
      changeCartNumber(that, num, newList[index].id, ids, index);
    } else {
      wx.showToast({
        title: '不能大于99件',
        image: '../../image/tishi.png'
      });
    }

    //把新的值给新的数组
    var newList = that.data.list;
    newList[index].buy_number = num;

    //把新的数组传给前台
    that.setData({
      list: newList
    });

    //计算金额
    that.count();
  },

  // 输入购买数量
  input_buy_number: function (e) {
    var that = this;
    var index = e.currentTarget.dataset.index;
    var num = e.currentTarget.dataset.num;
    num = e.detail.value;
    if (num > 99) {
      num = 99;
      wx.showToast({
        title: '不能大于99件',
        image: '../../image/tishi.png'
      });
    }

    if (num < 1) {
      num = 1;
      wx.showToast({
        title: '不能少于一件',
        image: '../../image/tishi.png'
      });
    }

    //把新的值给新的数组
    var newList = that.data.list;
    newList[index].buy_number = num;

    //把新的数组传给前台
    that.setData({
      list: newList
    });

    //计算金额
    that.count();
  },

  //全选
  allSelect: function (e) {
    var that = this;
    //先判断现在选中没
    var allSelect = e.currentTarget.dataset.select
    var newList = that.data.list;
    if (allSelect == "circle") {
      //先把数组遍历一遍，然后改掉select值
      for (var i = 0; i < newList.length; i++) {
        newList[i].select = "success";
      }
      var select = "success";
      that.setData({
        dropColor: true,
        allSelect: 'success',
      })
    } else {
      for (var i = 0; i < newList.length; i++) {
        newList[i].select = "circle";
      }
      var select = "circle";
      that.setData({
        dropColor: false,
        allSelect: 'circle'
      })
    }
    that.setData({
      list: newList,
      
    });
    //计算金额
    that.count();
  },

  //计算金额方法
  count: function () {
    var that = this;
    //思路和上面一致
    //选中的订单，数量*价格加起来
    var newList = that.data.list;
    var newCount = 0;
    for (var i = 0; i < newList.length; i++) {
      if (newList[i].select == "success") {
        newCount += parseInt(newList[i].buy_number) * parseInt(newList[i].market_price);
      }
    }
    that.setData({
      count: newCount
    });
  },

  // 结算
  balance: function (e) {
    var that = this;
    var newList = that.data.list;
    var ids = '';
    if (newList){
      newList.forEach(function(index,i){
        if (newList[i].select == 'success'){
          ids += newList[i].id + ',';
        }
        
      })
    }
    //去掉最后一个','
    ids = ids.substring(0, ids.length - 1);
    console.log('ids', ids)
    if (ids) {
      wx.navigateTo({
        url: 'order_confirm/order_confirm?cart_ids=' + ids,
      });
    } else {
      wx.showToast({
        title: '请选择购买商品',
        image: '../../image/tishi.png',
        duration: 1000
      });
    }
  },
  //没有登陆跳转登陆
  fnLogin:function(){
    if (!app.d.sid){
      console.log('[提示] 没有登陆，跳转登陆页')
      wx.navigateTo({
        url: '/pages/login/login'
      })
    }
  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    
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
    that.setData({
      list: [],
      allSelect: "circle",
      count : 0
    });
    carList(that);
    this.fnLogin();
    list = '';
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