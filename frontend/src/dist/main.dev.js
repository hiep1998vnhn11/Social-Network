"use strict";

var _vue = _interopRequireDefault(require("vue"));

var _App = _interopRequireDefault(require("./App.vue"));

var _router = _interopRequireDefault(require("./router"));

var _store = _interopRequireDefault(require("./store"));

var _vuetify = _interopRequireDefault(require("./plugins/vuetify"));

var _axios = _interopRequireDefault(require("axios"));

var _jsCookie = _interopRequireDefault(require("js-cookie"));

var _vueSweetalert = _interopRequireDefault(require("vue-sweetalert2"));

var _i18n = _interopRequireDefault(require("./lang/i18n"));

var _vueDatetime = require("vue-datetime");

require("vue-datetime/dist/vue-datetime.css");

var _vueFilterDateFormat = _interopRequireDefault(require("vue-filter-date-format"));

var _vueSocialAuth = _interopRequireDefault(require("vue-social-auth"));

var _vueAxios = _interopRequireDefault(require("vue-axios"));

require("./plugins");

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }

_vue["default"].config.productionTip = false;

_vue["default"].use(_jsCookie["default"]);

_vue["default"].use(_vueSocialAuth["default"], {
  providers: {
    github: {
      clientId: '',
      redirectUri: '/auth/github/callback' // Your client app URL

    }
  }
});

_vue["default"].use(_vueSweetalert["default"]);

_vue["default"].use(_vueDatetime.Datetime, _vueAxios["default"]);

_vue["default"].use(_vueFilterDateFormat["default"], {
  dayOfWeekNames: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
  dayOfWeekNamesShort: ['Su', 'Mo', 'Tu', 'We', 'Tr', 'Fr', 'Sa'],
  monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
  monthNamesShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
});

_vue["default"].component('datetime', _vueDatetime.Datetime);

_axios["default"].defaults.baseURL = 'http://dev.socialnetwork.api.com/api';

_router["default"].beforeEach(function (to, from, next) {
  if (to.matched.some(function (record) {
    return record.meta.requiresAuth;
  })) {
    if (!_store["default"].getters.loggedIn) {
      next({
        name: 'Login'
      });
    } else {
      next();
    }
  } else if (to.matched.some(function (record) {
    return record.meta.requiresVisitor;
  })) {
    if (_store["default"].getters.loggedIn) {
      next({
        name: 'Profile'
      });
    } else {
      next();
    }
  } else {
    next();
  }
});

new _vue["default"]({
  router: _router["default"],
  store: _store["default"],
  i18n: _i18n["default"],
  vuetify: _vuetify["default"],
  render: function render(h) {
    return h(_App["default"]);
  }
}).$mount('#app');