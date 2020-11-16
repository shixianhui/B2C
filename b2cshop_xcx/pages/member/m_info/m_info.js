// pages/member/m-info/m-info.js
var app = getApp();
const base_url = app.d.base_url;
var address = require('../../../utils/city.js');
var util = require('../../../utils/util.js');
var animation;
var weixin_account = '';
var nickname = '';
var province_id = '';
var city_id = '';
var area_id = '';
var txt_address = '';
var sex = '';
var birthday = '';

// 获取用户信息
var GetUserInfo = function (that) {
  that.setData({
    hidden: false
  });
  wx.request({
    url: base_url + 'napi/get_user_info?sid=' + app.d.sid,
    method: 'GET',
    header: {
      'content-type': 'application/x-www-form-urlencoded'
    },
    success: function (res) {
      if (res.data.success) {
        weixin_account = res.data.data.weixin_account;
        nickname = res.data.data.nickname;
        sex = res.data.data.sex;
        province_id = res.data.data.province_id;
        city_id = res.data.data.city_id;
        area_id = res.data.data.area_id;
        txt_address = res.data.data.txt_address;
        if(res.data.data.birthday == '0000-00-00'){
          birthday = util.formatDate(new Date());
        }else{
          birthday = res.data.data.birthday;
        }
        that.setData({
          content: res.data.data,
          areaInfo: txt_address,
          date: birthday
        });
      } else {
        wx.showToast({
          title: res.message,
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

// 修改用户信息
var changeUserInfo = function (that) {
  that.setData({
    hidden: false
  });

  wx.request({
    url: base_url + 'napi/change_user_info?sid=' + app.d.sid,
    data: {
      nickname: nickname,
      sex: sex,
      weixin_account: weixin_account,
      birthday: that.data.date,
      province_id: province_id,
      city_id: city_id,
      area_id: area_id,
      txt_address: txt_address
    },
    method: 'POST',
    header: {
      'content-type': 'application/x-www-form-urlencoded'
    },
    success: function (res) {
      if (res.data.success) {
        app.globalData.userInfo.nickname = nickname;
        var pages = getCurrentPages();
        var prevPage = pages[pages.length - 2];
        wx.navigateBack({
          success: function () {
            prevPage.onLoad(); // 执行前一个页面的onLoad方法  
          }
        });
        wx.showToast({
          title: res.data.message,
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
  })
}

Page({

  /**
   * 页面的初始数据
   */
  data: {
    menuType: 0,
    begin: null,
    status: 1,
    end: null,
    isVisible: false,
    animationData: {},
    animationAddressMenu: {},
    addressMenuIsShow: false,
    value: [0, 0, 0],
    provinces: [],
    citys: [],
    areas: [],
    province: '',
    city: '',
    area: '',

    items:[{
      name:'男',
      id:'1'
    }, {
      name: '女',
      id: '2'
    }],
    date:'2016-06-07',
    index: 0
  },

  bindDateChange: function (e) {
    this.setData({
      date: e.detail.value
    })
  },

  //获取用户输入内容
  input_nickname: function (e) {
    nickname = e.detail.value;
  },

  input_weixin_account: function (e) {
    weixin_account = e.detail.value;
  },

  // 确认修改
  confirmModify: function (e) {
    var that = this;
    changeUserInfo(that);
  },

  // 选择性别
  radioChange: function (e) {
    sex = e.detail.value;
  },

  /**
   * 生命周期函数--监听页面加载
   */

  onLoad: function (options) {
    var that = this;
    GetUserInfo(that);

    var animation = wx.createAnimation({
      duration: 300,
      transformOrigin: "50% 50%",
      timingFunction: 'ease',
    });
    this.animation = animation;
    var id = address.provinces[0].id
    this.setData({
      provinces: address.provinces,
      citys: address.citys[id],
      areas: address.areas[address.citys[id][0].id],
    });
  },

  selectDistrict: function (e) {
    var that = this;
    if (that.data.addressMenuIsShow) {
      return;
    }
    that.startAddressAnimation(true);
  },
  // 执行动画
  startAddressAnimation: function (isShow) {
    var that = this;
    if (isShow) {
      that.animation.translateY(0 + 'vh').step();
    } else {
      that.animation.translateY(40 + 'vh').step();
    }
    that.setData({
      animationAddressMenu: that.animation.export(),
      addressMenuIsShow: isShow,
    })
  },
  // 点击地区选择取消按钮
  cityCancel: function (e) {
    this.startAddressAnimation(false);
  },
  // 点击地区选择确定按钮
  citySure: function (e) {
    var that = this;
    var city = that.data.city;
    var value = that.data.value;
    that.startAddressAnimation(false);
    // 将选择的城市信息显示到输入框
    var areaInfo = that.data.provinces[value[0]].name + ' ' + that.data.citys[value[1]].name + ' ' + that.data.areas[value[2]].name;
    province_id = that.data.provinces[value[0]].name;
    city_id = that.data.provinces[value[1]].name;
    area_id = that.data.provinces[value[2]].name;
    txt_address = areaInfo;
    that.setData({
      areaInfo: areaInfo,
    });
  },
  hideCitySelected: function (e) {
    this.startAddressAnimation(false);
  },
  // 处理省市县联动逻辑
  cityChange: function (e) {
    var value = e.detail.value;
    var provinces = this.data.provinces;
    var citys = this.data.citys;
    var areas = this.data.areas;
    var provinceNum = value[0];
    var cityNum = value[1];
    var countyNum = value[2];
    if (this.data.value[0] != provinceNum) {
      var id = provinces[provinceNum].id;
      this.setData({
        value: [provinceNum, 0, 0],
        citys: address.citys[id],
        areas: address.areas[address.citys[id][0].id],
      });
    } else if (this.data.value[1] != cityNum) {
      var id = citys[cityNum].id;
      this.setData({
        value: [provinceNum, cityNum, 0],
        areas: address.areas[citys[cityNum].id],
      });
    } else {
      this.setData({
        value: [provinceNum, cityNum, countyNum]
      });
    }
  },
/*地区结束 */

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