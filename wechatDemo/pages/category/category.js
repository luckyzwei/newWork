const app = getApp()
// 商品分类
Page({
  data: {
    cateItems: [],
    curNav: 0,
    curIndex: 0,
  },

  onLoad: function(options) {
    var that = this
    that.getCategory();
  },

  onShow: function() {
    app.checkCartNum();
  },
  //点击切换分类项 
  switchRightTab: function(e) {
    var id = e.currentTarget.dataset.id;
    var index = parseInt(e.currentTarget.dataset.index);
    this.setData({
      curNav: index,
      curIndex: index
    })
  },
  /**到商品列表页 */
  productList: function(e) {
    var that = this
    var child_id = e.currentTarget.dataset.child_id
    wx.navigateTo({
      url: '/pages/productList/productList?child_id=' + child_id,
    })

  },
  /**获取分类接口数据 */
  getCategory: function() {
    var that = this;
    var data = {};
    app.apiPost({
      'uri': 'category/get_categories.html',
      'data': data,
      'callback': function(res) {
        if (!res.error_code) {
          that.setData({
            cateItems: res.data
          })
        }
      }
    });
  }
})