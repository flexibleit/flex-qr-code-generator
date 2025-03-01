/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/CreateQrForm.js":
/*!*****************************!*\
  !*** ./src/CreateQrForm.js ***!
  \*****************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);

const CreateQrForm = () => {
  const [qrCodeText, setQrCodeText] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)('');
  const [qrCodeSize, setQrCodeSize] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)('150');
  const [eyeColor, setEyeColor] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)('#2563eb');
  const [dotColor, setDotColor] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)('#25eb3c');
  const [circleRadius, setCircleRadius] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)(0.5);
  const [version, setVersion] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)(7);
  // const [qrCodeFormat, setQrCodeFormat] = useState('png');
  const [qrCodeMargin, setQrCodeMargin] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)('100');
  const [selectedInput, setSelectedInput] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)('');
  const [drawCircularModules, setDrawCircularModules] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)(false);
  const [isLoading, setIsLoading] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)(false);
  const [qrCodeOutput, setQrCodeOutput] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)(null);
  const [file, setFile] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)(null);
  function handleFileChange(e) {
    if (e.target.files) {
      setFile(e.target.files[0]);
    }
  }
  const handleSubmit = async event => {
    event.preventDefault();
    // return;
    // Set loading state
    setIsLoading(true);
    const formData = new FormData();
    formData.append("qr_code_text", qrCodeText);
    formData.append("qr_code_size", qrCodeSize);
    formData.append("eye_color", eyeColor);
    formData.append("dot_color", dotColor);
    formData.append("circleRadius", circleRadius);
    formData.append("version", version);
    // formData.append("qr_code_format", qrCodeFormat);
    formData.append("qr_code_margin", qrCodeMargin);
    formData.append("qr_code_input", selectedInput);
    formData.append("drawCircularModules", drawCircularModules ? 1 : 0);
    formData.append("qr_code_logo", file);
    formData.append("action", 'flexqr_generate_qr');
    try {
      // Make the AJAX request
      const response = await fetch(ajaxurl, {
        method: 'POST',
        body: formData
      });

      // Handle response
      if (response.ok) {
        const result = await response.json(); // Assuming the response is in JSON
        console.log("result", result);
        setQrCodeOutput(result.qrCode); // Set the generated QR code image URL
      } else {
        console.error("Error generating QR code");
      }
    } catch (error) {
      console.error("Request failed", error);
    } finally {
      setIsLoading(false);
    }
  };
  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement((react__WEBPACK_IMPORTED_MODULE_0___default().Fragment), null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", {
    className: "flex-qr-code-form",
    id: "flex-qr-code-form"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("h3", {
    className: "text-lg text-black font-bold my-3"
  }, "Create QR Code "), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("p", null, "You can create QR code for any texts or links. There is option to select page, post or product link. You can select easily from dropdown. Here is also options for select QR code color, size, format and margin. After creating you can see the qr code under table. You can easily copy the Qr code and share it as your own."), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", {
    className: "flex"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", {
    className: "w-2/3"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("form", {
    onSubmit: handleSubmit,
    action: "/Wordpress/wp-admin/admin.php?page=flexqr-code-generator",
    method: "post",
    id: "qrForm"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("input", {
    type: "hidden",
    name: "action",
    value: "flexqr_generate_qr"
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("input", {
    type: "hidden",
    id: "qrcode_nonce",
    name: "qrcode_nonce",
    value: "18f8a2af7a"
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("input", {
    type: "hidden",
    name: "_wp_http_referer",
    value: "/Wordpress/wp-admin/admin.php?page=flexqr-code-generator"
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", {
    className: "my-4 flex"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", {
    className: "w-2/3"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("label", {
    for: "message",
    class: "block mb-2 text-sm font-medium text-gray-900 dark:text-white"
  }, "Enter text to encode in QR code:"), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("textarea", {
    id: "flexqrcode_code_text",
    placeholder: "text/url/anything",
    name: "qr_code_text",
    required: "",
    value: qrCodeText,
    onChange: e => setQrCodeText(e.target.value),
    class: "block w-full p-2.5 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
  })), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", {
    className: "w-1/3 m-7"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("select", {
    id: "flexqrcode_select_page_option",
    name: "qr_code_input",
    onChange: e => setSelectedInput(e.target.value),
    class: "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("option", {
    value: ""
  }, "Select"), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("option", {
    value: "page"
  }, "page"), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("option", {
    value: "post"
  }, "post")), selectedInput === 'page' && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("td", {
    id: "flexqrcode_input_page",
    style: {
      display: "none"
    }
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("select", {
    name: "page-dropdown",
    style: {
      padding: "6px 20px",
      margin: "8px 0",
      display: "inline-block",
      border: "1px solid #ccc",
      borderRadius: "4px",
      boxSizing: "border-box",
      width: "300px"
    }
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("option", {
    value: ""
  }, "Select page"), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("option", {
    value: "http://localhost/Wordpress/sample-page/"
  }, "Sample Page"))), selectedInput === 'post' && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("td", {
    id: "flexqrcode_input_post",
    style: {
      display: "none"
    }
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("select", {
    name: "page-dropdown",
    style: {
      padding: "6px 20px",
      margin: "8px 0",
      display: "inline-block",
      border: "1px solid #ccc",
      borderRadius: "4px",
      boxSizing: "border-box",
      width: "300px"
    }
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("option", {
    value: ""
  }, "Select Posts"), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("option", {
    value: "http://localhost/Wordpress/2025/02/13/hello-world/"
  }, "Hello world!"))), selectedInput === 'product' && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("td", {
    id: "flexqrcode_input_product",
    style: {
      display: "none"
    }
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("select", {
    name: "page-dropdown",
    style: {
      padding: "6px 20px",
      margin: "8px 0",
      display: "inline-block",
      border: "1px solid #ccc",
      borderRadius: "4px",
      boxSizing: "border-box",
      width: "300px"
    }
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("option", {
    value: ""
  }, "Select Product"))))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", {
    className: "my-4 flex gap-2"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("label", {
    for: "countries",
    class: "block mb-2 text-sm font-medium text-gray-900 dark:text-white"
  }, "QR Code Version:"), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("select", {
    id: "version",
    name: "version",
    value: version,
    onChange: e => setVersion(e.target.value),
    class: "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("option", {
    value: "5"
  }, "5"), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("option", {
    value: "6"
  }, "6"), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("option", {
    value: "7"
  }, "7"), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("option", {
    value: "8"
  }, "8"), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("option", {
    value: "9"
  }, "9"), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("option", {
    value: "10"
  }, "10"))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("label", {
    for: "number-input",
    class: "block mb-2 text-sm font-medium text-gray-900 dark:text-white"
  }, "Circle Radius (0.5 to 0.75):"), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("input", {
    type: "number",
    id: "circleRadius",
    name: "circleRadius",
    min: "0.5",
    max: "0.75",
    step: "0.05",
    value: circleRadius,
    onChange: e => setCircleRadius(e.target.value),
    "aria-describedby": "helper-text-explanation",
    class: "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500",
    required: true
  })), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("label", {
    for: "hs-color-input",
    class: "block text-sm font-medium mb-2 dark:text-black"
  }, "Eye Color:")), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("input", {
    type: "color",
    id: "eye_color",
    name: "eye_color",
    value: eyeColor,
    onChange: e => setEyeColor(e.target.value),
    class: "p-1 h-10 w-14 block bg-white border border-gray-200 cursor-pointer rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700",
    title: "Choose your color"
  }))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("label", {
    for: "hs-color-input",
    class: "block text-sm font-medium mb-2 dark:text-black"
  }, "Dot Color:")), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("input", {
    type: "color",
    id: "dot_color",
    name: "dot_color",
    value: dotColor,
    onChange: e => setDotColor(e.target.value),
    class: "p-1 h-10 w-14 block bg-white border border-gray-200 cursor-pointer rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700",
    title: "Choose your color"
  }))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("label", {
    for: "drawCircularModules",
    class: "block text-sm font-medium mb-2 dark:text-black"
  }, "Draw Circular Modules:")), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", {
    className: "flex gap-2"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", {
    className: `w-24 cursor-pointer ${drawCircularModules ? "" : "border-4 border-blue-500"}`,
    onClick: () => setDrawCircularModules(false)
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("img", {
    src: `${FLEXQR_CODE_GENERATOR_URI}/round.png`,
    alt: "Image 1",
    className: "module-preview w-full",
    id: "image1"
  })), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", {
    className: `w-24 cursor-pointer ${drawCircularModules ? "border-4 border-blue-500" : ""}`,
    onClick: () => setDrawCircularModules(true)
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("img", {
    src: `${FLEXQR_CODE_GENERATOR_URI}/dot.png`,
    alt: "Image 2",
    className: "w-full module-preview"
  }))))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", {
    className: "my-4 flex gap-2"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("label", {
    for: "number-input",
    class: "block mb-2 text-sm font-medium text-gray-900 dark:text-white"
  }, "Size(150 X 150):"), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("input", {
    type: "number",
    id: "qr_code_size",
    name: "qr_code_size",
    value: qrCodeSize,
    onChange: e => setQrCodeSize(e.target.value),
    "aria-describedby": "helper-text-explanation",
    class: "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500",
    required: true
  })), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("label", {
    for: "number-input",
    class: "block mb-2 text-sm font-medium text-gray-900 dark:text-white"
  }, "Margin:"), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("input", {
    type: "number",
    id: "qr_code_margin",
    name: "qr_code_margin",
    max: 100,
    value: qrCodeMargin,
    onChange: e => setQrCodeMargin(e.target.value),
    "aria-describedby": "helper-text-explanation",
    class: "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500",
    required: true
  })), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("label", {
    class: "block mb-2 text-sm font-medium text-gray-900 dark:text-white",
    for: "file_input"
  }, "Upload Logo"), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("input", {
    onChange: handleFileChange,
    class: "block text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400",
    id: "qr_code_logo",
    type: "file"
  }))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", {
    className: "my-4"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("input", {
    type: "submit",
    className: "button button-primary inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800",
    value: isLoading ? 'Generating...' : 'Generate QR Code',
    disabled: isLoading // Disable submit button while loading 
  })))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", {
    className: "w-1/3"
  }, qrCodeOutput && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", {
    id: "qrCodeOutput"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("img", {
    src: qrCodeOutput,
    alt: "Generated QR Code"
  }))))));
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (CreateQrForm);

/***/ }),

/***/ "react":
/*!************************!*\
  !*** external "React" ***!
  \************************/
/***/ ((module) => {

module.exports = window["React"];

/***/ }),

/***/ "react-dom":
/*!***************************!*\
  !*** external "ReactDOM" ***!
  \***************************/
/***/ ((module) => {

module.exports = window["ReactDOM"];

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
// This entry needs to be wrapped in an IIFE because it needs to be isolated against other modules in the chunk.
(() => {
/*!**********************!*\
  !*** ./src/admin.js ***!
  \**********************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react_dom__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react-dom */ "react-dom");
/* harmony import */ var react_dom__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react_dom__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _CreateQrForm__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./CreateQrForm */ "./src/CreateQrForm.js");



react_dom__WEBPACK_IMPORTED_MODULE_1__.createRoot(document.getElementById("flex_qr_code_input")).render(/*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0__.createElement(react__WEBPACK_IMPORTED_MODULE_0__.StrictMode, null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0__.createElement(_CreateQrForm__WEBPACK_IMPORTED_MODULE_2__["default"], null)));
})();

/******/ })()
;
//# sourceMappingURL=admin.js.map