// 分销中心
const App = getApp()
Page({
  data: {
    userInfo: {},
    agentData: {},
    showPoster: false
  },
  onLoad: function(options) {
    var that = this;
    App.initialize(function(res) {
      that.setData({
        "userInfo": res.userInfo,
      });
    });
  },

  onShow: function() {
    var that = this
    that.agentAccount();
  },

  /**分销统计 */
  agentAccount: function() {
    var that = this;
    App.apiPost({
      "uri": "storeCtrl/get_store_count.html",
      "data": {},
      "callback": function(res) {
        that.setData({
          "agentData": res.data
        })
      }
    })
  },

  /**生成海报 */
  bindPost: function(e) {
    var that = this
    var shareType = e.currentTarget.dataset.but
    //创建分享图片
    wx.showLoading({
      title: '海报努力生成中',
    });
    App.apiPost({
      "uri": "storeProduct/sale_center_poster.html",
      "data": {
        "posttype": shareType
      },
      "callback": function(res) {
        if (!res.error_code) {
          /**海报推广 */
          if (shareType = "mpp") {
            that.setData({
              "posturl": res.data
            });
          } else {
            /**邀请好友 */
            that.setData({
              "posturl": res.data
            });
          }
          /**显示海报区 */
          that.setData({
            "showPoster": true,
          })
        }
        wx.hideLoading()
      }
    })
  },
  /**保存图片到相册 */
  savePictureToAlbum: function() {
    var that = this;
    wx.showLoading({
      title: '正在下载图片',
    });
    wx.downloadFile({
      url: that.data.posturl,
      success: function(res) {
        //图片保存到本地
        wx.saveImageToPhotosAlbum({
          filePath: res.tempFilePath,
          success: function(data) {
            wx.hideLoading();
            wx.showToast({
              title: '保存成功',
              icon: 'success',
              duration: 2000,
              success: function() {
                that.setData({
                  "showPoster": false,
                })
              }
            })
          },
          fail: function(err) {
            wx.hideLoading();
            if (err.errMsg === "saveImageToPhotosAlbum:fail auth deny") {
              wx.openSetting({
                success(settingdata) {
                  if (settingdata.authSetting['scope.writePhotosAlbum']) {} else {
                    wx.showToast({
                      title: '请授权相册',
                    })
                  }
                }
              })
            }
          },
          complete(res) {}
        })
      }
    })
  },
  /**跳转累计客户列表 */
  goTotalCustomer: function() {
    wx.navigateTo({
      url: '/pages/personal/totalcustomer/totalcustomer',
    })
  },
  /**跳转邀请推广列表 */
  goInvited: function() {
    wx.navigateTo({
      url: '/pages/personal/invited/invited',
    })
  },
  /**跳转推广订单 */
  goExtendList: function() {
    wx.navigateTo({
      url: '/pages/personal/extendlist/extendlist',
    })
  },

  /**跳转到所有商品 */
  goProductList: function() {
    wx.navigateTo({
      url: '/pages/productList/productList',
    })
  },
  /**跳转到提现页*/
  goGetCash: function(e) {
    var that = this;
    wx.navigateTo({
      url: '/pages/personal/getcash/getcash',
    })
  },
  /**关闭弹层 */
  closeShare: function() {
    var that = this;
    that.setData({
      showPoster: false
    })
  },
})