// 体现页面 js
var App = getApp();
Page({
  data: {
    showCashModal: false,
    showCashModal: false,
    activeBtn: false,
    account: {},
    cashMoney: 0
  },


  onShow: function() {
    var that = this;
    that.getUserAccount();
  },

  getUserAccount: function() {
    var that = this;
    App.apiPost({
      "uri": "user/user_center_data.html",
      "data": {},
      "callback": function(res) {
        that.setData({
          "account": res.data.user_account
        })
      }
    })
  },

  /**输入提现金额 */
  getCashMoney: function(e) {
    var that = this;
    var cashMoney = e.detail.value
    if (cashMoney * 1 > that.data.account.settlement_money * 1) {
      cashMoney = that.data.account.settlement_money;
    }
    that.setData({
      "cashMoney": cashMoney
    });
  },

  // 提现弹窗
  showCashModal: function(e) {
    this.setData({
      showCashModal: true,
    })
  },
  //取消按钮
  cancel() {
    this.setData({
      showCashModal: false
    });
  },
  // 提交提现事件
  confirm() {
    var that = this;
    that.setData({
      showCashModal: false
    });
    if (0 > that.data.cashMoney * 1) {
      wx.showToast({
        title: '请输入正确数值',
      })
      return;
    }
    App.apiPost({
      "uri": "recharge/get_cash.html",
      "data": {
        "cash_amount": that.data.cashMoney
      },
      "callback": function(res) {
        if (!res.error_code) {
          wx.showToast({
            title: res.data,
            icon: 'success',
            success: function() {}
          })
        } else {
          wx.showToast({
            title: res.data,
            icon: 'none'
          })
        }
      }
    });
  },
  /**全部提现*/
  getAllWithdraw: function() {
    var that = this;
    that.setData({
      'cashMoney': that.data.account.settlement_money
    })
  }

})