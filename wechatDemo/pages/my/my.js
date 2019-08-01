const App = getApp()
Page({
  data: {
    curIndex: 0,
    userInfo: {},
    userAccount: {},
    countInfo: {},
    orderStatus: {},
    showModal: false,
    sign: 0, //0未签到 1 已签到
  },

  onShow: function() {
    var that = this;
    wx.hideShareMenu();

    wx.clearStorageSync(); //初始化的时候先清除本地缓存
    App.initialize(function(res) {
      that.setData({
        "userInfo": res.userInfo,
        "sign": res.userInfo.is_sign
      }, function() {
        App.checkCartNum();
        that.checkOrderByStatus();
        that.getUserCenterData();
      })

    });
  },

  getUserCenterData: function() {
    var that = this;
    App.apiPost({
      "uri": "user/user_center_data.html",
      "data": {},
      "callback": function(res) {
        that.setData({
          "userAccount": res.data
        })
      }
    })
  },

  /**用户订单统计 */
  checkOrderByStatus: function() {
    var that = this;
    App.apiPost({
      "uri": "order/check_order_bystatus.html",
      "data": {},
      "callback": function(res) {
        that.setData({
          "orderStatus": res.data
        })
      }
    })
  },


  /**下拉刷新 */
  onPullDownRefresh: function() {
    var that = this;
    that.onShow();
    wx.stopPullDownRefresh();
  },
  /**顶部tab */
  bindTap: function(e) {
    const index = parseInt(e.currentTarget.dataset.index);
    this.setData({
      curIndex: index
    })
  },

  /**授权获取用户信息 */
  authorize: function(e) {
    var that = this;
    console.log(e);
    if (e.detail.errMsg == "getUserInfo:ok") {
      var userdata = wx.getStorageSync("user_data");
      var wx_user_info = e.detail.userInfo;
      //更新用户信息
      App.apiPost({
        'uri': 'user/update_user_info.html',
        'data': wx_user_info,
        'callback': function(res) {
          wx.setStorage({
            key: "user_data",
            data: "",
            success: function() {
              App.userLogin().then(function(res) {
                that.setData({
                  "userInfo": res,
                });
              });
            }
          });
          that.setData({
            showModal: true,
          })
        }
      });
    } else {
      wx.showToast({
        title: '请授权应用',
        icon: 'none',
        duration: 3000
      })
    }
  },
  /**跳转订单状态页 */
  orderStatus: function(e) {
    var that = this
    var status = e.currentTarget.dataset.status;
    wx.navigateTo({
      url: '/pages/personal/allorder/allorder?status=' + status,
    })
  },
  /**获取微信绑定手机号事件 */
  getPhoneNumber: function(e) {
    var that = this
    console.log(e)
    if (e.detail.errMsg == "getPhoneNumber:ok") {
      var endata = e.detail.encryptedData;
      var iv = e.detail.iv;
      App.apiPost({
        'uri': 'user/bind_phone.html',
        'data': {
          "endata": endata,
          "iv": iv
        },
        'callback': function(res) {

          that.onShow();
        }
      });
    }

  },
  /**显示绑定手机号弹窗 */
  showGetPhone: function(e) {
    var that = this;
    var shows = e.currentTarget.dataset.show;
    if (shows == "open") {
      that.setData({
        showModal: true,
      })
    } else {
      that.setData({
        showModal: false,
      })
    }
  },
  /**签到 */
  signIn: function(e) {
    // var signDate=
    var that = this;
    if (that.data.sign == 1) {
      wx.showToast({
        title: '您已签到过明天再来吧~',
        duration: 1500,
        mask: true,
        icon: "none",
      })
    } else {
      App.apiPost({
        'uri': "user/up_intergal",
        'data': {
          "change_type": 1,
          "change_intergal": 5,
          "remark": "签到送5积分"
        },
        'callback': function(res) {
          if (!res.error_code) {
            wx.showToast({
              title: '本次签到成功,获得5积分',
              duration: 2500,
              mask: true,
              icon: "none",
              success: function() {
                // var sign = 1;
                // that.setData({
                //   sign: sign
                // })
                that.onShow();
              },
              fail: function() {},
              complete: function() {
                // wx.hideToast()
              }
            })
          }
        }
      });
    }

  },
  /**等级升级 */
  upGrade: function() {
    var that = this;
    wx.showModal({
      title: '是否消耗' + that.data.userInfo.level_up.up_level.integral + '升级会员',
      content: '',
      success(res) {
        if (res.confirm) {
          App.apiPost({
            'uri': "user/up_grade",
            'data': {
              "group_id": that.data.userInfo.level_up.up_level.user_group_id,
            },
            'callback': function(res) {
              if (!res.error_code) {
                wx.showToast({
                  title: '已升级',
                  duration: 2500,
                  mask: true,
                  icon: "none",
                  success: function() {
                    // var sign = 1;
                    // that.setData({
                    //   sign: sign
                    // })
                    that.onShow();
                  },
                  fail: function() {},
                  complete: function() {
                    // wx.hideToast()
                  }
                })
              }
            }
          });
        } else if (res.cancel) {
          console.log('用户点击取消')
        }
      }
    })

  },
  /**跳转到积分规则页面 */
  goIntegralRule: function() {
    wx.navigateTo({
      url: '/pages/personal/integralrule/integralrule',
    })
  },
  /**跳转到分销规则页面 */
  goSaleRule: function() {
    wx.navigateTo({
      url: '/pages/personal/salerule/salerule',
    })
  }
})