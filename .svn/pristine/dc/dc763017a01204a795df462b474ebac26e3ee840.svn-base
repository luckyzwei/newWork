// 商品评论页
var App = getApp();
Page({
  data: {
    products: {},
    starMap: [
      '非常差',
      '差',
      '一般',
      '好',
      '非常好',
    ],
  },
  onLoad: function (options) {
    var that = this;
    if (options.order_id) {
      that.setData({
        'order_id': options.order_id
      });
      that.get_order_product(options.order_id)
    }
  },
  get_order_product: function (order_id) {
    var that = this;
    App.apiPost({
      "uri": 'order/get_order_product.html',
      "data": {
        order_id: order_id,
      },
      "callback": function (res) {
        that.setData({
          "products": res.data,
        });
      }
    })
  },
  // 点击星星评论
  myStarChoose(e) {
    var that = this;
    console.log(e);
    var products = that.data.products;
    let star = parseInt(e.target.dataset.star) || 0;
    let index = parseInt(e.target.dataset.index) || 0;
    products[index].product_score = star
    that.setData({
      products: products,
    });
  },
  // 填写文字评论
  bindFormSubmit: function (e) {
    App.addformId({
      formid: e.detail.formId,
      source_field: 'sub_cart'
    });
    var that = this;
    var reviewValue = e.detail.value;
    reviewValue.order_id = that.data.order_id;
    console.log(reviewValue);
    App.apiPost({
      "uri": 'productComment/add_product_comment.html',
      "data": reviewValue,
      "callback": function (res) {
        wx.showToast({
          title: '评论成功',
          icon: 'success',
          success: function () {
            wx.redirectTo({
              url: '/pages/personal/allorder/allorder?status=5',
            })
          }
        })
      }
    })
  }
})