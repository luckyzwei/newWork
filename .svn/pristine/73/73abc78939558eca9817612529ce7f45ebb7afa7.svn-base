// 累计客户.js
var app = getApp();
Page({
  data: {
    userInfo: {},
    orders: [],
    page: 1
  },

  onShow: function () {
    var that = this;
    that.setData({
      "userInfo": wx.getStorageSync("user_data")
    }, function () {
      that.getUserOrders()
    })
  },
  /**获取用户的团队信息 */
  getUserOrders: function () {
    var that = this;
    app.apiPost({
      "uri": "storeCtrl/get_store_orders.html",
      "data": {
        "page": that.data.page,
        "number":20
      },
      "callback": function (res) {
        if (res.data.data.length > 0) {
          var data = that.data.orders.concat(res.data.data)
          that.setData({
            "orders": data
          })
        }
      }
    })
  },
  /**触底加载 */
  onReachBottom: function () {
    var that = this;
    wx.showLoading({
      title: '玩命加载中...',
    });
    that.setData({
      "page": that.data.page + 1
    }, function () {
      that.getUserOrders();
    })

  },


})