<?php


namespace app\api\validate;


class wxjs
{
//index.js
////获取应用实例
//    const app = getApp()
//var baseUrl = 'http://z.cn/api/v1';
//Page({
// data: {
//   motto: 'Hello World',
//   userInfo: {},
//hasUserInfo: false,
//   canIUse: wx.canIUse('button.open-type.getUserInfo')
// },
// //事件处理函数
// checkSession:function(){    //判断是否是登录状态
//    wx.checkSession({
//      success:function(){
//        console.log('session success')
//      },
//      fail:function(){
//        console.log('session fail');
//    }
//    });
//
// },
// getSuperToken:function(){
//    wx.request({
//       url: baseUrl + '/token/app',
//       data:{
//        ac:'warcraft',
//                se:'777'
//       },
//       method:'post',
//       success:function(res){
//        console.log(res.data);
//        wx.setStorageSync('super_token', res.data.token);
//    },
//       fail:function(){
//        //fail
//    },
//       complete:function(){
//        //complete
//    }
//
//     })
// },
// pay:function(){
//    var token = wx.getStorageSync('token');
//    var that = this;
//    wx.request({
//       url: baseUrl +'/order?XDEBUG_SESSION_START=18953',
//       header:{
//        token:token
//       },
//       data:{
//        products:[
//           {product_id:1,count:2},
//           {product_id:2, count:3}
//         ]
//       },
//       method:'POST',
//       success: function (res) {
//        console.log(res.data);
//        //  if(res.data.pass){
//        //    wx.setStorageSync('order_id',res.data.order_id);
//
//        //  }else{
//        //    console.log('订单创建失败');
//        //  }
//    },
//       fail: function (res) {
//        console.log(res.data);
//    }
//     })
//
// },
// getToken:function(){     //登录
//    wx.login({
//     success: res => {
//        // 发送 res.code 到后台换取 openId, sessionKey, unionId
//        console.log('res', res);
//        var code = res.code;
//        console.log('code',code);
//        wx.request({
//         url: baseUrl +'/token/user?XDEBUG_SESSION_START=15940',
//         data: {
//            code: code
//         },
//         method: 'POST',
//         success: function (res) {
//            console.log(res.data);
//            wx.setStorageSync('token', res.data.token);
//        },
//         fail:function(res){
//            console.log(res.data);
//        }
//
//
//       })
//     }
//   })
// },
// bindViewTap: function() {
//    wx.navigateTo({
//     url: '../logs/logs'
//   })
// },
// onLoad: function () {
//    if (app.globalData.userInfo) {
//        this.setData({
//       userInfo: app.globalData.userInfo,
//       hasUserInfo: true
//     })
//   } else if (this.data.canIUse){
//        // 由于 getUserInfo 是网络请求，可能会在 Page.onLoad 之后才返回
//        // 所以此处加入 callback 以防止这种情况
//        app.userInfoReadyCallback = res => {
//            this.setData({
//         userInfo: res.userInfo,
//         hasUserInfo: true
//       })
//     }
//   } else {
//        // 在没有 open-type=getUserInfo 版本的兼容处理
//        wx.getUserInfo({
//       success: res => {
//            app.globalData.userInfo = res.userInfo
//         this.setData({
//           userInfo: res.userInfo,
//           hasUserInfo: true
//         })
//       }
//     })
//   }
//},
// getUserInfo: function(e) {
//    console.log(e)
//   app.globalData.userInfo = e.detail.userInfo
//   this.setData({
//     userInfo: e.detail.userInfo,
//     hasUserInfo: true
//   })
// }
//})

}