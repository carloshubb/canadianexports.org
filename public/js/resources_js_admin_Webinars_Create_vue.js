"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_admin_Webinars_Create_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/Webinars/Create.vue?vue&type=script&lang=js":
/*!****************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/Webinars/Create.vue?vue&type=script&lang=js ***!
  \****************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Layouts_App_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../Layouts/App.vue */ "./resources/js/admin/Layouts/App.vue");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var vue_filepond__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vue-filepond */ "./node_modules/vue-filepond/dist/vue-filepond.js");
/* harmony import */ var vue_filepond__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(vue_filepond__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var filepond_plugin_file_validate_type_dist_filepond_plugin_file_validate_type_esm_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.esm.js */ "./node_modules/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.esm.js");
/* harmony import */ var filepond_plugin_image_preview_dist_filepond_plugin_image_preview_esm_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! filepond-plugin-image-preview/dist/filepond-plugin-image-preview.esm.js */ "./node_modules/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.esm.js");
/* harmony import */ var filepond_dist_filepond_min_css__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! filepond/dist/filepond.min.css */ "./node_modules/filepond/dist/filepond.min.css");
/* harmony import */ var filepond_plugin_image_preview_dist_filepond_plugin_image_preview_min_css__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css */ "./node_modules/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css");
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _slicedToArray(r, e) { return _arrayWithHoles(r) || _iterableToArrayLimit(r, e) || _unsupportedIterableToArray(r, e) || _nonIterableRest(); }
function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }
function _unsupportedIterableToArray(r, a) { if (r) { if ("string" == typeof r) return _arrayLikeToArray(r, a); var t = {}.toString.call(r).slice(8, -1); return "Object" === t && r.constructor && (t = r.constructor.name), "Map" === t || "Set" === t ? Array.from(r) : "Arguments" === t || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t) ? _arrayLikeToArray(r, a) : void 0; } }
function _arrayLikeToArray(r, a) { (null == a || a > r.length) && (a = r.length); for (var e = 0, n = Array(a); e < a; e++) n[e] = r[e]; return n; }
function _iterableToArrayLimit(r, l) { var t = null == r ? null : "undefined" != typeof Symbol && r[Symbol.iterator] || r["@@iterator"]; if (null != t) { var e, n, i, u, a = [], f = !0, o = !1; try { if (i = (t = t.call(r)).next, 0 === l) { if (Object(t) !== t) return; f = !1; } else for (; !(f = (e = i.call(t)).done) && (a.push(e.value), a.length !== l); f = !0); } catch (r) { o = !0, n = r; } finally { try { if (!f && null != t["return"] && (u = t["return"](), Object(u) !== u)) return; } finally { if (o) throw n; } } return a; } }
function _arrayWithHoles(r) { if (Array.isArray(r)) return r; }
function ownKeys(e, r) { var t = Object.keys(e); if (Object.getOwnPropertySymbols) { var o = Object.getOwnPropertySymbols(e); r && (o = o.filter(function (r) { return Object.getOwnPropertyDescriptor(e, r).enumerable; })), t.push.apply(t, o); } return t; }
function _objectSpread(e) { for (var r = 1; r < arguments.length; r++) { var t = null != arguments[r] ? arguments[r] : {}; r % 2 ? ownKeys(Object(t), !0).forEach(function (r) { _defineProperty(e, r, t[r]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(t)) : ownKeys(Object(t)).forEach(function (r) { Object.defineProperty(e, r, Object.getOwnPropertyDescriptor(t, r)); }); } return e; }
function _defineProperty(e, r, t) { return (r = _toPropertyKey(r)) in e ? Object.defineProperty(e, r, { value: t, enumerable: !0, configurable: !0, writable: !0 }) : e[r] = t, e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return e; }; var t, e = {}, r = Object.prototype, n = r.hasOwnProperty, o = Object.defineProperty || function (t, e, r) { t[e] = r.value; }, i = "function" == typeof Symbol ? Symbol : {}, a = i.iterator || "@@iterator", c = i.asyncIterator || "@@asyncIterator", u = i.toStringTag || "@@toStringTag"; function define(t, e, r) { return Object.defineProperty(t, e, { value: r, enumerable: !0, configurable: !0, writable: !0 }), t[e]; } try { define({}, ""); } catch (t) { define = function define(t, e, r) { return t[e] = r; }; } function wrap(t, e, r, n) { var i = e && e.prototype instanceof Generator ? e : Generator, a = Object.create(i.prototype), c = new Context(n || []); return o(a, "_invoke", { value: makeInvokeMethod(t, r, c) }), a; } function tryCatch(t, e, r) { try { return { type: "normal", arg: t.call(e, r) }; } catch (t) { return { type: "throw", arg: t }; } } e.wrap = wrap; var h = "suspendedStart", l = "suspendedYield", f = "executing", s = "completed", y = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var p = {}; define(p, a, function () { return this; }); var d = Object.getPrototypeOf, v = d && d(d(values([]))); v && v !== r && n.call(v, a) && (p = v); var g = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(p); function defineIteratorMethods(t) { ["next", "throw", "return"].forEach(function (e) { define(t, e, function (t) { return this._invoke(e, t); }); }); } function AsyncIterator(t, e) { function invoke(r, o, i, a) { var c = tryCatch(t[r], t, o); if ("throw" !== c.type) { var u = c.arg, h = u.value; return h && "object" == _typeof(h) && n.call(h, "__await") ? e.resolve(h.__await).then(function (t) { invoke("next", t, i, a); }, function (t) { invoke("throw", t, i, a); }) : e.resolve(h).then(function (t) { u.value = t, i(u); }, function (t) { return invoke("throw", t, i, a); }); } a(c.arg); } var r; o(this, "_invoke", { value: function value(t, n) { function callInvokeWithMethodAndArg() { return new e(function (e, r) { invoke(t, n, e, r); }); } return r = r ? r.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(e, r, n) { var o = h; return function (i, a) { if (o === f) throw Error("Generator is already running"); if (o === s) { if ("throw" === i) throw a; return { value: t, done: !0 }; } for (n.method = i, n.arg = a;;) { var c = n.delegate; if (c) { var u = maybeInvokeDelegate(c, n); if (u) { if (u === y) continue; return u; } } if ("next" === n.method) n.sent = n._sent = n.arg;else if ("throw" === n.method) { if (o === h) throw o = s, n.arg; n.dispatchException(n.arg); } else "return" === n.method && n.abrupt("return", n.arg); o = f; var p = tryCatch(e, r, n); if ("normal" === p.type) { if (o = n.done ? s : l, p.arg === y) continue; return { value: p.arg, done: n.done }; } "throw" === p.type && (o = s, n.method = "throw", n.arg = p.arg); } }; } function maybeInvokeDelegate(e, r) { var n = r.method, o = e.iterator[n]; if (o === t) return r.delegate = null, "throw" === n && e.iterator["return"] && (r.method = "return", r.arg = t, maybeInvokeDelegate(e, r), "throw" === r.method) || "return" !== n && (r.method = "throw", r.arg = new TypeError("The iterator does not provide a '" + n + "' method")), y; var i = tryCatch(o, e.iterator, r.arg); if ("throw" === i.type) return r.method = "throw", r.arg = i.arg, r.delegate = null, y; var a = i.arg; return a ? a.done ? (r[e.resultName] = a.value, r.next = e.nextLoc, "return" !== r.method && (r.method = "next", r.arg = t), r.delegate = null, y) : a : (r.method = "throw", r.arg = new TypeError("iterator result is not an object"), r.delegate = null, y); } function pushTryEntry(t) { var e = { tryLoc: t[0] }; 1 in t && (e.catchLoc = t[1]), 2 in t && (e.finallyLoc = t[2], e.afterLoc = t[3]), this.tryEntries.push(e); } function resetTryEntry(t) { var e = t.completion || {}; e.type = "normal", delete e.arg, t.completion = e; } function Context(t) { this.tryEntries = [{ tryLoc: "root" }], t.forEach(pushTryEntry, this), this.reset(!0); } function values(e) { if (e || "" === e) { var r = e[a]; if (r) return r.call(e); if ("function" == typeof e.next) return e; if (!isNaN(e.length)) { var o = -1, i = function next() { for (; ++o < e.length;) if (n.call(e, o)) return next.value = e[o], next.done = !1, next; return next.value = t, next.done = !0, next; }; return i.next = i; } } throw new TypeError(_typeof(e) + " is not iterable"); } return GeneratorFunction.prototype = GeneratorFunctionPrototype, o(g, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), o(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, u, "GeneratorFunction"), e.isGeneratorFunction = function (t) { var e = "function" == typeof t && t.constructor; return !!e && (e === GeneratorFunction || "GeneratorFunction" === (e.displayName || e.name)); }, e.mark = function (t) { return Object.setPrototypeOf ? Object.setPrototypeOf(t, GeneratorFunctionPrototype) : (t.__proto__ = GeneratorFunctionPrototype, define(t, u, "GeneratorFunction")), t.prototype = Object.create(g), t; }, e.awrap = function (t) { return { __await: t }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, c, function () { return this; }), e.AsyncIterator = AsyncIterator, e.async = function (t, r, n, o, i) { void 0 === i && (i = Promise); var a = new AsyncIterator(wrap(t, r, n, o), i); return e.isGeneratorFunction(r) ? a : a.next().then(function (t) { return t.done ? t.value : a.next(); }); }, defineIteratorMethods(g), define(g, u, "Generator"), define(g, a, function () { return this; }), define(g, "toString", function () { return "[object Generator]"; }), e.keys = function (t) { var e = Object(t), r = []; for (var n in e) r.push(n); return r.reverse(), function next() { for (; r.length;) { var t = r.pop(); if (t in e) return next.value = t, next.done = !1, next; } return next.done = !0, next; }; }, e.values = values, Context.prototype = { constructor: Context, reset: function reset(e) { if (this.prev = 0, this.next = 0, this.sent = this._sent = t, this.done = !1, this.delegate = null, this.method = "next", this.arg = t, this.tryEntries.forEach(resetTryEntry), !e) for (var r in this) "t" === r.charAt(0) && n.call(this, r) && !isNaN(+r.slice(1)) && (this[r] = t); }, stop: function stop() { this.done = !0; var t = this.tryEntries[0].completion; if ("throw" === t.type) throw t.arg; return this.rval; }, dispatchException: function dispatchException(e) { if (this.done) throw e; var r = this; function handle(n, o) { return a.type = "throw", a.arg = e, r.next = n, o && (r.method = "next", r.arg = t), !!o; } for (var o = this.tryEntries.length - 1; o >= 0; --o) { var i = this.tryEntries[o], a = i.completion; if ("root" === i.tryLoc) return handle("end"); if (i.tryLoc <= this.prev) { var c = n.call(i, "catchLoc"), u = n.call(i, "finallyLoc"); if (c && u) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } else if (c) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); } else { if (!u) throw Error("try statement without catch or finally"); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } } } }, abrupt: function abrupt(t, e) { for (var r = this.tryEntries.length - 1; r >= 0; --r) { var o = this.tryEntries[r]; if (o.tryLoc <= this.prev && n.call(o, "finallyLoc") && this.prev < o.finallyLoc) { var i = o; break; } } i && ("break" === t || "continue" === t) && i.tryLoc <= e && e <= i.finallyLoc && (i = null); var a = i ? i.completion : {}; return a.type = t, a.arg = e, i ? (this.method = "next", this.next = i.finallyLoc, y) : this.complete(a); }, complete: function complete(t, e) { if ("throw" === t.type) throw t.arg; return "break" === t.type || "continue" === t.type ? this.next = t.arg : "return" === t.type ? (this.rval = this.arg = t.arg, this.method = "return", this.next = "end") : "normal" === t.type && e && (this.next = e), y; }, finish: function finish(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.finallyLoc === t) return this.complete(r.completion, r.afterLoc), resetTryEntry(r), y; } }, "catch": function _catch(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.tryLoc === t) { var n = r.completion; if ("throw" === n.type) { var o = n.arg; resetTryEntry(r); } return o; } } throw Error("illegal catch attempt"); }, delegateYield: function delegateYield(e, r, n) { return this.delegate = { iterator: values(e), resultName: r, nextLoc: n }, "next" === this.method && (this.arg = t), y; } }, e; }
function asyncGeneratorStep(n, t, e, r, o, a, c) { try { var i = n[a](c), u = i.value; } catch (n) { return void e(n); } i.done ? t(u) : Promise.resolve(u).then(r, o); }
function _asyncToGenerator(n) { return function () { var t = this, e = arguments; return new Promise(function (r, o) { var a = n.apply(t, e); function _next(n) { asyncGeneratorStep(a, r, o, _next, _throw, "next", n); } function _throw(n) { asyncGeneratorStep(a, r, o, _next, _throw, "throw", n); } _next(void 0); }); }; }







var FilePond = vue_filepond__WEBPACK_IMPORTED_MODULE_2___default()(filepond_plugin_file_validate_type_dist_filepond_plugin_file_validate_type_esm_js__WEBPACK_IMPORTED_MODULE_3__["default"], filepond_plugin_image_preview_dist_filepond_plugin_image_preview_esm_js__WEBPACK_IMPORTED_MODULE_4__["default"]);
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'AdminWebinarsCreate',
  components: {
    AppLayout: _Layouts_App_vue__WEBPACK_IMPORTED_MODULE_0__["default"],
    FilePond: FilePond
  },
  data: function data() {
    return {
      loading: false,
      form: {
        title: '',
        slug: '',
        description: '',
        presenter_name: '',
        presenter_bio: '',
        presenter_image: '',
        scheduled_at: '',
        duration_minutes: 60,
        meeting_link: '',
        meeting_platform: 'zoom',
        cover_image: '',
        max_attendees: null,
        status: 'draft',
        is_recorded: false,
        recording_url: '',
        keywords: [],
        meta_title: '',
        meta_description: ''
      },
      keywordsInput: '',
      errors: {},
      coverImageFiles: [],
      presenterImageFiles: []
    };
  },
  computed: {
    isEdit: function isEdit() {
      return !!this.$route.params.id;
    }
  },
  methods: {
    generateSlug: function generateSlug() {
      if (!this.isEdit && this.form.title) {
        this.form.slug = this.form.title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
      }
    },
    applyKeywords: function applyKeywords() {
      if (!this.keywordsInput) {
        this.form.keywords = [];
        return;
      }
      this.form.keywords = this.keywordsInput.split(',').map(function (s) {
        return s.trim();
      }).filter(Boolean);
    },
    loadWebinar: function loadWebinar() {
      var _this = this;
      return _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
        var _yield$axios$get, data, webinar;
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              if (_this.isEdit) {
                _context.next = 2;
                break;
              }
              return _context.abrupt("return");
            case 2:
              _context.prev = 2;
              _context.next = 5;
              return axios__WEBPACK_IMPORTED_MODULE_1___default().get("".concat("http://localhost:8000/api/admin/", "webinars/").concat(_this.$route.params.id));
            case 5:
              _yield$axios$get = _context.sent;
              data = _yield$axios$get.data;
              webinar = data.data;
              _this.form = {
                title: webinar.title || '',
                slug: webinar.slug || '',
                description: webinar.description || '',
                presenter_name: webinar.presenter_name || '',
                presenter_bio: webinar.presenter_bio || '',
                presenter_image: webinar.presenter_image || '',
                scheduled_at: webinar.scheduled_at ? webinar.scheduled_at.replace(' ', 'T').slice(0, 16) : '',
                duration_minutes: webinar.duration_minutes || 60,
                meeting_link: webinar.meeting_link || '',
                meeting_platform: webinar.meeting_platform || 'zoom',
                cover_image: webinar.cover_image || '',
                max_attendees: webinar.max_attendees || null,
                status: webinar.status || 'draft',
                is_recorded: webinar.is_recorded || false,
                recording_url: webinar.recording_url || '',
                keywords: webinar.keywords || [],
                meta_title: webinar.meta_title || '',
                meta_description: webinar.meta_description || ''
              };
              _this.keywordsInput = (_this.form.keywords || []).join(', ');

              // Load existing images
              if (webinar.cover_image) {
                _this.coverImageFiles = [{
                  source: webinar.cover_image,
                  options: {
                    type: 'local'
                  }
                }];
              }
              if (webinar.presenter_image) {
                _this.presenterImageFiles = [{
                  source: webinar.presenter_image,
                  options: {
                    type: 'local'
                  }
                }];
              }
              _context.next = 18;
              break;
            case 14:
              _context.prev = 14;
              _context.t0 = _context["catch"](2);
              console.error('Failed to load webinar:', _context.t0);
              _this.$swal('Error', 'Failed to load webinar', 'error');
            case 18:
            case "end":
              return _context.stop();
          }
        }, _callee, null, [[2, 14]]);
      }))();
    },
    submit: function submit() {
      var _this2 = this;
      return _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee2() {
        var payload, url, method, _error$response$data, errs;
        return _regeneratorRuntime().wrap(function _callee2$(_context2) {
          while (1) switch (_context2.prev = _context2.next) {
            case 0:
              _this2.loading = true;
              _this2.errors = {};
              _context2.prev = 2;
              payload = _objectSpread({}, _this2.form);
              if (!payload.scheduled_at) delete payload.scheduled_at;
              if (!payload.max_attendees) delete payload.max_attendees;
              url = _this2.isEdit ? "".concat("http://localhost:8000/api/admin/", "webinars/").concat(_this2.$route.params.id) : "".concat("http://localhost:8000/api/admin/", "webinars");
              method = _this2.isEdit ? 'put' : 'post';
              _context2.next = 10;
              return (axios__WEBPACK_IMPORTED_MODULE_1___default())[method](url, payload);
            case 10:
              _this2.$swal('Success', "Webinar ".concat(_this2.isEdit ? 'updated' : 'created', " successfully"), 'success');
              _this2.$router.push({
                name: 'admin.webinars.index'
              });
              _context2.next = 17;
              break;
            case 14:
              _context2.prev = 14;
              _context2.t0 = _context2["catch"](2);
              if (_context2.t0.response && _context2.t0.response.status === 422) {
                errs = ((_error$response$data = _context2.t0.response.data) === null || _error$response$data === void 0 ? void 0 : _error$response$data.errors) || {};
                _this2.errors = Object.fromEntries(Object.entries(errs).map(function (_ref) {
                  var _ref2 = _slicedToArray(_ref, 2),
                    k = _ref2[0],
                    v = _ref2[1];
                  return [k, v[0]];
                }));
              } else {
                _this2.$swal('Error', 'Failed to save webinar', 'error');
              }
            case 17:
              _context2.prev = 17;
              _this2.loading = false;
              return _context2.finish(17);
            case 20:
            case "end":
              return _context2.stop();
          }
        }, _callee2, null, [[2, 14, 17, 20]]);
      }))();
    },
    handleCoverImageInit: function handleCoverImageInit() {
      this.setupFilePond('cover');
    },
    handlePresenterImageInit: function handlePresenterImageInit() {
      this.setupFilePond('presenter');
    },
    setupFilePond: function setupFilePond(type) {
      (0,vue_filepond__WEBPACK_IMPORTED_MODULE_2__.setOptions)({
        credits: false,
        server: {
          url: "http://localhost:8000/api/admin/",
          process: function (_process) {
            function process(_x, _x2, _x3, _x4, _x5, _x6, _x7) {
              return _process.apply(this, arguments);
            }
            process.toString = function () {
              return _process.toString();
            };
            return process;
          }(function (fieldName, file, metadata, load, error, progress, abort) {
            var formData = new FormData();
            formData.append("media", file, file.name);
            formData.append("is_temp_media", 1);
            formData.append("type", "webinar-".concat(type));
            var request = new XMLHttpRequest();
            request.open("POST", "".concat("http://localhost:8000/api/admin/", "media/process"));
            request.setRequestHeader("X-CSRF-TOKEN", document.head.querySelector('meta[name="csrf-token"]').content);
            request.upload.onprogress = function (e) {
              progress(e.lengthComputable, e.loaded, e.total);
            };
            request.onload = function () {
              if (request.status >= 200 && request.status < 300) {
                load(request.responseText);
              } else {
                error("Upload failed");
              }
            };
            request.send(formData);
            return {
              abort: function (_abort) {
                function abort() {
                  return _abort.apply(this, arguments);
                }
                abort.toString = function () {
                  return _abort.toString();
                };
                return abort;
              }(function () {
                request.abort();
                abort();
              })
            };
          }),
          revert: function revert(uniqueFileId, load, error) {
            var formData = new FormData();
            formData.append("media", uniqueFileId);
            var request = new XMLHttpRequest();
            request.open("POST", "".concat("http://localhost:8000/api/admin/", "media/revert"));
            request.setRequestHeader("X-CSRF-TOKEN", document.head.querySelector('meta[name="csrf-token"]').content);
            request.send(formData);
            return {
              abort: function (_abort2) {
                function abort() {
                  return _abort2.apply(this, arguments);
                }
                abort.toString = function () {
                  return _abort2.toString();
                };
                return abort;
              }(function () {
                request.abort();
                abort();
              })
            };
          }
        }
      });
    },
    handleCoverImageProcess: function handleCoverImageProcess(error, file) {
      if (!error) this.form.cover_image = file.serverId;
    },
    handlePresenterImageProcess: function handlePresenterImageProcess(error, file) {
      if (!error) this.form.presenter_image = file.serverId;
    },
    handleCoverImageRemoveFile: function handleCoverImageRemoveFile() {
      this.form.cover_image = '';
    },
    handlePresenterImageRemoveFile: function handlePresenterImageRemoveFile() {
      this.form.presenter_image = '';
    }
  },
  mounted: function mounted() {
    this.loadWebinar();
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/Webinars/Create.vue?vue&type=template&id=0757ea34":
/*!********************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/Webinars/Create.vue?vue&type=template&id=0757ea34 ***!
  \********************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "relative shadow-md sm:rounded-lg bg-white py-4"
};
var _hoisted_2 = {
  "class": "pt-4"
};
var _hoisted_3 = {
  "class": "max-w-full mx-auto px-4 sm:px-6 lg:px-8"
};
var _hoisted_4 = {
  "class": "flex items-center justify-between"
};
var _hoisted_5 = {
  "class": "can-exp-h3 text-primary"
};
var _hoisted_6 = {
  "class": "grid my-5 grid-cols-1 md:grid-cols-2 gap-6"
};
var _hoisted_7 = ["textContent"];
var _hoisted_8 = ["textContent"];
var _hoisted_9 = ["textContent"];
var _hoisted_10 = ["textContent"];
var _hoisted_11 = {
  "class": "md:col-span-2"
};
var _hoisted_12 = ["textContent"];
var _hoisted_13 = {
  "class": "md:col-span-2"
};
var _hoisted_14 = {
  "class": "md:col-span-2"
};
var _hoisted_15 = {
  "class": "md:col-span-2"
};
var _hoisted_16 = {
  "class": "md:col-span-2"
};
var _hoisted_17 = {
  "class": "md:col-span-2"
};
var _hoisted_18 = {
  "class": "flex items-center"
};
var _hoisted_19 = {
  key: 0,
  "class": "md:col-span-2"
};
var _hoisted_20 = {
  "class": "md:col-span-2"
};
var _hoisted_21 = {
  "class": "md:col-span-2"
};
var _hoisted_22 = ["disabled"];
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_router_link = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("router-link");
  var _component_FilePond = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("FilePond");
  var _component_AppLayout = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("AppLayout");
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_AppLayout, null, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("header", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h3", _hoisted_5, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.isEdit ? 'Edit' : 'Create') + " Webinar", 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_router_link, {
        to: {
          name: 'admin.webinars.index'
        },
        "class": "button-exp-fill"
      }, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          return _cache[19] || (_cache[19] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Back ")]);
        }),
        _: 1 /* STABLE */
      })])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("form", {
        "class": "px-4 md:px-6 lg:px-8",
        onSubmit: _cache[18] || (_cache[18] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function () {
          return $options.submit && $options.submit.apply($options, arguments);
        }, ["prevent"]))
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_6, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Title "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [_cache[20] || (_cache[20] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
        "for": "title"
      }, "Title *", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
        id: "title",
        type: "text",
        "class": "can-exp-input w-full block border border-gray-300 rounded",
        "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
          return $data.form.title = $event;
        }),
        onInput: _cache[1] || (_cache[1] = function () {
          return $options.generateSlug && $options.generateSlug.apply($options, arguments);
        })
      }, null, 544 /* NEED_HYDRATION, NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.title]]), $data.errors.title ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("p", {
        key: 0,
        "class": "mt-2 text-sm text-red-400",
        textContent: (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.errors.title)
      }, null, 8 /* PROPS */, _hoisted_7)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Slug "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [_cache[21] || (_cache[21] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
        "for": "slug"
      }, "Slug *", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
        id: "slug",
        type: "text",
        "class": "can-exp-input w-full block border border-gray-300 rounded",
        "onUpdate:modelValue": _cache[2] || (_cache[2] = function ($event) {
          return $data.form.slug = $event;
        })
      }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.slug]]), $data.errors.slug ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("p", {
        key: 0,
        "class": "mt-2 text-sm text-red-400",
        textContent: (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.errors.slug)
      }, null, 8 /* PROPS */, _hoisted_8)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Scheduled Date Time "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [_cache[22] || (_cache[22] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
        "for": "scheduled_at"
      }, "Scheduled Date & Time *", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
        id: "scheduled_at",
        type: "datetime-local",
        "class": "can-exp-input w-full block border border-gray-300 rounded",
        "onUpdate:modelValue": _cache[3] || (_cache[3] = function ($event) {
          return $data.form.scheduled_at = $event;
        })
      }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.scheduled_at]]), $data.errors.scheduled_at ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("p", {
        key: 0,
        "class": "mt-2 text-sm text-red-400",
        textContent: (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.errors.scheduled_at)
      }, null, 8 /* PROPS */, _hoisted_9)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Duration "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [_cache[23] || (_cache[23] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
        "for": "duration_minutes"
      }, "Duration (minutes) *", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
        id: "duration_minutes",
        type: "number",
        min: "15",
        max: "480",
        "class": "can-exp-input w-full block border border-gray-300 rounded",
        "onUpdate:modelValue": _cache[4] || (_cache[4] = function ($event) {
          return $data.form.duration_minutes = $event;
        })
      }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.duration_minutes]]), $data.errors.duration_minutes ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("p", {
        key: 0,
        "class": "mt-2 text-sm text-red-400",
        textContent: (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.errors.duration_minutes)
      }, null, 8 /* PROPS */, _hoisted_10)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Presenter Name "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [_cache[24] || (_cache[24] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
        "for": "presenter_name"
      }, "Presenter Name", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
        id: "presenter_name",
        type: "text",
        "class": "can-exp-input w-full block border border-gray-300 rounded",
        "onUpdate:modelValue": _cache[5] || (_cache[5] = function ($event) {
          return $data.form.presenter_name = $event;
        })
      }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.presenter_name]])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Meeting Platform "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [_cache[26] || (_cache[26] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
        "for": "meeting_platform"
      }, "Meeting Platform", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
        id: "meeting_platform",
        "class": "can-exp-input w-full block border border-gray-300 rounded",
        "onUpdate:modelValue": _cache[6] || (_cache[6] = function ($event) {
          return $data.form.meeting_platform = $event;
        })
      }, _cache[25] || (_cache[25] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
        value: "zoom"
      }, "Zoom", -1 /* HOISTED */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
        value: "teams"
      }, "Microsoft Teams", -1 /* HOISTED */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
        value: "youtube"
      }, "YouTube Live", -1 /* HOISTED */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
        value: "custom"
      }, "Custom", -1 /* HOISTED */)]), 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, $data.form.meeting_platform]])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Meeting Link "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_11, [_cache[27] || (_cache[27] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
        "for": "meeting_link"
      }, "Meeting Link", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
        id: "meeting_link",
        type: "url",
        "class": "can-exp-input w-full block border border-gray-300 rounded",
        "onUpdate:modelValue": _cache[7] || (_cache[7] = function ($event) {
          return $data.form.meeting_link = $event;
        }),
        placeholder: "https://zoom.us/j/..."
      }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.meeting_link]]), $data.errors.meeting_link ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("p", {
        key: 0,
        "class": "mt-2 text-sm text-red-400",
        textContent: (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.errors.meeting_link)
      }, null, 8 /* PROPS */, _hoisted_12)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Max Attendees "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [_cache[28] || (_cache[28] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
        "for": "max_attendees"
      }, "Max Attendees (leave empty for unlimited)", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
        id: "max_attendees",
        type: "number",
        min: "1",
        "class": "can-exp-input w-full block border border-gray-300 rounded",
        "onUpdate:modelValue": _cache[8] || (_cache[8] = function ($event) {
          return $data.form.max_attendees = $event;
        })
      }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.max_attendees]])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Status "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [_cache[30] || (_cache[30] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
        "for": "status"
      }, "Status *", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
        id: "status",
        "class": "can-exp-input w-full block border border-gray-300 rounded",
        "onUpdate:modelValue": _cache[9] || (_cache[9] = function ($event) {
          return $data.form.status = $event;
        })
      }, _cache[29] || (_cache[29] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
        value: "draft"
      }, "Draft", -1 /* HOISTED */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
        value: "published"
      }, "Published", -1 /* HOISTED */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
        value: "completed"
      }, "Completed", -1 /* HOISTED */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
        value: "cancelled"
      }, "Cancelled", -1 /* HOISTED */)]), 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, $data.form.status]])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Description "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_13, [_cache[31] || (_cache[31] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
        "for": "description"
      }, "Description", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("textarea", {
        id: "description",
        rows: "4",
        "class": "can-exp-input w-full block border border-gray-300 rounded",
        "onUpdate:modelValue": _cache[10] || (_cache[10] = function ($event) {
          return $data.form.description = $event;
        })
      }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.description]])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Presenter Bio "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_14, [_cache[32] || (_cache[32] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
        "for": "presenter_bio"
      }, "Presenter Bio", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("textarea", {
        id: "presenter_bio",
        rows: "3",
        "class": "can-exp-input w-full block border border-gray-300 rounded",
        "onUpdate:modelValue": _cache[11] || (_cache[11] = function ($event) {
          return $data.form.presenter_bio = $event;
        })
      }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.presenter_bio]])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Cover Image "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_15, [_cache[33] || (_cache[33] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
        "for": "cover_image"
      }, "Cover Image", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_FilePond, {
        name: "cover_image",
        "class-name": "my-pond",
        "accepted-file-types": "image/*",
        credits: "false",
        labelIdle: "<span class='cursor-pointer'>Drag & Drop cover image or <span class='filepond--label-action'>Browse</span></span>",
        ref: "cover_image",
        files: $data.coverImageFiles,
        onInit: $options.handleCoverImageInit,
        onProcessfile: $options.handleCoverImageProcess,
        onRemovefile: $options.handleCoverImageRemoveFile
      }, null, 8 /* PROPS */, ["files", "onInit", "onProcessfile", "onRemovefile"]), _cache[34] || (_cache[34] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
        "class": "mt-1 text-sm text-gray-500"
      }, "Recommended size: 1200x630px", -1 /* HOISTED */))]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Presenter Image "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_16, [_cache[35] || (_cache[35] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
        "for": "presenter_image"
      }, "Presenter Image", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_FilePond, {
        name: "presenter_image",
        "class-name": "my-pond",
        "accepted-file-types": "image/*",
        credits: "false",
        labelIdle: "<span class='cursor-pointer'>Drag & Drop presenter image or <span class='filepond--label-action'>Browse</span></span>",
        ref: "presenter_image",
        files: $data.presenterImageFiles,
        onInit: $options.handlePresenterImageInit,
        onProcessfile: $options.handlePresenterImageProcess,
        onRemovefile: $options.handlePresenterImageRemoveFile
      }, null, 8 /* PROPS */, ["files", "onInit", "onProcessfile", "onRemovefile"])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Recording "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_17, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", _hoisted_18, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
        type: "checkbox",
        "class": "mr-2",
        "onUpdate:modelValue": _cache[12] || (_cache[12] = function ($event) {
          return $data.form.is_recorded = $event;
        })
      }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelCheckbox, $data.form.is_recorded]]), _cache[36] || (_cache[36] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, "This webinar will be recorded", -1 /* HOISTED */))])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Recording URL "), $data.form.is_recorded ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_19, [_cache[37] || (_cache[37] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
        "for": "recording_url"
      }, "Recording URL", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
        id: "recording_url",
        type: "url",
        "class": "can-exp-input w-full block border border-gray-300 rounded",
        "onUpdate:modelValue": _cache[13] || (_cache[13] = function ($event) {
          return $data.form.recording_url = $event;
        }),
        placeholder: "https://..."
      }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.recording_url]])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Keywords "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_20, [_cache[38] || (_cache[38] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
        "for": "keywords"
      }, "Keywords (comma separated)", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
        id: "keywords",
        type: "text",
        "class": "can-exp-input w-full block border border-gray-300 rounded",
        "onUpdate:modelValue": _cache[14] || (_cache[14] = function ($event) {
          return $data.keywordsInput = $event;
        }),
        onBlur: _cache[15] || (_cache[15] = function () {
          return $options.applyKeywords && $options.applyKeywords.apply($options, arguments);
        })
      }, null, 544 /* NEED_HYDRATION, NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.keywordsInput]])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Meta Title "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [_cache[39] || (_cache[39] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
        "for": "meta_title"
      }, "Meta Title", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
        id: "meta_title",
        type: "text",
        "class": "can-exp-input w-full block border border-gray-300 rounded",
        "onUpdate:modelValue": _cache[16] || (_cache[16] = function ($event) {
          return $data.form.meta_title = $event;
        })
      }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.meta_title]])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Meta Description "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_21, [_cache[40] || (_cache[40] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
        "for": "meta_description"
      }, "Meta Description", -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("textarea", {
        id: "meta_description",
        rows: "2",
        "class": "can-exp-input w-full block border border-gray-300 rounded",
        "onUpdate:modelValue": _cache[17] || (_cache[17] = function ($event) {
          return $data.form.meta_description = $event;
        })
      }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.form.meta_description]])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
        type: "submit",
        "class": "button-exp-fill",
        disabled: $data.loading
      }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.loading ? 'Saving...' : 'Save Webinar'), 9 /* TEXT, PROPS */, _hoisted_22)], 32 /* NEED_HYDRATION */)])];
    }),
    _: 1 /* STABLE */
  });
}

/***/ }),

/***/ "./resources/js/admin/Webinars/Create.vue":
/*!************************************************!*\
  !*** ./resources/js/admin/Webinars/Create.vue ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Create_vue_vue_type_template_id_0757ea34__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Create.vue?vue&type=template&id=0757ea34 */ "./resources/js/admin/Webinars/Create.vue?vue&type=template&id=0757ea34");
/* harmony import */ var _Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Create.vue?vue&type=script&lang=js */ "./resources/js/admin/Webinars/Create.vue?vue&type=script&lang=js");
/* harmony import */ var _node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Create_vue_vue_type_template_id_0757ea34__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/admin/Webinars/Create.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/admin/Webinars/Create.vue?vue&type=script&lang=js":
/*!************************************************************************!*\
  !*** ./resources/js/admin/Webinars/Create.vue?vue&type=script&lang=js ***!
  \************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Create.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/Webinars/Create.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/admin/Webinars/Create.vue?vue&type=template&id=0757ea34":
/*!******************************************************************************!*\
  !*** ./resources/js/admin/Webinars/Create.vue?vue&type=template&id=0757ea34 ***!
  \******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Create_vue_vue_type_template_id_0757ea34__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Create_vue_vue_type_template_id_0757ea34__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Create.vue?vue&type=template&id=0757ea34 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/Webinars/Create.vue?vue&type=template&id=0757ea34");


/***/ })

}]);