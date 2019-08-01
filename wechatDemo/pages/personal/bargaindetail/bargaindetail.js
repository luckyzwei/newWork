//砍价详情.js
const App = getApp()
Page({
  data: {
    bargain_product: {},
    killproduct: {},
    orderinfo: {},
    killlog: [],
    killprice: {},
    showRule: false,
    showBargainNum: false,
    order_id: 0
  },
  onLoad: function(options) {
    var that = this;
    var order_id = options.order_id;
    if (order_id == undefined) {
      order_id = 0;
    }
    that.setData({
      'order_id': order_id
    })
    App.initialize(function(res) {
      that.setData({
        "userInfo": wx.getStorageSync("user_data"),
      }, function() {
        that.get_killorder(order_id)
      });

    });
    wx.hideShareMenu();
  },
  onReady: function() {
    var circleCount = 0;
    this.animationMiddleHeaderItem = wx.createAnimation({
      duration: 1000, // 以毫秒为单位
      timingFunction: 'linear',
      delay: 100,
      transformOrigin: '50% 50%',
      success: function(res) {}
    });

    setInterval(function() {
      if (circleCount % 2 == 0) {
        this.animationMiddleHeaderItem.scale(1.10).step();
      } else {
        this.animationMiddleHeaderItem.scale(0.9).step();
      }

      this.setData({
        animationMiddleHeaderItem: this.animationMiddleHeaderItem.export()
      });

      circleCount++;
      if (circleCount == 1000) {
        circleCount = 0;
      }
    }.bind(this), 600);

  },
  onShow: function() {

  },

  get_killorder: function(order_id) {
    var that = this;
    App.apiPost({
      "uri": 'KillProduct/get_killorder.html',
      "data": {
        order_id: order_id,
      },
      "callback": function(res) {
        if (!res.error_code) {
          that.setData({
            product: res.data.product,
            orderinfo: res.data.orderinfo,
            killproduct: res.data.killproduct,
            killlog: res.data.killlog
          })
        }
        that.kill_pridct(res.data.killproduct);
      }
    })
  },
  kill_pridct: function(killproduct) {
    var that = this;
    App.apiPost({
      "uri": 'KillProduct/kill_price.html',
      "data": {
        order_id: that.data.order_id,
      },
      "callback": function(res) {
        var showBargainNum = false;
        if (res.data.msg == "") {
          showBargainNum = true;
        }else{
          wx.showToast({
            title: res.data.msg,
            icon:'none'
          })
        }
        var price = res.data.original_price - res.data.reduced_price - killproduct.kill_product_min_price;
        res.data.surplusprice = price.toFixed(2);
        that.setData({
          killprice: res.data,
          showBargainNum: showBargainNum
        })

      }
    })
  },
  onShareAppMessage: function(e) {
    console.log(e);
    var that = this
    //group_product_id=15&groupbuy_sn=gps15234566
    return {
      title: "快来参加我的团吧",
      path: '/pages/personal/bargaindetail/bargaindetail?order_id=' + that.data.order_id,
      imageUrl: "/images/kan.png"
    }
  },

  /**显示砍价规则弹窗 */
  showRule: function(e) {
    var that = this;
    that.setData({
      showRule: true
    })
  },
  /**关闭弹窗 */
  closeRuleModal_rule: function(e) {
    var that = this;
    that.setData({
      showRule: false,
      showBargainNum: false
    })
  },
  /**关闭弹窗 */
  closeRuleModal: function(e) {
    var that = this;
    that.setData({
      showBargainNum: false
    })
    that.get_killorder(that.data.order_id);
  },
  /**跳转关联商品详情 */
  goGoodsDetail: function(e) {
    var that = this;
    wx.navigateTo({
      url: '',
    })
  },
  /**砍价数量弹窗 */
  showBargainNum: function(e) {
    var that = this
    that.setData({
      showBargainNum: true
    })
  },
  /**到促销专区 */
  goMore: function() {
    wx.switchTab({
      url: '/pages/salespromotion/salespromotion',
    })
  },
})