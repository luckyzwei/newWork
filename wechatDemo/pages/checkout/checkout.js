// 订单结算页
var App = getApp();
Page({
  data: {
    userAddress: {},
    showAddress: true,
    products: [],
    marketing: [],
    checkOut: {},
    coupons: [],
    useCoupon: {},
    showCashgift: false,
    remark: "",
    product_type: "O",
    use_integral:0,
    groupbuy: {},
  },
  onLoad: function(options) {
    var that = this;
    wx.showLoading({
      title: '正在计算',
    });
    var source_diy = options.source_diy;
    if (source_diy == undefined) {
      wx.setStorageSync('groupbuy_data', '');
      wx.setStorageSync('kill_product_id', '');
      that.checkout(0);
    } 
    var group_product_id = options.group_product_id;
    var kill_product_id = options.kill_product_id;
    if (group_product_id != undefined) {
      var groupbuy_data = {
        'group_product_id': group_product_id,
        'groupbuy_sn': options.groupbuy_sn,
        'product_number': options.product_number
      };
      wx.setStorageSync('groupbuy_data', groupbuy_data)
      that.checkout_group(groupbuy_data);
    } else if (kill_product_id != undefined){
      wx.setStorageSync('kill_product_id', kill_product_id);
      that.checkout_kill(kill_product_id);
    } else {
      var groupbuy_data = wx.getStorageSync('groupbuy_data');
      var kill_product_id = wx.getStorageSync('kill_product_id');
      if (groupbuy_data != '') {
        that.checkout_group(groupbuy_data);
      } else if (kill_product_id != ''){
        that.checkout_kill(kill_product_id);
      }else{
        that.checkout(0);
      }
    }


    that.getUserAddress();
  },

  /**获取用户的默认地址 */
  getUserAddress: function() {
    var that = this;
    App.apiPost({
      "uri": "address/get_address_info.html",
      "data": {},
      "callback": function(res) {
        if (!res.error_code) {
          that.setData({
            "userAddress": res.data
          });

        } else {
          that.setData({
            "showAddress": false
          })
        }

      }
    })
  },
  /**结算团购 */
  checkout_group: function(groupbuy_data) {
    var that = this;
    var address_id = that.data.userAddress.address_id;
    if (address_id == undefined) {
      address_id = 0;
    }
    groupbuy_data.address_id = address_id
    App.apiPost({
      "uri": "GroupProduct/check_group.html",
      "data": groupbuy_data,
      "callback": function(res) {
        if (res.data.products != false) {
          that.setData({
            "groupbuy": res.data.groupbuy == undefined ? '' : res.data.groupbuy,
            "products": res.data.products,
            "marketings": res.data.check_marketings,
            "useCoupon": res.data.coupon,
            "product_type": 'G',
            "checkOut": {
              "total_price": res.data.total_price,
              "coupon_discount": res.data.coupon_discount,
              "product_price": res.data.product_price,
              "show_total": res.data.total_price_text,
              "amount_price": res.data.total_amount,
              "shipping_fee": res.data.shipping_fee,
              "can_use_coupon_amount": res.data.cuca,
            }
          }, function() {
            wx.hideLoading();
          })
        }
      }
    });
  },
  /**结算砍价 */
  checkout_kill: function (kill_product_id) {
    var that = this;
    var address_id = that.data.userAddress.address_id;
    if (address_id == undefined) {
      address_id = 0;
    }
    App.apiPost({
      "uri": "KillProduct/check_kill.html",
      "data": {
        'kill_product_id': kill_product_id,
        'address_id': address_id
      },
      "callback": function (res) {
        if (res.data.products != false) {
          that.setData({
            "groupbuy": res.data.groupbuy == undefined ? '' : res.data.groupbuy,
            "products": res.data.products,
            "marketings": res.data.check_marketings,
            "useCoupon": res.data.coupon,
            "product_type": 'K',
            "checkOut": {
              "total_price": res.data.total_price,
              "coupon_discount": res.data.coupon_discount,
              "product_price": res.data.product_price,
              "show_total": res.data.total_price_text,
              "amount_price": res.data.total_amount,
              "shipping_fee": res.data.shipping_fee,
              "can_use_coupon_amount": res.data.cuca,
            }
          }, function () {
            wx.hideLoading();
          })
        }
      }
    });
  },
  /**结算商品*/
  checkout: function(coupon_id) {
    var that = this;
    var use_integral=that.data.use_integral;
    App.apiPost({
      "uri": "checkout/checkout_order.html",
      "data": {
        "coupon_id": coupon_id,
        "use_integral":use_integral
      },
      "callback": function(res) {
        if (res.data.products != false) {
          that.setData({
            "products": res.data.products,
            "marketings": res.data.check_marketings,
            "useCoupon": res.data.coupon,
            "product_type":'O',
            'can_use_integral': res.data.can_use_integral,
            "checkOut": {
              "total_price": res.data.total_price,
              "coupon_discount": res.data.coupon_discount,
              "product_price": res.data.product_price,
              "show_total": res.data.total_price_text,
              "amount_price": res.data.total_amount,
              "shipping_fee": res.data.shipping_fee,
              "can_use_coupon_amount": res.data.cuca,
              "is_exchange": res.data.is_exchange
            }

          }, function() {
            that.getValidCoupons();
          })
        } else {
          wx.switchTab({
            url: '',
          })
        }
      }
    });
  },

  getValidCoupons: function() {
    var that = this;
    var hasuseCouponid = 0;
    console.log(that.data.useCoupon);
    if (typeof that.data.useCoupon.coupon_id != "undefined") {
      hasuseCouponid = that.data.useCoupon.coupon_id;
    }
    App.apiPost({
      "uri": "checkout/get_valid_coupons.html",
      "data": {
        "total_price": that.data.checkOut.can_use_coupon_amount,
        "use_coupon": hasuseCouponid
      },
      "callback": function(res) {
        if (!res.error_code) {
          that.setData({
            "coupons": res.data
          });
        }
        wx.hideLoading();
      }
    });
  },
  /**使用优惠券 */
  useCoupon: function(e) {
    var that = this;
    var useCoupon = that.data.useCoupon;
    var coupon_id = e.currentTarget.dataset.coupon_id;
    if (useCoupon != null && coupon_id == useCoupon.coupon_id) {
      coupon_id = 0; //取消应用
    }
    that.setData({
      "showCashgift": false
    }, function() {
      that.checkout(coupon_id);
    })

  },
  /**创建订单 */
  createOrder: function() {
    var address_id = 0;
    var that = this;
    if (typeof that.data.userAddress.address_id != "undefined") {
      address_id = that.data.userAddress.address_id;
    }
    var hasuseCouponid = 0;
    if (that.data.useCoupon != null && that.data.useCoupon.coupon_id != null) {
      hasuseCouponid = that.data.useCoupon.coupon_id;
    }
    if (address_id == 0) {
      wx.showToast({
        "title": "请填写收货地址",
        "icon": "none"
      });
      return;
    }
    if (that.data.product_type == 'G') {
      var groupbuy_data = wx.getStorageSync('groupbuy_data');
      groupbuy_data.address_id = address_id;
      groupbuy_data.remark = that.data.remark;
      App.apiPost({
        "uri": "GroupProduct/create_group_order.html",
        "data": groupbuy_data,
        "callback": function(res) {
          if (!res.error_code) {
            console.log(res);
            that.getPayParams(res.data.order_id);
          }else{
            if (res.error_code == 1) {
              res.data = res.data+'  3秒跳转'
            }
            wx.showToast({
              "title": res.data,
              "icon": "none",
              "duration":5000,
              "success":function(){
                if (res.error_code == 1) {
                  setTimeout(function () {
                    wx.switchTab({
                      url: '/pages/salespromotion/salespromotion',
                    })
                  }, 4000)
                } else if(res.error_code == 3) {
                  setTimeout(function () {
                    wx.switchTab({
                      url: '/pages/personal/grouplist/grouplist',
                    })
                  }, 4000)
                }
              }
            });
          }
        }
      });
    } else if (that.data.product_type == 'K'){

      var kill_product_id = wx.getStorageSync('kill_product_id');
      App.apiPost({
        "uri": "KillProduct/create_kill_order.html",
        "data": {
          'kill_product_id': kill_product_id,
          'address_id': address_id,
          'remark': that.data.remark
        },
        "callback": function (res) {
          if (!res.error_code) {
            console.log(res);
            wx.redirectTo({
              url: '/pages/personal/bargaindetail/bargaindetail?order_id=' + res.data.order_id + '&kill_product_id=' + kill_product_id,
            })
            
          } else {
            if (res.error_code == 1) {
              res.data = res.data + '  3秒跳转'
            }
            wx.showToast({
              "title": res.data,
              "icon": "none",
              "duration": 5000,
              "success": function () {
                if (res.error_code == 1) {
                  setTimeout(function () {
                    wx.switchTab({
                      url: '/pages/salespromotion/salespromotion',
                    })
                  }, 4000)
                } else if (res.error_code == 3) {
                  setTimeout(function () {
                    wx.switchTab({
                      url: '/pages/personal/grouplist/grouplist',
                    })
                  }, 4000)
                }
              }
            });
          }
        }
      });
    }else {
      
      App.apiPost({
        "uri": "checkout/create_order.html",
        "data": {
          "address_id": address_id,
          "coupon_id": hasuseCouponid,
          "use_integral": that.data.use_integral,
          "remark": that.data.remark
        },
        "callback": function(res) {
          if (!res.error_code) {
            console.log(res);
            that.getPayParams(res.data.order_id);
          }else{
            wx.showToast({
              "title": res.data,
              "icon": "none"
            });
          }
        }
      });
    }

  },
  //修改收货地址
  selectadddress: function() {
    wx.redirectTo({
      url: '/pages/personal/addressList/addressList?ref=checkout',
    })
  },
  //新增收货地址
  addaddress: function() {
    wx.redirectTo({
      url: '/pages/personal/addressList/addressList?ref=checkout',
    })
  },
  /**支付订单 */
  remark: function(e) {
    this.setData({
      "remark": e.detail.value
    })
  },
  //显示可用优惠券
  showCashgift: function() {
    this.setData({
      showCashgift: !this.data.showCashgift
    })
  },
  /**获取订单信息和支付参数 */
  getPayParams: function(orderId) {
    var that = this;
    App.apiPost({
      'uri': 'checkout/order_pay.html',
      'data': {
        'order_id': orderId,
      },
      'callback': function(res) {
        if (!res.error_code) {

          that.setData({
            "orderInfo": res.data.orderInfo,
            "payParams": res.data.payParams
          }, function() {
            that.pay();
          });

        }else{
          wx.showToast({
            "title": res.data,
            "icon": "none"
          });
        }
      }
    })
  },
  // 微信支付
  wxPay: function() {
    var that = this;
    that.createOrder();
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
          if (!res.error_code) {
            wx.showToast({
              "title": "支付成功",
              "icon": "success",
              success: function() {
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
        'success': function(res) {},
        'fail': function(res) {},
        'complete': function(res) {
          wx.switchTab({
            url: '/pages/my/my',
          })
        }
      })
    }
  },
  /**积分兑换选中按钮 */
  changeBox: function(e) {
    var that=this;
    var value = !e.detail.value.use_integral;
    that.setData({
      use_integral: value
    },function(){
      that.onLoad({});
    })
    
  }
})