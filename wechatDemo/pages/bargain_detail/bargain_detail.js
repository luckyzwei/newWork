//拼团商品详情
const App = getApp()
Page({
  data: {
    userInfo: {},
    storeInfo: {},
    choose_modal: "none", //弹出层的初始状态是隐藏
    num: 1, //初始数量
    minusStatus: 'disabled', //禁用减号
    killproduct: {},
    default_special_price: 0,
    cartProductNum: 0,
    curIndex: 0,
    kill_product_id: '',
    reviews: {},
    commentPage: 1,
    buy_button: '',
    star: [0, 1, 2, 3, 4],
    times: 0,
    h: '',
    day: '',
    m: '',
    limitWarning: "距离结束仅剩",
    kill_order: true

  },
  onShow: function() {},

  onLoad: function(options) {
    var that = this;
    var kill_product_id = options.kill_product_id;
    that.setData({
      kill_product_id: kill_product_id
    })
    App.initialize(function() {
      that.setData({
        "storeInfo": wx.getStorageSync("storeInfo"),
        "userInfo": wx.getStorageSync("user_data")
      }, function() {
        that.get_killproduct();
        wx.hideShareMenu();
      });
    });
  },
  /**跳转到促销专区 */
  goMore: function(e) {
    var that = this
    wx.switchTab({
      url: '/pages/salespromotion/salespromotion',
    })
  },
  /**砍价进度详情页 */
  goBargainDetail: function() {
    var that = this;
    var times = that.data.times;
    if (times > 0) {
      wx.navigateTo({
        url: '/pages/checkout/checkout?kill_product_id=' + that.data.kill_product_id +
          '&source_diy=killproduct',
      })
    } else {
      that.goMore();
    }
  },
  cancel_kill_order: function() {
    this.setData({
      kill_order: true
    })
  },
  confirm_kill_order: function(e) {
    var that = this;
    wx.navigateTo({
      url: '/pages/personal/bargaindetail/bargaindetail?order_id=' + that.data.killproduct.order_id,
    })
  },
  /**获取当前商品信息 */
  get_killproduct: function() {
    var that = this;
    wx.showLoading({
      title: '努力加载中……',
      mask: true,
      success: function(res) {
        App.apiPost({
          "uri": 'KillProduct/get_killproduct.html',
          "data": {
            kill_product_id: that.data.kill_product_id,
          },
          "callback": function(res) {
            if (!res.error_code) {
              /** 清除详情图片上下之间空隙 */
              res.data.description = res.data.description.replace(/style="width:.+?100%;"/gi, ' style="width:100%;display:block;" ')
              var kill_order = true;
              if (res.data.order_id > 0) {
                kill_order = false;
              }
              that.setData({
                "kill_order": kill_order,
                "killproduct": res.data,
                "times": res.data.kill_product_endtime
              }, function() {});
              that.countdown(res.data.kill_product_endtime);
              wx.hideLoading();
            }
          }
        })
      },

    })
  },

  /**切换详情 评论列表 */
  changeTap: function(e) {
    var that = this;
    var index = e.currentTarget.dataset.index;
    that.setData({
      curIndex: index
    })
    if (index == 1) {
      that.getComment();
    }
  },
  getComment: function() {
    var that = this;
    wx.showLoading({
      title: '努力加载中……',
      mask: true,
      success: function(res) {
        App.apiPost({
          "uri": 'ProductComment/get_product_comments.html',
          "data": {
            product_id: that.data.killproduct.product_id,
            store_id: that.data.storeInfo.store_id,
            page: that.data.commentPage
          },
          "callback": function(res) {
            if (!res.error_code) {
              that.setData({
                "reviews": res.data,
              });
              wx.hideLoading();
            }
          }
        })
      },

    })
  },

  /* 毫秒级秒杀倒计时 */
  countdown: function(times) {
    var that = this;
    var day = Math.floor(times / 3600 / 24);
    var hr = Math.floor(times / 3600);
    var hr2 = hr % 24;
    var min = Math.floor((times - hr * 3600) / 60);
    var sec = (times - hr * 3600 - min * 60);
    // 渲染倒计时时钟
    that.setData({
      h: hr2, //格式化时间
      day: day,
      m: min,
      s: sec
    });
    times = times - 1;
    if (times <= 0 || isNaN(times)) {
      that.setData({
        limitWarning: "砍价已结束"
      });
      return;
    } else {
      that.setData({
        times: times
      });
    }
    //settimeout实现倒计时效果
    setTimeout(function() {
      that.countdown(times);
    }, 1000)
  },
  /**已有砍价订单取消按钮处理 */
  cancel: function() {
    this.setData({

    })

  },
  /**已有砍价订单确认按钮处理 */
  confirm: function(e) {
    var that = this
    wx.navigateTo({
      url: '/pages/personal/bargaindetail/bargaindetail',
    })
  }


})