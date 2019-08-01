// 秒杀商品
const app = getApp()
Page({
  data: {
    products: [],
    categories: [],
    orderby: 'all',
    order: 'DESC',
    diytype: '',
    curIndex: 0,
    showNavOrder: false,
    is_showUp: false, //价格上下选择箭头
    scrollTop: { //回到顶部
      scroll_top: 0,
      goTop_show: false
    },
    keyword: "",
    page: 1,
    category_id: "",
    choose_modal: "none", //弹出层的初始状态是隐藏
    num: 1, //初始数量
    minusStatus: 'disabled', //禁用减号
    chooseProduct: {},//选中的商品id
  },
  onLoad: function (option) {
    var that = this;
    var category_id = '';
    var keyword = '';

    if (app.globalData.keyword) {
      keyword = app.globalData.keyword;
    }
    if (app.globalData.category_id) {
      category_id = app.globalData.category_id
    }
    that.setData({
      category_id: category_id,
      keyword: keyword,
    }, function () {
      that.getProductList();
      that.getCategories();
    });
    app.globalData.keyword = "";
    app.globalData.category_id = "";

  },
  onShow: function () {

  },
  /**导航切换 */
  bindTap: function (e) {
    var that = this;
    var index = parseInt(e.currentTarget.dataset.index);
    if (index == 0) {
      var orderby = "all";
    }
    if (index == 1) {
      var orderby = "sale";
    }
    if (index == 2) {
      var orderby = "price";
    }
    if (index == 3) {
      var orderby = "new";
    }
    that.setData({
      curIndex: index,
      orderby: orderby
    })
    if (index == 2) {
      if (!that.data.is_showUp) {
        var order = "DESC";
      } else {
        var order = "ASC";
      }
      that.setData({
        is_showUp: !that.data.is_showUp,
        order: order,
      })

    }
    that.setData({
      products: [],
      page: 1,
    })
    that.getProductList();


  },
  /**获取分类接口数据 */
  getCategories: function () {
    var that = this;
    var data = {};
    app.apiPost({
      'uri': 'category/get_categories.html',
      'data': data,
      'callback': function (res) {
        if (!res.error_code) {
          that.setData({
            "categories": res.data
          })
        }
      }
    });
  },
  /**
* 页面上拉触底事件的处理函数
*/
  onReachBottom: function (e) {
    var that = this;
    that.getProductList();

  },
  /**加入购物车 */
  addToCart: function () {
    var that = this;
    var storege = wx.getStorageSync("storeInfo");
    var product_info = that.data.chooseProduct;
    if (product_info.timelimit) {
      var product_type = "T";
    } else {
      var product_type = "O";
    }
    var data = {
      "product_id": that.data.chooseProduct.product_id,
      "product_number": that.data.num,
      "product_type": product_type,
      "product_special_id": "",
      "store_id": storege.store_id,
    };
    app.apiPost({
      'uri': 'Cart/add_cart.html',
      'data': data,
      'callback': function (res) {
        if (!res.error_code) {
          wx.showToast({
            'title': '加入成功',
            'icon': 'success',
            'success': function () {
              that.modal_none();
            }
          })
        } else {
          wx.showToast({
            "title": res.data,
            "icon": "none"
          });
        }
        app.checkCartNum();
      }
    })
  },
  /**回顶部*/
  scrollTopFun: function (e) {
    if (e.detail.scrollTop > 100) {
      this.setData({
        'scrollTop.goTop_show': true
      });
    } else {
      this.setData({
        'scrollTop.goTop_show': false
      });
    }
  },
  goTopFun: function (e) {
    var top = this.data.scrollTop.scroll_top;
    if (top == 1) {
      top = 0;
    } else {
      top = 1;
    }
    this.setData({
      'scrollTop.scroll_top': top
    });
  },
  /**跳转到商品详情 */
  goGoodsDetail: function (e) {
    var thst = this;
    var product_id = e.currentTarget.dataset.product_id;
    console.log(e);
    wx.navigateTo({
      url: '/pages/goodsdetail/goodsdetail?product_id=' + product_id
    })
  },
  getProductList: function () {
    var that = this;
    wx.showLoading({
      title: '加载中……'
    });
    var data = {
      keyword: that.data.keyword,
      order: that.data.order,
      orderby: that.data.orderby,
      page: that.data.page,
      limit: 10,
      category_id: that.data.category_id,
      goods_type:'spike'
    };
    app.apiPost({
      'uri': 'Product/get_products.html',
      'data': data,
      'callback': function (res) {
        if (res.error_code == 0) {
          if (res.data.length > 0) {
            that.setData({
              "page": that.data.page + 1
            })
          }
          that.setData({
            'products': that.data.products.concat(res.data),
          }, function () {
            wx.hideLoading();
          })
        }
      }
    });
  },
  //弹出商品数量选择
  modal_show: function (e) {
    console.log(e);
    this.setData({
      chooseProduct: e.currentTarget.dataset.product,
      choose_modal: "block",
    });
  },
  //关闭数量选择
  modal_none: function () {
    this.setData({
      choose_modal: "none",
    });
  },
  /* 点击减号 */
  bindMinus: function () {
    var num = this.data.num;
    // 如果大于1，可以减
    if (num > 1) {
      num--;
    }
    // 只有大于1的时候，才能normal状态进行减法，否则disable状态
    var minusStatus = num <= 1 ? 'disabled' : 'normal';
    // 将数值与状态写回
    this.setData({
      num: num,
      minusStatus: minusStatus
    });
  },
  /* 点击加号*/
  bindPlus: function () {
    var num = this.data.num;
    // 不作过多考虑自增1
    num++;
    // 小于1,为disable状态
    var minusStatus = num < 1 ? 'disabled' : 'normal';
    // 将数值与状态写回
    this.setData({
      num: num,
      minusStatus: minusStatus
    });

  },
  /* 输入框事件 */
  bindManual: function (e) {
    var num = e.detail.value;
    if (isNaN(num)) {
      num = 1;
    }
    // 将数值与状态写回
    this.setData({
      num: parseInt(num)
    });
  },
  /* 分类跳转 */
  filterByCate: function (e) {
    var that = this;
    var cate = e.currentTarget.dataset.category;
    this.setData({
      category_id: cate,
      products: [],
      keyword: "",
      page: 1,
    }, function () {
      that.getProductList();
    });
    this.setData({
      showNavOrder: false
    });
  },
  clickSearch: function (e) {
    var that = this;
    this.setData({
      keyword: e.detail.value,
      products: [],
      category_id: "",
      page: 1,
    }, function () {
      that.getProductList();
    });
  }
})