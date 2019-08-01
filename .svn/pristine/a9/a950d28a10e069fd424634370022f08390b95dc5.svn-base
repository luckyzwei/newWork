// 活动促销.js
const App = getApp();
Page({
  data: {
    indicatorDots: true, //小点
    autoplay: true, //自动轮播
    interval: 2000, //间隔
    duration: 2000, //滑动时间,
    imgUrls: [],
    curIndex: 0,
    groupproducts: [],
    killproducts: [],
    g_page: 1,
    k_page: 1,
    choose_modal: false, //弹出层的初始状态是隐藏
  },
  onLoad: function() {
    var imgUrls = [{
      ad_source: "http://admin.cutepetxb.cn/upload/image/shouye/kaizhang/(16).jpg",
    }]
    this.setData({
      imgUrls: imgUrls,
    })
  },
  onShow: function() {
    var that = this;
    if (that.data.curIndex == 0) {
      that.getgroupproduct();
    } else {
      that.getkillproduct();
    }
  },
  /**砍价/拼团Tab切换 */
  changeTap: function(e) {
    var that = this;
    var index = e.currentTarget.dataset.index;
    that.setData({
      curIndex: index
    })
    if (that.data.curIndex == 0) {
      that.setData({
        "g_page": 1,
        "groupproducts": []
      })
      that.getgroupproduct();
    } else {
      that.setData({
        "k_page": 1,
        "killproducts": []
      })
      that.getkillproduct();
    }
  },
  getkillproduct: function() {
    var that = this;
    var k_page = that.data.k_page;
    var killproducts = that.data.killproducts;
    wx.showLoading({
      title: '努力加载中…',
      mask: true,
      success: function(res) {
        App.apiPost({
          "uri": 'KillProduct/get_killproducts.html',
          "data": {
            'page': k_page,
          },
          "callback": function(res) {
            if (res.data.length > 0) {
              k_page++;
              killproducts = killproducts.concat(res.data)
            }
            that.setData({
              "k_page": k_page,
              "killproducts": killproducts,
            })

            wx.hideLoading();
          }
        })
      }
    })
  },
  getgroupproduct: function() {
    var that = this;
    var g_page = that.data.g_page;
    var groupproducts = that.data.groupproducts;
    wx.showLoading({
      title: '努力加载中……',
      mask: true,
      success: function(res) {
        App.apiPost({
          "uri": 'GroupProduct/get_groupproducts.html',
          "data": {
            'page': g_page,
          },
          "callback": function(res) {
            if (res.data.length > 0) {
              g_page++;
              groupproducts = groupproducts.concat(res.data)
            }
            that.setData({
              "g_page": g_page,
              "groupproducts": groupproducts,
            })

            wx.hideLoading();
          }
        })
      }
    })
  },
  /** 跳转到拼团详情页*/
  goTuan: function(e) {
    // var product_id = ;
    wx.navigateTo({
      url: '/pages/groupdetail/groupdetail?group_product_id=' + e.currentTarget.dataset.group_product_id,
    })
  },

  /**跳转到砍价进度详情 */
  gokill: function(e) {
    var that = this
    wx.navigateTo({
      url: '/pages/bargain_detail/bargain_detail?kill_product_id=' + e.currentTarget.dataset.kill_product_id,
    })
  },
})