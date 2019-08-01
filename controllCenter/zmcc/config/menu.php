<?php

/*
 * 系统管理菜单配置文件
 * 每一组菜单用一个systemMenu的元素，结构参照如下
 * 当item数组未定义表示为一级菜单 
 */
//控制台
$config['systemMenu'][] = array(
    "group" => "控制面板",
    "controller" => "Welcome",
    "method" => "index",
    "icon" => '',
);
//商品管理
$config['systemMenu'][] = array(
    "group" => "商品管理",
    "icon" => 'shopping-bag',
    "items" => array(
        array(
            "title" => "商品分类",
            "icon" => 'navicon',
            "controller" => "Category",
            "method" => "index",
            "blank" => false
        ),
        array(
            "title" => "商品管理",
            "icon" => 'shopping-bag',
            "controller" => "Product",
            "method" => "index",
            "blank" => false
        ),
        array(
            "title" => "商品回收站",
            "icon" => 'trash',
            "controller" => "ProductRecycle",
            "method" => "index",
            "blank" => false
        ),
        array(
            "title" => "商品类型",
            "icon" => 'tags',
            "controller" => "CommodityTyp",
            "method" => "index",
            "blank" => false
        ),
        array(
            "title" => "商品标签",
            "icon" => 'tags',
            "controller" => "Tag",
            "method" => "index",
            "blank" => false
        ),
        array(
            "title" => "商品评论",
            "icon" => 'commenting',
            "controller" => "Comment",
            "method" => "index",
            "blank" => false
        ),
        array(
            "title" => "商品销售排行",
            "icon" => '',
            "controller" => "ProductRankings",
            "method" => "index",
            "blank" => false
        ),
    )
);
//订单管理
$config['systemMenu'][] = array(
    "group" => "销售管理",
    "icon" => 'shopping-cart',
    "items" => array(
        array(
            "title" => "订单管理",
            "icon" => 'list',
            "controller" => "Order",
            "method" => "index",
            "blank" => false
        ),
        array(
            "title" => "拼团订单",
            "icon" => 'list',
            "controller" => "GroupOrder",
            "method" => "index",
            "blank" => false
        ),
        array(
            "title" => "砍价订单",
            "icon" => 'list',
            "controller" => "KillOrder",
            "method" => "index",
            "blank" => false
        ),
        array(
            "title" => "退换订单",
            "icon" => 'list-ul',
            "controller" => "Order",
            "method" => "refundsOrder",
            "blank" => false
        ),
    )
);
$config['systemMenu'][] = array(
    "group" => "会员管理",
    "controller" => "",
    "method" => "",
    "icon" => 'user',
    "items" => array(
        array(
            "title" => "会员管理",
            "icon" => 'podcast',
            "controller" => "User",
            "method" => "index",
            "blank" => false
        ),
        array(
            "title" => "会员分组",
            "icon" => 'group',
            "controller" => "UserGroup",
            "method" => "index",
            "blank" => false
        ),
//        array(
//            "title" => "会员等级",
//            "icon" => 'sort-amount-asc',
//            "controller" => "UserLevel",
//            "method" => "index",
//            "blank" => false
//        ),
        array(
            "title" => "提现申请",
            "icon" => 'whatsapp',
            "controller" => "cashApplication",
            "method" => "index",
            "blank" => false
        ),
    )
);
$config['systemMenu'][] = array(
    "group" => "营销管理",
    "icon" => 'shopping-cart',
    "items" => array(
        array(
            "title" => "优惠券",
            "icon" => 'cc',
            "controller" => "Coupon",
            "method" => "index",
            "blank" => false
        ),
        array(
            "title" => "营销活动",
            "icon" => 'cart-plus',
            "controller" => "Marketing",
            "method" => "index",
            "blank" => false
        ),
//        array(
//            "title" => "充值策略",
//            "icon" => 'cart-plus',
//            "controller" => "RechargeStrategy",
//            "method" => "index",
//            "blank" => false
//        ),
        array(
            "title" => "限时秒杀",
            "icon" => 'clock-o',
            "controller" => "TimelimitProduct",
            "method" => "index",
            "blank" => false
        ),
        array(
            "title" => "线上拼团",
            "icon" => 'shopping-bag',
            "controller" => "GroupProduct",
            "method" => "index",
            "blank" => false
        ),
        array(
            "title" => "助力砍价",
            "icon" => 'legal',
            "controller" => "KillProduct",
            "method" => "index",
            "blank" => false
        ),
    )
);
//$config['systemMenu'][] = array(
//    "group" => "内容管理",
//    "icon" => 'book',
//    "items" => array(
//        array(
//            "title" => "文章管理",
//            "icon" => 'newspaper-o',
//            "controller" => "Article",
//            "method" => "index",
//            "blank" => false
//        ),
//        array(
//            "title" => "文章分类管理",
//            "icon" => 'navicon',
//            "controller" => "ArticleCategory",
//            "method" => "index",
//            "blank" => false
//        ),
//        array(
//            "title" => "博客管理",
//            "icon" => 'map-o',
//            "controller" => "Blog",
//            "method" => "index",
//            "blank" => false
//        ),
//        array(
//            "title" => "博客分类管理",
//            "icon" => 'folder-o',
//            "controller" => "BlogCategory",
//            "method" => "index",
//            "blank" => false
//        ),
//        array(
//            "title" => "线下活动",
//            "icon" => 'handshake-o',
//            "controller" => "Activity",
//            "method" => "index",
//            "blank" => false
//        ), array(
//            "title" => "报名列表",
//            "icon" => 'navicon',
//            "controller" => "ActivityOrder",
//            "method" => "index",
//            "blank" => false
//        ),
//    )
//);


$config['systemMenu'][] = array(
    "group" => "分销管理",
    "icon" => 'hdd-o',
    "items" => array(
//        array(
//            "title" => "分销商店铺",
//            "icon" => 'database',
//            "controller" => "Store",
//            "method" => "index",
//            "blank" => false
//        ),
        array(
            "title" => "分销商等级",
            "icon" => 'laptop',
            "controller" => "AgentGroup",
            "method" => "index",
            "blank" => false
        ),
        array(
            "title" => "分销商管理",
            "icon" => 'inbox',
            "controller" => "Agent",
            "method" => "index",
            "blank" => false
        ),
    ),
);

//$config['systemMenu'][] = array(
//    "group" => "供货商管理",
//    "icon" => 'suitcase',
//    "controller" => "Supplier",
//    "method" => "index",
//    "blank" => false
//);


$config['systemMenu'][] = array(
    "group" => "支付管理",
    "controller" => "Payment",
    "method" => "paymentList",
    "icon" => 'cc-paypal',
    "items" => array(
    )
);

$config['systemMenu'][] = array(
    "group" => "配送区域费用管理",
    "controller" => "Logistics",
    "method" => "getList",
    "icon" => 'deaf',
    "items" => array(
    )
);

$config['systemMenu'][] = array(
    "group" => "广告管理",
    "controller" => "Logistics",
    "method" => "getList",
    "icon" => 'deaf',
    "items" => array(
        array(
            "title" => "广告管理",
            "icon" => 'laptop',
            "controller" => "Advert",
            "method" => "getAdvertList",
            "blank" => false
        ),
        array(
            "title" => "广告位管理",
            "icon" => 'laptop',
            "controller" => "Advert",
            "method" => "getPositionList",
            "blank" => false
        ),
    )
);

//$config['systemMenu'][] = array(
//    "group" => "微信公众号小程序",
//    "controller" => "",
//    "method" => "",
//    "icon" => 'deaf',
//    "items" => array(
//        array(
//            "title" => "公众号用户",
//            "icon" => 'laptop',
//            "controller" => "Wechat",
//            "method" => "getMpuser",
//            "blank" => false
//        ),
//        array(
//            "title" => "小程序用户",
//            "icon" => 'laptop',
//            "controller" => "Wechat",
//            "method" => "Wechat",
//            "blank" => false
//        ),
//        array(
//            "title" => "公众号自定义菜单",
//            "icon" => 'laptop',
//            "controller" => "Wechat",
//            "method" => "getPositionList",
//            "blank" => false
//        ),
//        array(
//            "title" => "公众号模板消息",
//            "icon" => 'laptop',
//            "controller" => "Wechat",
//            "method" => "getPositionList",
//            "blank" => false
//        ),
//        array(
//            "title" => "公众号自动回复",
//            "icon" => 'laptop',
//            "controller" => "Wechat",
//            "method" => "autoReply",
//            "blank" => false
//        ),
//        array(
//            "title" => "小程序消息",
//            "icon" => 'laptop',
//            "controller" => "Wechat",
//            "method" => "getPositionList",
//            "blank" => false
//        )
//    )
//);
//系统参数配置
$config['systemMenu'][] = array(
    "group" => "系统配置",
    "controller" => "",
    "method" => "",
    "icon" => 'cogs',
    "items" => array(
        array(
            "title" => "参数配置",
            "icon" => 'database',
            "controller" => "Setting",
            "method" => "setting",
            "blank" => false
        ),
        array(
            "title" => "参数项管理",
            "icon" => 'cog',
            "controller" => "Setting",
            "method" => "settingList",
            "blank" => false
        ),
        array(
            "title" => "Api接口管理",
            "icon" => 'cube',
            "controller" => "Api",
            "method" => "index",
            "blank" => false
        ),
    )
);
//管理员管理
$config['systemMenu'][] = array(
    "group" => "管理员管理",
    "controller" => "",
    "method" => "",
    "icon" => 'cogs',
    "items" => array(
        array(
            "title" => "管理员管理",
            "icon" => 'database',
            "controller" => "Admin",
            "method" => "index",
            "blank" => false
        ),
        array(
            "title" => "角色管理",
            "icon" => 'cog',
            "controller" => "Role",
            "method" => "index",
            "blank" => false
        ),
    )
);
