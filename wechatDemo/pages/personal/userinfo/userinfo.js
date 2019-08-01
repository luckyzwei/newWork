// 添加/编辑收货地址页
var area = require('../../../utils/area.js')
var t = 0;
var show = false;
var moveY = 200;
var p = 0,
  c = 0,
  d = 0;
var App = getApp();
Page({
  data: {
    userInfo: {},
    provinceName: [],
    provinceCode: [],
    provinceSelIndex: '',
    cityName: [],
    cityCode: [],
    citySelIndex: '',
    districtName: [],
    districtCode: [],
    districtSelIndex: '',
    show: show,
    value: [0, 0, 0],
    sex: ["男孩", "女孩"],
    category: ["猫", "狗"],
    member: {}
  },

  onLoad: function(options) {
    var that = this;
    
    App.initialize(function(res) {
      if (!res.userInfo.wx_headimg) {
        wx.redirectTo({
          url: "/pages/authoriz/authoriz?referer=usi"
        });
      } else {
        that.setData({
          "userInfo": res.userInfo,
        });
      }
    });
  },

  onShow: function(options) {
    var that = this;
    that.showMemberInfo();
  },
  showMemberInfo: function() {
    var that = this;
    p = c = d = 0;
    App.apiPost({
      "uri": 'User/show_member_info.html',
      "data": {},
      "callback": function(res) {
        if (!res.error_code) {
          var address_info = res.data;
          var province = area['zone'];
          that.setData({
            member: res.data,
            cate_index: res.data.pet_type,
            sex_index: res.data.pet_sex,
            "empty": false,
          });
          for (var key in province) {
            if (address_info.province_id == key) {
              break;
            }
            p++;
          }

          for (var key in area['zone' + address_info.province_id]) {
            if (address_info.city_id == key) {
              break;
            }
            c++;
          }
          for (var key in area['city' + address_info.city_id]) {
            if (address_info.district_id == key) {
              break;
            }
            d++;
          }
          that.setAreaData(p, c, d);
        } else {
          that.setAreaData(0, 0, 0, false);
          that.setData({
            "value": [0, 0, 0],
            "empty": true,

          });
        }
        wx.hideLoading();
      }
    })
  },


  //初始化区域数据。参数代表的是默认的区域例如0，0，0表示安徽………………
  setAreaData: function(px, cx, dx, s) {
    var p = px || 0 // provinceSelIndex
    var c = cx || 0 // citySelIndex
    var d = dx || 0 // districtSelIndex
    var that = this;
    // 设置省的数据
    var province = area['zone'];
    var provinceName = [];
    var provinceCode = [];
    for (var item in province) {
      provinceName.push(province[item])
      provinceCode.push(item)
    }

    this.setData({
      provinceName: provinceName,
      provinceCode: provinceCode
    })
    // 设置市的数据

    var city = area["zone" + provinceCode[p]];
    var cityName = [];
    var cityCode = [];
    for (var item in city) {
      cityName.push(city[item])
      cityCode.push(item)
    }
    this.setData({
      cityName: cityName,
      cityCode: cityCode
    })
    // 设置区的数据
    var district = area["city" + cityCode[c]]
    var districtName = [];
    var districtCode = [];
    for (var item in district) {
      districtName.push(district[item])
      districtCode.push(item)
    }
    this.setData({
      districtName: districtName,
      districtCode: districtCode
    });
    if (s === false) {
      that.setData({
        "value": [p, c, d]
      });
    } else {
      that.setData({
        "changedo": true
      });
      that.setData({
        provinceSelIndex: p,
        citySelIndex: c,
        districtSelIndex: d,
        "value": [p, c, d]
      });
    }
  },

  /**保存用户地址 */
  saveUserInfo: function(e) {
    var that = this;
    var data = e.detail.value
    var telRule = /^1[3|4|5|7|8]\d{9}$/,
      nameRule = /^[\u2E80-\u9FFF]+$/
    if (data.name == '') {
      wx.showToast({
        "title": '请输入姓名',
        "icon": "none"
      })
    } else if (data.tel == '') {
      wx.showToast({
        "title": '请输入手机号码',
        "icon": "none"
      })
    } else if (!telRule.test(data.tel)) {
      wx.showToast({
        "title": '手机号码格式不正确',
        "icon": "none"
      })
    } else if (data.province == '') {
      wx.showToast({
        "title": '请选择所在地区',
        "icon": "none"
      })
    } else if (data.city == '') {
      wx.showToast({
        "title": '请选择所在地区',
        "icon": "none"
      })
    } else {
      //组合地址数据
      var address_id = 0;
      if (that.data.edit_address_info) {
        address_id = that.data.edit_address_info.address_id;
      }
      var province_name = that.data.provinceName[that.data.provinceSelIndex];
      var city_name = that.data.cityName[that.data.citySelIndex];
      App.apiPost({
        "uri": "store/create_store.html",
        "data": {
          "user_name": data.name,
          "phone": data.tel,
          "province_id": data.province,
          "province": province_name,
          "city": city_name,
          "city_id": data.city,
          "pet_name": data.pet_name,
          "pet_type": data.pet_type,
          "pet_age": data.pet_age,
          "pet_sex": data.pet_sex,
          "pet_breed": data.pet_breed,
          "agent_status": that.data.userInfo.agent_status
        },
        "callback": function(res) {
          if (!res.error_code) {
            wx.showToast({
              title: '保存成功，等待审核',
              duration: 3000,
              mask: true,
              success: function() {
                //跳转到个人中心
                wx.switchTab({
                  url: "/pages/my/my",
                })
              }
            })
          } else {
            wx.showToast({
              title: '信息保存失败',
              icon: 'none',
              mask: true,
            })
          }
        }
      })
    }
  },

  //点击区域编辑框
  translate: function(e) {
    var that = this;
    if (that.data.userInfo.agent_status == "1") {
      return false;
    }
    if (t == 0) {
      moveY = 0;
      show = false;
      t = 1;
    } else {
      moveY = 200;
      show = true;
      t = 0;
    }
    console.log(show)
    animationEvents(this, moveY, show);
  },
  //隐藏弹窗浮层
  hiddenFloatView(e) {
    var that = this;
    moveY = 200;
    show = true;
    t = 0;
    p = that.data.value[0]
    c = that.data.value[1]
    d = that.data.value[2]
    this.setAreaData(p, c, d)
    animationEvents(this, moveY, show);
  },
  //改变区域
  changeArea: function(e) {
    p = e.detail.value[0]
    c = e.detail.value[1]
    d = e.detail.value[2]
    this.setAreaData(p, c, d)

  },
  /**性别选择 */
  bindPickerChange: function(e) {
    var that = this;
    var sex_index = e.detail.value;
    that.setData({
      sex_index: sex_index
    })
  },
  /**类别选择 */
  bindPickerChange1: function(e) {
    var that = this;
    var cate_index = e.detail.value;
    that.setData({
      cate_index: cate_index
    })
  },
})
//动画事件
function animationEvents(that, moveY, show) {
  // console.log("moveY:" + moveY + "\nshow:" + show);
  that.animation = wx.createAnimation({
    transformOrigin: "50% 50%",
    duration: 400,
    timingFunction: "ease",
    delay: 0
  })
  that.animation.translateY(moveY + 'vh').step()

  that.setData({
    animation: that.animation.export(),
    show: show
  })

}