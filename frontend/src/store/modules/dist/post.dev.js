"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;

var _axios = _interopRequireDefault(require("axios"));

var _jsCookie = _interopRequireDefault(require("js-cookie"));

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }

var state = {
  posts: [],
  paramPost: null,
  setHeader: function setHeader() {
    _axios["default"].defaults.headers.common['Authorization'] = 'Bearer' + _jsCookie["default"].get('access_token');
  }
};
var getters = {
  allPosts: function allPosts(state) {
    return state.posts;
  },
  paramPost: function paramPost(state) {
    return state.paramPost;
  }
};
var actions = {
  getPost: function getPost(context) {
    var url, response;
    return regeneratorRuntime.async(function getPost$(_context) {
      while (1) {
        switch (_context.prev = _context.next) {
          case 0:
            context.state.setHeader();
            url = '/auth/user/post/get';
            _context.next = 4;
            return regeneratorRuntime.awrap(_axios["default"].get(url));

          case 4:
            response = _context.sent;
            context.commit('SET_POST', response.data);

          case 6:
          case "end":
            return _context.stop();
        }
      }
    });
  },
  getParamPost: function getParamPost(_ref, payload) {
    var commit, state, url, response;
    return regeneratorRuntime.async(function getParamPost$(_context2) {
      while (1) {
        switch (_context2.prev = _context2.next) {
          case 0:
            commit = _ref.commit, state = _ref.state;
            state.setHeader();
            url = '/get_posts';
            _context2.next = 5;
            return regeneratorRuntime.awrap(_axios["default"].get(url, payload));

          case 5:
            response = _context2.sent;
            commit('SET_PARAM_POST', response.data.data);

          case 7:
          case "end":
            return _context2.stop();
        }
      }
    });
  }
};
var mutations = {
  SET_POST: function SET_POST(state, posts) {
    return state.posts = posts;
  },
  SET_PARAM_POST: function SET_PARAM_POST(state, paramPost) {
    return state.paramPost = paramPost;
  }
};
var _default = {
  state: state,
  getters: getters,
  actions: actions,
  mutations: mutations
};
exports["default"] = _default;