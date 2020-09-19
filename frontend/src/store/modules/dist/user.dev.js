"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;

var _axios = _interopRequireDefault(require("axios"));

var _jsCookie = _interopRequireDefault(require("js-cookie"));

var _vue = _interopRequireDefault(require("vue"));

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }

var state = {
  users: [],
  currentUser: null,
  paramUser: [],
  token: _jsCookie["default"].get('access_token') || null,
  setHeader: function setHeader() {
    _axios["default"].defaults.headers.common['Authorization'] = 'Bearer' + _jsCookie["default"].get('access_token');
  }
};
var getters = {
  allUser: function allUser(state) {
    return state.users;
  },
  currentUser: function currentUser(state) {
    return state.currentUser;
  },
  paramUser: function paramUser(state) {
    return state.paramUser;
  },
  loggedIn: function loggedIn(state) {
    return state.token !== null;
  }
};
var actions = {
  fetchUser: function fetchUser(context) {
    var response;
    return regeneratorRuntime.async(function fetchUser$(_context) {
      while (1) {
        switch (_context.prev = _context.next) {
          case 0:
            _context.next = 2;
            return regeneratorRuntime.awrap(_axios["default"].get('/get_users'));

          case 2:
            response = _context.sent;
            context.commit('SET_USER', response.data.data);

          case 4:
          case "end":
            return _context.stop();
        }
      }
    });
  },
  getParamUser: function getParamUser(_ref, payload) {
    var commit, url, response;
    return regeneratorRuntime.async(function getParamUser$(_context2) {
      while (1) {
        switch (_context2.prev = _context2.next) {
          case 0:
            commit = _ref.commit;
            url = '/get_users';
            _context2.next = 4;
            return regeneratorRuntime.awrap(_axios["default"].get(url, payload));

          case 4:
            response = _context2.sent;
            commit('SET_PARAM_USER', response.data.data);

          case 6:
          case "end":
            return _context2.stop();
        }
      }
    });
  },
  getCurrentUser: function getCurrentUser(context) {
    var currentUserApi;
    return regeneratorRuntime.async(function getCurrentUser$(_context3) {
      while (1) {
        switch (_context3.prev = _context3.next) {
          case 0:
            context.state.setHeader();
            _context3.next = 3;
            return regeneratorRuntime.awrap(_axios["default"].post('/auth/me'));

          case 3:
            currentUserApi = _context3.sent;
            context.commit('SET_CURRENT_USER', currentUserApi.data);

          case 5:
          case "end":
            return _context3.stop();
        }
      }
    });
  },
  login: function login(_ref2, user) {
    var commit, auth, token, UserApi;
    return regeneratorRuntime.async(function login$(_context4) {
      while (1) {
        switch (_context4.prev = _context4.next) {
          case 0:
            commit = _ref2.commit;
            _context4.prev = 1;
            _context4.next = 4;
            return regeneratorRuntime.awrap(_axios["default"].post('/auth/login', {
              email: user.email,
              password: user.password
            }));

          case 4:
            auth = _context4.sent;
            token = auth.data.access_token;
            _axios["default"].defaults.headers.common['Authorization'] = 'Bearer' + token;
            _context4.next = 9;
            return regeneratorRuntime.awrap(_axios["default"].post('/auth/me'));

          case 9:
            UserApi = _context4.sent;

            _jsCookie["default"].set('access_token', token);

            commit('RETRIEVE_TOKEN', token);
            commit('SET_CURRENT_USER', UserApi.data);
            _context4.next = 18;
            break;

          case 15:
            _context4.prev = 15;
            _context4.t0 = _context4["catch"](1);

            _vue["default"].swal({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong with server... Please try another time...',
              footer: '<a href>How can I fix this issue?</a>'
            });

          case 18:
          case "end":
            return _context4.stop();
        }
      }
    }, null, null, [[1, 15]]);
  },
  register: function register(context, data) {
    var authRegister;
    return regeneratorRuntime.async(function register$(_context5) {
      while (1) {
        switch (_context5.prev = _context5.next) {
          case 0:
            _context5.next = 2;
            return regeneratorRuntime.awrap(_axios["default"].post('/register', {
              name: data.name,
              email: data.email,
              password: data.password,
              password_confirmation: data.password_confirmation
            }));

          case 2:
            authRegister = _context5.sent;
            console.log(authRegister.data.message);

          case 4:
          case "end":
            return _context5.stop();
        }
      }
    });
  },
  deleteUser: function deleteUser(context, idUser) {
    var deleteUserApi;
    return regeneratorRuntime.async(function deleteUser$(_context6) {
      while (1) {
        switch (_context6.prev = _context6.next) {
          case 0:
            context.state.setHeader();
            _context6.next = 3;
            return regeneratorRuntime.awrap(_axios["default"].post("/admin/delete/".concat(idUser)));

          case 3:
            deleteUserApi = _context6.sent;
            console.log(deleteUserApi.data);
            context.commit('REMOVE_USER', idUser);

          case 6:
          case "end":
            return _context6.stop();
        }
      }
    });
  },
  destroyToken: function destroyToken(context) {
    context.state.setHeader();

    if (context.getters.loggedIn) {
      return new Promise(function (resolve, reject) {
        _axios["default"].post('/auth/logout').then(function (response) {
          _jsCookie["default"].remove('access_token');

          context.commit('DESTROY_TOKEN');
          resolve(response); // console.log(token)
          //console.log(response);
        })["catch"](function (error) {
          // console.log(error);
          _jsCookie["default"].remove('access_token');

          context.commit('DESTROY_TOKEN');
          reject(error);
        });
      });
    }
  }
};
var mutations = {
  SET_CURRENT_USER: function SET_CURRENT_USER(state, currentUser) {
    return state.currentUser = currentUser;
  },
  RETRIEVE_TOKEN: function RETRIEVE_TOKEN(state, token) {
    return state.token = token;
  },
  DESTROY_TOKEN: function DESTROY_TOKEN(state) {
    state.token = null, state.currentUser = null, state.users = [];
  },
  SET_USER: function SET_USER(state, users) {
    return state.users = users;
  },
  SET_PARAM_USER: function SET_PARAM_USER(state, paramUser) {
    return state.paramUser = paramUser;
  },
  REMOVE_USER: function REMOVE_USER(state, idUser) {
    return state.users = state.users.filter(function (users) {
      return users.id != idUser;
    });
  }
};
var _default = {
  state: state,
  getters: getters,
  actions: actions,
  mutations: mutations
};
exports["default"] = _default;