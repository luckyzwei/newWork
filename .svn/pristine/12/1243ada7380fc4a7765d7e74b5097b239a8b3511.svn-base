const App = getApp()
// 砍价列表.js
Page({
  data: {
    killlist: [],
    showTransport: false,
    status: 0,
    express: [],
    page: 1
  },
  onLoad: function(options) {
    var that = this
    that.get_killorders();
  },
  onReady: function() {},
  onShow: function() {},

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function() {},
  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function() {
    this.get_killorders();
  },
  get_killorders: function() {
    wx.showLoading({
      title: '努力加载中……'
    });
    var that = this;
    App.apiPost({
      "uri": 'KillProduct/get_killorders.html',
      "data": {
        page: that.data.page,
      },
      "callback": function(res) {
        if (res.data.length > 0) {
          var nextpage = that.data.page + 1;
          that.setData({
            "page": nextpage
          });
          if (nextpage == 2) {
            var killlist = res.data;
          } else {
            var killlist = that.data.killlist.concat(res.data);
          }
          that.setData({
            "killlist": killlist,
          });
        } else {
          that.setData({
            "empty": true
          });
          wx.showToast({
            title: '全部加载完毕',
            icon: "none"
          })
        }
        wx.hideLoading();
      }
    })
  },
  payorder: function(e) {
    wx.showLoading({
      title: '支付请求。。'
    });
    var that = this;
    App.apiPost({
      'uri': 'checkout/order_pay.html',
      'data': {
        'order_id': e.currentTarget.dataset.order_id,
      },
      'callback': function(res) {
        if (!res.error_code) {

          that.setData({
            "orderInfo": res.data.orderInfo,
            "payParams": res.data.payParams
          }, function() {
            that.pay();
          });

        }
      }
    })
  },
  pay: function() {
    var that = this;
    var payParams = that.data.payParams;
    if (typeof payParams.notify_url != "undefined") {
      App.apiPost({
        'uri': payParams.notify_url,
        'data': {
          'order_id': that.data.orderInfo.order_id,
        },
        'callback': function(res) {
          wx.hideLoading();
          if (!res.error_code) {
            wx.showToast({
              "title": "支付成功",
              "icon": "success",
              success: function() {
                wx.showLoading({
                  title: '刷新。。'
                });
                that.setData({
                  page: 1,
                  killlist: []
                })
                that.get_killorders();
              }
            })
          }
        }
      })
    } else {
      App.addformId({
        formid: that.data.payParams.package,
        source_field: 'sub_pay'
      });
      wx.hideLoading();
      wx.requestPayment({
        'timeStamp': that.data.payParams.timeStamp,
        'nonceStr': that.data.payParams.nonceStr,
        'package': that.data.payParams.package,
        'signType': 'MD5',
        'paySign': that.data.payParams.paySign,
        'success': function(res) {},
        'fail': function(res) {},
        'complete': function(res) {
          wx.showLoading({
            title: '刷新。。'
          });
          that.setData({
            page: 1,
            killlist: []
          })
          that.get_killorders();
        }
      })
    }
  },
  /**物流信息弹出*/
  showTransport: function(e) {
    var that = this;
    var currentStatu = e.currentTarget.dataset.statu;
    if (currentStatu == "open") {
      wx.showLoading({
        title: '正在同步物流信息',
      })
      // that.get_express(e.currentTarget.dataset.order_id);
    } else {
      that.setData({
        showTransport: false,
      })
    }
  },
  /** 获取物流信息*/
  get_express: function(order_id) {
    var that = this;
    if (!that.data.order_id) {
      App.apiPost({
        "uri": 'order/get_express.html',
        "data": {
          order_id: order_id,
        },
        "callback": function(res) {
          wx.hideLoading()
          console.log(res);
          if (!res.error_code) {
            that.setData({
              showTransport: true,
              express: res.data
            })
          } else if (res.error_code == 3) {
            wx.showToast({
              title: '未获取到物流信息',
              icon: "none"
            })
          }
        }
      })
    }
  },
  /**退货*/
  refundorder: function(e) {
    var that = this;
    wx.showModal({
      title: '提示',
      content: '是否确认退货?',
      showCancel: true,
      success: function(res) {
        if (res.confirm) {
          if (e.currentTarget.dataset.order_id) {
            App.apiPost({
              "uri": 'order/refundorder.html',
              "data": {
                order_id: e.currentTarget.dataset.order_id
              },
              "callback": function(res) {
                if (!res.error_code) {
                  wx.showToast({
                    title: '退货申请已提交',
                    icon: 'success',
                    success: function(e) {
                      that.setData({
                        page: 1,
                        killlist: []
                      })
                      that.get_killorders();
                    }
                  })
                }
              }
            })
          }
        } else {
          console.log("用户点击取消");
        }
      },
      fail: function(res) {},
      complete: function(res) {},
    })
  },
  /**确认收货 提示 */
  clickreceipt: function(e) {
    var that = this;
    wx.showModal({
      title: '提示',
      content: '是否确认收货?',
      showCancel: true,
      success: function(res) {
        if (res.confirm) {
          that.receipt(e.currentTarget.dataset.order_id);
        } else {
          console.log("用户点击取消");
        }
      },
      fail: function(res) {},
      complete: function(res) {},
    })
  },
  /**确认收货 */
  receipt: function(order_id) {
    var that = this;
    App.apiPost({
      "uri": 'order/receipt.html',
      "data": {
        order_id: order_id,
      },
      "callback": function(res) {
        console.log(res);
        if (!res.error_code) {
          wx.showToast({
            title: '确认收货',
            icon: "success"
          })
          that.setData({
            page: 1,
            killlist: [],
          })
          that.get_killorders();
        } else if (res.error_code == 3) {
          wx.showToast({
            title: '未获取到物流信息',
            icon: "none"
          })
        }
      }
    })
  },
  /**去评价*/
  comment: function(e) {
    wx.redirectTo({
      url: '/pages/personal/goods_reviews/goods_reviews?order_id=' + e.currentTarget.dataset.order_id,
    })
  },
  /**砍价商品详情 */
  goDetail: function(e) {
    var kill_product_id = e.currentTarget.dataset.kill_product_id;
    wx.navigateTo({
      url: '/pages/bargain_detail/bargain_detail?kill_product_id=' + kill_product_id,
    })
  },
  /**取消退款 */
  refundCancel: function(e) {
    var that = this;
    wx.showModal({
      title: '提示',
      content: '取消退款?',
      showCancel: true,
      success: function(res) {
        if (res.confirm) {
          if (e.currentTarget.dataset.order_id) {
            App.apiPost({
              "uri": 'order/refundCancel.html',
              "data": {
                order_id: e.currentTarget.dataset.order_id
              },
              "callback": function(res) {
                if (!res.error_code) {
                  wx.showToast({
                    title: '退款已取消',
                    icon: 'success',
                    success: function(e) {
                      that.setData({
                        page: 1,
                        killlist: []
                      })
                      that.get_killorders();
                    }
                  })
                }
              }
            })
          }
        } else {
          console.log("用户点击取消");
        }
      },
      fail: function(res) {},
      complete: function(res) {},
    })
  },
  /**到砍价进度页继续砍价 */
  goOn: function(e) {
    console.log(e);
    wx.navigateTo({
      url: '/pages/personal/bargaindetail/bargaindetail?order_id=' + e.currentTarget.dataset.order_id,
    })
  }
})