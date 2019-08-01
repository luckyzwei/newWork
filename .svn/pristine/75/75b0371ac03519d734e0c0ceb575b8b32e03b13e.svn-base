//优惠券列表页
const App = getApp()
Page({
  data: {
    curIndex: 0,
    coupons: [] //优惠券
  },

  onShow: function(options) {
    var that = this
   
    that.get_coupons(0);
  },

  /**标签切换 */
  bindTap: function(e) {
    var that = this;
    const index = parseInt(e.currentTarget.dataset.index);
   
    that.setData({
      curIndex: index,
    })
    that.get_coupons(index)
  },
  /**获取优惠券 */
  get_coupons: function(status) {
    var that = this;
    App.apiPost({
      'uri': 'Coupon/get_user_coupon.html',
      'data': { "status": status},
      'callback': function(res) {
        that.setData({
          coupons: res.data
        })
      }
    })

  },
  /** 页面相关事件处理函数--监听用户下拉动作*/
  onPullDownRefresh: function() {},
  /** 页面上拉触底事件的处理函数 */
  onReachBottom: function() {

  },
})