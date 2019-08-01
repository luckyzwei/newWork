//地址列表页
var App = getApp();
Page({
  data: {
    addresslist: {},
    ref: '',
    empty:false,
  },

  onLoad: function (options) {
    var that = this;
    if (options.ref) {
      that.setData({
        "ref": options.ref
      });
    }
  },
  onShow: function () {
    var that = this;
    that.get_address();
  },
  /**获取地址列表 */
  get_address: function () {
    var that = this;
    App.apiPost({
      "uri": "address/get_address.html",
      "data": {},
      "callback": function (res) {
        if (!res.error_code) {
          that.setData({
            "addresslist": res.data,
            "empty":false,
          });
        } else {
          wx.redirectTo({
            url: '/pages/personal/addressedit/addressList/addressList?ref=' + this.data.ref,
          })
          that.setData({
            "empty": true,
          })
        }
      }
    })
  },
  /**设置默认地址 */
  setdefault: function (e) {
    wx.showToast({
      title: '请稍后',
      icon: 'loading'
    });
    var that = this;
    App.apiPost({
      "uri": "address/set_default.html",
      "data": { address_id: e.currentTarget.dataset.address_id },
      "callback": function (res) {
        if (!res.error_code) {
          that.get_address();
          if (that.data.ref) {
            wx.redirectTo({
              url: "/pages/checkout/checkout?source_diy=address",
            })
          }
        } else {
          wx.redirectTo({
            url: '/pages/personal/addressedit/addressList/addressList?ref=' + that.data.ref,
          })
        }
      }
    })
  }
})