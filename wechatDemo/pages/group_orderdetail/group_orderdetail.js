// 拼团订单详情
var App = getApp();
Page({
  data: {
    showTransport: false,
    order_id: 0,
    showTuanInfo:false

  },
  onLoad: function (options) {
    var that = this;
    if (options.order_id) {
      that.getorderinfo(options.order_id);
      that.setData({
        order_id: options.order_id
      })
    }
  },
  onReady: function () { },
  onShow: function () { },
  //获取订单详情
  getorderinfo(order_id) {
    var that = this;
    App.apiPost({
      "uri": 'order/get_order_info.html',
      "data": {
        order_id: order_id
      },
      "callback": function (res) {
        if (!res.error_code) {
          that.setData({
            coupon: res.data.coupon,
            marketing: res.data.marketing,
            order_product: res.data.order_product,
            orderinfo: res.data.orderinfo
          })
        }
      }
    })
  },
  //取消订单
  deleteOrder: function () {
    var that = this;
    wx.showModal({
      title: '提示',
      content: '是否取消订单?',
      showCancel: true,
      success: function (res) {
        if (res.confirm) {
          App.apiPost({
            "uri": 'order/delete_order.html',
            "data": {
              order_id: that.data.order_id
            },
            "callback": function (res) {
              if (!res.error_code) {
                wx.showToast({
                  title: '订单已删除',
                  icon: 'success',
                  success: function (e) {
                    wx.redirectTo({
                      url: '/pages/personal/allorder/allorder?status=0',
                    })
                  }
                })
              }
            }
          })
        } else {
          console.log("用户点击取消");
        }
      },
      fail: function (res) { },
      complete: function (res) { },
    })

  },
  //支付订单
  payorder: function (e) {
    var that = this;
    wx.navigateTo({
      url: '/pages/pay/pay?order_id=' + that.data.order_id,
    })
  },
  //退货
  refundorder: function (e) {
    var that = this;
    App.apiPost({
      "uri": 'order/refundorder.html',
      "data": {
        order_id: that.data.order_id
      },
      "callback": function (res) {
        if (!res.error_code) {
          wx.showToast({
            title: '退货申请已提交',
            icon: 'success',
            success: function (e) {
              that.getorderinfo(that.data.order_id);
            }
          })
        }
      }
    })
  },
  //退货
  refundCancel: function (e) {
    var that = this;
    App.apiPost({
      "uri": 'order/refundCancel.html',
      "data": {
        order_id: that.data.order_id
      },
      "callback": function (res) {
        if (!res.error_code) {
          wx.showToast({
            title: '已取消退款',
            icon: 'success',
            success: function (e) {
              that.getorderinfo(that.data.order_id);
            }
          })
        }
      }
    })
  },

  //物流信息弹出
  showTransport: function (e) {
    var that = this;
    var currentStatu = e.currentTarget.dataset.statu;
    if (currentStatu == "open") {
      that.get_express(that.data.order_id);
    } else {
      that.setData({
        showTransport: false,
      })
    }
  },
  //获取物流信息
  get_express: function (order_id) {
    var that = this;
    if (that.data.order_id) {
      App.apiPost({
        "uri": 'order/get_express.html',
        "data": {
          order_id: order_id,
        },
        "callback": function (res) {
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
  clickreceipt: function (e) {
    var that = this;
    wx.showModal({
      title: '提示',
      content: '是否确认收货?',
      showCancel: true,
      success: function (res) {
        if (res.confirm) {
          that.receipt(that.data.order_id);
        } else {
          console.log("用户点击取消");
        }
      },
      fail: function (res) { },
      complete: function (res) { },
    })
  },
  receipt: function (order_id) {
    var that = this;

    App.apiPost({
      "uri": 'order/receipt.html',
      "data": {
        order_id: order_id,
      },
      "callback": function (res) {
        console.log(res);
        if (!res.error_code) {
          wx.showToast({
            title: '确认收货',
            icon: "success"
          })
          that.getorderinfo(that.data.order_id);
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
  comment: function (e) {
    var that = this;
    wx.redirectTo({
      url: '/pages/goods/goods_reviews/goods_reviews?order_id=' + that.data.order_id,
    })
  },
  /**获取订单信息和支付参数 */
  getPayParams: function (e) {
    var that = this;
    App.apiPost({
      'uri': 'checkout/order_pay.html',
      'data': {
        'order_id': e.currentTarget.dataset.order,
      },
      'callback': function (res) {
        if (!res.error_code) {

          that.setData({
            "orderInfo": res.data.orderInfo,
            "payParams": res.data.payParams
          }, function () {
            that.pay();
          });

        }
      }
    })
  },
  pay: function () {
    var that = this;
    var payParams = that.data.payParams;
    if (typeof payParams.notify_url != "undefined") {
      App.apiPost({
        'uri': payParams.notify_url,
        'data': {
          'order_id': that.data.orderInfo.order_id,
        },
        'callback': function (res) {
          if (!res.error_code) {
            wx.showToast({
              "title": "支付成功",
              "icon": "success",
              success: function () {
                wx.switchTab({
                  url: '/pages/my/my',
                })
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
      wx.requestPayment({
        'timeStamp': that.data.payParams.timeStamp,
        'nonceStr': that.data.payParams.nonceStr,
        'package': that.data.payParams.package,
        'signType': 'MD5',
        'paySign': that.data.payParams.paySign,
        'success': function (res) { },
        'fail': function (res) { },
        'complete': function (res) {
          wx.switchTab({
            url: '/pages/my/my',
          })
        }
      })
    }
  },
  goodsDetail: function (e) {
    wx.navigateTo({
      url: '/pages/goodsdetail/goodsdetail?product_id=' + e.currentTarget.dataset.product,
    })
  },
  /**显示团成员信息弹窗 */
  showTuanInfo:function(){
    var that=this
    that.setData({
      showTuanInfo:true
    })

  },
  /**关闭 */
  closeModal:function(){
    var that = this
    that.setData({
      showTuanInfo: false
    })
  }
})