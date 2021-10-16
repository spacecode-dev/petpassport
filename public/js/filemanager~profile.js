(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["filemanager~profile"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/util/filemanager/components/Manager.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/util/filemanager/components/Manager.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var core_js_modules_es_array_filter__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! core-js/modules/es.array.filter */ "./node_modules/core-js/modules/es.array.filter.js");
/* harmony import */ var core_js_modules_es_array_filter__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_array_filter__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var core_js_modules_es_array_find__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! core-js/modules/es.array.find */ "./node_modules/core-js/modules/es.array.find.js");
/* harmony import */ var core_js_modules_es_array_find__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_array_find__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var core_js_modules_es_array_for_each__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! core-js/modules/es.array.for-each */ "./node_modules/core-js/modules/es.array.for-each.js");
/* harmony import */ var core_js_modules_es_array_for_each__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_array_for_each__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var core_js_modules_es_array_includes__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! core-js/modules/es.array.includes */ "./node_modules/core-js/modules/es.array.includes.js");
/* harmony import */ var core_js_modules_es_array_includes__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_array_includes__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var core_js_modules_es_array_index_of__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! core-js/modules/es.array.index-of */ "./node_modules/core-js/modules/es.array.index-of.js");
/* harmony import */ var core_js_modules_es_array_index_of__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_array_index_of__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var core_js_modules_es_array_iterator__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! core-js/modules/es.array.iterator */ "./node_modules/core-js/modules/es.array.iterator.js");
/* harmony import */ var core_js_modules_es_array_iterator__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_array_iterator__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var core_js_modules_es_array_join__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! core-js/modules/es.array.join */ "./node_modules/core-js/modules/es.array.join.js");
/* harmony import */ var core_js_modules_es_array_join__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_array_join__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var core_js_modules_es_function_name__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! core-js/modules/es.function.name */ "./node_modules/core-js/modules/es.function.name.js");
/* harmony import */ var core_js_modules_es_function_name__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_function_name__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var core_js_modules_es_number_constructor__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! core-js/modules/es.number.constructor */ "./node_modules/core-js/modules/es.number.constructor.js");
/* harmony import */ var core_js_modules_es_number_constructor__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_number_constructor__WEBPACK_IMPORTED_MODULE_8__);
/* harmony import */ var core_js_modules_es_object_to_string__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! core-js/modules/es.object.to-string */ "./node_modules/core-js/modules/es.object.to-string.js");
/* harmony import */ var core_js_modules_es_object_to_string__WEBPACK_IMPORTED_MODULE_9___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_object_to_string__WEBPACK_IMPORTED_MODULE_9__);
/* harmony import */ var core_js_modules_es_regexp_exec__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! core-js/modules/es.regexp.exec */ "./node_modules/core-js/modules/es.regexp.exec.js");
/* harmony import */ var core_js_modules_es_regexp_exec__WEBPACK_IMPORTED_MODULE_10___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_regexp_exec__WEBPACK_IMPORTED_MODULE_10__);
/* harmony import */ var core_js_modules_es_string_includes__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! core-js/modules/es.string.includes */ "./node_modules/core-js/modules/es.string.includes.js");
/* harmony import */ var core_js_modules_es_string_includes__WEBPACK_IMPORTED_MODULE_11___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_string_includes__WEBPACK_IMPORTED_MODULE_11__);
/* harmony import */ var core_js_modules_es_string_iterator__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! core-js/modules/es.string.iterator */ "./node_modules/core-js/modules/es.string.iterator.js");
/* harmony import */ var core_js_modules_es_string_iterator__WEBPACK_IMPORTED_MODULE_12___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_string_iterator__WEBPACK_IMPORTED_MODULE_12__);
/* harmony import */ var core_js_modules_es_string_replace__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! core-js/modules/es.string.replace */ "./node_modules/core-js/modules/es.string.replace.js");
/* harmony import */ var core_js_modules_es_string_replace__WEBPACK_IMPORTED_MODULE_13___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_string_replace__WEBPACK_IMPORTED_MODULE_13__);
/* harmony import */ var core_js_modules_es_string_search__WEBPACK_IMPORTED_MODULE_14__ = __webpack_require__(/*! core-js/modules/es.string.search */ "./node_modules/core-js/modules/es.string.search.js");
/* harmony import */ var core_js_modules_es_string_search__WEBPACK_IMPORTED_MODULE_14___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_string_search__WEBPACK_IMPORTED_MODULE_14__);
/* harmony import */ var core_js_modules_es_string_split__WEBPACK_IMPORTED_MODULE_15__ = __webpack_require__(/*! core-js/modules/es.string.split */ "./node_modules/core-js/modules/es.string.split.js");
/* harmony import */ var core_js_modules_es_string_split__WEBPACK_IMPORTED_MODULE_15___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_string_split__WEBPACK_IMPORTED_MODULE_15__);
/* harmony import */ var core_js_modules_web_dom_collections_for_each__WEBPACK_IMPORTED_MODULE_16__ = __webpack_require__(/*! core-js/modules/web.dom-collections.for-each */ "./node_modules/core-js/modules/web.dom-collections.for-each.js");
/* harmony import */ var core_js_modules_web_dom_collections_for_each__WEBPACK_IMPORTED_MODULE_16___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_web_dom_collections_for_each__WEBPACK_IMPORTED_MODULE_16__);
/* harmony import */ var core_js_modules_web_dom_collections_iterator__WEBPACK_IMPORTED_MODULE_17__ = __webpack_require__(/*! core-js/modules/web.dom-collections.iterator */ "./node_modules/core-js/modules/web.dom-collections.iterator.js");
/* harmony import */ var core_js_modules_web_dom_collections_iterator__WEBPACK_IMPORTED_MODULE_17___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_web_dom_collections_iterator__WEBPACK_IMPORTED_MODULE_17__);
/* harmony import */ var core_js_modules_web_url__WEBPACK_IMPORTED_MODULE_18__ = __webpack_require__(/*! core-js/modules/web.url */ "./node_modules/core-js/modules/web.url.js");
/* harmony import */ var core_js_modules_web_url__WEBPACK_IMPORTED_MODULE_18___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_web_url__WEBPACK_IMPORTED_MODULE_18__);
/* harmony import */ var _home_vladlen_localhost_PETPASSPORT_node_modules_babel_runtime_helpers_esm_objectSpread2__WEBPACK_IMPORTED_MODULE_19__ = __webpack_require__(/*! ./node_modules/@babel/runtime/helpers/esm/objectSpread2 */ "./node_modules/@babel/runtime/helpers/esm/objectSpread2.js");
/* harmony import */ var _home_vladlen_localhost_PETPASSPORT_node_modules_babel_runtime_helpers_esm_createForOfIteratorHelper__WEBPACK_IMPORTED_MODULE_20__ = __webpack_require__(/*! ./node_modules/@babel/runtime/helpers/esm/createForOfIteratorHelper */ "./node_modules/@babel/runtime/helpers/esm/createForOfIteratorHelper.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_21__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_21___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_21__);
/* harmony import */ var _home_vladlen_localhost_PETPASSPORT_node_modules_babel_runtime_helpers_esm_toConsumableArray__WEBPACK_IMPORTED_MODULE_22__ = __webpack_require__(/*! ./node_modules/@babel/runtime/helpers/esm/toConsumableArray */ "./node_modules/@babel/runtime/helpers/esm/toConsumableArray.js");
/* harmony import */ var regenerator_runtime_runtime__WEBPACK_IMPORTED_MODULE_23__ = __webpack_require__(/*! regenerator-runtime/runtime */ "./node_modules/regenerator-runtime/runtime.js");
/* harmony import */ var regenerator_runtime_runtime__WEBPACK_IMPORTED_MODULE_23___default = /*#__PURE__*/__webpack_require__.n(regenerator_runtime_runtime__WEBPACK_IMPORTED_MODULE_23__);
/* harmony import */ var _home_vladlen_localhost_PETPASSPORT_node_modules_babel_runtime_helpers_esm_asyncToGenerator__WEBPACK_IMPORTED_MODULE_24__ = __webpack_require__(/*! ./node_modules/@babel/runtime/helpers/esm/asyncToGenerator */ "./node_modules/@babel/runtime/helpers/esm/asyncToGenerator.js");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_25__ = __webpack_require__(/*! lodash */ "./node_modules/lodash/lodash.js");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_25___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_25__);
/* harmony import */ var filesize__WEBPACK_IMPORTED_MODULE_26__ = __webpack_require__(/*! filesize */ "./node_modules/filesize/lib/filesize.min.js");
/* harmony import */ var filesize__WEBPACK_IMPORTED_MODULE_26___default = /*#__PURE__*/__webpack_require__.n(filesize__WEBPACK_IMPORTED_MODULE_26__);
/* harmony import */ var md5__WEBPACK_IMPORTED_MODULE_27__ = __webpack_require__(/*! md5 */ "./node_modules/md5/md5.js");
/* harmony import */ var md5__WEBPACK_IMPORTED_MODULE_27___default = /*#__PURE__*/__webpack_require__.n(md5__WEBPACK_IMPORTED_MODULE_27__);
/* harmony import */ var _api__WEBPACK_IMPORTED_MODULE_28__ = __webpack_require__(/*! ../api */ "./resources/js/util/filemanager/api.js");
/* harmony import */ var vue_custom_scrollbar__WEBPACK_IMPORTED_MODULE_29__ = __webpack_require__(/*! vue-custom-scrollbar */ "./node_modules/vue-custom-scrollbar/dist/vueScrollbar.umd.min.js");
/* harmony import */ var vue_custom_scrollbar__WEBPACK_IMPORTED_MODULE_29___default = /*#__PURE__*/__webpack_require__.n(vue_custom_scrollbar__WEBPACK_IMPORTED_MODULE_29__);
/* harmony import */ var _modules_ImageLoader__WEBPACK_IMPORTED_MODULE_30__ = __webpack_require__(/*! ../modules/ImageLoader */ "./resources/js/util/filemanager/modules/ImageLoader.vue");
/* harmony import */ var _modules_Folder__WEBPACK_IMPORTED_MODULE_31__ = __webpack_require__(/*! ../modules/Folder */ "./resources/js/util/filemanager/modules/Folder.vue");
/* harmony import */ var _event_bus__WEBPACK_IMPORTED_MODULE_32__ = __webpack_require__(/*! ../../event-bus */ "./resources/js/util/event-bus.js");
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_33__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
/* harmony import */ var _helper__WEBPACK_IMPORTED_MODULE_34__ = __webpack_require__(/*! ../../helper */ "./resources/js/util/helper.js");

























//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//










/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'Manager',
  components: {
    vueCustomScrollbar: vue_custom_scrollbar__WEBPACK_IMPORTED_MODULE_29___default.a,
    ImageLoader: _modules_ImageLoader__WEBPACK_IMPORTED_MODULE_30__["default"],
    Folder: _modules_Folder__WEBPACK_IMPORTED_MODULE_31__["default"]
  },
  props: {
    files: {
      "default": function _default() {
        return [];
      },
      required: true
    },
    path: {
      "default": function _default() {
        return [];
      },
      required: true
    },
    userId: {
      type: Number,
      "default": 0,
      required: true
    },
    current: {
      type: String,
      "default": '/',
      required: true
    },
    parent: {
      type: Object,
      required: true
    },
    noFiles: {
      type: Boolean,
      "default": false,
      required: true
    },
    home: {
      type: String,
      required: false,
      "default": '/'
    },
    search: {
      type: String,
      required: false,
      "default": ''
    },
    filters: {
      type: Array,
      required: false,
      "default": function _default() {
        return [];
      }
    },
    multiSelecting: {
      type: Boolean,
      "default": false,
      required: false
    },
    selectedFiles: {
      type: Array,
      "default": function _default() {
        return [];
      },
      required: false
    },
    buttons: {
      "default": function _default() {
        return [];
      },
      required: true
    }
  },
  data: function data() {
    return {
      info: {},
      loadingInfo: false,
      firstUploadFolder: null
    };
  },
  methods: {
    goToFolder: function goToFolder(path) {
      this.$emit('goToFolderManager', path);
    },
    goToFolderNav: function goToFolderNav(path) {
      this.$emit('goToFolderManagerNav', path);
    },
    checkIsLastItem: function checkIsLastItem(index) {
      return lodash__WEBPACK_IMPORTED_MODULE_25___default.a.size(this.path) === parseInt(index) + 1;
    },
    removeDirectory: function removeDirectory() {
      var _this = this;

      _api__WEBPACK_IMPORTED_MODULE_28__["default"].removeDirectory(this.current, this.userId).then(function (response) {
        _this.$emit('goToFolderManager', _this.getParentFolder());

        _event_bus__WEBPACK_IMPORTED_MODULE_32__["default"].$emit('refreshFilemanager');
        Object(_helper__WEBPACK_IMPORTED_MODULE_34__["getToast"])(_this, 'success', response.message);
      })["catch"](function (error) {
        if (typeof error.response !== 'undefined' && error.response.status === 422) {
          Object(_helper__WEBPACK_IMPORTED_MODULE_34__["getToast"])(_this, 'danger', error.response.data.errors);
        }
      });
    },
    showInfo: function showInfo(file) {
      var _this2 = this;

      _api__WEBPACK_IMPORTED_MODULE_28__["default"].getInfo(file.path, this.userId).then(function (response) {
        _this2.$emit('showInfoItem', response);
      })["catch"](function (error) {
        if (typeof error.response !== 'undefined' && error.response.status === 404) {
          Object(_helper__WEBPACK_IMPORTED_MODULE_34__["getToast"])(_this2, 'danger', error.response.data.errors);
        }
      });
    },
    selectFile: function selectFile(file) {
      this.$emit('selectFile', file);
    },
    getFilesAsync: function getFilesAsync(dataTransfer) {
      var _this3 = this;

      return Object(_home_vladlen_localhost_PETPASSPORT_node_modules_babel_runtime_helpers_esm_asyncToGenerator__WEBPACK_IMPORTED_MODULE_24__["default"])( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_21___default.a.mark(function _callee() {
        var files, folders, i, item, entry, entryContent, file, _file;

        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_21___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                files = [];
                folders = [];
                _this3.firstUploadFolder = null;
                i = 0;

              case 4:
                if (!(i < dataTransfer.items.length)) {
                  _context.next = 24;
                  break;
                }

                item = dataTransfer.items[i];
                entry = item.webkitGetAsEntry();

                if (!entry.isDirectory) {
                  _context.next = 19;
                  break;
                }

                if (_this3.firstUploadFolder == null) {
                  _this3.firstUploadFolder = entry.name;
                }

                if (!(item.kind === 'file')) {
                  _context.next = 17;
                  break;
                }

                if (!(typeof item.webkitGetAsEntry === 'function')) {
                  _context.next = 15;
                  break;
                }

                _context.next = 13;
                return _this3.readEntryContentAsync(entry);

              case 13:
                entryContent = _context.sent;
                folders.push.apply(folders, Object(_home_vladlen_localhost_PETPASSPORT_node_modules_babel_runtime_helpers_esm_toConsumableArray__WEBPACK_IMPORTED_MODULE_22__["default"])(entryContent));

              case 15:
                file = item.getAsFile();

                if (file) {
                  files.push(file);
                }

              case 17:
                _context.next = 21;
                break;

              case 19:
                _file = item.getAsFile();

                if (_file) {
                  files.push(_file);
                }

              case 21:
                i++;
                _context.next = 4;
                break;

              case 24:
                return _context.abrupt("return", {
                  files: files,
                  folders: folders
                });

              case 25:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    readEntryContentAsync: function readEntryContentAsync(entry) {
      return new Promise(function (resolve) {
        var reading = 0;
        var contents = [];
        readEntry(entry);

        function readEntry(entry) {
          if (isFile(entry)) {
            reading++;
            entry.file(function (file) {
              reading--;
              file.filepath = entry.fullPath.replace('/' + entry.name, '');
              contents.push(file);

              if (reading === 0) {
                resolve(contents);
              }
            });
          } else if (isDirectory(entry)) {
            readReaderContent(entry.createReader());
          }
        }

        function readReaderContent(reader) {
          reading++;
          reader.readEntries(function (entries) {
            reading--;

            var _iterator = Object(_home_vladlen_localhost_PETPASSPORT_node_modules_babel_runtime_helpers_esm_createForOfIteratorHelper__WEBPACK_IMPORTED_MODULE_20__["default"])(entries),
                _step;

            try {
              for (_iterator.s(); !(_step = _iterator.n()).done;) {
                var _entry = _step.value;
                readEntry(_entry);
              }
            } catch (err) {
              _iterator.e(err);
            } finally {
              _iterator.f();
            }

            if (reading === 0) {
              resolve(contents);
            }
          });
        }

        function isDirectory(entry) {
          return entry.isDirectory;
        }

        function isFile(entry) {
          return entry.isFile;
        }
      });
    },
    uploadFiles: function uploadFiles(data) {
      var files = this.formatFiles(data.files || []);
      var folders = this.formatFiles(data.folders || []);

      if (files.length > 0) {
        this.$emit('uploadFiles', files, 'files');
      }

      if (folders.length > 0) {
        this.$emit('uploadFiles', folders, 'folders', this.firstUploadFolder);
      }
    },
    formatFiles: function formatFiles(files) {
      var _this4 = this;

      var arrayFiles = [];
      files.forEach(function (file) {
        if (file.name !== '.DS_Store') {
          arrayFiles.push({
            id: md5__WEBPACK_IMPORTED_MODULE_27___default()(file.name),
            preview: _this4.getPreview(file),
            type: file.type,
            name: file.name,
            size: filesize__WEBPACK_IMPORTED_MODULE_26___default()(file.size),
            upload: true,
            progress: 0,
            error: false,
            file: file
          });
        }
      });
      return arrayFiles;
    },
    getPreview: function getPreview(file) {
      if (this.isImage(file)) {
        return URL.createObjectURL(file);
      }

      return file.name.split('.').pop();
    },
    isImage: function isImage(file) {
      return file.type.includes('image');
    },
    getFileById: function getFileById(type, id) {
      if (id === 'folder_back') {
        return this.$refs[type + '_' + id];
      }

      var found = this.files.find(function (file) {
        return file.id === id;
      });

      if (found) {
        return this.$refs[type + '_' + id][0];
      }
    },
    getParentFolder: function getParentFolder() {
      var pathData = this.current.split('/');
      pathData.pop();

      if (pathData.length) {
        return pathData.join('/');
      }

      return '/';
    },
    rename: function rename(type, path) {
      this.$emit('rename', type, path);
    },
    deleteData: function deleteData(type, path) {
      this.$emit('delete', type, path);
    },
    select: function select(file) {
      this.$emit('select', file);
    }
  },
  computed: Object(_home_vladlen_localhost_PETPASSPORT_node_modules_babel_runtime_helpers_esm_objectSpread2__WEBPACK_IMPORTED_MODULE_19__["default"])(Object(_home_vladlen_localhost_PETPASSPORT_node_modules_babel_runtime_helpers_esm_objectSpread2__WEBPACK_IMPORTED_MODULE_19__["default"])({}, Object(vuex__WEBPACK_IMPORTED_MODULE_33__["mapState"])({
    settings: function settings(state) {
      return state.settings.filemanager.scroll.settings;
    },
    showModal: function showModal(state) {
      return state.settings.filemanager.showModal;
    }
  })), {}, {
    pathsLength: function pathsLength() {
      return lodash__WEBPACK_IMPORTED_MODULE_25___default.a.size(this.path);
    },
    filesCount: function filesCount() {
      return lodash__WEBPACK_IMPORTED_MODULE_25___default.a.size(this.files);
    },
    filteredFiles: function filteredFiles() {
      var _this5 = this;

      var filtered = this.files;

      if (this.search) {
        filtered = this.files.filter(function (m) {
          return m.name.toLowerCase().indexOf(_this5.search) > -1;
        });
      }

      if (this.filters.length > 0) {
        filtered = lodash__WEBPACK_IMPORTED_MODULE_25___default.a.filter(filtered, function (file) {
          if (file.type === 'dir') {
            return true;
          }

          return lodash__WEBPACK_IMPORTED_MODULE_25___default.a.includes(_this5.filters, file.ext.toLowerCase());
        });
      }

      return filtered;
    }
  })
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/util/filemanager/modules/Folder.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/util/filemanager/modules/Folder.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _home_vladlen_localhost_PETPASSPORT_node_modules_babel_runtime_helpers_esm_objectSpread2__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./node_modules/@babel/runtime/helpers/esm/objectSpread2 */ "./node_modules/@babel/runtime/helpers/esm/objectSpread2.js");
/* harmony import */ var lodash_findIndex__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! lodash/findIndex */ "./node_modules/lodash/findIndex.js");
/* harmony import */ var lodash_findIndex__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(lodash_findIndex__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _event_bus__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../event-bus */ "./resources/js/util/event-bus.js");
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//



/* harmony default export */ __webpack_exports__["default"] = ({
  props: {
    file: {
      type: Object,
      "default": function _default() {
        return {
          name: ''
        };
      },
      required: true
    },
    multiSelecting: {
      type: Boolean,
      "default": false,
      required: false
    },
    selectedFiles: {
      type: Array,
      "default": function _default() {
        return [];
      },
      required: false
    },
    deletePermission: {
      type: Boolean,
      required: false,
      "default": true
    },
    renamePermission: {
      type: Boolean,
      required: false,
      "default": true
    }
  },
  data: function data() {
    return {
      loading: true,
      missing: false
    };
  },
  mounted: function mounted() {
    this.loading = false;
  },
  computed: Object(_home_vladlen_localhost_PETPASSPORT_node_modules_babel_runtime_helpers_esm_objectSpread2__WEBPACK_IMPORTED_MODULE_0__["default"])(Object(_home_vladlen_localhost_PETPASSPORT_node_modules_babel_runtime_helpers_esm_objectSpread2__WEBPACK_IMPORTED_MODULE_0__["default"])({}, Object(vuex__WEBPACK_IMPORTED_MODULE_3__["mapState"])({
    showModal: function showModal(state) {
      return state.settings.filemanager.showModal;
    }
  })), {}, {
    selected: function selected() {
      return lodash_findIndex__WEBPACK_IMPORTED_MODULE_1___default()(this.selectedFiles, {
        type: this.file.type,
        path: this.file.path
      }) >= 0;
    }
  }),
  methods: {
    clickStrategy: function clickStrategy() {
      return this.multiSelecting ? this.select() : this.goToFolder();
    },
    goToFolder: function goToFolder() {
      this.$emit('goToFolderEvent', this.file.path);
    },
    deleteFolder: function deleteFolder(e) {
      this.stopDefaultActions(e);
      _event_bus__WEBPACK_IMPORTED_MODULE_2__["default"].$emit('openModal', 'delete');
      _event_bus__WEBPACK_IMPORTED_MODULE_2__["default"].$emit('delete', 'folder', this.file.path);
    },
    editFolder: function editFolder(e) {
      this.stopDefaultActions(e);
      _event_bus__WEBPACK_IMPORTED_MODULE_2__["default"].$emit('openModal', 'rename');
      _event_bus__WEBPACK_IMPORTED_MODULE_2__["default"].$emit('rename', 'folder', this.file.path);
    },
    stopDefaultActions: function stopDefaultActions(e) {
      e.preventDefault();
      e.stopPropagation();
    },
    select: function select() {
      this.$emit('select', {
        type: this.file.type,
        path: this.file.path
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/util/filemanager/modules/ImageLoader.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/util/filemanager/modules/ImageLoader.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var core_js_modules_es_array_slice__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! core-js/modules/es.array.slice */ "./node_modules/core-js/modules/es.array.slice.js");
/* harmony import */ var core_js_modules_es_array_slice__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_array_slice__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _home_vladlen_localhost_PETPASSPORT_node_modules_babel_runtime_helpers_esm_objectSpread2__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./node_modules/@babel/runtime/helpers/esm/objectSpread2 */ "./node_modules/@babel/runtime/helpers/esm/objectSpread2.js");
/* harmony import */ var lodash_findIndex__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! lodash/findIndex */ "./node_modules/lodash/findIndex.js");
/* harmony import */ var lodash_findIndex__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(lodash_findIndex__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _event_bus__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../event-bus */ "./resources/js/util/event-bus.js");
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");


//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//



/* harmony default export */ __webpack_exports__["default"] = ({
  props: {
    file: {
      type: Object,
      "default": function _default() {
        return {
          name: ''
        };
      },
      required: true
    },
    multiSelecting: {
      type: Boolean,
      "default": false,
      required: false
    },
    selectedFiles: {
      type: Array,
      "default": function _default() {
        return [];
      },
      required: false
    },
    deletePermission: {
      type: Boolean,
      required: false,
      "default": true
    },
    renamePermission: {
      type: Boolean,
      required: false,
      "default": true
    }
  },
  computed: Object(_home_vladlen_localhost_PETPASSPORT_node_modules_babel_runtime_helpers_esm_objectSpread2__WEBPACK_IMPORTED_MODULE_1__["default"])(Object(_home_vladlen_localhost_PETPASSPORT_node_modules_babel_runtime_helpers_esm_objectSpread2__WEBPACK_IMPORTED_MODULE_1__["default"])({}, Object(vuex__WEBPACK_IMPORTED_MODULE_4__["mapState"])({
    showModal: function showModal(state) {
      return state.settings.filemanager.showModal;
    }
  })), {}, {
    selected: function selected() {
      if (this.showModal) {
        return lodash_findIndex__WEBPACK_IMPORTED_MODULE_2___default()(this.selectedFiles, {
          id: this.file.id,
          mime: this.file.mime,
          path: this.file.asset
        }) >= 0;
      } else {
        return lodash_findIndex__WEBPACK_IMPORTED_MODULE_2___default()(this.selectedFiles, {
          type: this.file.type,
          path: this.file.path
        }) >= 0;
      }
    }
  }),
  mounted: function mounted() {
    var _this = this;

    if (this.file.mime === 'image') {
      var imageDiv = document.createElement('div');
      imageDiv.style.backgroundImage = "url('" + this.file.thumb + "')";
      imageDiv.className = 'block-grid';
      imageDiv.draggable = false;
      this.$refs.image.appendChild(imageDiv);
    }

    _event_bus__WEBPACK_IMPORTED_MODULE_3__["default"].$on('removeSelectedInModal', function (arg) {
      _this.selectedFiles = arg;
    });
  },
  methods: {
    clickStrategy: function clickStrategy() {
      if (this.showModal) {
        return this.select();
      } else {
        return this.multiSelecting ? this.select() : this.showInfo();
      }
    },
    select: function select() {
      if (this.showModal) {
        this.$emit('select', {
          id: this.file.id,
          mime: this.file.mime,
          path: this.file.asset
        });
      } else {
        this.$emit('select', {
          type: this.file.type,
          path: this.file.path
        });
      }
    },
    showInfo: function showInfo() {
      this.$emit('showInfo', this.file);
    },
    deleteFile: function deleteFile(e) {
      this.stopDefaultActions(e);
      _event_bus__WEBPACK_IMPORTED_MODULE_3__["default"].$emit('openModal', 'delete');
      _event_bus__WEBPACK_IMPORTED_MODULE_3__["default"].$emit('delete', 'file', this.file.path);
    },
    renameFile: function renameFile(e) {
      this.stopDefaultActions(e);
      _event_bus__WEBPACK_IMPORTED_MODULE_3__["default"].$emit('openModal', 'rename');
      _event_bus__WEBPACK_IMPORTED_MODULE_3__["default"].$emit('rename', 'file', this.file.path);
    },
    stopDefaultActions: function stopDefaultActions(e) {
      e.preventDefault();
      e.stopPropagation();
    }
  },
  filters: {
    truncate: function truncate(text, stop, clamp) {
      return text.slice(0, stop) + (stop < text.length ? clamp || '...' : '');
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/util/filemanager/components/Manager.vue?vue&type=style&index=0&id=0d389cd1&lang=scss&scoped=true&":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/sass-loader/dist/cjs.js??ref--6-3!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/util/filemanager/components/Manager.vue?vue&type=style&index=0&id=0d389cd1&lang=scss&scoped=true& ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "[data-v-0d389cd1] .breadcrumb ul {\n  margin: 0;\n}\n[data-v-0d389cd1] .breadcrumb ul li {\n  margin: 0;\n}\n[data-v-0d389cd1] .breadcrumb ul li:not(.is-active) a {\n  font-weight: 600;\n}\n[data-v-0d389cd1] .files > div {\n  display: flex;\n  flex-wrap: wrap;\n}\n[data-v-0d389cd1] .files .w-100 {\n  width: 100%;\n}\n[data-v-0d389cd1] .files .text-center {\n  text-align: center;\n}\n[data-v-0d389cd1] .files .my-4 {\n  margin: 2rem 0;\n}\n[data-v-0d389cd1] .files .grid {\n  width: 200px;\n  height: 200px;\n  margin-right: 1rem;\n  margin-bottom: 1rem;\n  overflow: hidden;\n  position: relative;\n}\n[data-v-0d389cd1] .files .grid:hover .folder-item .main-svg,[data-v-0d389cd1] .files .grid:hover .file-item .image-block,[data-v-0d389cd1] .files .grid:hover .file-item .mime-icon {\n  opacity: 0.5;\n}\n[data-v-0d389cd1] .files .grid:hover .folder-item .actions-grid,[data-v-0d389cd1] .files .grid:hover .file-item .actions-grid {\n  display: flex;\n}\n[data-v-0d389cd1] .files .grid .folder-item,[data-v-0d389cd1] .files .grid .file-item {\n  position: absolute;\n  left: 0;\n  right: 0;\n  top: 0;\n  bottom: 0;\n  display: flex;\n  align-items: center;\n  justify-content: center;\n  cursor: pointer;\n  margin: 0;\n}\n[data-v-0d389cd1] .files .grid .folder-item .name,[data-v-0d389cd1] .files .grid .file-item .name {\n  position: absolute;\n  bottom: 0;\n  width: 100%;\n  background: #f8f9fa;\n  font-size: 0.85rem;\n  text-align: center;\n  padding: 0.3rem 0;\n  cursor: pointer;\n  font-weight: 600;\n}\n[data-v-0d389cd1] .files .grid .folder-item .actions-grid,[data-v-0d389cd1] .files .grid .file-item .actions-grid {\n  position: absolute;\n  display: none;\n  right: 7px;\n  top: 7px;\n  color: var(--manatee);\n}\n[data-v-0d389cd1] .files .grid .folder-item .actions-grid > div,[data-v-0d389cd1] .files .grid .file-item .actions-grid > div {\n  display: flex;\n}\n[data-v-0d389cd1] .files .grid .folder-item .actions-grid.is-select,[data-v-0d389cd1] .files .grid .file-item .actions-grid.is-select {\n  display: flex !important;\n}\n[data-v-0d389cd1] .files .grid .folder-item .actions-grid span.icon,[data-v-0d389cd1] .files .grid .file-item .actions-grid span.icon {\n  cursor: pointer;\n}\n[data-v-0d389cd1] .files .grid .folder-item .actions-grid span.icon i:before,[data-v-0d389cd1] .files .grid .file-item .actions-grid span.icon i:before {\n  font-size: 1.4rem;\n}\n[data-v-0d389cd1] .files .grid .folder-item .actions-grid span.icon.trash,[data-v-0d389cd1] .files .grid .file-item .actions-grid span.icon.trash {\n  margin-right: 0.3rem;\n}\n[data-v-0d389cd1] .files .grid .file-item .image-block {\n  position: absolute;\n  transition: opacity 0.3s;\n  top: 39px;\n}\n[data-v-0d389cd1] .files .grid .file-item .image-block .block-grid {\n  width: 150px;\n  height: 130px;\n  background-size: cover;\n  background-position: top center;\n  background-repeat: no-repeat;\n  border-radius: 0.25rem 0.25rem 0 0;\n}\n[data-v-0d389cd1] .files .grid .file-item .mime-icon {\n  transition: opacity 0.3s;\n  margin-top: -25px;\n}\n[data-v-0d389cd1] .files .grid .file-item .mime-icon svg {\n  width: 90px;\n  height: 90px;\n  fill: gainsboro;\n}\n[data-v-0d389cd1] .files .grid .folder-item .main-svg {\n  color: gainsboro;\n  transition: opacity 0.3s;\n  margin-top: -25px;\n}\n[data-v-0d389cd1] .files .grid .folder-item .main-svg i:not(.mdi-undo-variant):before {\n  font-size: 7rem;\n}\n[data-v-0d389cd1] .files .grid .folder-item .main-svg i.mdi-undo-variant:before {\n  font-size: 3rem;\n}\n[data-v-0d389cd1] .custom-control-label::after,[data-v-0d389cd1] .custom-control-label::before {\n  top: 0;\n  left: -1.25rem;\n  width: 1.15rem;\n  height: 1.15rem;\n}", ""]);

// exports


/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/util/filemanager/components/Manager.vue?vue&type=style&index=0&id=0d389cd1&lang=scss&scoped=true&":
/*!**************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/sass-loader/dist/cjs.js??ref--6-3!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/util/filemanager/components/Manager.vue?vue&type=style&index=0&id=0d389cd1&lang=scss&scoped=true& ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../../../node_modules/css-loader!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/src??ref--6-2!../../../../../node_modules/sass-loader/dist/cjs.js??ref--6-3!../../../../../node_modules/vue-loader/lib??vue-loader-options!./Manager.vue?vue&type=style&index=0&id=0d389cd1&lang=scss&scoped=true& */ "./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/util/filemanager/components/Manager.vue?vue&type=style&index=0&id=0d389cd1&lang=scss&scoped=true&");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/util/filemanager/components/Manager.vue?vue&type=template&id=0d389cd1&scoped=true&":
/*!***************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/util/filemanager/components/Manager.vue?vue&type=template&id=0d389cd1&scoped=true& ***!
  \***************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    {
      ref: "fileManagerContainer",
      attrs: { id: "filemanager-manager-container" }
    },
    [
      _c(
        "nav",
        {
          staticClass: "breadcrumb has-arrow-separator",
          attrs: { "aria-label": "breadcrumbs" }
        },
        [
          _c(
            "ul",
            [
              _c("li", [
                _c(
                  "a",
                  {
                    attrs: { href: "#", target: "_self" },
                    on: {
                      click: function($event) {
                        $event.preventDefault()
                        return _vm.goToFolderNav(_vm.home)
                      }
                    }
                  },
                  [_c("b-icon", { attrs: { icon: "folder-home" } })],
                  1
                )
              ]),
              _vm._v(" "),
              _vm._l(_vm.path, function(folder, index) {
                return [
                  _vm.checkIsLastItem(index)
                    ? _c("li", { key: index, staticClass: "is-active" }, [
                        _c(
                          "a",
                          { attrs: { href: "#", "aria-current": "page" } },
                          [_vm._v(_vm._s(folder.name))]
                        )
                      ])
                    : _c("li", { key: index }, [
                        _c(
                          "a",
                          {
                            attrs: { href: "#", target: "_self" },
                            on: {
                              click: function($event) {
                                $event.preventDefault()
                                return _vm.goToFolder(folder.path)
                              }
                            }
                          },
                          [_vm._v(_vm._s(folder.name))]
                        )
                      ])
                ]
              })
            ],
            2
          )
        ]
      ),
      _vm._v(" "),
      _c(
        "vue-custom-scrollbar",
        {
          staticClass: "scroll-area",
          attrs: { tagname: "div", settings: _vm.settings }
        },
        [
          _c("div", { staticClass: "files" }, [
            _c(
              "div",
              [
                _vm.files.error
                  ? [
                      _c("div", { staticClass: "w-100 text-center my-4" }, [
                        _c("h6", [
                          _vm._v("У вас нет прав для просмотра этой папки")
                        ])
                      ])
                    ]
                  : _vm._e(),
                _vm._v(" "),
                _vm.noFiles
                  ? [
                      _c(
                        "div",
                        { staticClass: "w-100 text-center my-4" },
                        [
                          _c("h6", [
                            _vm._v("Нет файлов или папок в текущем каталоге")
                          ]),
                          _vm._v(" "),
                          !_vm.showModal &&
                          _vm.current !== "/" &&
                          _vm.buttons.delete_folder
                            ? _c(
                                "b-button",
                                {
                                  attrs: {
                                    type: "is-danger",
                                    size: "is-normal"
                                  },
                                  on: { click: _vm.removeDirectory }
                                },
                                [_vm._v("Удалить папку")]
                              )
                            : _vm._e()
                        ],
                        1
                      )
                    ]
                  : _vm._e(),
                _vm._v(" "),
                !_vm.files.error
                  ? [
                      [
                        !_vm.files.error
                          ? [
                              _vm.parent.id
                                ? [
                                    _c(
                                      "div",
                                      {
                                        key: _vm.parent.id,
                                        staticClass: "grid"
                                      },
                                      [
                                        _c("Folder", {
                                          ref: "folder_" + _vm.parent.id,
                                          staticClass: "folder-item",
                                          class: { loading: _vm.loadingInfo },
                                          attrs: {
                                            file: _vm.parent,
                                            "data-key": _vm.parent.id
                                          },
                                          on: {
                                            goToFolderEvent: _vm.goToFolder
                                          }
                                        })
                                      ],
                                      1
                                    )
                                  ]
                                : _vm._e(),
                              _vm._v(" "),
                              _vm._l(_vm.filteredFiles, function(file) {
                                return [
                                  _c(
                                    "div",
                                    { key: file.id, staticClass: "grid" },
                                    [
                                      file.type === "file"
                                        ? [
                                            _c("ImageLoader", {
                                              ref: "file_" + file.id,
                                              refInFor: true,
                                              staticClass: "file-item",
                                              attrs: {
                                                file: file,
                                                "data-key": file.id,
                                                "multi-selecting":
                                                  _vm.multiSelecting,
                                                "selected-files":
                                                  _vm.selectedFiles,
                                                "delete-permission":
                                                  _vm.buttons.delete_file,
                                                "rename-permission":
                                                  _vm.buttons.rename_file
                                              },
                                              on: {
                                                missing: function(value) {
                                                  return (_vm.missing = value)
                                                },
                                                showInfo: _vm.showInfo,
                                                rename: _vm.rename,
                                                delete: _vm.deleteData,
                                                select: _vm.select
                                              }
                                            })
                                          ]
                                        : _vm._e(),
                                      _vm._v(" "),
                                      file.type === "dir"
                                        ? [
                                            _c("Folder", {
                                              ref: "folder_" + file.id,
                                              refInFor: true,
                                              staticClass: "folder-item",
                                              class: {
                                                loading: _vm.loadingInfo
                                              },
                                              attrs: {
                                                file: file,
                                                "data-key": file.id,
                                                "multi-selecting":
                                                  _vm.multiSelecting,
                                                "selected-files":
                                                  _vm.selectedFiles,
                                                "delete-permission":
                                                  _vm.buttons.delete_folder,
                                                "rename-permission":
                                                  _vm.buttons.rename_folder
                                              },
                                              on: {
                                                goToFolderEvent: _vm.goToFolder,
                                                rename: _vm.rename,
                                                delete: _vm.deleteData,
                                                select: _vm.select
                                              }
                                            })
                                          ]
                                        : _vm._e()
                                    ],
                                    2
                                  )
                                ]
                              })
                            ]
                          : _vm._e()
                      ]
                    ]
                  : _vm._e()
              ],
              2
            )
          ])
        ]
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/util/filemanager/modules/Folder.vue?vue&type=template&id=20917e5a&":
/*!***********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/util/filemanager/modules/Folder.vue?vue&type=template&id=20917e5a& ***!
  \***********************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("transition", { attrs: { name: "fade" } }, [
    _c(
      "div",
      {
        on: {
          click: function($event) {
            $event.preventDefault()
            return _vm.clickStrategy($event)
          }
        }
      },
      [
        _vm.file.id === "folder_back"
          ? [
              _c("b-icon", {
                staticClass: "main-svg",
                attrs: { icon: "undo-variant" }
              }),
              _vm._v(" "),
              _c("div", { staticClass: "name" }, [_vm._v("Назад")])
            ]
          : [
              _c("b-icon", {
                staticClass: "main-svg",
                attrs: { icon: "folder" }
              }),
              _vm._v(" "),
              !_vm.showModal
                ? _c(
                    "div",
                    {
                      class: [
                        "actions-grid",
                        { "is-select": _vm.multiSelecting }
                      ]
                    },
                    [
                      _vm.multiSelecting
                        ? _c("b-checkbox", {
                            model: {
                              value: _vm.selected,
                              callback: function($$v) {
                                _vm.selected = $$v
                              },
                              expression: "selected"
                            }
                          })
                        : _c(
                            "div",
                            [
                              _vm.deletePermission
                                ? _c("b-icon", {
                                    staticClass: "trash",
                                    attrs: { icon: "delete-sweep" },
                                    nativeOn: {
                                      click: function($event) {
                                        $event.preventDefault()
                                        return _vm.deleteFolder($event)
                                      }
                                    }
                                  })
                                : _vm._e(),
                              _vm._v(" "),
                              _vm.renamePermission
                                ? _c("b-icon", {
                                    attrs: { icon: "square-edit-outline" },
                                    nativeOn: {
                                      click: function($event) {
                                        $event.preventDefault()
                                        return _vm.editFolder($event)
                                      }
                                    }
                                  })
                                : _vm._e()
                            ],
                            1
                          )
                    ],
                    1
                  )
                : _vm._e(),
              _vm._v(" "),
              _c("div", { staticClass: "name" }, [
                _vm._v(
                  "\n                " +
                    _vm._s(_vm.file.name) +
                    "\n            "
                )
              ])
            ]
      ],
      2
    )
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/util/filemanager/modules/ImageLoader.vue?vue&type=template&id=6a3d9039&":
/*!****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/util/filemanager/modules/ImageLoader.vue?vue&type=template&id=6a3d9039& ***!
  \****************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("transition", { attrs: { name: "fade" } }, [
    _c(
      "div",
      {
        staticClass: "card",
        on: {
          click: function($event) {
            $event.preventDefault()
            return _vm.clickStrategy($event)
          }
        }
      },
      [
        _vm.file.mime !== "image"
          ? _c("div", {
              staticClass: "mime-icon",
              domProps: { innerHTML: _vm._s(_vm.file.thumb) }
            })
          : _vm._e(),
        _vm._v(" "),
        _vm.file.mime === "image"
          ? _c("div", { ref: "image", staticClass: "image-block" })
          : _vm._e(),
        _vm._v(" "),
        !_vm.showModal
          ? _c(
              "div",
              { class: ["actions-grid", { "is-select": _vm.multiSelecting }] },
              [
                _vm.multiSelecting
                  ? _c("b-checkbox", {
                      model: {
                        value: _vm.selected,
                        callback: function($$v) {
                          _vm.selected = $$v
                        },
                        expression: "selected"
                      }
                    })
                  : _c(
                      "div",
                      [
                        _vm.deletePermission
                          ? _c("b-icon", {
                              staticClass: "trash",
                              attrs: { icon: "delete-sweep" },
                              nativeOn: {
                                click: function($event) {
                                  $event.preventDefault()
                                  return _vm.deleteFile($event)
                                }
                              }
                            })
                          : _vm._e(),
                        _vm._v(" "),
                        _vm.renamePermission
                          ? _c("b-icon", {
                              attrs: { icon: "square-edit-outline" },
                              nativeOn: {
                                click: function($event) {
                                  $event.preventDefault()
                                  return _vm.renameFile($event)
                                }
                              }
                            })
                          : _vm._e()
                      ],
                      1
                    )
              ],
              1
            )
          : _vm._e(),
        _vm._v(" "),
        _vm.showModal
          ? _c(
              "div",
              { staticClass: "actions-grid is-select is-modal" },
              [
                _c("b-checkbox", {
                  model: {
                    value: _vm.selected,
                    callback: function($$v) {
                      _vm.selected = $$v
                    },
                    expression: "selected"
                  }
                })
              ],
              1
            )
          : _vm._e(),
        _vm._v(" "),
        _c("div", { staticClass: "name" }, [
          _vm._v(
            "\n            " +
              _vm._s(_vm._f("truncate")(_vm.file.name, 25)) +
              "\n        "
          )
        ])
      ]
    )
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/util/event-bus.js":
/*!****************************************!*\
  !*** ./resources/js/util/event-bus.js ***!
  \****************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.common.js");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);

var EventBus = new vue__WEBPACK_IMPORTED_MODULE_0___default.a();
/* harmony default export */ __webpack_exports__["default"] = (EventBus);

/***/ }),

/***/ "./resources/js/util/filemanager/api.js":
/*!**********************************************!*\
  !*** ./resources/js/util/filemanager/api.js ***!
  \**********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_0__);

/* harmony default export */ __webpack_exports__["default"] = ({
  getData: function getData(pathToList, id) {
    return axios__WEBPACK_IMPORTED_MODULE_0___default.a.get('/api/filemanager/data', {
      params: {
        folder: pathToList,
        userId: id
      }
    }).then(function (response) {
      return response.data;
    });
  },
  createFolder: function createFolder(folderName, currentFolder, id) {
    return axios__WEBPACK_IMPORTED_MODULE_0___default.a.post('/api/filemanager/actions/create-folder', {
      folder: folderName,
      current: currentFolder,
      userId: id
    }).then(function (response) {
      return response.data;
    });
  },
  removeDirectory: function removeDirectory(currentFolder, id) {
    return axios__WEBPACK_IMPORTED_MODULE_0___default.a.post('/api/filemanager/actions/delete-folder', {
      current: currentFolder,
      userId: id
    }).then(function (response) {
      return response.data;
    });
  },
  getInfo: function getInfo(file, id) {
    return axios__WEBPACK_IMPORTED_MODULE_0___default.a.post('/api/filemanager/actions/get-info', {
      file: file,
      userId: id
    }).then(function (response) {
      return response.data;
    });
  },
  removeFile: function removeFile(file, id) {
    return axios__WEBPACK_IMPORTED_MODULE_0___default.a.post('/api/filemanager/actions/remove-file', {
      file: file,
      userId: id
    }).then(function (response) {
      return response.data;
    });
  },
  renameFile: function renameFile(file, name, id) {
    return axios__WEBPACK_IMPORTED_MODULE_0___default.a.post('/api/filemanager/actions/rename-file', {
      file: file,
      name: name,
      userId: id
    }).then(function (response) {
      return response.data;
    });
  },
  rename: function rename(path, name, id) {
    return axios__WEBPACK_IMPORTED_MODULE_0___default.a.post('/api/filemanager/actions/rename', {
      path: path,
      name: name,
      userId: id
    }).then(function (response) {
      return response.data;
    });
  }
});

/***/ }),

/***/ "./resources/js/util/filemanager/components/Manager.vue":
/*!**************************************************************!*\
  !*** ./resources/js/util/filemanager/components/Manager.vue ***!
  \**************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Manager_vue_vue_type_template_id_0d389cd1_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Manager.vue?vue&type=template&id=0d389cd1&scoped=true& */ "./resources/js/util/filemanager/components/Manager.vue?vue&type=template&id=0d389cd1&scoped=true&");
/* harmony import */ var _Manager_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Manager.vue?vue&type=script&lang=js& */ "./resources/js/util/filemanager/components/Manager.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _Manager_vue_vue_type_style_index_0_id_0d389cd1_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Manager.vue?vue&type=style&index=0&id=0d389cd1&lang=scss&scoped=true& */ "./resources/js/util/filemanager/components/Manager.vue?vue&type=style&index=0&id=0d389cd1&lang=scss&scoped=true&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _Manager_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Manager_vue_vue_type_template_id_0d389cd1_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Manager_vue_vue_type_template_id_0d389cd1_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "0d389cd1",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/util/filemanager/components/Manager.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/util/filemanager/components/Manager.vue?vue&type=script&lang=js&":
/*!***************************************************************************************!*\
  !*** ./resources/js/util/filemanager/components/Manager.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Manager_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./Manager.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/util/filemanager/components/Manager.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Manager_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/util/filemanager/components/Manager.vue?vue&type=style&index=0&id=0d389cd1&lang=scss&scoped=true&":
/*!************************************************************************************************************************!*\
  !*** ./resources/js/util/filemanager/components/Manager.vue?vue&type=style&index=0&id=0d389cd1&lang=scss&scoped=true& ***!
  \************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_sass_loader_dist_cjs_js_ref_6_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Manager_vue_vue_type_style_index_0_id_0d389cd1_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader!../../../../../node_modules/css-loader!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/src??ref--6-2!../../../../../node_modules/sass-loader/dist/cjs.js??ref--6-3!../../../../../node_modules/vue-loader/lib??vue-loader-options!./Manager.vue?vue&type=style&index=0&id=0d389cd1&lang=scss&scoped=true& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/util/filemanager/components/Manager.vue?vue&type=style&index=0&id=0d389cd1&lang=scss&scoped=true&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_sass_loader_dist_cjs_js_ref_6_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Manager_vue_vue_type_style_index_0_id_0d389cd1_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_sass_loader_dist_cjs_js_ref_6_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Manager_vue_vue_type_style_index_0_id_0d389cd1_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_sass_loader_dist_cjs_js_ref_6_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Manager_vue_vue_type_style_index_0_id_0d389cd1_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_0__) if(__WEBPACK_IMPORT_KEY__ !== 'default') (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_sass_loader_dist_cjs_js_ref_6_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Manager_vue_vue_type_style_index_0_id_0d389cd1_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_sass_loader_dist_cjs_js_ref_6_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Manager_vue_vue_type_style_index_0_id_0d389cd1_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_0___default.a); 

/***/ }),

/***/ "./resources/js/util/filemanager/components/Manager.vue?vue&type=template&id=0d389cd1&scoped=true&":
/*!*********************************************************************************************************!*\
  !*** ./resources/js/util/filemanager/components/Manager.vue?vue&type=template&id=0d389cd1&scoped=true& ***!
  \*********************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Manager_vue_vue_type_template_id_0d389cd1_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./Manager.vue?vue&type=template&id=0d389cd1&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/util/filemanager/components/Manager.vue?vue&type=template&id=0d389cd1&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Manager_vue_vue_type_template_id_0d389cd1_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Manager_vue_vue_type_template_id_0d389cd1_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/util/filemanager/modules/Folder.vue":
/*!**********************************************************!*\
  !*** ./resources/js/util/filemanager/modules/Folder.vue ***!
  \**********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Folder_vue_vue_type_template_id_20917e5a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Folder.vue?vue&type=template&id=20917e5a& */ "./resources/js/util/filemanager/modules/Folder.vue?vue&type=template&id=20917e5a&");
/* harmony import */ var _Folder_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Folder.vue?vue&type=script&lang=js& */ "./resources/js/util/filemanager/modules/Folder.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Folder_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Folder_vue_vue_type_template_id_20917e5a___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Folder_vue_vue_type_template_id_20917e5a___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/util/filemanager/modules/Folder.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/util/filemanager/modules/Folder.vue?vue&type=script&lang=js&":
/*!***********************************************************************************!*\
  !*** ./resources/js/util/filemanager/modules/Folder.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Folder_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./Folder.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/util/filemanager/modules/Folder.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Folder_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/util/filemanager/modules/Folder.vue?vue&type=template&id=20917e5a&":
/*!*****************************************************************************************!*\
  !*** ./resources/js/util/filemanager/modules/Folder.vue?vue&type=template&id=20917e5a& ***!
  \*****************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Folder_vue_vue_type_template_id_20917e5a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./Folder.vue?vue&type=template&id=20917e5a& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/util/filemanager/modules/Folder.vue?vue&type=template&id=20917e5a&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Folder_vue_vue_type_template_id_20917e5a___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Folder_vue_vue_type_template_id_20917e5a___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/util/filemanager/modules/ImageLoader.vue":
/*!***************************************************************!*\
  !*** ./resources/js/util/filemanager/modules/ImageLoader.vue ***!
  \***************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ImageLoader_vue_vue_type_template_id_6a3d9039___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ImageLoader.vue?vue&type=template&id=6a3d9039& */ "./resources/js/util/filemanager/modules/ImageLoader.vue?vue&type=template&id=6a3d9039&");
/* harmony import */ var _ImageLoader_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ImageLoader.vue?vue&type=script&lang=js& */ "./resources/js/util/filemanager/modules/ImageLoader.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _ImageLoader_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ImageLoader_vue_vue_type_template_id_6a3d9039___WEBPACK_IMPORTED_MODULE_0__["render"],
  _ImageLoader_vue_vue_type_template_id_6a3d9039___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/util/filemanager/modules/ImageLoader.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/util/filemanager/modules/ImageLoader.vue?vue&type=script&lang=js&":
/*!****************************************************************************************!*\
  !*** ./resources/js/util/filemanager/modules/ImageLoader.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ImageLoader_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./ImageLoader.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/util/filemanager/modules/ImageLoader.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ImageLoader_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/util/filemanager/modules/ImageLoader.vue?vue&type=template&id=6a3d9039&":
/*!**********************************************************************************************!*\
  !*** ./resources/js/util/filemanager/modules/ImageLoader.vue?vue&type=template&id=6a3d9039& ***!
  \**********************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ImageLoader_vue_vue_type_template_id_6a3d9039___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./ImageLoader.vue?vue&type=template&id=6a3d9039& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/util/filemanager/modules/ImageLoader.vue?vue&type=template&id=6a3d9039&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ImageLoader_vue_vue_type_template_id_6a3d9039___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ImageLoader_vue_vue_type_template_id_6a3d9039___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/util/helper.js":
/*!*************************************!*\
  !*** ./resources/js/util/helper.js ***!
  \*************************************/
/*! exports provided: getToast */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "getToast", function() { return getToast; });
var getToast = function getToast(self, variant, message) {
  return self.$buefy.toast.open({
    duration: 5000,
    message: message,
    position: 'is-top',
    type: 'is-' + variant
  });
};



/***/ })

}]);