// 邀请客户.js
var app = getApp();
Page({
  data: {
    userInfo: {},
    customer: [],
    page: 1
  },

  onShow: function () {
    var that = this;
    that.setData({
      "userInfo": wx.getStorageSync("user_data")
    }, function () {
      that.getUserTeam()
    })
  },
  /**获取用户的团队信息 */
  getUserTeam: function () {
    var that = this;
    app.apiPost({
      "uri": "storeCtrl/get_user_team.html",
      "data": {
        "team": "mpp",
        "page": that.data.page
      },
      "callback": function (res) {
        if (res.data.length > 0) {
          var data = that.data.customer.concat(res.data)
          that.setData({
            "customer": data
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
      that.getUserTeam();
    })

  },


})