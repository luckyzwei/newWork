// pages/index/index.js
const App = getApp()
Page({
  data: {
    num: 1, //初始值
    userInfo: {},
    cartProducts: [],
    totalPrice: 0,
    empty: false,
    minusStatus: 'disabled', //禁用减号
    order_marketing: [],
    onFocus: false, //textarea焦点是否选中
    isShowInput: true,
    isShowText: false, //控制显示 input 还是 text
  },

  onShow: function() {
    var that = this;
    that.setData({
      "userInfo": wx.getStorageSync("user_data")
    });
    that.getCartProducts();

  },
  /**下拉刷新 */
  onPullDownRefresh: function() {
    var that = this;
    that.onShow();
    wx.stopPullDownRefresh();
  },

  /**获取购物车商品 */
  getCartProducts: function() {
    var that = this;
    wx.showLoading({
      title: '加载中……',
    });
    App.apiPost({
      'uri': 'cart/get_cart_products.html',
      'data': {},
      'callback': function(res) {
        if (!res.error_code) {
          var products = res.data.products;
          var marketings = res.data.order_marketing;
          that.setData({
            "cartProducts": products,
            "order_marketing": marketings,
            "totalPrice": res.data.total_price,
            "amount": res.data.total_amount,
            "discount": res.data.discount,
            "showTotal": res.data.total_amount_text,
          });
        } else {
          that.setData({
            "totalPrice": 0,
            "amount": 0,
            "showTotal": "",
            "discount": 0,
            "cartProducts": [],
            "order_marketing": []
          });
        }
        App.checkCartNum();
        wx.hideLoading();
      }
    })
  },

  /**改变购物车商品数量 */
  changeCartNumber: function(index, cart_id, num) {
    var that = this;
    App.apiPost({
      'uri': 'cart/set_cart_product_num.html',
      'data': {
        'cart_id': cart_id,
        "product_number": num
      },
      'callback': function(res) {
        if (!res.error_code) {
          that.getCartProducts();
        } else {
          console.log(res);
        }
      }
    })

  },
  /**结算按钮 */
  checkout: function() {
    var that = this;
    var products = that.data.cartProducts;
    var cart_ids = [];
    for (var i = 0; i < products.length; i++) {
      if (products[i].checkout == "1") {
        cart_ids.push(products[i].cart_id);
      }
    }
    if (cart_ids.length == 0) {
      wx.showToast({
        title: '请选择要结算的商品',
        icon: "none"
      })
    } else {
      wx.navigateTo({
        url: '/pages/checkout/checkout',
      });
    }

  },
  /**删除商品 */
  deleteCartProduct: function(e) {
    var that = this;
    var products = that.data.cartProducts;
    var cart_ids = [];
    for (var i = 0; i < products.length; i++) {
      if (products[i].checkout == "1") {
        cart_ids.push(products[i].cart_id);
      }
    }
    var cart_str = cart_ids.join(',');
    wx.showModal({
      title: '是否要删除所选商品?',
      showCancel: true,
      cancelText: '取消',
      confirmText: '确定',
      confirmColor: '#ef2d23',
      success: function(res) {
        if (res.confirm) {
          //点击取消,默认隐藏弹框

          App.apiPost({
            'uri': 'cart/delect_cart.html',
            'data': {
              'cart_ids': cart_str
            },
            'callback': function(res) {
              if (!res.error_code) {
                that.getCartProducts();
              } else {
                console.log(res);
              }
            }
          })
        }
      },
      fail: function(res) {},
      complete: function(res) {},
    })
    // this.changeCartNumber(cart_ids, 0);
  },

  /* 点击减号 */
  bindMinus: function(e) {
    var that = this;
    var index = e.currentTarget.dataset.index;
    var num = parseInt(e.currentTarget.dataset.buy_num);
    var cart_id = e.currentTarget.dataset.cart_id;
    // 如果大于1，可以减
    if (num > 1) {
      num--;
    }
    // 只有大于1的时候，才能normal状态进行减法，否则disable状态
    var minusStatus = num <= 1 ? 'disabled' : 'normal';
    // 将数值与状态写回
    this.setData({
      num: num,
      minusStatus: minusStatus
    });
    that.changeCartNumber(index, cart_id, num);

  },
  /* 点击加号*/
  bindPlus: function(e) {
    var that = this;
    var index = e.currentTarget.dataset.index;
    var num = parseInt(e.currentTarget.dataset.buy_num);
    var cart_id = e.currentTarget.dataset.cart_id;
    // 不作过多考虑自增1
    num++;
    // 小于1,为disable状态
    var minusStatus = num < 1 ? 'disabled' : 'normal';
    // 将数值与状态写回
    this.setData({
      num: num,
      minusStatus: minusStatus
    });
    that.changeCartNumber(index, cart_id, num);
  },
  /* 输入框事件 */
  bindManual: function(e) {
    var that = this;
    var index = e.currentTarget.dataset.index;
    var num = e.detail.value;
    var value = e.detail.value;
    if (isNaN(num)) {
      num = 1;
    }
    var cart_id = e.currentTarget.dataset.cart_id;
    that.changeCartNumber(index, cart_id, num);
    that.setData({
      remark: value,
    });
  },


  /**设置购物车商品结算状态 */
  setCartProductChkStatus: function(e) {
    var cart_id;
    var that = this;
    var cart_id = e.currentTarget.dataset.cart_id;
    var chkstatus = 0;
    if (e.detail.value[0] == cart_id) {
      chkstatus = 1;
    }
    App.apiPost({
      'uri': 'cart/set_cart_check_status.html',
      'data': {
        'cart_id': cart_id,
        "chk_status": chkstatus
      },
      'callback': function(res) {
        if (!res.error_code) {
          that.getCartProducts();
        } else {
          console.log(res);
        }
      }
    })

  },
  goHome: function() {
    wx.switchTab({
      url: '/pages/index/index',
    })
  },
  onShowTextare() { //显示textarea
    this.setData({
      isShowText: false,
      isShowInput: true,
      onFacus: true
    })
  },
  onShowText() { //显示text
    this.setData({
      isShowText: true,
      isShowInput: false,
      onFacus: false
    })
  },

})