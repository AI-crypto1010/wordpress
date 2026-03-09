(self["webpackChunkelementor"] = self["webpackChunkelementor"] || []).push([["modules_nested-elements_assets_js_editor_nested-element-types-base_js"],{

/***/ "../assets/dev/js/editor/utils/editor-one-events.js":
/*!**********************************************************!*\
  !*** ../assets/dev/js/editor/utils/editor-one-events.js ***!
  \**********************************************************/
/***/ ((__unused_webpack_module, exports, __webpack_require__) => {

"use strict";


var _interopRequireDefault = __webpack_require__(/*! @babel/runtime/helpers/interopRequireDefault */ "../node_modules/@babel/runtime/helpers/interopRequireDefault.js");
Object.defineProperty(exports, "__esModule", ({
  value: true
}));
exports["default"] = exports.createDebouncedWidgetPanelSearch = exports.createDebouncedFinderSearch = exports.EditorOneEventManager = void 0;
var _defineProperty2 = _interopRequireDefault(__webpack_require__(/*! @babel/runtime/helpers/defineProperty */ "../node_modules/@babel/runtime/helpers/defineProperty.js"));
var _classCallCheck2 = _interopRequireDefault(__webpack_require__(/*! @babel/runtime/helpers/classCallCheck */ "../node_modules/@babel/runtime/helpers/classCallCheck.js"));
var _createClass2 = _interopRequireDefault(__webpack_require__(/*! @babel/runtime/helpers/createClass */ "../node_modules/@babel/runtime/helpers/createClass.js"));
function ownKeys(e, r) { var t = Object.keys(e); if (Object.getOwnPropertySymbols) { var o = Object.getOwnPropertySymbols(e); r && (o = o.filter(function (r) { return Object.getOwnPropertyDescriptor(e, r).enumerable; })), t.push.apply(t, o); } return t; }
function _objectSpread(e) { for (var r = 1; r < arguments.length; r++) { var t = null != arguments[r] ? arguments[r] : {}; r % 2 ? ownKeys(Object(t), !0).forEach(function (r) { (0, _defineProperty2.default)(e, r, t[r]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(t)) : ownKeys(Object(t)).forEach(function (r) { Object.defineProperty(e, r, Object.getOwnPropertyDescriptor(t, r)); }); } return e; }
var EditorOneEventManager = exports.EditorOneEventManager = /*#__PURE__*/function () {
  function EditorOneEventManager() {
    (0, _classCallCheck2.default)(this, EditorOneEventManager);
  }
  return (0, _createClass2.default)(EditorOneEventManager, null, [{
    key: "getEventsManager",
    value: function getEventsManager() {
      var _elementorCommon;
      return (_elementorCommon = elementorCommon) === null || _elementorCommon === void 0 ? void 0 : _elementorCommon.eventsManager;
    }
  }, {
    key: "getConfig",
    value: function getConfig() {
      var _this$getEventsManage;
      return (_this$getEventsManage = this.getEventsManager()) === null || _this$getEventsManage === void 0 ? void 0 : _this$getEventsManage.config;
    }
  }, {
    key: "canSendEvents",
    value: function canSendEvents() {
      var _elementorCommon2;
      return ((_elementorCommon2 = elementorCommon) === null || _elementorCommon2 === void 0 || (_elementorCommon2 = _elementorCommon2.config) === null || _elementorCommon2 === void 0 || (_elementorCommon2 = _elementorCommon2.editor_events) === null || _elementorCommon2 === void 0 ? void 0 : _elementorCommon2.can_send_events) || false;
    }
  }, {
    key: "isEventsManagerAvailable",
    value: function isEventsManagerAvailable() {
      var eventsManager = this.getEventsManager();
      return eventsManager && 'function' === typeof eventsManager.dispatchEvent;
    }
  }, {
    key: "dispatchEvent",
    value: function dispatchEvent(eventName, payload) {
      if (!this.isEventsManagerAvailable() || !this.canSendEvents()) {
        return false;
      }
      try {
        return this.getEventsManager().dispatchEvent(eventName, payload);
      } catch (error) {
        return false;
      }
    }
  }, {
    key: "toLowerSnake",
    value: function toLowerSnake(value) {
      if (!value || 'string' !== typeof value) {
        return value;
      }
      return value.replace(/\s+/g, '_').toLowerCase();
    }
  }, {
    key: "decodeHtmlEntities",
    value: function decodeHtmlEntities(text) {
      if (!text || 'string' !== typeof text) {
        return text;
      }
      var doc = new DOMParser().parseFromString(text, 'text/html');
      return doc.body.textContent || text;
    }
  }, {
    key: "isInEditorContext",
    value: function isInEditorContext() {
      var _window$elementor;
      return 'undefined' !== typeof window.elementor && !!((_window$elementor = window.elementor) !== null && _window$elementor !== void 0 && _window$elementor.documents);
    }
  }, {
    key: "getFinderContext",
    value: function getFinderContext() {
      var _config$appTypes, _config$appTypes2, _config$locations, _config$locations2;
      var config = this.getConfig();
      var isEditor = this.isInEditorContext();
      return {
        windowName: isEditor ? config === null || config === void 0 || (_config$appTypes = config.appTypes) === null || _config$appTypes === void 0 ? void 0 : _config$appTypes.editor : config === null || config === void 0 || (_config$appTypes2 = config.appTypes) === null || _config$appTypes2 === void 0 ? void 0 : _config$appTypes2.wpAdmin,
        targetLocation: this.toLowerSnake(isEditor ? config === null || config === void 0 || (_config$locations = config.locations) === null || _config$locations === void 0 ? void 0 : _config$locations.topBar : config === null || config === void 0 || (_config$locations2 = config.locations) === null || _config$locations2 === void 0 ? void 0 : _config$locations2.sidebar)
      };
    }
  }, {
    key: "createBasePayload",
    value: function createBasePayload() {
      var _config$appTypes$edit, _config$appTypes3, _config$appTypes$edit2, _config$appTypes4;
      var overrides = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
      var config = this.getConfig();
      return _objectSpread({
        app_type: (_config$appTypes$edit = config === null || config === void 0 || (_config$appTypes3 = config.appTypes) === null || _config$appTypes3 === void 0 ? void 0 : _config$appTypes3.editor) !== null && _config$appTypes$edit !== void 0 ? _config$appTypes$edit : 'editor',
        window_name: (_config$appTypes$edit2 = config === null || config === void 0 || (_config$appTypes4 = config.appTypes) === null || _config$appTypes4 === void 0 ? void 0 : _config$appTypes4.editor) !== null && _config$appTypes$edit2 !== void 0 ? _config$appTypes$edit2 : 'editor'
      }, overrides);
    }
  }, {
    key: "sendTopBarPublishDropdown",
    value: function sendTopBarPublishDropdown(targetName) {
      var _config$names, _config$triggers, _config$targetTypes, _config$interactionRe, _config$locations3, _config$secondaryLoca, _config$targetTypes2;
      var config = this.getConfig();
      return this.dispatchEvent(config === null || config === void 0 || (_config$names = config.names) === null || _config$names === void 0 || (_config$names = _config$names.editorOne) === null || _config$names === void 0 ? void 0 : _config$names.topBarPublishDropdown, this.createBasePayload({
        interaction_type: this.toLowerSnake(config === null || config === void 0 || (_config$triggers = config.triggers) === null || _config$triggers === void 0 ? void 0 : _config$triggers.click),
        target_type: config === null || config === void 0 || (_config$targetTypes = config.targetTypes) === null || _config$targetTypes === void 0 ? void 0 : _config$targetTypes.dropdownItem,
        target_name: targetName,
        interaction_result: config === null || config === void 0 || (_config$interactionRe = config.interactionResults) === null || _config$interactionRe === void 0 ? void 0 : _config$interactionRe.actionSelected,
        target_location: this.toLowerSnake(config === null || config === void 0 || (_config$locations3 = config.locations) === null || _config$locations3 === void 0 ? void 0 : _config$locations3.topBar),
        location_l1: this.toLowerSnake(config === null || config === void 0 || (_config$secondaryLoca = config.secondaryLocations) === null || _config$secondaryLoca === void 0 ? void 0 : _config$secondaryLoca.publishDropdown),
        location_l2: config === null || config === void 0 || (_config$targetTypes2 = config.targetTypes) === null || _config$targetTypes2 === void 0 ? void 0 : _config$targetTypes2.dropdownItem,
        interaction_description: 'User selected an action from the publish dropdown'
      }));
    }
  }, {
    key: "sendTopBarPageList",
    value: function sendTopBarPageList(targetName) {
      var _config$names2, _config$triggers2, _config$targetTypes3, _config$interactionRe2, _config$interactionRe3, _config$locations4, _config$secondaryLoca2, _config$targetTypes4;
      var isCreate = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
      var config = this.getConfig();
      return this.dispatchEvent(config === null || config === void 0 || (_config$names2 = config.names) === null || _config$names2 === void 0 || (_config$names2 = _config$names2.editorOne) === null || _config$names2 === void 0 ? void 0 : _config$names2.topBarPageList, this.createBasePayload({
        interaction_type: this.toLowerSnake(config === null || config === void 0 || (_config$triggers2 = config.triggers) === null || _config$triggers2 === void 0 ? void 0 : _config$triggers2.click),
        target_type: config === null || config === void 0 || (_config$targetTypes3 = config.targetTypes) === null || _config$targetTypes3 === void 0 ? void 0 : _config$targetTypes3.dropdownItem,
        target_name: targetName,
        interaction_result: isCreate ? config === null || config === void 0 || (_config$interactionRe2 = config.interactionResults) === null || _config$interactionRe2 === void 0 ? void 0 : _config$interactionRe2.create : config === null || config === void 0 || (_config$interactionRe3 = config.interactionResults) === null || _config$interactionRe3 === void 0 ? void 0 : _config$interactionRe3.navigate,
        target_location: this.toLowerSnake(config === null || config === void 0 || (_config$locations4 = config.locations) === null || _config$locations4 === void 0 ? void 0 : _config$locations4.topBar),
        location_l1: this.toLowerSnake(config === null || config === void 0 || (_config$secondaryLoca2 = config.secondaryLocations) === null || _config$secondaryLoca2 === void 0 ? void 0 : _config$secondaryLoca2.pageListDropdown),
        location_l2: config === null || config === void 0 || (_config$targetTypes4 = config.targetTypes) === null || _config$targetTypes4 === void 0 ? void 0 : _config$targetTypes4.dropdownItem,
        interaction_description: 'User selected an action from the page list dropdown'
      }));
    }
  }, {
    key: "sendSiteSettingsSession",
    value: function sendSiteSettingsSession(_ref) {
      var _config$names3, _config$triggers3, _config$interactionRe4, _config$locations5, _config$secondaryLoca3;
      var targetType = _ref.targetType,
        _ref$visitedItems = _ref.visitedItems,
        visitedItems = _ref$visitedItems === void 0 ? [] : _ref$visitedItems,
        _ref$savedItems = _ref.savedItems,
        savedItems = _ref$savedItems === void 0 ? [] : _ref$savedItems,
        state = _ref.state;
      var config = this.getConfig();
      return this.dispatchEvent(config === null || config === void 0 || (_config$names3 = config.names) === null || _config$names3 === void 0 || (_config$names3 = _config$names3.editorOne) === null || _config$names3 === void 0 ? void 0 : _config$names3.siteSettingsSession, this.createBasePayload({
        interaction_type: this.toLowerSnake(config === null || config === void 0 || (_config$triggers3 = config.triggers) === null || _config$triggers3 === void 0 ? void 0 : _config$triggers3.click),
        target_type: targetType,
        target_name: 'site_settings',
        interaction_result: config === null || config === void 0 || (_config$interactionRe4 = config.interactionResults) === null || _config$interactionRe4 === void 0 ? void 0 : _config$interactionRe4.sessionEnd,
        target_location: this.toLowerSnake(config === null || config === void 0 || (_config$locations5 = config.locations) === null || _config$locations5 === void 0 ? void 0 : _config$locations5.leftPanel),
        location_l1: this.toLowerSnake(config === null || config === void 0 || (_config$secondaryLoca3 = config.secondaryLocations) === null || _config$secondaryLoca3 === void 0 ? void 0 : _config$secondaryLoca3.siteSettings),
        interaction_description: 'Records areas visited as part of the site setting session',
        metadata: {
          visited_items: visitedItems,
          saved_items: savedItems
        },
        state: state
      }));
    }
  }, {
    key: "sendELibraryNav",
    value: function sendELibraryNav(tabName) {
      var _config$names4, _config$triggers4, _config$targetTypes5, _config$interactionRe5, _config$locations6, _config$secondaryLoca4;
      var config = this.getConfig();
      return this.dispatchEvent(config === null || config === void 0 || (_config$names4 = config.names) === null || _config$names4 === void 0 || (_config$names4 = _config$names4.editorOne) === null || _config$names4 === void 0 ? void 0 : _config$names4.eLibraryNav, this.createBasePayload({
        interaction_type: this.toLowerSnake(config === null || config === void 0 || (_config$triggers4 = config.triggers) === null || _config$triggers4 === void 0 ? void 0 : _config$triggers4.tabSelect),
        target_type: config === null || config === void 0 || (_config$targetTypes5 = config.targetTypes) === null || _config$targetTypes5 === void 0 ? void 0 : _config$targetTypes5.tab,
        target_name: this.toLowerSnake(tabName),
        interaction_result: config === null || config === void 0 || (_config$interactionRe5 = config.interactionResults) === null || _config$interactionRe5 === void 0 ? void 0 : _config$interactionRe5.tabChanged,
        target_location: this.toLowerSnake(config === null || config === void 0 || (_config$locations6 = config.locations) === null || _config$locations6 === void 0 ? void 0 : _config$locations6.elementorLibrary),
        location_l1: this.toLowerSnake(config === null || config === void 0 || (_config$secondaryLoca4 = config.secondaryLocations) === null || _config$secondaryLoca4 === void 0 ? void 0 : _config$secondaryLoca4.libraryTabs),
        interaction_description: 'User navigates within elementor library'
      }));
    }
  }, {
    key: "sendELibraryInsert",
    value: function sendELibraryInsert(_ref2) {
      var _config$triggers5, _config$targetTypes6, _config$interactionRe6, _config$locations7, _config$secondaryLoca5, _config$names5;
      var assetId = _ref2.assetId,
        assetName = _ref2.assetName,
        libraryType = _ref2.libraryType,
        _ref2$proRequired = _ref2.proRequired,
        proRequired = _ref2$proRequired === void 0 ? false : _ref2$proRequired;
      var config = this.getConfig();
      var payload = this.createBasePayload({
        interaction_type: this.toLowerSnake(config === null || config === void 0 || (_config$triggers5 = config.triggers) === null || _config$triggers5 === void 0 ? void 0 : _config$triggers5.insert),
        target_type: config === null || config === void 0 || (_config$targetTypes6 = config.targetTypes) === null || _config$targetTypes6 === void 0 ? void 0 : _config$targetTypes6.button,
        target_name: String(assetId),
        interaction_result: config === null || config === void 0 || (_config$interactionRe6 = config.interactionResults) === null || _config$interactionRe6 === void 0 ? void 0 : _config$interactionRe6.assetInserted,
        target_location: this.toLowerSnake(config === null || config === void 0 || (_config$locations7 = config.locations) === null || _config$locations7 === void 0 ? void 0 : _config$locations7.elementorLibrary),
        location_l1: this.toLowerSnake(libraryType),
        location_l2: this.toLowerSnake(config === null || config === void 0 || (_config$secondaryLoca5 = config.secondaryLocations) === null || _config$secondaryLoca5 === void 0 ? void 0 : _config$secondaryLoca5.assetCard),
        interaction_description: 'User inserts block/pages from elementor library',
        metadata: {
          template_id: String(assetId),
          template_name: this.decodeHtmlEntities(assetName) || ''
        }
      });
      if (proRequired) {
        payload.state = 'pro_plan_required';
      }
      return this.dispatchEvent(config === null || config === void 0 || (_config$names5 = config.names) === null || _config$names5 === void 0 || (_config$names5 = _config$names5.editorOne) === null || _config$names5 === void 0 ? void 0 : _config$names5.eLibraryInsert, payload);
    }
  }, {
    key: "sendELibraryFavorite",
    value: function sendELibraryFavorite(_ref3) {
      var _config$triggers6, _config$targetTypes7, _config$interactionRe7, _config$locations8, _config$secondaryLoca6, _config$names6;
      var assetId = _ref3.assetId,
        assetName = _ref3.assetName,
        libraryType = _ref3.libraryType,
        isFavorite = _ref3.isFavorite,
        _ref3$proRequired = _ref3.proRequired,
        proRequired = _ref3$proRequired === void 0 ? false : _ref3$proRequired;
      var config = this.getConfig();
      var payload = this.createBasePayload({
        interaction_type: this.toLowerSnake(config === null || config === void 0 || (_config$triggers6 = config.triggers) === null || _config$triggers6 === void 0 ? void 0 : _config$triggers6.click),
        target_type: config === null || config === void 0 || (_config$targetTypes7 = config.targetTypes) === null || _config$targetTypes7 === void 0 ? void 0 : _config$targetTypes7.toggle,
        target_name: String(assetId),
        interaction_result: config === null || config === void 0 || (_config$interactionRe7 = config.interactionResults) === null || _config$interactionRe7 === void 0 ? void 0 : _config$interactionRe7.assetFavorite,
        target_value: Boolean(isFavorite),
        target_location: this.toLowerSnake(config === null || config === void 0 || (_config$locations8 = config.locations) === null || _config$locations8 === void 0 ? void 0 : _config$locations8.elementorLibrary),
        location_l1: this.toLowerSnake(libraryType),
        location_l2: this.toLowerSnake(config === null || config === void 0 || (_config$secondaryLoca6 = config.secondaryLocations) === null || _config$secondaryLoca6 === void 0 ? void 0 : _config$secondaryLoca6.assetCard),
        interaction_description: 'User favorite block/pages from elementor library',
        metadata: {
          template_id: String(assetId),
          template_name: this.decodeHtmlEntities(assetName) || ''
        }
      });
      if (proRequired) {
        payload.state = 'pro_plan_required';
      }
      return this.dispatchEvent(config === null || config === void 0 || (_config$names6 = config.names) === null || _config$names6 === void 0 || (_config$names6 = _config$names6.editorOne) === null || _config$names6 === void 0 ? void 0 : _config$names6.eLibraryFavorite, payload);
    }
  }, {
    key: "sendELibraryGenerateAi",
    value: function sendELibraryGenerateAi(_ref4) {
      var _config$names7, _config$triggers7, _config$targetTypes8, _config$interactionRe8, _config$locations9, _config$secondaryLoca7;
      var assetId = _ref4.assetId,
        assetName = _ref4.assetName,
        libraryType = _ref4.libraryType;
      var config = this.getConfig();
      return this.dispatchEvent(config === null || config === void 0 || (_config$names7 = config.names) === null || _config$names7 === void 0 || (_config$names7 = _config$names7.editorOne) === null || _config$names7 === void 0 ? void 0 : _config$names7.eLibraryGenerateAi, this.createBasePayload({
        interaction_type: this.toLowerSnake(config === null || config === void 0 || (_config$triggers7 = config.triggers) === null || _config$triggers7 === void 0 ? void 0 : _config$triggers7.click),
        target_type: config === null || config === void 0 || (_config$targetTypes8 = config.targetTypes) === null || _config$targetTypes8 === void 0 ? void 0 : _config$targetTypes8.button,
        target_name: String(assetId),
        interaction_result: config === null || config === void 0 || (_config$interactionRe8 = config.interactionResults) === null || _config$interactionRe8 === void 0 ? void 0 : _config$interactionRe8.aiGenerate,
        target_location: this.toLowerSnake(config === null || config === void 0 || (_config$locations9 = config.locations) === null || _config$locations9 === void 0 ? void 0 : _config$locations9.elementorLibrary),
        location_l1: this.toLowerSnake(libraryType),
        location_l2: this.toLowerSnake(config === null || config === void 0 || (_config$secondaryLoca7 = config.secondaryLocations) === null || _config$secondaryLoca7 === void 0 ? void 0 : _config$secondaryLoca7.assetCard),
        interaction_description: 'User generated block/page based on a library asset',
        metadata: {
          template_id: String(assetId),
          template_name: this.decodeHtmlEntities(assetName) || ''
        }
      }));
    }
  }, {
    key: "sendFinderSearchInput",
    value: function sendFinderSearchInput(_ref5) {
      var _config$triggers8, _config$targetTypes9, _config$interactionRe9, _config$interactionRe0, _config$secondaryLoca8, _config$names8;
      var resultsCount = _ref5.resultsCount,
        _ref5$searchTerm = _ref5.searchTerm,
        searchTerm = _ref5$searchTerm === void 0 ? null : _ref5$searchTerm;
      var config = this.getConfig();
      var hasResults = resultsCount > 0;
      var finderContext = this.getFinderContext();
      var payload = this.createBasePayload({
        window_name: finderContext.windowName,
        interaction_type: this.toLowerSnake(config === null || config === void 0 || (_config$triggers8 = config.triggers) === null || _config$triggers8 === void 0 ? void 0 : _config$triggers8.typing),
        target_type: config === null || config === void 0 || (_config$targetTypes9 = config.targetTypes) === null || _config$targetTypes9 === void 0 ? void 0 : _config$targetTypes9.searchInput,
        target_name: 'finder',
        interaction_result: hasResults ? config === null || config === void 0 || (_config$interactionRe9 = config.interactionResults) === null || _config$interactionRe9 === void 0 ? void 0 : _config$interactionRe9.resultsUpdated : config === null || config === void 0 || (_config$interactionRe0 = config.interactionResults) === null || _config$interactionRe0 === void 0 ? void 0 : _config$interactionRe0.noResults,
        target_location: finderContext.targetLocation,
        location_l1: this.toLowerSnake(config === null || config === void 0 || (_config$secondaryLoca8 = config.secondaryLocations) === null || _config$secondaryLoca8 === void 0 ? void 0 : _config$secondaryLoca8.finder),
        interaction_description: 'Finder search input, follows debounce behavior',
        metadata: {
          results_count: resultsCount
        }
      });
      if (!hasResults && searchTerm) {
        payload.metadata.search_term = searchTerm;
      }
      return this.dispatchEvent(config === null || config === void 0 || (_config$names8 = config.names) === null || _config$names8 === void 0 || (_config$names8 = _config$names8.editorOne) === null || _config$names8 === void 0 ? void 0 : _config$names8.finderSearchInput, payload);
    }
  }, {
    key: "sendFinderResultSelect",
    value: function sendFinderResultSelect(choice) {
      var _config$names9, _config$triggers9, _config$targetTypes0, _config$interactionRe1, _config$secondaryLoca9, _config$secondaryLoca0;
      var config = this.getConfig();
      var finderContext = this.getFinderContext();
      return this.dispatchEvent(config === null || config === void 0 || (_config$names9 = config.names) === null || _config$names9 === void 0 || (_config$names9 = _config$names9.editorOne) === null || _config$names9 === void 0 ? void 0 : _config$names9.finderResultSelect, this.createBasePayload({
        window_name: finderContext.windowName,
        interaction_type: this.toLowerSnake(config === null || config === void 0 || (_config$triggers9 = config.triggers) === null || _config$triggers9 === void 0 ? void 0 : _config$triggers9.click),
        target_type: config === null || config === void 0 || (_config$targetTypes0 = config.targetTypes) === null || _config$targetTypes0 === void 0 ? void 0 : _config$targetTypes0.searchResult,
        target_name: choice,
        interaction_result: config === null || config === void 0 || (_config$interactionRe1 = config.interactionResults) === null || _config$interactionRe1 === void 0 ? void 0 : _config$interactionRe1.selected,
        target_location: finderContext.targetLocation,
        location_l1: this.toLowerSnake(config === null || config === void 0 || (_config$secondaryLoca9 = config.secondaryLocations) === null || _config$secondaryLoca9 === void 0 ? void 0 : _config$secondaryLoca9.finder),
        location_l2: this.toLowerSnake(config === null || config === void 0 || (_config$secondaryLoca0 = config.secondaryLocations) === null || _config$secondaryLoca0 === void 0 ? void 0 : _config$secondaryLoca0.finderResults),
        interaction_description: 'Finder search results was selected'
      }));
    }
  }, {
    key: "sendCanvasEmptyBoxAction",
    value: function sendCanvasEmptyBoxAction(_ref6) {
      var _config$triggers0, _config$targetTypes1, _config$interactionRe10, _config$locations0, _config$secondaryLoca1, _config$names0;
      var targetName = _ref6.targetName,
        _ref6$metadata = _ref6.metadata,
        metadata = _ref6$metadata === void 0 ? {} : _ref6$metadata,
        _ref6$containerCreate = _ref6.containerCreated,
        containerCreated = _ref6$containerCreate === void 0 ? null : _ref6$containerCreate;
      var config = this.getConfig();
      var payload = this.createBasePayload({
        interaction_type: this.toLowerSnake(config === null || config === void 0 || (_config$triggers0 = config.triggers) === null || _config$triggers0 === void 0 ? void 0 : _config$triggers0.click),
        target_type: config === null || config === void 0 || (_config$targetTypes1 = config.targetTypes) === null || _config$targetTypes1 === void 0 ? void 0 : _config$targetTypes1.buttons,
        target_name: targetName,
        interaction_result: config === null || config === void 0 || (_config$interactionRe10 = config.interactionResults) === null || _config$interactionRe10 === void 0 ? void 0 : _config$interactionRe10.selected,
        target_location: this.toLowerSnake(config === null || config === void 0 || (_config$locations0 = config.locations) === null || _config$locations0 === void 0 ? void 0 : _config$locations0.canvas),
        location_l1: this.toLowerSnake(config === null || config === void 0 || (_config$secondaryLoca1 = config.secondaryLocations) === null || _config$secondaryLoca1 === void 0 ? void 0 : _config$secondaryLoca1.emptyBox),
        interaction_description: 'Empty box on canvas actions'
      });
      if (Object.keys(metadata).length > 0) {
        payload.metadata = metadata;
      }
      if (containerCreated !== null) {
        payload.state = containerCreated;
      }
      return this.dispatchEvent(config === null || config === void 0 || (_config$names0 = config.names) === null || _config$names0 === void 0 || (_config$names0 = _config$names0.editorOne) === null || _config$names0 === void 0 ? void 0 : _config$names0.canvasEmptyBoxAction, payload);
    }
  }, {
    key: "sendWidgetPanelSearch",
    value: function sendWidgetPanelSearch(_ref7) {
      var _config$triggers1, _config$targetTypes10, _config$interactionRe11, _config$interactionRe12, _config$locations1, _config$locations10, _config$secondaryLoca10, _config$names1;
      var resultsCount = _ref7.resultsCount,
        _ref7$userInput = _ref7.userInput,
        userInput = _ref7$userInput === void 0 ? null : _ref7$userInput;
      var config = this.getConfig();
      var hasResults = resultsCount > 0;
      var payload = this.createBasePayload({
        interaction_type: this.toLowerSnake(config === null || config === void 0 || (_config$triggers1 = config.triggers) === null || _config$triggers1 === void 0 ? void 0 : _config$triggers1.typing),
        target_type: config === null || config === void 0 || (_config$targetTypes10 = config.targetTypes) === null || _config$targetTypes10 === void 0 ? void 0 : _config$targetTypes10.searchWidget,
        target_name: 'search_widget',
        interaction_result: hasResults ? config === null || config === void 0 || (_config$interactionRe11 = config.interactionResults) === null || _config$interactionRe11 === void 0 ? void 0 : _config$interactionRe11.resultsUpdated : config === null || config === void 0 || (_config$interactionRe12 = config.interactionResults) === null || _config$interactionRe12 === void 0 ? void 0 : _config$interactionRe12.noResults,
        target_location: this.toLowerSnake(config === null || config === void 0 || (_config$locations1 = config.locations) === null || _config$locations1 === void 0 ? void 0 : _config$locations1.leftPanel),
        location_l1: this.toLowerSnake(config === null || config === void 0 || (_config$locations10 = config.locations) === null || _config$locations10 === void 0 ? void 0 : _config$locations10.widgetPanel),
        location_l2: this.toLowerSnake(config === null || config === void 0 || (_config$secondaryLoca10 = config.secondaryLocations) === null || _config$secondaryLoca10 === void 0 ? void 0 : _config$secondaryLoca10.searchBar),
        interaction_description: 'Widget search input, follows debounce behavior'
      });
      if (!hasResults && userInput) {
        payload.metadata = {
          user_input: userInput
        };
      }
      return this.dispatchEvent(config === null || config === void 0 || (_config$names1 = config.names) === null || _config$names1 === void 0 || (_config$names1 = _config$names1.editorOne) === null || _config$names1 === void 0 ? void 0 : _config$names1.widgetPanelSearch, payload);
    }
  }]);
}();
var createDebouncedFinderSearch = exports.createDebouncedFinderSearch = function createDebouncedFinderSearch() {
  var delay = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 300;
  return _.debounce(function (resultsCount, searchTerm) {
    EditorOneEventManager.sendFinderSearchInput({
      resultsCount: resultsCount,
      searchTerm: searchTerm
    });
  }, delay);
};
var createDebouncedWidgetPanelSearch = exports.createDebouncedWidgetPanelSearch = function createDebouncedWidgetPanelSearch() {
  var delay = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 2000;
  return _.debounce(function (resultsCount, userInput) {
    EditorOneEventManager.sendWidgetPanelSearch({
      resultsCount: resultsCount,
      userInput: userInput
    });
  }, delay);
};
var _default = exports["default"] = EditorOneEventManager;

/***/ }),

/***/ "../modules/nested-elements/assets/js/editor/nested-element-types-base.js":
/*!********************************************************************************!*\
  !*** ../modules/nested-elements/assets/js/editor/nested-element-types-base.js ***!
  \********************************************************************************/
/***/ ((__unused_webpack_module, exports, __webpack_require__) => {

"use strict";


var _interopRequireDefault = __webpack_require__(/*! @babel/runtime/helpers/interopRequireDefault */ "../node_modules/@babel/runtime/helpers/interopRequireDefault.js");
Object.defineProperty(exports, "__esModule", ({
  value: true
}));
exports["default"] = exports.NestedElementTypesBase = void 0;
var _classCallCheck2 = _interopRequireDefault(__webpack_require__(/*! @babel/runtime/helpers/classCallCheck */ "../node_modules/@babel/runtime/helpers/classCallCheck.js"));
var _createClass2 = _interopRequireDefault(__webpack_require__(/*! @babel/runtime/helpers/createClass */ "../node_modules/@babel/runtime/helpers/createClass.js"));
var _possibleConstructorReturn2 = _interopRequireDefault(__webpack_require__(/*! @babel/runtime/helpers/possibleConstructorReturn */ "../node_modules/@babel/runtime/helpers/possibleConstructorReturn.js"));
var _getPrototypeOf2 = _interopRequireDefault(__webpack_require__(/*! @babel/runtime/helpers/getPrototypeOf */ "../node_modules/@babel/runtime/helpers/getPrototypeOf.js"));
var _inherits2 = _interopRequireDefault(__webpack_require__(/*! @babel/runtime/helpers/inherits */ "../node_modules/@babel/runtime/helpers/inherits.js"));
var _view = _interopRequireDefault(__webpack_require__(/*! ./views/view */ "../modules/nested-elements/assets/js/editor/views/view.js"));
var _empty = _interopRequireDefault(__webpack_require__(/*! ./views/empty */ "../modules/nested-elements/assets/js/editor/views/empty.js"));
function _callSuper(t, o, e) { return o = (0, _getPrototypeOf2.default)(o), (0, _possibleConstructorReturn2.default)(t, _isNativeReflectConstruct() ? Reflect.construct(o, e || [], (0, _getPrototypeOf2.default)(t).constructor) : o.apply(t, e)); }
function _isNativeReflectConstruct() { try { var t = !Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})); } catch (t) {} return (_isNativeReflectConstruct = function _isNativeReflectConstruct() { return !!t; })(); }
/**
 * @typedef {import('../../../../../assets/dev/js/editor/elements/types/base/element-base')} ElementBase
 */
var NestedElementTypesBase = exports.NestedElementTypesBase = /*#__PURE__*/function (_elementor$modules$el) {
  function NestedElementTypesBase() {
    (0, _classCallCheck2.default)(this, NestedElementTypesBase);
    return _callSuper(this, NestedElementTypesBase, arguments);
  }
  (0, _inherits2.default)(NestedElementTypesBase, _elementor$modules$el);
  return (0, _createClass2.default)(NestedElementTypesBase, [{
    key: "getType",
    value: function getType() {
      elementorModules.ForceMethodImplementation();
    }
  }, {
    key: "getView",
    value: function getView() {
      return _view.default;
    }
  }, {
    key: "getEmptyView",
    value: function getEmptyView() {
      return _empty.default;
    }
  }, {
    key: "getModel",
    value: function getModel() {
      return $e.components.get('nested-elements/nested-repeater').exports.NestedModelBase;
    }
  }]);
}(elementor.modules.elements.types.Base);
var _default = exports["default"] = NestedElementTypesBase;

/***/ }),

/***/ "../modules/nested-elements/assets/js/editor/views/add-section-area.js":
/*!*****************************************************************************!*\
  !*** ../modules/nested-elements/assets/js/editor/views/add-section-area.js ***!
  \*****************************************************************************/
/***/ ((__unused_webpack_module, exports, __webpack_require__) => {

"use strict";
/* provided dependency */ var __ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n")["__"];
/* provided dependency */ var PropTypes = __webpack_require__(/*! prop-types */ "../node_modules/prop-types/index.js");


var _typeof = __webpack_require__(/*! @babel/runtime/helpers/typeof */ "../node_modules/@babel/runtime/helpers/typeof.js");
Object.defineProperty(exports, "__esModule", ({
  value: true
}));
exports["default"] = AddSectionArea;
var _react = _interopRequireWildcard(__webpack_require__(/*! react */ "react"));
function _interopRequireWildcard(e, t) { if ("function" == typeof WeakMap) var r = new WeakMap(), n = new WeakMap(); return (_interopRequireWildcard = function _interopRequireWildcard(e, t) { if (!t && e && e.__esModule) return e; var o, i, f = { __proto__: null, default: e }; if (null === e || "object" != _typeof(e) && "function" != typeof e) return f; if (o = t ? n : r) { if (o.has(e)) return o.get(e); o.set(e, f); } for (var _t in e) "default" !== _t && {}.hasOwnProperty.call(e, _t) && ((i = (o = Object.defineProperty) && Object.getOwnPropertyDescriptor(e, _t)) && (i.get || i.set) ? o(f, _t, i) : f[_t] = e[_t]); return f; })(e, t); }
/* eslint-disable jsx-a11y/click-events-have-key-events */

function AddSectionArea(props) {
  var addAreaElementRef = (0, _react.useRef)(),
    containerHelper = elementor.helpers.container;
  (0, _react.useEffect)(function () {
    var $addAreaElementRef = jQuery(addAreaElementRef.current),
      defaultDroppableOptions = props.container.view.getDroppableOptions();
    defaultDroppableOptions.placeholder = false;
    defaultDroppableOptions.items = '> .elementor-add-section-inner';
    defaultDroppableOptions.hasDraggingOnChildClass = 'elementor-dragging-on-child';
    $addAreaElementRef.html5Droppable(defaultDroppableOptions);
    return function () {
      $addAreaElementRef.html5Droppable('destroy');
    };
  }, []);
  var handleAddContainerClick = function handleAddContainerClick() {
    props.setIsRenderPresets(true);
  };
  return /*#__PURE__*/_react.default.createElement("div", {
    className: "elementor-add-section",
    onClick: function onClick() {
      return containerHelper.openEditMode(props.container);
    },
    ref: addAreaElementRef,
    role: "button",
    tabIndex: "0"
  }, /*#__PURE__*/_react.default.createElement("div", {
    className: "elementor-add-section-inner"
  }, /*#__PURE__*/_react.default.createElement("div", {
    className: "e-view elementor-add-new-section"
  }, /*#__PURE__*/_react.default.createElement("button", {
    type: "button",
    className: "elementor-add-section-area-button elementor-add-section-button",
    "aria-label": __('Add new container', 'elementor'),
    onClick: handleAddContainerClick
  }, /*#__PURE__*/_react.default.createElement("i", {
    className: "eicon-plus",
    "aria-hidden": "true"
  })), /*#__PURE__*/_react.default.createElement("div", {
    className: "elementor-add-section-drag-title"
  }, __('Drag widget here', 'elementor')))));
}
AddSectionArea.propTypes = {
  container: PropTypes.object.isRequired,
  setIsRenderPresets: PropTypes.func.isRequired
};

/***/ }),

/***/ "../modules/nested-elements/assets/js/editor/views/empty.js":
/*!******************************************************************!*\
  !*** ../modules/nested-elements/assets/js/editor/views/empty.js ***!
  \******************************************************************/
/***/ ((__unused_webpack_module, exports, __webpack_require__) => {

"use strict";
/* provided dependency */ var PropTypes = __webpack_require__(/*! prop-types */ "../node_modules/prop-types/index.js");


var _interopRequireDefault = __webpack_require__(/*! @babel/runtime/helpers/interopRequireDefault */ "../node_modules/@babel/runtime/helpers/interopRequireDefault.js");
var _typeof = __webpack_require__(/*! @babel/runtime/helpers/typeof */ "../node_modules/@babel/runtime/helpers/typeof.js");
Object.defineProperty(exports, "__esModule", ({
  value: true
}));
exports["default"] = Empty;
var _react = _interopRequireWildcard(__webpack_require__(/*! react */ "react"));
var _defineProperty2 = _interopRequireDefault(__webpack_require__(/*! @babel/runtime/helpers/defineProperty */ "../node_modules/@babel/runtime/helpers/defineProperty.js"));
var _slicedToArray2 = _interopRequireDefault(__webpack_require__(/*! @babel/runtime/helpers/slicedToArray */ "../node_modules/@babel/runtime/helpers/slicedToArray.js"));
var _addSectionArea = _interopRequireDefault(__webpack_require__(/*! ./add-section-area */ "../modules/nested-elements/assets/js/editor/views/add-section-area.js"));
var _selectPreset = _interopRequireDefault(__webpack_require__(/*! ./select-preset */ "../modules/nested-elements/assets/js/editor/views/select-preset.js"));
function _interopRequireWildcard(e, t) { if ("function" == typeof WeakMap) var r = new WeakMap(), n = new WeakMap(); return (_interopRequireWildcard = function _interopRequireWildcard(e, t) { if (!t && e && e.__esModule) return e; var o, i, f = { __proto__: null, default: e }; if (null === e || "object" != _typeof(e) && "function" != typeof e) return f; if (o = t ? n : r) { if (o.has(e)) return o.get(e); o.set(e, f); } for (var _t in e) "default" !== _t && {}.hasOwnProperty.call(e, _t) && ((i = (o = Object.defineProperty) && Object.getOwnPropertyDescriptor(e, _t)) && (i.get || i.set) ? o(f, _t, i) : f[_t] = e[_t]); return f; })(e, t); }
function ownKeys(e, r) { var t = Object.keys(e); if (Object.getOwnPropertySymbols) { var o = Object.getOwnPropertySymbols(e); r && (o = o.filter(function (r) { return Object.getOwnPropertyDescriptor(e, r).enumerable; })), t.push.apply(t, o); } return t; }
function _objectSpread(e) { for (var r = 1; r < arguments.length; r++) { var t = null != arguments[r] ? arguments[r] : {}; r % 2 ? ownKeys(Object(t), !0).forEach(function (r) { (0, _defineProperty2.default)(e, r, t[r]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(t)) : ownKeys(Object(t)).forEach(function (r) { Object.defineProperty(e, r, Object.getOwnPropertyDescriptor(t, r)); }); } return e; }
function Empty(props) {
  var _useState = (0, _react.useState)(false),
    _useState2 = (0, _slicedToArray2.default)(_useState, 2),
    isRenderPresets = _useState2[0],
    setIsRenderPresets = _useState2[1];
  props = _objectSpread(_objectSpread({}, props), {}, {
    setIsRenderPresets: setIsRenderPresets
  });
  return isRenderPresets ? /*#__PURE__*/_react.default.createElement(_selectPreset.default, props) : /*#__PURE__*/_react.default.createElement(_addSectionArea.default, props);
}
Empty.propTypes = {
  container: PropTypes.object.isRequired
};

/***/ }),

/***/ "../modules/nested-elements/assets/js/editor/views/select-preset.js":
/*!**************************************************************************!*\
  !*** ../modules/nested-elements/assets/js/editor/views/select-preset.js ***!
  \**************************************************************************/
/***/ ((__unused_webpack_module, exports, __webpack_require__) => {

"use strict";
/* provided dependency */ var __ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n")["__"];
/* provided dependency */ var PropTypes = __webpack_require__(/*! prop-types */ "../node_modules/prop-types/index.js");


var _interopRequireDefault = __webpack_require__(/*! @babel/runtime/helpers/interopRequireDefault */ "../node_modules/@babel/runtime/helpers/interopRequireDefault.js");
Object.defineProperty(exports, "__esModule", ({
  value: true
}));
exports["default"] = SelectPreset;
var _react = _interopRequireDefault(__webpack_require__(/*! react */ "react"));
var _editorOneEvents = __webpack_require__(/*! elementor-editor-utils/editor-one-events */ "../assets/dev/js/editor/utils/editor-one-events.js");
/* eslint-disable jsx-a11y/click-events-have-key-events */

function SelectPreset(props) {
  var containerHelper = elementor.helpers.container,
    onPresetSelected = function onPresetSelected(preset, container) {
      var options = {
        createWrapper: false
      };
      _editorOneEvents.EditorOneEventManager.sendCanvasEmptyBoxAction({
        targetName: 'add_container',
        metadata: {
          container_type: 'flexbox',
          structure_type: preset
        },
        containerCreated: true
      });
      containerHelper.createContainerFromPreset(preset, container, options);
    };
  var handleClose = function handleClose() {
    _editorOneEvents.EditorOneEventManager.sendCanvasEmptyBoxAction({
      targetName: 'close',
      containerCreated: false
    });
    props.setIsRenderPresets(false);
  };
  return /*#__PURE__*/_react.default.createElement(_react.default.Fragment, null, /*#__PURE__*/_react.default.createElement("button", {
    type: "button",
    className: "elementor-add-section-close",
    "aria-label": __('Close', 'elementor'),
    onClick: handleClose
  }, /*#__PURE__*/_react.default.createElement("i", {
    className: "eicon-close",
    "aria-hidden": "true"
  })), /*#__PURE__*/_react.default.createElement("div", {
    className: "e-view e-con-select-preset"
  }, /*#__PURE__*/_react.default.createElement("div", {
    className: "e-con-select-preset__title"
  }, __('Select your Structure', 'elementor')), /*#__PURE__*/_react.default.createElement("div", {
    className: "e-con-select-preset__list"
  }, elementor.presetsFactory.getContainerPresets().map(function (preset) {
    return /*#__PURE__*/_react.default.createElement("button", {
      type: "button",
      className: "e-con-preset",
      "data-preset": preset,
      key: preset,
      onClick: function onClick() {
        return onPresetSelected(preset, props.container);
      },
      dangerouslySetInnerHTML: {
        __html: elementor.presetsFactory.generateContainerPreset(preset)
      }
    });
  }))));
}
SelectPreset.propTypes = {
  container: PropTypes.object.isRequired,
  setIsRenderPresets: PropTypes.func.isRequired
};

/***/ }),

/***/ "../modules/nested-elements/assets/js/editor/views/view.js":
/*!*****************************************************************!*\
  !*** ../modules/nested-elements/assets/js/editor/views/view.js ***!
  \*****************************************************************/
/***/ ((__unused_webpack_module, exports, __webpack_require__) => {

"use strict";


var _interopRequireDefault = __webpack_require__(/*! @babel/runtime/helpers/interopRequireDefault */ "../node_modules/@babel/runtime/helpers/interopRequireDefault.js");
Object.defineProperty(exports, "__esModule", ({
  value: true
}));
exports["default"] = exports.View = void 0;
var _readOnlyError2 = _interopRequireDefault(__webpack_require__(/*! @babel/runtime/helpers/readOnlyError */ "../node_modules/@babel/runtime/helpers/readOnlyError.js"));
var _classCallCheck2 = _interopRequireDefault(__webpack_require__(/*! @babel/runtime/helpers/classCallCheck */ "../node_modules/@babel/runtime/helpers/classCallCheck.js"));
var _createClass2 = _interopRequireDefault(__webpack_require__(/*! @babel/runtime/helpers/createClass */ "../node_modules/@babel/runtime/helpers/createClass.js"));
var _possibleConstructorReturn2 = _interopRequireDefault(__webpack_require__(/*! @babel/runtime/helpers/possibleConstructorReturn */ "../node_modules/@babel/runtime/helpers/possibleConstructorReturn.js"));
var _getPrototypeOf2 = _interopRequireDefault(__webpack_require__(/*! @babel/runtime/helpers/getPrototypeOf */ "../node_modules/@babel/runtime/helpers/getPrototypeOf.js"));
var _get2 = _interopRequireDefault(__webpack_require__(/*! @babel/runtime/helpers/get */ "../node_modules/@babel/runtime/helpers/get.js"));
var _inherits2 = _interopRequireDefault(__webpack_require__(/*! @babel/runtime/helpers/inherits */ "../node_modules/@babel/runtime/helpers/inherits.js"));
function _callSuper(t, o, e) { return o = (0, _getPrototypeOf2.default)(o), (0, _possibleConstructorReturn2.default)(t, _isNativeReflectConstruct() ? Reflect.construct(o, e || [], (0, _getPrototypeOf2.default)(t).constructor) : o.apply(t, e)); }
function _isNativeReflectConstruct() { try { var t = !Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})); } catch (t) {} return (_isNativeReflectConstruct = function _isNativeReflectConstruct() { return !!t; })(); }
function _superPropGet(t, o, e, r) { var p = (0, _get2.default)((0, _getPrototypeOf2.default)(1 & r ? t.prototype : t), o, e); return 2 & r && "function" == typeof p ? function (t) { return p.apply(e, t); } : p; }
var View = exports.View = /*#__PURE__*/function (_$e$components$get$ex) {
  function View() {
    (0, _classCallCheck2.default)(this, View);
    return _callSuper(this, View, arguments);
  }
  (0, _inherits2.default)(View, _$e$components$get$ex);
  return (0, _createClass2.default)(View, [{
    key: "events",
    value: function events() {
      var _this = this;
      var events = _superPropGet(View, "events", this, 3)([]);
      events.click = function (e) {
        // If the clicked Nested Element is not within the currently edited document, don't do anything with it.
        if (elementor.documents.currentDocument.id.toString() !== e.target.closest('.elementor').dataset.elementorId) {
          return;
        }
        var closest = e.target.closest('.elementor-element');
        var targetContainer = null;

        // For clicks on container/widget.
        if (['container', 'widget'].includes(closest === null || closest === void 0 ? void 0 : closest.dataset.element_type)) {
          // eslint-disable-line camelcase
          // In case the container empty, click should be handled by the EmptyView.
          var container = elementor.getContainer(closest.dataset.id);
          if (container.view.isEmpty()) {
            return true;
          }

          // If not empty, open it.
          targetContainer = container;
        }
        e.stopPropagation();
        $e.run('document/elements/select', {
          container: targetContainer || _this.getContainer()
        });
      };
      return events;
    }

    /**
     * Function renderHTML().
     *
     * The `renderHTML()` method is overridden as it causes redundant renders when removing focus from any nested element.
     * This is because the original `renderHTML()` method sets `editModel.renderOnLeave = true;`.
     */
  }, {
    key: "renderHTML",
    value: function renderHTML() {
      var templateType = this.getTemplateType(),
        editModel = this.getEditModel();
      if ('js' === templateType) {
        editModel.setHtmlCache();
        this.render();
      } else {
        editModel.renderRemoteServer();
      }
    }
  }]);
}($e.components.get('nested-elements/nested-repeater').exports.NestedViewBase);
var _default = exports["default"] = View;

/***/ }),

/***/ "../node_modules/@babel/runtime/helpers/assertThisInitialized.js":
/*!***********************************************************************!*\
  !*** ../node_modules/@babel/runtime/helpers/assertThisInitialized.js ***!
  \***********************************************************************/
/***/ ((module) => {

function _assertThisInitialized(e) {
  if (void 0 === e) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
  return e;
}
module.exports = _assertThisInitialized, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ "../node_modules/@babel/runtime/helpers/defineProperty.js":
/*!****************************************************************!*\
  !*** ../node_modules/@babel/runtime/helpers/defineProperty.js ***!
  \****************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var toPropertyKey = __webpack_require__(/*! ./toPropertyKey.js */ "../node_modules/@babel/runtime/helpers/toPropertyKey.js");
function _defineProperty(e, r, t) {
  return (r = toPropertyKey(r)) in e ? Object.defineProperty(e, r, {
    value: t,
    enumerable: !0,
    configurable: !0,
    writable: !0
  }) : e[r] = t, e;
}
module.exports = _defineProperty, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ "../node_modules/@babel/runtime/helpers/get.js":
/*!*****************************************************!*\
  !*** ../node_modules/@babel/runtime/helpers/get.js ***!
  \*****************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var superPropBase = __webpack_require__(/*! ./superPropBase.js */ "../node_modules/@babel/runtime/helpers/superPropBase.js");
function _get() {
  return module.exports = _get = "undefined" != typeof Reflect && Reflect.get ? Reflect.get.bind() : function (e, t, r) {
    var p = superPropBase(e, t);
    if (p) {
      var n = Object.getOwnPropertyDescriptor(p, t);
      return n.get ? n.get.call(arguments.length < 3 ? e : r) : n.value;
    }
  }, module.exports.__esModule = true, module.exports["default"] = module.exports, _get.apply(null, arguments);
}
module.exports = _get, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ "../node_modules/@babel/runtime/helpers/getPrototypeOf.js":
/*!****************************************************************!*\
  !*** ../node_modules/@babel/runtime/helpers/getPrototypeOf.js ***!
  \****************************************************************/
/***/ ((module) => {

function _getPrototypeOf(t) {
  return module.exports = _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf.bind() : function (t) {
    return t.__proto__ || Object.getPrototypeOf(t);
  }, module.exports.__esModule = true, module.exports["default"] = module.exports, _getPrototypeOf(t);
}
module.exports = _getPrototypeOf, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ "../node_modules/@babel/runtime/helpers/inherits.js":
/*!**********************************************************!*\
  !*** ../node_modules/@babel/runtime/helpers/inherits.js ***!
  \**********************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var setPrototypeOf = __webpack_require__(/*! ./setPrototypeOf.js */ "../node_modules/@babel/runtime/helpers/setPrototypeOf.js");
function _inherits(t, e) {
  if ("function" != typeof e && null !== e) throw new TypeError("Super expression must either be null or a function");
  t.prototype = Object.create(e && e.prototype, {
    constructor: {
      value: t,
      writable: !0,
      configurable: !0
    }
  }), Object.defineProperty(t, "prototype", {
    writable: !1
  }), e && setPrototypeOf(t, e);
}
module.exports = _inherits, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ "../node_modules/@babel/runtime/helpers/possibleConstructorReturn.js":
/*!***************************************************************************!*\
  !*** ../node_modules/@babel/runtime/helpers/possibleConstructorReturn.js ***!
  \***************************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var _typeof = (__webpack_require__(/*! ./typeof.js */ "../node_modules/@babel/runtime/helpers/typeof.js")["default"]);
var assertThisInitialized = __webpack_require__(/*! ./assertThisInitialized.js */ "../node_modules/@babel/runtime/helpers/assertThisInitialized.js");
function _possibleConstructorReturn(t, e) {
  if (e && ("object" == _typeof(e) || "function" == typeof e)) return e;
  if (void 0 !== e) throw new TypeError("Derived constructors may only return object or undefined");
  return assertThisInitialized(t);
}
module.exports = _possibleConstructorReturn, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ "../node_modules/@babel/runtime/helpers/readOnlyError.js":
/*!***************************************************************!*\
  !*** ../node_modules/@babel/runtime/helpers/readOnlyError.js ***!
  \***************************************************************/
/***/ ((module) => {

function _readOnlyError(r) {
  throw new TypeError('"' + r + '" is read-only');
}
module.exports = _readOnlyError, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ "../node_modules/@babel/runtime/helpers/setPrototypeOf.js":
/*!****************************************************************!*\
  !*** ../node_modules/@babel/runtime/helpers/setPrototypeOf.js ***!
  \****************************************************************/
/***/ ((module) => {

function _setPrototypeOf(t, e) {
  return module.exports = _setPrototypeOf = Object.setPrototypeOf ? Object.setPrototypeOf.bind() : function (t, e) {
    return t.__proto__ = e, t;
  }, module.exports.__esModule = true, module.exports["default"] = module.exports, _setPrototypeOf(t, e);
}
module.exports = _setPrototypeOf, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ "../node_modules/@babel/runtime/helpers/superPropBase.js":
/*!***************************************************************!*\
  !*** ../node_modules/@babel/runtime/helpers/superPropBase.js ***!
  \***************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var getPrototypeOf = __webpack_require__(/*! ./getPrototypeOf.js */ "../node_modules/@babel/runtime/helpers/getPrototypeOf.js");
function _superPropBase(t, o) {
  for (; !{}.hasOwnProperty.call(t, o) && null !== (t = getPrototypeOf(t)););
  return t;
}
module.exports = _superPropBase, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ })

}]);
//# sourceMappingURL=9b97a73ee8fdc5fb7dc3.bundle.js.map