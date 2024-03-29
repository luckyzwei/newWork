//商品详情
const App = getApp()
Page({
  data: {
    userInfo: {},
    hasUserInfo: false,
    canIUse: wx.canIUse('button.open-type.getUserInfo'),
    choose_modal: "none", //弹出层的初始状态是隐藏
    num: 1, //初始数量
    minusStatus: 'disabled', //禁用减号
    product: {},
    default_special_price: 0,
    cartProductNum: 0,
    curIndex: 0,
    product_id: '',
    reviews: {},
    commentPage: 1,
    buy_button: '',
    star: [0, 1, 2, 3, 4],
    shareModal: false,
    showPoster: false

  },


  onLoad: function(options) {
    var that = this;
    var product_id = options.product_id;

    /**二维码进入的该页面 */
    if (options.scene) {
      var params = options.scene.split("_");
      product_id = params[0];
    }

    if ("cate" in options) {
      App.globalData.category_id = options.cate;
    }
    if ('keyword' in options) {
      App.globalData.keyword = options.keyword;
    }
    /**初始化用户数据 */
    App.initialize(function(res) {
      that.setData({
        "userInfo": res.userInfo,
        "product_id": product_id
      }, function() {
        if (!res.userInfo.wx_headimg) {
          wx.redirectTo({
            url: "/pages/authoriz/authoriz?referer=gdt&"+"product_id="+product_id
          });
        } else {
          that.getProduct();
          that.addProductData();
        }
      });
    });
  },
  /**检查购物车商品数量 */
  onShow: function() {
    var that = this;
    App.checkCartNum(function(cartnum) {
      that.setData({
        "cartProductNum": cartnum
      });
    });
  },

  /**获取当前商品信息 */
  getProduct: function() {
    var that = this;
    wx.showLoading({
      title: '努力加载中……',
      mask: true,
      success: function(res) {
        App.apiPost({
          "uri": 'product/get_product_info.html',
          "data": {
            product_id: that.data.product_id,
            // store_id: that.data.storeInfo.store_id
          },
          "callback": function(res) {
            if (!res.error_code) {
              /** 清除详情图片上下之间空隙 */
              res.data.description = res.data.description.replace(/style="width:.+?100%;"/gi, ' style="width:100%;display:block;" ')
              that.setData({
                "product": res.data,
                "default_special_price": res.data.default_special_price,
              }, function() {
                that.mkProductSpecial();
              });
              wx.hideLoading();
            }
          }
        })
      },

    })
  },

  /**导航到首页 */
  goHome: function() {
    wx.switchTab({
      url: '/pages/index/index',
    })
  },
  /**导航购物车页 */
  showCart: function() {
    wx.switchTab({
      url: '/pages/shopcar/shopcar',
    })
  },
  /**购买/加入购物车 */
  addToCart: function(e) {
    var that = this;
    var click_button = that.data.buy_button;
    var product_info = that.data.product;
    if (product_info.timelimit) {
      var product_type = "T";
    } else {
      var product_type = "O";
    }
    var data = {
      "product_id": that.data.product.product_id,
      "product_number": that.data.num,
      "product_type": product_type,
      "product_special_id": "",
    };
    //判断规格是否选择完毕
    var product_special_id = 0;
    App.apiPost({
      'uri': 'Cart/add_cart.html',
      'data': data,
      'callback': function(res) {
        if (!res.error_code) {
          if (click_button == "addCart") {
            wx.showToast({
              'title': '加入成功',
              'icon': 'none',
              'success': function() {
                that.setData({
                  choose_modal: "none",
                });
              },
            });
            /**跟新购物车提示数字 */
            App.checkCartNum(function(cartnum) {
              that.setData({
                "cartProductNum": cartnum
              });
            });
          }
          if (click_button == "goBuy") {
            that.setData({
              choose_modal: "none",
            }, function() {
              var cart_id = res.data.cart_id;
              that.nowCheckout(cart_id);
            })

          }
        } else {
          console.log(res);
        }
      }
    })
  },
  /**处理立即购买 */
  nowCheckout: function(cart_id) {
    //把其它商品设置为不结算
    App.apiPost({
      'uri': 'cart/set_cart_check_status.html',
      'data': {
        'cart_id': "all",
        "chk_status": 0
      },
      'callback': function(res) {
        if (!res.error_code) {
          //把当前cart_id设置为结算
          App.apiPost({
            'uri': 'cart/set_cart_check_status.html',
            'data': {
              'cart_id': cart_id,
              "chk_status": 1
            },
            'callback': function(res) {
              if (!res.error_code) {
                wx.navigateTo({
                  url: '/pages/checkout/checkout',
                })
              } else {
                console.log(res);
              }
            }
          })
        } else {
          console.log(res);
        }
      }
    });


  },

  /**重新处理商品规格的数据结构 */
  mkProductSpecial: function() {
    var that = this;
    var productSpecial = that.data.product.product_special;
    var specialStruct = that.data.product.product_special.special_struct;
    if (typeof specialStruct !== "undefined") {
      var newStructs = [];
      var hideArray = [];
      for (var s in specialStruct) {
        var newStruct = {};
        newStruct.special_name = specialStruct[s].special_name;
        var newOptions = [];
        for (var o in specialStruct[s].specification) {
          var newOption = {};
          newOption.option_name = specialStruct[s].specification[o];
          //处理默认选项
          if (o == productSpecial.default[s]) {
            newOption.selected = true;
          } else {
            newOption.selected = false;
          }
          newOptions.push(newOption);
        }
        newStruct.specification = newOptions;
        newStructs.push(newStruct);
      }

      //---------处理隐藏项-----------------
      if (typeof productSpecial.default != "undefined" && productSpecial.default.length >= specialStruct.length - 1) {
        var index_str = productSpecial.default.join("-");
        if (productSpecial.default.length == specialStruct.length) {
          index_str = productSpecial.default.slice(0, -1).join("-");
          //获取选项的价格
          var allIndexstr = productSpecial.default.join("-");
          for (var ss in productSpecial.specifications) {
            if (productSpecial.specifications[ss].goods_code == "goods_" + allIndexstr) {
              that.setData({
                "default_special_price": parseFloat(productSpecial.specifications[ss].goods_plus_price) + that.data.product.user_price
              })
            }
          }
        }
        var currhide = [];

        for (var h in productSpecial.hidden) {
          var psH = productSpecial.hidden[h].split("-");
          if (psH[0] == index_str) {
            var harray = productSpecial.hidden[h].split("-");
            currhide.push(harray[specialStruct.length - 1]);
          }
        }

        //最后一项
        var last_sp = newStructs[specialStruct.length - 1].specification;
        for (var k in last_sp) {
          if (currhide.indexOf(k) >= 0) {
            last_sp[k].hide = true;
          } else {
            last_sp[k].hide = false;
          }
        }
        newStructs[specialStruct.length - 1].specification = last_sp;
      }
      //-----------隐藏 end------------------
      that.setData({
        "special_structs": newStructs
      });
    }
  },
  /**选择规格 */
  selectSpecial: function(e) {
    var that = this;
    var level = e.currentTarget.dataset.level;
    var specialIndex = e.currentTarget.dataset.specialindex;
    //约束跨层选择
    if (that.data.productinfo.product_special.default.length < level) {
      var needSelectName = that.data.special_structs[that.data.productinfo.product_special.default.length].special_name;
      wx.showToast({
        "title": "请先选择" + needSelectName,
        "icon": "none"
      });
      return;
    }

    that.data.productinfo.product_special.default[level] = specialIndex;
    //清除掉该层级之后的值
    that.data.productinfo.product_special.default.splice(level + 1, that.data.productinfo.product_special.special_struct.length - level);
    that.setData({
      "productinfo": that.data.productinfo
    });
    //去掉选项中的hide
    var struct = that.data.special_structs;
    for (var x in struct) {
      for (var st in struct[x].specification) {
        struct[x].specification[st].hide = false;
      }
    }
    that.setData({
      "special_structs": struct
    });
    that.mkProductSpecial();
  },
  /* 点击减号 */
  bindMinus: function() {
    var num = this.data.num;
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
  bindPlus: function() {
    var num = this.data.num;
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
  bindManual: function(e) {
    var num = e.detail.value;
    if (isNaN(num)) {
      num = 1;
    }
    // 将数值与状态写回
    this.setData({
      num: parseInt(num)
    });
  },
  //弹出
  modal_show: function(e) {
    this.setData({
      buy_button: e.currentTarget.dataset.button,
      choose_modal: "block",
    });
  },
  //消失
  modal_none: function() {
    this.setData({
      choose_modal: "none",
    });
  },
  /**切换详情 评论列表 */
  changeTap: function(e) {
    var that = this;
    var index = e.currentTarget.dataset.index;
    that.setData({
      curIndex: index
    })
    if (index == 1) {
      that.getComment();
    }
  },
  getComment: function() {
    var that = this;
    wx.showLoading({
      title: '努力加载中……',
      mask: true,
      success: function(res) {
        App.apiPost({
          "uri": 'ProductComment/get_product_comments.html',
          "data": {
            product_id: that.data.product_id,
            // store_id: that.data.storeInfo.store_id,
            page: that.data.commentPage
          },
          "callback": function(res) {
            if (!res.error_code) {
              that.setData({
                "reviews": res.data,
              });
              wx.hideLoading();
            }
          }
        })
      },

    })
  },
  /**增加商品查看次数 */
  addProductData: function() {
    var that = this;
    App.apiPost({
      "uri": 'Product/addProductData.html',
      "data": {
        product_id: that.data.product_id,
        type: 1,
      },
      "callback": function(res) {}
    })
  },
  /**显示分享方式 */
  shareStyle: function(e) {
    var that = this;
    that.setData({
      shareModal: true,
    })
  },
  //**关闭弹层 */
  closeShare: function() {
    var that = this;
    that.setData({
      shareModal: false,
      showPoster: false
    })
  },
  /**生成海报 */
  createShareImg: function(e) {
    var that = this
    //创建分享图片
    wx.showLoading({
      title: '海报努力生成中',
    });
    App.apiPost({
      "uri": "storeProduct/product_share_image.html",
      "data": {
        "product_id": that.data.product_id
      },
      "callback": function(res) {
        if (!res.error_code) {
          that.setData({
            "posturl": res.data
          });
          /**显示海报区 */
          that.setData({
            "showPoster": true,
            "shareModal": false,
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
                  "shareModal": false,
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
  /**自定义转发 */
  onShareAppMessage: function(res) {
    var that = this;
    /**显示海报区 */
    that.setData({
      "shareModal": false,
    })
    return {
      title: that.data.product.product_name,
      imageUrl: that.data.product.thumb,
      path: '/pages/goodsdetail/goodsdetail?scene=' + that.data.product.product_id + "_" + that.data.userInfo.user_id
    }
  }


})