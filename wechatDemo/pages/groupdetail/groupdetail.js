//拼团商品详情
const App = getApp()
Page({
  data: {
    userInfo: {},
    storeInfo: {},
    hasUserInfo: false,
    canIUse: wx.canIUse('button.open-type.getUserInfo'),
    choose_modal: "none", //弹出层的初始状态是隐藏
    num: 1, //初始数量
    minusStatus: 'disabled', //禁用减号
    maxusStatus: 'normal',
    groupproduct: {},
    groupbuy_sn: '0', //分享进来的团编号
    cartProductNum: 0,
    curIndex: 0,
    group_product_id: '',
    reviews: {},
    commentPage: 1,
    star: [0, 1, 2, 3, 4],
    times: 0,
    h: '',
    day: '',
    m: '',
    limitWarning: "距离结束仅剩",
    c_groupbuy_sn: '0' //提交的团编号
  },
  onLoad: function(options) {
    var that = this;
    var group_product_id = options.group_product_id;
    that.setData({
      group_product_id: group_product_id
    })

    var groupbuy_sn = options.groupbuy_sn;
    if (groupbuy_sn != undefined) {
      that.setData({
        groupbuy_sn: groupbuy_sn
      })
    }
    App.initialize(function() {
      that.setData({
        "storeInfo": wx.getStorageSync("storeInfo"),
        "userInfo": wx.getStorageSync("user_data")
      }, function() {
        wx.hideShareMenu();
        that.get_groupproduct();
      });
    });
  },

  /**获取当前商品信息 */
  get_groupproduct: function() {
    var that = this;
    wx.showLoading({
      title: '努力加载中……',
      mask: true,
      success: function(res) {
        App.apiPost({
          "uri": 'GroupProduct/get_groupproduct.html',
          "data": {
            group_product_id: that.data.group_product_id,
            groupbuy_sn: that.data.groupbuy_sn
          },
          "callback": function(res) {
            if (!res.error_code) {
              /** 清除详情图片上下之间空隙 */
              res.data.description = res.data.description.replace(/style="width:.+?100%;"/gi, ' style="width:100%;display:block;" ')
              that.setData({
                "groupproduct": res.data,
                "times": res.data.endtime
              }, function() {
                that.countdown(that.data.times);
              });
            }
            wx.hideLoading();
          }
        })
      },

    })
  },

  /**导航到首页 */
  showStore: function() {
    wx.switchTab({
      url: '/pages/index/index',
    })
  },
  /**导航购物车页 */
  showCart: function() {
    wx.switchTab({
      url: '/pages/shopcar/shopcar',
    })
  },
  goproduct: function() {
    var that = this;
    wx.navigateTo({
      url: '/pages/goodsdetail/goodsdetail?product_id=' + that.data.groupproduct.product_id,
    })
  },
  /**购买/加入购物车 */
  addToCart: function(e) {
    var that = this;
    var product_number = that.data.num;
    if (that.data.num > that.data.groupproduct.group_user_num_every) {
      product_number = that.data.groupproduct.group_user_num_every;
    }
    wx.navigateTo({
      url: '/pages/checkout/checkout?group_product_id=' + that.data.group_product_id +
        '&groupbuy_sn=' + that.data.c_groupbuy_sn + '&product_number=' + product_number + '&source_diy=groupproduct',
    })
  },



  /* 点击减号 */
  bindMinus: function() {
    var num = this.data.num;
    // 如果大于1，可以减
    if (num > 1) {
      num--;
    }

    // 只有大于1的时候，才能normal状态进行减法，否则disable状态
    var minusStatus = num <= 1 ? 'disabled' : 'normal';
    this.setData({
      num: num,
      minusStatus: minusStatus,
      maxusStatus: 'normal'
    });
  },
  /* 点击加号*/
  bindPlus: function() {
    var that = this;
    var num = that.data.num;
    // 不作过多考虑自增1
    num++;
    // 小于1,为disable状态
    var maxusStatus = 'normal';
    if (num >= that.data.groupproduct.group_user_num_every) {
      num = that.data.groupproduct.group_user_num_every;
      maxusStatus = 'disabled';
      wx.showToast({
        title: '每人限购' + num + '件',
        icon:'none'
      })
    }
    // 将数值与状态写回
    that.setData({
      num: num,
      maxusStatus: maxusStatus,
      minusStatus: 'normal'
    });

  },
  /* 输入框事件 */
  bindManual: function(e) {
    var that = this;
    var num = e.detail.value;
    if (isNaN(num)) {
      num = 1;
    }
    var maxusStatus = 'normal';
    if (num >= that.data.groupproduct.group_user_num_every) {
      num = that.data.groupproduct.group_user_num_every;
      maxusStatus = 'disabled';
      wx.showToast({
        title: '每人限购' + num + '件',
        icon: 'none'
      })
    }
    // 将数值与状态写回
    that.setData({
      num: parseInt(num),
      maxusStatus: maxusStatus,
      minusStatus: 'normal'
    });
  },
  //弹出
  modal_show: function(e) {
    this.setData({
      c_groupbuy_sn: e.currentTarget.dataset.groupbuy_sn,
      choose_modal: "block",
    });
  },
  //消失
  modal_none: function() {
    this.setData({
      choose_modal: "none",
    });
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
            product_id: that.data.groupproduct.product_id,
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
        limitWarning: "拼团已结束"
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
})