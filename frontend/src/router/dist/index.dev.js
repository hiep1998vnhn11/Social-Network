"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;

var _vue = _interopRequireDefault(require("vue"));

var _vueRouter = _interopRequireDefault(require("vue-router"));

var _Index = _interopRequireDefault(require("@/views/about/Index"));

var _Index2 = _interopRequireDefault(require("@/views/app/Index"));

var _Login = _interopRequireDefault(require("@/components/User/Login"));

var _Register = _interopRequireDefault(require("@/components/User/Register"));

var _Profile = _interopRequireDefault(require("@/components/User/Profile"));

var _Logout = _interopRequireDefault(require("@/components/User/Logout"));

var _Home = _interopRequireDefault(require("@/components/Home/Home"));

var _Index3 = _interopRequireDefault(require("@/views/404/Index"));

var _Post = _interopRequireDefault(require("@/components/Post/Post"));

var _Message = _interopRequireDefault(require("@/components/Message/Message"));

var _MyProfile = _interopRequireDefault(require("@/components/User/MyProfile"));

var _Test = _interopRequireDefault(require("@/components/Test"));

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }

_vue["default"].use(_vueRouter["default"]);

var routes = [{
  path: '/about',
  component: _Index["default"]
}, {
  path: '/',
  component: _Index2["default"],
  name: 'App',
  meta: {
    requiresVisitor: true
  }
}, {
  path: '/home',
  component: _Home["default"],
  name: 'Home',
  meta: {
    requiresAuth: true
  }
}, {
  path: '/login',
  component: _Login["default"],
  name: 'Login',
  meta: {
    requiresVisitor: true
  }
}, {
  path: '/logout',
  component: _Logout["default"]
}, {
  path: '/register',
  component: _Register["default"],
  name: 'Register',
  meta: {
    requiresVisitor: true
  }
}, {
  path: '/user/:url',
  name: 'User_profile',
  component: _Profile["default"]
}, {
  path: '/post/:post_id',
  name: 'Param_Post',
  component: _Post["default"]
}, {
  path: '/message',
  name: 'Message',
  component: _Message["default"],
  meta: {
    requiresAuth: true
  }
}, {
  path: '/myprofile',
  name: 'MyProfile',
  component: _MyProfile["default"],
  meta: {
    requiresAuth: true
  }
}, {
  path: '/test',
  name: 'Test',
  component: _Test["default"]
}, {
  path: '*',
  name: 'FOF',
  component: _Index3["default"]
}];
var router = new _vueRouter["default"]({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: routes
});
var _default = router;
exports["default"] = _default;