// 收支明细.js
var App = getApp();
Page({
  data: {
    accountList : []
  },

  onShow: function() {
    var that = this;
    that.getAccountList();
  },
  
  /**获取用户账户变更记录 */
  getAccountList: function() {
    var that = this;
    App.apiPost({
      "uri": "user/get_account_log.html",
      "data": {},
      "callback": function(res) {
        that.setData({
          "accountList": res.data.logs
        })
      }
    })
  }

})