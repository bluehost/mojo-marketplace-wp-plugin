/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./src/app/index.js":
/*!**************************!*\
  !*** ./src/app/index.js ***!
  \**************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "App": () => (/* binding */ App),
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _stylesheet_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./stylesheet.scss */ "./src/app/stylesheet.scss");
/* harmony import */ var _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/api-fetch */ "@wordpress/api-fetch");
/* harmony import */ var _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! classnames */ "./node_modules/classnames/index.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(classnames__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _vendor_newfold_labs_wp_module_marketplace_components_marketplace_index_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ../../vendor/newfold-labs/wp-module-marketplace/components/marketplace/index.js */ "./vendor/newfold-labs/wp-module-marketplace/components/marketplace/index.js");








const App = () => {
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "wppw"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_vendor_newfold_labs_wp_module_marketplace_components_marketplace_index_js__WEBPACK_IMPORTED_MODULE_6__["default"], {
    Components: {
      Button: _wordpress_components__WEBPACK_IMPORTED_MODULE_5__.Button,
      Card: _wordpress_components__WEBPACK_IMPORTED_MODULE_5__.Card,
      CardBody: _wordpress_components__WEBPACK_IMPORTED_MODULE_5__.CardBody,
      CardFooter: _wordpress_components__WEBPACK_IMPORTED_MODULE_5__.CardFooter,
      CardHeader: _wordpress_components__WEBPACK_IMPORTED_MODULE_5__.CardHeader,
      CardMedia: _wordpress_components__WEBPACK_IMPORTED_MODULE_5__.CardMedia,
      TabPanel: _wordpress_components__WEBPACK_IMPORTED_MODULE_5__.TabPanel,
      Spinner: _wordpress_components__WEBPACK_IMPORTED_MODULE_5__.Spinner
    },
    constants: {
      'resturl': window.mojo.restUrl,
      'eventendpoint': '/newfold-data/v1/events/',
      'perPage': 12,
      'supportsCTB': false
    },
    methods: {
      apiFetch: (_wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_2___default()),
      classnames: (classnames__WEBPACK_IMPORTED_MODULE_3___default()),
      useEffect: react__WEBPACK_IMPORTED_MODULE_4__.useEffect,
      useState: _wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState
    }
  }));
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (App);

/***/ }),

/***/ "./vendor/newfold-labs/wp-module-marketplace/components/marketplace/index.js":
/*!***********************************************************************************!*\
  !*** ./vendor/newfold-labs/wp-module-marketplace/components/marketplace/index.js ***!
  \***********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _marketplaceList___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../marketplaceList/ */ "./vendor/newfold-labs/wp-module-marketplace/components/marketplaceList/index.js");


/**
 * Marketplace Module
 * For use in brand app to display marketplace
 * 
 * @param {*} props 
 * @returns 
 */

const Marketplace = _ref => {
  let {
    methods,
    constants,
    Components,
    ...props
  } = _ref;
  const [isLoading, setIsLoading] = methods.useState(true);
  const [isError, setIsError] = methods.useState(false);
  const [marketplaceCategories, setMarketplaceCategories] = methods.useState([]);
  const [marketplaceItems, setMarketplaceItems] = methods.useState([]);
  const [initialTab, setInitialTab] = methods.useState('all'); // const location = methods.useLocation();
  // const navigate = methods.useNavigate();

  const onTabNavigate = tabName => {// methods.navigate( '/marketplace/' + tabName, { replace: true } );
    // console.log( tabName );
  }; // useEffect( () => {
  // 	if ( location.pathname.includes( '/services' ) ) {
  // 		setInitialTab( 'services' );
  // 	} else if ( location.pathname.includes( '/themes' ) ) {
  // 		setInitialTab( 'themes' );
  // 	} else if ( ! location.pathname.includes( '/plugins' ) ) {
  // 		methods.navigate( '/marketplace/plugins', { replace: true } );
  // 	}
  // 	setIsLoading( false );
  // }, [ location ] );

  /**
   * on mount load all marketplace data from module api
   */


  methods.useEffect(() => {
    methods.apiFetch({
      url: `${constants.resturl}/newfold-marketplace/v1/marketplace`
    }).then(response => {
      // console.log(response);
      setIsLoading(false); // check response for data

      if (!response.hasOwnProperty('data')) {
        setIsError(true);
      } else {
        const products = response['data'];
        setMarketplaceItems(products);
        setMarketplaceCategories(collectCategories(products));
      }
    });
  }, []);
  /**
   * map all categories into an array for consuming by tabpanel component
   * @param Array products 
   * @returns 
   */

  const collectCategories = products => {
    let thecategories = [{
      name: 'all',
      title: 'Everything',
      currentCount: constants.perPage
    }];

    if (!products.length) {
      return thecategories;
    }

    let cats = new Set();
    products.forEach(product => {
      product.categories.forEach(category => {
        cats.add(category);
      });
    });
    cats.forEach(cat => {
      thecategories.push({
        name: cat,
        title: cat,
        currentCount: constants.perPage
      });
    });
    return thecategories;
  };
  /**
   * Save a potential updated display counts per category
   * @param string categoryName 
   * @param Number newCount 
   */


  const saveCategoryDisplayCount = (categoryName, newCount) => {
    let updatedMarketplaceCategories = [...marketplaceCategories]; // find matching cat, and update perPage amount

    updatedMarketplaceCategories.forEach(cat => {
      if (cat.name === categoryName) {
        cat.currentCount = newCount;
      }
    });
    setMarketplaceCategories(updatedMarketplaceCategories);
  };

  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: methods.classnames('newfold-marketplace-wrapper')
  }, isLoading && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Components.Spinner, null), isError && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("h3", null, "Oops, we encountered an error loading the marketplace, please try again later."), !isLoading && !isError && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Components.TabPanel, {
    className: "newfold-marketplace-tabs",
    activeClass: "current-tab",
    orientation: "vertical",
    initialTabName: initialTab,
    onSelect: onTabNavigate,
    tabs: marketplaceCategories
  }, tab => (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_marketplaceList___WEBPACK_IMPORTED_MODULE_1__["default"], {
    marketplaceItems: marketplaceItems,
    category: tab.name,
    Components: Components,
    methods: methods,
    constants: constants,
    currentCount: tab.currentCount,
    saveCategoryDisplayCount: saveCategoryDisplayCount
  })));
};

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Marketplace);

/***/ }),

/***/ "./vendor/newfold-labs/wp-module-marketplace/components/marketplaceItem/index.js":
/*!***************************************************************************************!*\
  !*** ./vendor/newfold-labs/wp-module-marketplace/components/marketplaceItem/index.js ***!
  \***************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);


/**
 * MarketplaceItem Component
 * For use in Marketplace to display marketplace items
 * 
 * @param {*} props 
 * @returns 
 */
const MarketplaceItem = _ref => {
  let {
    item,
    Components,
    methods,
    constants
  } = _ref;

  /**
   * Send events to the WP REST API
   *
   * @param {Object} event The event data to be tracked.
   */
  const sendEvent = event => {
    event.data = event.data || {};
    event.data.page = window.location.href;
    methods.apiFetch({
      url: `${constants.resturl}${constants.eventendpoint}`,
      method: 'POST',
      data: event
    });
  };
  /**
   * Handle button clicks
   * @param Event event 
   * @returns 
   */


  const onButtonNavigate = event => {
    if (event.keycode && ENTER !== event.keycode) {
      return;
    }

    sendEvent({
      action: 'newfold-marketplaceitem-click',
      data: {
        element: 'button',
        label: event.target.innerText,
        productId: item.id
      }
    });
  };
  /**
   * Handle link clicks
   * @param Event event 
   * @returns 
   */


  const onAnchorNavigate = event => {
    if (event.keycode && ENTER !== event.keycode) {
      return;
    }

    sendEvent({
      action: 'newfold-marketplaceitem-click',
      data: {
        element: 'a',
        href: event.target.getAttribute('href'),
        label: event.target.innerText,
        productId: item.id
      }
    });
  };
  /**
   * initial set up - adding event listeners
   */


  methods.useEffect(() => {
    const itemContainer = document.getElementById(`marketplace-item-${item.id}`);
    const itemButtons = Array.from(itemContainer.querySelectorAll('button'));
    const itemAnchors = Array.from(itemContainer.querySelectorAll('a'));

    if (itemButtons.length) {
      itemButtons.forEach(button => {
        if (button.getAttribute('data-action') !== 'close') {
          button.addEventListener('click', onButtonNavigate);
          button.addEventListener('onkeydown', onButtonNavigate);
        }
      });
    }

    if (itemAnchors.length) {
      itemAnchors.forEach(link => {
        if (link.getAttribute('data-action') !== 'close') {
          link.addEventListener('click', onAnchorNavigate);
          link.addEventListener('onkeydown', onAnchorNavigate);
        }
      });
    } // unmount remove event listeners


    return () => {
      if (itemButtons.length) {
        itemButtons.forEach(button => {
          if (button.getAttribute('data-action') !== 'close') {
            button.removeEventListener('click', onButtonNavigate);
            button.removeEventListener('onkeydown', onButtonNavigate);
          }
        });
      }

      if (itemAnchors.length) {
        itemAnchors.forEach(link => {
          if (link.getAttribute('data-action') !== 'close') {
            link.removeEventListener('click', onAnchorNavigate);
            link.removeEventListener('onkeydown', onAnchorNavigate);
          }
        });
      }
    };
  }, []);

  const renderCTAs = item => {
    let primaryCTA, secondaryCTA;

    if (constants.supportsCTB && item.clickToBuyId && item.primaryCallToAction) {
      // create CTB button
      primaryCTA = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Components.Button, {
        variant: "primary",
        "data-action": "load-nfd-ctb",
        "data-ctb-id": item.clickToBuyId
      }, item.primaryCallToAction);
    } else if (item.primaryUrl && item.primaryCallToAction) {
      // primary cta link
      primaryCTA = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Components.Button, {
        variant: "primary",
        target: "_blank",
        href: item.primaryUrl
      }, item.primaryCallToAction);
    }

    if (item.secondaryCallToAction && item.secondaryUrl) {
      secondaryCTA = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Components.Button, {
        variant: "secondary",
        target: "_blank",
        href: item.secondaryUrl
      }, item.secondaryCallToAction);
    }

    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, primaryCTA, secondaryCTA);
  };

  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Components.Card, {
    className: `marketplace-item marketplace-item-${item.id}`,
    id: `marketplace-item-${item.id}`
  }, item.productThumbnailUrl && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Components.CardMedia, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("img", {
    src: item.productThumbnailUrl,
    alt: item.name + ' thumbnail'
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Components.CardHeader, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("h3", null, item.name), item.price > 0 && item.price_formatted && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("em", {
    className: "price"
  }, item.price_formatted)), item.description && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Components.CardBody, {
    // Comes from internal source - let's trust ourselves (for now)
    dangerouslySetInnerHTML: {
      __html: item.description
    }
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Components.CardFooter, null, renderCTAs(item)));
};

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (MarketplaceItem);

/***/ }),

/***/ "./vendor/newfold-labs/wp-module-marketplace/components/marketplaceList/index.js":
/*!***************************************************************************************!*\
  !*** ./vendor/newfold-labs/wp-module-marketplace/components/marketplaceList/index.js ***!
  \***************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _marketplaceItem___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../marketplaceItem/ */ "./vendor/newfold-labs/wp-module-marketplace/components/marketplaceItem/index.js");


/**
 * MarketplaceList Component
 * For use in Marketplace to display a list of marketplace items
 * 
 * @param {*} props 
 * @returns 
 */

const MarketplaceList = _ref => {
  let {
    marketplaceItems,
    currentCount,
    category = 'all',
    Components,
    methods,
    constants,
    saveCategoryDisplayCount
  } = _ref;
  const [itemsCount, setItemsCount] = methods.useState(currentCount);
  const [currentItems, setCurrentItems] = methods.useState([]);
  const [activeItems, setActiveItems] = methods.useState([]);
  /**
   * Filter Products By Category - this ensures only this category products is listed here, it gets us current items
   * @param Array items - the products
   * @param string category - the category to filter by 
   * @returns 
   */

  const filterProductsByCategory = (items, category) => {
    return items.filter(item => {
      return category === 'all' || item.categories.includes(category);
    });
  };
  /**
   * Set Product List Length - this controls how many products are displayed in the list, it gets us active current items
   * @param Array items 
   * @param Number itemsCount 
   * @returns 
   */


  const setProductListCount = (items, itemsCount) => {
    let count = 0;
    return items.filter(item => {
      count++;
      return count <= itemsCount;
    });
  };
  /**
   * increment itemCount by perPage amount
   */


  const loadMoreClick = () => {
    setItemsCount(itemsCount + constants.perPage);
  };
  /**
   * init method - filter products
   */


  methods.useEffect(() => {
    setCurrentItems(filterProductsByCategory(marketplaceItems, category));
  }, []);
  /**
   * recalculate activeItems if currnetItems or itemsCount changes
   */

  methods.useEffect(() => {
    setActiveItems(setProductListCount(currentItems, itemsCount));
  }, [currentItems, itemsCount]);
  /**
   * pass up itemsCount for this list when it changes
   * this is so users don't need to load more every time they click back into a category
   */

  methods.useEffect(() => {
    saveCategoryDisplayCount(category, itemsCount);
  }, [itemsCount]);
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "marketplaceList"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "grid col2"
  }, activeItems.map(item => (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_marketplaceItem___WEBPACK_IMPORTED_MODULE_1__["default"], {
    key: item.hash,
    item: item,
    Components: Components,
    methods: methods,
    constants: constants
  }))), currentItems && currentItems.length > itemsCount && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    style: {
      display: 'flex',
      margin: '1rem 0'
    }
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Components.Button, {
    onClick: loadMoreClick,
    variant: "primary",
    className: "align-center",
    style: {
      margin: 'auto'
    }
  }, "Load More")));
};

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (MarketplaceList);

/***/ }),

/***/ "./node_modules/classnames/index.js":
/*!******************************************!*\
  !*** ./node_modules/classnames/index.js ***!
  \******************************************/
/***/ ((module, exports) => {

var __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;/*!
  Copyright (c) 2018 Jed Watson.
  Licensed under the MIT License (MIT), see
  http://jedwatson.github.io/classnames
*/
/* global define */

(function () {
	'use strict';

	var hasOwn = {}.hasOwnProperty;

	function classNames() {
		var classes = [];

		for (var i = 0; i < arguments.length; i++) {
			var arg = arguments[i];
			if (!arg) continue;

			var argType = typeof arg;

			if (argType === 'string' || argType === 'number') {
				classes.push(arg);
			} else if (Array.isArray(arg)) {
				if (arg.length) {
					var inner = classNames.apply(null, arg);
					if (inner) {
						classes.push(inner);
					}
				}
			} else if (argType === 'object') {
				if (arg.toString === Object.prototype.toString) {
					for (var key in arg) {
						if (hasOwn.call(arg, key) && arg[key]) {
							classes.push(key);
						}
					}
				} else {
					classes.push(arg.toString());
				}
			}
		}

		return classes.join(' ');
	}

	if ( true && module.exports) {
		classNames.default = classNames;
		module.exports = classNames;
	} else if (true) {
		// register as 'classnames', consistent with npm package name
		!(__WEBPACK_AMD_DEFINE_ARRAY__ = [], __WEBPACK_AMD_DEFINE_RESULT__ = (function () {
			return classNames;
		}).apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__),
		__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
	} else {}
}());


/***/ }),

/***/ "./src/app/stylesheet.scss":
/*!*********************************!*\
  !*** ./src/app/stylesheet.scss ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "react":
/*!************************!*\
  !*** external "React" ***!
  \************************/
/***/ ((module) => {

"use strict";
module.exports = window["React"];

/***/ }),

/***/ "@wordpress/api-fetch":
/*!**********************************!*\
  !*** external ["wp","apiFetch"] ***!
  \**********************************/
/***/ ((module) => {

"use strict";
module.exports = window["wp"]["apiFetch"];

/***/ }),

/***/ "@wordpress/components":
/*!************************************!*\
  !*** external ["wp","components"] ***!
  \************************************/
/***/ ((module) => {

"use strict";
module.exports = window["wp"]["components"];

/***/ }),

/***/ "@wordpress/dom-ready":
/*!**********************************!*\
  !*** external ["wp","domReady"] ***!
  \**********************************/
/***/ ((module) => {

"use strict";
module.exports = window["wp"]["domReady"];

/***/ }),

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/***/ ((module) => {

"use strict";
module.exports = window["wp"]["element"];

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be in strict mode.
(() => {
"use strict";
/*!****************************!*\
  !*** ./src/marketplace.js ***!
  \****************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _app__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./app */ "./src/app/index.js");
/* harmony import */ var _wordpress_dom_ready__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/dom-ready */ "@wordpress/dom-ready");
/* harmony import */ var _wordpress_dom_ready__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_dom_ready__WEBPACK_IMPORTED_MODULE_2__);




_wordpress_dom_ready__WEBPACK_IMPORTED_MODULE_2___default()(() => {
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.render)((0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_app__WEBPACK_IMPORTED_MODULE_1__["default"], null), document.getElementById('mojo-marketplace-app'));
});
})();

/******/ })()
;
//# sourceMappingURL=marketplace.js.map