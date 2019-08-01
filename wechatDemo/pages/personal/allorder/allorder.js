//商品订单状态列表页
var App = getApp();
Page({
  data: {
    orderlist: [],
    status: 0,
    page: 1,
    showTransport: false,
    express: []
  },
  onLoad: function(options) {
    var that = this;
    if (options.status == 0) {
      var title = "待付款"
    } else if (options.status == 2) {
      var title = "待收货"
    } else if (options.status == 1) {
      var title = "待发货"
    } else if (options.status ==5) {
      var title = "评价"
    } else {
      var title = "全部订单"
    }
    wx.setNavigationBarTitle({
      title: title
    })

    that.setData({
      "status": options.status,
    })
    that.get_orders();
  },

  /**下拉刷新 */
  onPullDownRefresh: function() {
    var that = this;
    that.setData({
      "page": 1
    }, function() {
      that.get_orders();
    })
    wx.stopPullDownRefresh();
  },

  /**获取订单 */

  get_orders: function() {
    wx.showLoading({
      title: '努力加载中……'
    });
    var that = this;
    App.apiPost({
      "uri": 'order/get_orders.html',
      "data": {
        status: that.data.status,
        page: that.data.page,
      },
      "callback": function(res) {
        if (!res.error_code) {
          var nextpage = that.data.page + 1;
          that.setData({
            "page": nextpage
          });
          if (nextpage == 2) {
            var orderlist = res.data;
          } else {
            var orderlist = that.data.orderlist.concat(res.data);
          }
          that.setData({
            "orderlist": orderlist,
            "empty": false,
          });

        } else {
          that.setData({
            "empty": true,
          });
        }
        wx.hideLoading();
      }
    })
  },
  onReachBottom: function() {
    if (!this.data.empty) {
      this.get_orders();
    }
  },
  //支付订单
  payorder: function(e) {
    var order_id = e.currentTarget.dataset.order_id;
    wx.navigateTo({
      url: '/pages/orderdetail/orderdetail?order_id=' + order_id,
    })
  },
  //物流信息弹出
  showTransport: function(e) {
    var that = this;
    var currentStatu = e.currentTarget.dataset.statu;
    if (currentStatu == "open") {
      wx.showLoading({
        title: '正在同步物流信息',
      })
      that.get_express(e.currentTarget.dataset.order_id);
    } else {
      that.setData({
        showTransport: false,
      })
    }
  },
  //获取物流信息
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
  //退货
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
                        orderlist: []
                      })
                      that.get_orders();
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
            orderlist: [],
          })
          that.get_orders();
        } else if (res.error_code == 3) {
          wx.showToast({
            title: '未获取到物流信息',
            icon: "none"
          })
        }
      }
    })
  },
  //去评价
  comment: function(e) {
    wx.redirectTo({
      url: '/pages/personal/goods_reviews/goods_reviews?order_id=' + e.currentTarget.dataset.order_id,
    })
  },
  goDetail: function (e) {
    var order_id = e.currentTarget.dataset.order_id;
    wx.navigateTo({
      url: '/pages/orderdetail/orderdetail?order_id=' + order_id,
    })
  },
  refundCancel: function (e){
    var that = this;
    wx.showModal({
      title: '提示',
      content: '取消退款?',
      showCancel: true,
      success: function (res) {
        if (res.confirm) {
          if (e.currentTarget.dataset.order_id) {
            App.apiPost({
              "uri": 'order/refundCancel.html',
              "data": {
                order_id: e.currentTarget.dataset.order_id
              },
              "callback": function (res) {
                if (!res.error_code) {
                  wx.showToast({
                    title: '退款已取消',
                    icon: 'success',
                    success: function (e) {
                      that.setData({
                        page: 1,
                        orderlist: []
                      })
                      that.get_orders();
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
      fail: function (res) { },
      complete: function (res) { },
    })
  }
})