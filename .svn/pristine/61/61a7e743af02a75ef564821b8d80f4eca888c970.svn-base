var App = getApp();
Page({
  data: {
    userInfo: '',
    storeInfo: '',
    money: 0,
    paymoneyinfo: "",
    payParams: "",
    paySuccess: false
  },
  onLoad: function(options) {
    var that = this;
    wx.setStorageSync("storeInfo", "");
    wx.setStorageSync("user_data", "");
    App.initialize(function() {
      that.setData({
        "userInfo": wx.getStorageSync("user_data"),
        "storeInfo": wx.getStorageSync("storeInfo"),
      });
    });
  },
  setmoney: function(e) {
    if (0 >= e.detail.value) {
      wx.showToast({
        title: '输入金额错误',
        icon: 'none'
      })
    }
    this.setData({
      "money": e.detail.value
    })
  },
  showSuccess: function() {
    var that = this;
    if (0 >= that.data.money) {
      wx.showToast({
        title: '输入金额错误',
        icon: 'none'
      })
      return;
    }
    App.apiPost({
      'uri': 'recharge/qrrecharge.html',
      'data': {
        'money': that.data.money,
      },
      'callback': function(res) {
        if (!res.error_code) {
          that.setData({
            "paymoneyinfo": res.paymoneyinfo,
            "payParams": res.data
          });
          that.wxPay();
        } else if (res.error_code == 1) {
          that.setData({
            "paymoneyinfo": res.data,
            "paySuccess": true
          });
        } else {
          wx.showToast({
            title: '支付失败，请重试',
            icon: 'none'
          })
        }
      }
    })

  },
  finished: function() {
    this.setData({
      paySuccess: false
    })
    wx.switchTab({
      url: '/pages/store/store',
    })
  },

  wxPay: function() {
    var that = this;
    var payParams = that.data.payParams;
    App.addformId({
      formid: that.data.payParams.package,
      source_field: 'sub_pay'
    });
    wx.requestPayment({
      'timeStamp': that.data.payParams.timeStamp,
      'nonceStr': that.data.payParams.nonceStr,
      'package': that.data.payParams.package,
      'signType': 'MD5',
      'paySign': that.data.payParams.paySign,
      'success': function(res) {
        if (res.errMsg == "requestPayment:ok"){
          that.setData({
            "paySuccess": true
          });
        }
      },
      'fail': function(res) {
        console.log(res);
        wx.showToast({
          title: '支付失败，请重试',
          icon: 'none'
        })
      },
      'complete': function(res) {
        console.log(res);
      }
    })
  }
})