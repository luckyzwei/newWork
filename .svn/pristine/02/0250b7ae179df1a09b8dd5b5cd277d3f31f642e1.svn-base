// 授权登录页
const App = getApp()
Page({
  data: {
    referer: "",
    product_id:0
  },

  onLoad: function(options) {
    var that=this;
    console.log(options.referer)
    if (typeof options.referer != "undefined") {
      var product_id=0;
      if(typeof options.product_id!="undefined"){
        product_id = options.product_id;
      }
      that.setData({
        "referer": options.referer,
        "product_id":product_id
      })
    }
  },

  /**授权应用 */
  authorization: function(e) {
    var that = this;
    if (e.detail.errMsg == "getUserInfo:ok") {
      var userdata = wx.getStorageSync("user_data");
      var wx_user_info = e.detail.userInfo;
      wx_user_info.parent_user_id = wx.getStorageSync("from_user_id");
      //更新用户信息
      App.apiPost({
        'uri': 'user/update_user_info.html',
        'data': wx_user_info,
        'callback': function(res) {
          wx.setStorage({
            key: "user_data",
            data: "",
            success: function() {
              App.userLogin().then(function(res) {
                that.setData({
                  "userInfo": res
                }, function() {
                  if (that.data.referer == "usi") {
                    wx.redirectTo({
                      url: '/pages/personal/userinfo/userinfo',
                    })
                  } else if (that.data.referer == "gdt"){
                    wx.redirectTo({
                      url: '/pages/goodsdetail/goodsdetail?product_id='+that.data.product_id,
                    })
                  }
                  else {
                    wx.switchTab({
                      url: '/pages/index/index',
                    })
                  }
                })

              });

            }
          });
        }
      });
    } else {
      wx.showToast({
        title: '请授权应用',
        icon: 'none',
        duration: 3000
      })
    }
  },
})