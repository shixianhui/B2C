//app.js
App({
  base_url: 'https://www.modoge.com/xbshop/index.php/',
  d: {
    base_url: 'https://www.modoge.com/xbshop/index.php/',
    sid: '',
    user_id: '',
    parent_id: '',
    userInfo: { sid: '', id: '', nickname: '', path: '', total: '', sex: '', score: '', mobile: '', username: '', is_id_card_auth: '', is_default: '', address_id: '', store_display: '', store_id: '',}
  },
  onLaunch: function () {
    // 展示本地存储能力
    var logs = wx.getStorageSync('logs') || []
    logs.unshift(Date.now())
    wx.setStorageSync('logs', logs);
    // 登陆
    this.getUserInfo();
    // wx.login({
    //   success: function (res) {
    //     console.log(res.code);
    //     }
    // })
  },
  globalData: {
    userInfo: ''
  },
  // 获取用户信息
  getUserInfo: function () {
    var that = this;
    
    wx.getSetting({
      success: res => {
        // 已经授权
        if (res.authSetting['scope.userInfo']) {
          // 调用登录接口获取code
          wx.login({
            success: function (res) {
              let code = res.code;
              // console.log(code);
              // 获取iv - encryptedData
              wx.getUserInfo({
                success: function(res){
                  that.globalData.userInfo = res.userInfo
                  that.d.userInfo = res.userInfo
                  var encryptedData = res.encryptedData;
                  var iv = res.iv;
                  // console.log('登陆上传',code, res.userInfo, iv, encryptedData);
                  that.fnLogin(code, iv, encryptedData);
                }, fail: function (res) {
                  console.log(JSON.stringify(res));
                }
              })
            }
          });

          
        }
      }
    })
  },
  // 登录
  fnLogin: function (code, iv, encryptedData) {
    console.log('登陆上传',code,iv)
    var that = this;
    wx.request({
      url: that.base_url + 'napi/wx_login',
      method: 'POST',
      data: {
        code: code,
        iv: iv,
        encryptedData: encryptedData
      },
      header: {
        'content-type': 'application/x-www-form-urlencoded'
      },
      success: function (res) {
        console.log('登陆返回', res)
        if (res.data.success) {

          var data = res.data.data;
          that.d.sid = data.session_id;
          that.d.user_id = data.id;
          console.log('sid', data.session_id);
          that.d.userInfo['sid'] = data.session_id;
          that.d.userInfo['id'] = res.data.data.id;
          that.d.userInfo['nickname'] = res.data.data.nickname;
          that.d.userInfo['path_thumb'] = res.data.data.path_thumb;
          that.d.userInfo['path'] = res.data.data.path;
          that.d.userInfo['total'] = res.data.data.total;
          that.d.userInfo['sex'] = res.data.data.sex;
          that.d.userInfo['score'] = res.data.data.score;
          that.d.userInfo['mobile'] = res.data.data.mobile;
          that.d.userInfo['username'] = res.data.data.username;
          that.d.userInfo['store_id'] = res.data.data.store_id;
          that.d.userInfo['store_display'] = res.data.data.store_display;
        } else {
          wx.showToast({
            title: res.data.message,
            image: '/image/tishi.png',
            duration: 1000
          });
        }
      },
      fail: function () {
        wx.showToast({
          title: '网络异常！',
          image: '/image/tishi.png',
          duration: 1000
        });
      }
    });
  },
  // 内页调用登陆(未启用)
  fnDetailLogin:function(){
    let that = this;
    return new Promise(function (resolve, reject) {
      wx.getUserInfo({
        success: function (res) {
          let encryptedData = res.encryptedData;
          let iv = res.iv;
          wx.login({
            success: function (res) {
              var code = res.code;
              that.fnLogin(code, iv, encryptedData);
            }, fail: function (res) {
              
            }
          });
        }
      })
    });
  },
  
  // 获取广告位图片 例如: 广告位ID:10 获取张图:4 app.fnGet_Ad_List(10,4).then(function (data){});
  fnGetAdList: function (pos, num) {
    let that = this;
    return new Promise(function (resolve, reject) {
      wx.request({
        url: that.base_url + 'napi/get_ad_list/' + pos + '/' + num,
        method: 'GET',
        header: {
          'content-type': 'application/json'
        },
        success: function (res) {
          if (res.data.success) {
            resolve(res.data.data.item_list);
          }else{
            reject(res)
            wx.showToast({
              title: res.data.message,
              image: '/image/icon/tishi.png',
              duration: 1000
            });
          }
        },
        fail: function (e) {
          wx.showToast({
            title: '网络异常！',
            image: '/image/icon/tishi.png',
            duration: 1000
          });
        }
      });
    });
  },
})


