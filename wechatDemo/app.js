//app.js
App({
  baseData: {
    /**服务器api信息 注意不是微信小程序的信息 */
    apiUrl: "https://test.cutepetxb.cn/",
    api_appid: "wx9fd339ad1b6ef7e6",
    api_appsecret: 'c61e22dcc1c0283528dc6bf2e889bd52',
    api_access_token: {},
  },
  globalData: {
    keyword: "", 
    category_id: ""
  },

  onLaunch: function(options) {

    wx.clearStorageSync(); //初始化的时候先清除本地缓存
    var that = this;
    if (typeof options.query.from_user_id != "undefined") {
      var from_user_id = options.query.from_user_id;
      wx.setStorageSync("from_user_id", from_user_id);
    }
    //扫码
    if (typeof options.query.scene != "undefined") {
      var params = options.query.scene.split("_");
      var from_user_id = params[1];
      wx.setStorageSync("from_user_id", from_user_id);
    }

  },

  /**授权获取用户信息 */
  authorize: function() {
    wx.getSetting({
      success(res) {
        if (!res.authSetting['scope.userInfo']) {
          wx.authorize({
            scope: 'scope.userInfo',
            success() {
              // 用户已经同意小程序使用录音功能，后续调用 wx.startRecord 接口不会弹窗询问
              wx.startRecord()
            }
          })
        }
      }
    });
  },
  getjh: function() {
    // //更新用户信息
    that.apiPost({
      'uri': 'user/update_user_info.html',
      'data': res,
      'callback': function(res) {
        wx.setStorage({
          key: "user_data",
          data: "",
          success: function() {
            that.userLogin().then(function(res) {
              that.setData({
                "userInfo": res
              });
            });
          }
        });
      }
    });
  },
  /**初始化系统 */
  initialize: function(callback) {
    var that = this;

    that.getApiToken().then(function(api) {
      that.userLogin().then(function(userInfo) {
        if (typeof callback == "function") {
          return callback({
            "userInfo": userInfo,
          });
        }
       })
    })
  },


  /**检查购物车商品数量 */
  checkCartNum: function(callback) {
    var that = this;
    that.apiPost({
      "uri": "cart/check_cart_num.html",
      "data": {},
      "callback": function(res) {
        if (!res.error_code) {
          wx.setTabBarBadge({
            index: 3,
            text: res.data + "" //可改 
          });
        } else {
          wx.hideTabBarRedDot({
            index: 3
          })
        }
        if (typeof callback == "function") {
          return callback(res.data);
        }
      }
    })
  },

  /**api用户登陆 */
  getApiToken: function() {
    var that = this;
    return new Promise(function(resolve, reject) {
      //判断token是否存在过期
      var tokendata = wx.getStorageSync('api_access_token');
      var currtime = parseInt(Date.parse(new Date()) / 1000);

      if (tokendata == "" || tokendata.expire < currtime) {
        var pdata = {
          appid: that.baseData.api_appid,
          appsecret: that.baseData.api_appsecret
        };
        wx.request({
          url: that.baseData.apiUrl + 'base/get_access_token.html',
          method: "POST",
          dataType: 'json',
          header: {
            'content-type': 'application/x-www-form-urlencoded'
          },
          data: pdata,
          success: function(res) {
            var resd = res.data;
            if (!resd.error_code) {
              //保存token到缓存
              var expire = parseInt(Date.parse(new Date()) / 1000) + 7200;

              var tokendata = {
                "token": resd.data.access_token,
                "expire": expire
              };
              wx.setStorageSync("api_access_token", tokendata);
              wx.setStorageSync("user_data", "");
              resolve(tokendata);
            } else {
              console.log(res.error_code);
            }
          }
        });
      } else {
        //更新token时间
        var expire = parseInt(Date.parse(new Date()) / 1000) + 7200;
        tokendata.expire = expire;
        wx.setStorageSync("api_access_token", tokendata);
        resolve(tokendata);
      }

    })
  },

  /**用户登陆 */
  userLogin: function() {
    var that = this;
    return new Promise(function(resolve, reject) {
      var user_data = wx.getStorageSync('user_data');
      var from_user_id = wx.getStorageSync("from_user_id");
      var api_access_token = wx.getStorageSync("api_access_token");

      if (user_data == "") {
        wx.login({
          success: function(res) {
            if (res.code) {
              wx.request({
                url: that.baseData.apiUrl + 'user/user_login.html?access_token=' + api_access_token.token,
                data: {
                  "login_type": "wechatfun",
                  "code": res.code,
                  "parent_user_id": from_user_id ? from_user_id : 0
                },
                method: "POST",
                dataType: 'json',
                header: {
                  'content-type': 'application/x-www-form-urlencoded'
                },
                success: function(res) {
                  var res = res.data;
                  if (!res.error_code) {
                    wx.setStorageSync("user_data", res.data); //同步写入缓存
                    resolve(res.data);
                  } else {
                    console.log(res);
                  }
                }

              });
            } else {
              console.log('登录失败！' + res.errMsg)
            }
          },
        })
      } else {
        resolve(user_data);
      }
    })
  },
  /** 查找来源用户的店铺*/
  getStore: function(flush) {
    var that = this;
    return new Promise(function(resolve, reject) {
      var storeInfo = wx.getStorageSync("storeInfo");
      var from_user_id = wx.getStorageSync("from_user_id");
      var api_access_token = wx.getStorageSync("api_access_token");

      if (flush == true || typeof storeInfo == "undefined" || storeInfo == "") {
        wx.request({
          url: that.baseData.apiUrl + 'store/get_store.html?access_token=' + api_access_token.token,
          data: {
            "store_uid": from_user_id
          },
          method: "POST",
          dataType: 'json',
          header: {
            'content-type': 'application/x-www-form-urlencoded'
          },
          success: function(res) {
            if (!res.data.error_code) {
              wx.setStorageSync("storeInfo", res.data.store);
              resolve(res.data.store);
            }
            wx.hideLoading();
          }
        })
      } else {
        wx.hideLoading();
        resolve(storeInfo);
      }
    })

  },
  /**系统基础post数据方法 params={uri,data:{},[callback]}*/
  apiPost: function(params) {
    var that = this;
    var api_access_token = wx.getStorageSync("api_access_token");
    var url = that.baseData.apiUrl + params.uri;
    if (typeof params.uri == "undefined" || params.uri == "") {
      console.log("请求地址错误请正确配置uri参数");
      return;
    }

    if (params.uri !== "base/get_access_token.html") {
      if (typeof api_access_token.token != "undefined") {
        url += "?access_token=" + api_access_token.token;
      }
    }
    wx.request({
      url: url,
      method: "POST",
      dataType: 'json',
      header: {
        'content-type': 'application/x-www-form-urlencoded'
      },
      data: params.data,
      complete: function(res) {
        if (typeof params.callback === "function") {
          if (res.data.error_code == 4000405) { //token过期
            wx.setStorageSync("api_access_token", "");
            wx.setStorageSync("user_data", "");
            that.initialize(function() {
              that.apiPost(params);
            });

          } else {
            params.callback(res.data);
          }
        }
      }
    })
  },
  addformId: function(postdata) {
    var that = this;
    that.apiPost({
      "uri": 'wechatformid/addformid.html',
      "data": postdata,
      "callback": function(res) {}
    })
  },




})