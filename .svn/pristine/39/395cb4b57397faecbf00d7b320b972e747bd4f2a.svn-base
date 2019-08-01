// pages/goodscenter/
var App = getApp();
Page({

  data: {
    currentTab: 0, //tab切换  
    firstIndex: -1,
    curIndex: 0,
    category: 0,
    pagenumber: 0,
    products: [],
    categories: [],
    keywords: '',
    userInfo: {},
    adverts:{},
  },

  onShow: function(options) {
    var that = this;
    that.setData({
      "pagenumber": 0,
      "products": [],
      "category": 0,
      "userInfo": wx.getStorageSync("user_data"),
    }, function() {
      that.setData({
        "shopkeeper": that.data.userInfo.store_id ? true : false
      })
    });
    wx.showLoading({
      title: '加载中……'
    })
    that.getCategories();
    that.get_advert();
  },

  /**下拉刷新 */
  onPullDownRefresh: function () {
    var that = this;
    that.onShow();
    wx.stopPullDownRefresh();
  },

  /**获取商品分类信息 */
  getCategories: function() {
    var that = this;
    App.apiPost({
      'uri': 'Category/get_categories.html',
      'callback': function(res) {
        that.setData({
          "categories": res.data
        });
        that.getProductList();
      }
    });
  },
  /**获取广告信息 */
  get_advert: function () {
    var that = this;
    App.apiPost({
      'uri': 'advert/get_advert.html',
      'data': {'ad_id':1},
      'callback': function (res) {
        that.setData({
          "adverts": res.data
        });
      }
    });
  },
  //搜索
  clicksearch: function(e) {
    var that = this;
    that.setData({
      keywords: e.detail.value,
      "products": [],
      "pagenumber": 0
    })
    that.getProductList();
  },
  /**获取商品列表 */
  getProductList: function(e) {
    var that = this;
    wx.showLoading({
      title: '加载中……',
      })
    if (typeof e !== "undefined") {
      that.setData({
        "category": e.currentTarget.dataset.category,
        "products": [],
        "pagenumber": 0
      });
    }

    var currPage = that.data.pagenumber + 1;
    var category = that.data.category;
    App.apiPost({
      'uri': 'product/get_products.html',
      'data': {
        "category_id": category,
        "page": currPage,
        "keyword": that.data.keywords,
      },
      'callback': function(res) {
        var productList = that.data.products.concat(res.data);
        if (res.data.length > 0) {

          that.setData({
            "products": productList,
            "pagenumber": currPage
          });

        }
        wx.hideLoading();
      }
    });
  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function() {
    this.getProductList();
  },


  recommend: function(e) {
    var product_id = e.currentTarget.dataset.product_id;
    App.apiPost({
      uri: 'storeProduct/set_store_product.html',
      data: {
        "product_id": product_id
      },
      callback: function(res) {
        if (res.error_code) {
          wx.showToast({
            title: '该商品已推荐',
            icon: 'none',
            duration: 1500,
          })
        } else {
          wx.showToast({
            title: '推荐成功',
            icon: 'none',
            duration: 1500,
          })
        }
      }

    })
  },
  bindTap: function(e) {
    const index = parseInt(e.currentTarget.dataset.index);
    this.setData({
      curIndex: index
    })
  },
  addToCart: function(e) {
    var that = this;
    App.apiPost({
      'uri': 'cart/add_cart.html',
      'data': {
        'product_id': e.currentTarget.dataset.product_id,
        'product_special_id': 0, //商品的货号
        'product_number': 1,
        "product_type": "O",
      },
      'callback': function(res) {
        if (!res.error_code) {
          wx.showToast({
            'title': '加入成功',
            'icon': 'success',
            'success': function() {
              App.checkCartNum();
            }
          })
        } else {
          wx.showToast({
            "title": res.data,
            "icon": "none"
          });
        }
      }
    })
  }
})