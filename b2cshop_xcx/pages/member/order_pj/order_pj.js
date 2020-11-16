// pages/member/order_pj/order_pj.js
var app = getApp();
const base_url = app.d.base_url;
var item_id = 0;
var list = [];
var content = [];
var batch_path_ids = [];
var product_id = [];
var keyList = [];
let animationShowHeight = 400;  
var tempFilePaths;
var uploadImgCount = 0;
var imgIndex = 0;

// 订单列表
var GetOrderList = function (that) {
  wx.request({
    url: base_url + 'napi/get_order_detail_list/' + item_id + '?sid=' + app.d.sid,
    method: 'GET',
    header: {
      'content-type': 'application/json'
    },
    success: function (res) {
      if (res.data.success) {
        list = that.data.list;
        for (var i = 0; i < res.data.data.item_list.length; i++) {
          keyList[i] = 5;
          content[i] = '';
          product_id[i] = res.data.data.item_list[i].product_id;
          list.push(res.data.data.item_list[i]);
        }
        that.setData({
          list: list,
          key: keyList
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

// 评论
var commentSave = function (that, grades, contents, batch_path_idss) {
  wx.request({
    url: base_url + 'napi/comment_save?sid=' + app.d.sid,
    method: 'POST',
    data: {
      order_id: item_id,
      grade: JSON.stringify(grades),
      content: JSON.stringify(contents),
      batch_path_ids: JSON.stringify(batch_path_idss),
      product_id: JSON.stringify(product_id)
    },
    header: {
      'content-type': 'application/x-www-form-urlencoded'
    },
    success: function (res) {
      if (res.data.success) {
        var pages = getCurrentPages();
        var prevPage = pages[pages.length - 2];
        wx.navigateBack({
          success: function () {
            // prevPage.onLoad();
            console.log('返回上一页!');
          }
        });
        wx.showToast({
          title: '评论成功',
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

// 上传图片
var uploadPhoto = function (that, index) {
  wx.uploadFile({
    url: base_url + 'uploadapi/uploadImageByW2',
    filePath: tempFilePaths[uploadImgCount],
    name: 'field',
    formData: {
      'timestamp': "1471838886",
      "token": "3abaf957cc1d002f9e86de431c3aa02a",
      "model": "exchange",
      "img_index": uploadImgCount
    },
    header: {
      "Content-Type": "multipart/form-data"
    },
    success: function (res) {
      if (res.statusCode == 200) {
        uploadImgCount++;
        var data = JSON.parse(res.data);
        var newList = [];
        if (batch_path_ids[index]) {
          newList = batch_path_ids[index];
        } else {
          newList = [];
        }
        newList.push(data.data);
        batch_path_ids[index] = newList;
        that.setData({
          imgList: []
        });
        that.setData({
          imgList: batch_path_ids
        });
        if (uploadImgCount == tempFilePaths.length) {
          wx.hideToast();
        } else {
          uploadPhoto(that, index);
        }
      }
    },
    fail: function (res) {
      wx.hideToast();
      wx.showModal({
        title: '错误提示',
        content: '上传图片失败',
        image: '../../../image/tishi.png',
        showCancel: false,
        success: function (res) { }
      });
    }
  });
}

Page({

  /**
   * 页面的初始数据
   */
  data: {
    list: list,
    stars: [0, 1, 2, 3, 4],
    fullSrc: '../../../image/xingxing2.png',
    freeSrc: '../../../image/xingxing.png',
    imgList: [],
    key: [],
    animationData: "",
    showModalStatus: false
  },

  // 删除图片
  deleteImg: function (e) {
    var id = e.currentTarget.dataset.id;
    var index = e.currentTarget.dataset.index;
    for (var i = 0; i < batch_path_ids[index].length; i++) {
      if (batch_path_ids[index][i].id == id) {
        batch_path_ids[index].splice(i, 1);
      } 
    }
    this.setData({
      imgList: batch_path_ids
    });
  },

  // 星级
  selectStar: function (e) {
    var count = e.currentTarget.dataset.key;
    var index = e.currentTarget.dataset.index;
    keyList[index] = count;
    this.setData({
      key: keyList
    });
  }, 

  // 评论内容
  input_content: function (e) {
    var index = e.currentTarget.dataset.index;
    content[index] = e.detail.value;
  },

  // 评价
  comment: function (e) {
    var that = this;
    var grades = keyList;
    var contents = content;
    var imgList = that.data.imgList;
    var image_list = [];
    for (var i = 0; i < imgList.length; i++) {
      var imageStr = '';
      for (var j = 0; j < imgList[i].length; j++) {
        imageStr += imgList[i][j].id + ',';
      }
      image_list[i] = imageStr.substring(0, imageStr.length - 1);
    }
    commentSave(that, grades, contents, image_list);
  },

  // 显示遮罩层
  showModal: function (e) {  
    imgIndex = e.currentTarget.dataset.index;
    var animation = wx.createAnimation({
      duration: 200,
      timingFunction: "linear",
      delay: 0
    })
    this.animation = animation;
    animation.translateY(animationShowHeight).step();
    this.setData({
      animationData: animation.export(),
      showModalStatus: true
    });
    setTimeout(function () {
      animation.translateY(0).step()
      this.setData({
        animationData: animation.export()
      });
    }.bind(this), 200);
  },

  // 隐藏遮罩层  
  hideModal: function () {
    var animation = wx.createAnimation({
      duration: 200,
      timingFunction: "linear",
      delay: 0
    });
    this.animation = animation;
    animation.translateY(animationShowHeight).step();
    this.setData({
      animationData: animation.export(),
    });
    setTimeout(function () {
      animation.translateY(0).step();
      this.setData({
        animationData: animation.export(),
        showModalStatus: false
      });
    }.bind(this), 200);
  },

  // 拍照
  shoot: function (e) {
    this.hideModal();
    wx.chooseImage({
      count: 1,
      sizeType: ['original'],
      sourceType: ['camera'],
      success: function (res) {
        tempFilePaths = res.tempFilePaths;
        wx.showToast({
          title: '正在上传...',
          icon: 'loading',
          mask: true,
          duration: 10000
        });  
        uploadImgCount = 0;
        uploadPhoto(that, index);
      }
    });
  },

  // 从相册中选择
  photo: function (e) {
    var index = imgIndex;
    var that = this;
    this.hideModal();
    wx.chooseImage({
      count: 3,
      sizeType: ['original'],
      sourceType: ['album'],
      success: function (res) {
        tempFilePaths = res.tempFilePaths;
        wx.showToast({
          title: '正在上传...',
          icon: 'loading',
          mask: true,
          duration: 10000
        });
        uploadImgCount = 0;
        uploadPhoto(that, index);
      }
    });
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    keyList = [];
    item_id = options.item_id;
    var that = this;
    that.setData({
      imgList: []
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