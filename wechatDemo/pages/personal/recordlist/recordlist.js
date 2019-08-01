// 收支明细.js
var App = getApp();
Page({
  data: {
    cashList: []
  },

  onShow: function() {
    var that = this;
    that.getCashList();
  },

  /**获取用户账户变更记录 */
  getCashList: function() {
    var that = this;
    App.apiPost({
      "uri": "user/get_user_cash_list.html",
      "data": {},
      "callback": function(res) {
        that.setData({
          "cashList": res.data
        })
      }
    })
  }

})