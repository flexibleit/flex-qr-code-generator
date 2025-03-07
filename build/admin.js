/******/ (() => {
  // webpackBootstrap
  /******/ 'use strict';
  /******/ var __webpack_modules__ = {
    /***/ './src/CreateQrForm.js':
      /*!*****************************!*\
  !*** ./src/CreateQrForm.js ***!
  \*****************************/
      /***/ (
        __unused_webpack_module,
        __webpack_exports__,
        __webpack_require__
      ) => {
        __webpack_require__.r(__webpack_exports__);
        /* harmony export */ __webpack_require__.d(__webpack_exports__, {
          /* harmony export */ default: () => __WEBPACK_DEFAULT_EXPORT__,
          /* harmony export */
        });
        /* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ =
          __webpack_require__(/*! react */ 'react');
        /* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default =
          /*#__PURE__*/ __webpack_require__.n(
            react__WEBPACK_IMPORTED_MODULE_0__
          );
        /* harmony import */ var _components_Button__WEBPACK_IMPORTED_MODULE_1__ =
          __webpack_require__(
            /*! ./components/Button */ './src/components/Button.js'
          );
        /* harmony import */ var _components_TypeSelector__WEBPACK_IMPORTED_MODULE_2__ =
          __webpack_require__(
            /*! ./components/TypeSelector */ './src/components/TypeSelector.js'
          );
        /* harmony import */ var _helpers_fileTypeConverter__WEBPACK_IMPORTED_MODULE_3__ =
          __webpack_require__(
            /*! ./helpers/fileTypeConverter */ './src/helpers/fileTypeConverter.js'
          );
        /* harmony import */ var _components_NumberInputField__WEBPACK_IMPORTED_MODULE_4__ =
          __webpack_require__(
            /*! ./components/NumberInputField */ './src/components/NumberInputField.js'
          );

        // import axios from "axios";

        const CreateQrForm = () => {
          const [qrCodeText, setQrCodeText] = (0,
          react__WEBPACK_IMPORTED_MODULE_0__.useState)('');
          const [qrCodeSize, setQrCodeSize] = (0,
          react__WEBPACK_IMPORTED_MODULE_0__.useState)('150');
          const [eyeColor, setEyeColor] = (0,
          react__WEBPACK_IMPORTED_MODULE_0__.useState)('#2563eb');
          const [dotColor, setDotColor] = (0,
          react__WEBPACK_IMPORTED_MODULE_0__.useState)('#25eb3c');
          const [circleRadius, setCircleRadius] = (0,
          react__WEBPACK_IMPORTED_MODULE_0__.useState)(0.5);
          const [version, setVersion] = (0,
          react__WEBPACK_IMPORTED_MODULE_0__.useState)(7);
          // const [qrCodeFormat, setQrCodeFormat] = useState('png');
          const [qrCodeMargin, setQrCodeMargin] = (0,
          react__WEBPACK_IMPORTED_MODULE_0__.useState)('5');
          const [selectedInput, setSelectedInput] = (0,
          react__WEBPACK_IMPORTED_MODULE_0__.useState)('');
          const [drawCircularModules, setDrawCircularModules] = (0,
          react__WEBPACK_IMPORTED_MODULE_0__.useState)(false);
          const [isLoading, setIsLoading] = (0,
          react__WEBPACK_IMPORTED_MODULE_0__.useState)(false);
          const [isQrGenerated, setIsQrGenerated] = (0,
          react__WEBPACK_IMPORTED_MODULE_0__.useState)(false);
          const [isQrSaved, setIsQrSaved] = (0,
          react__WEBPACK_IMPORTED_MODULE_0__.useState)(false);
          const [isDownloaded, setIsDownloaded] = (0,
          react__WEBPACK_IMPORTED_MODULE_0__.useState)(false);
          //const [qrUrl, setQrUrl] = useState("");
          const [qrCodeOutput, setQrCodeOutput] = (0,
          react__WEBPACK_IMPORTED_MODULE_0__.useState)(null);
          const [file, setFile] = (0,
          react__WEBPACK_IMPORTED_MODULE_0__.useState)(null);
          const [logoUrlPath, setLogoUrlPath] = (0,
          react__WEBPACK_IMPORTED_MODULE_0__.useState)(null);
          const [downloadType, setDownloadType] = (0,
          react__WEBPACK_IMPORTED_MODULE_0__.useState)('svg');
          const [qrFileName, setQrFileName] = (0,
          react__WEBPACK_IMPORTED_MODULE_0__.useState)('qr_code');
          function handleFileChange(e) {
            if (e.target.files) {
              setFile(e.target.files[0]);
            }
          }
          const handleSubmit = async (event, storeData = false) => {
            event.preventDefault();
            // Set loading state
            setIsLoading(true);
            // Simulate QR code generation
            setTimeout(() => {
              setIsLoading(false);
              setIsQrGenerated(true); // Mark QR as generated
            }, 20);
            const formData = new FormData();
            formData.append('qr_code_text', qrCodeText);
            formData.append('qr_code_size', qrCodeSize);
            formData.append('eye_color', eyeColor);
            formData.append('dot_color', dotColor);
            formData.append('circleRadius', circleRadius);
            formData.append('version', version);
            formData.append('qr_code_margin', qrCodeMargin);
            // formData.append('qr_code_input', selectedInput);
            formData.append('drawCircularModules', drawCircularModules ? 1 : 0);
            formData.append('qr_code_logo', file);
            formData.append('action', 'flexqr_generate_qr');
            formData.append('store_data', storeData ? 1 : 0);
            formData.append('qr_code_url', `${qrFileName}.${downloadType}`);
            formData.append('qr_code_format', downloadType);
            try {
              // Make the AJAX request
              const response = await fetch(ajaxurl, {
                method: 'POST',
                body: formData,
              });

              // Handle response
              if (response.ok) {
                const result = await response.json(); // Assuming the response is in JSON

                setQrCodeOutput(result.qrCode); // Set the generated QR code image URL
                if (result.logo) {
                  setLogoUrlPath(result.logo);
                }
                if (storeData) {
                  setIsQrSaved(true); // Ensure button is disabled after saving
                  console.log('QR Code Saved Successfully');
                }
              } else {
                console.error('Error generating QR code');
              }
            } catch (error) {
              console.error('Request failed', error);
            } finally {
              setIsLoading(false);
            }
          };
          const handleDownloadQr = async (e) => {
            e.preventDefault();
            if (!qrCodeOutput) {
              alert('No QR Code available for download.');
              return;
            }
            await (0,
            _helpers_fileTypeConverter__WEBPACK_IMPORTED_MODULE_3__.fileTypeConverter)(
              qrCodeOutput,
              qrCodeSize,
              downloadType,
              qrFileName
            );
          };
          return /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
            react__WEBPACK_IMPORTED_MODULE_0___default().Fragment,
            null,
            /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
              'div',
              {
                className: 'flex-qr-code-form',
                id: 'flex-qr-code-form',
              },
              /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                'h3',
                {
                  className: 'text-lg text-black font-bold my-3',
                },
                'Create QR Code '
              ),
              /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                'p',
                null,
                'You can create QR code for any texts or links. There is option to select page, post or product link. You can select easily from dropdown. Here is also options for select QR code color, size, format and margin. After creating you can see the qr code under table. You can easily copy the Qr code and share it as your own.'
              ),
              /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                'div',
                {
                  className: 'flex',
                },
                /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                  'div',
                  {
                    className: 'w-2/3',
                  },
                  /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                    'form',
                    {
                      onSubmit: handleSubmit,
                      action:
                        '/Wordpress/wp-admin/admin.php?page=flexqr-code-generator',
                      method: 'post',
                      id: 'qrForm',
                    },
                    /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                      'input',
                      {
                        type: 'hidden',
                        name: 'action',
                        value: 'flexqr_generate_qr',
                      }
                    ),
                    /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                      'input',
                      {
                        type: 'hidden',
                        id: 'qrcode_nonce',
                        name: 'qrcode_nonce',
                        value: '18f8a2af7a',
                      }
                    ),
                    /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                      'input',
                      {
                        type: 'hidden',
                        name: '_wp_http_referer',
                        value:
                          '/Wordpress/wp-admin/admin.php?page=flexqr-code-generator',
                      }
                    ),
                    /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                      'div',
                      {
                        className: 'my-4 flex',
                      },
                      /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                        'div',
                        {
                          className: 'w-2/3',
                        },
                        /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                          'label',
                          {
                            for: 'message',
                            class:
                              'block mb-2 text-sm font-medium text-gray-900 dark:text-white',
                          },
                          'Enter text to encode in QR code:'
                        ),
                        /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                          'textarea',
                          {
                            id: 'flexqrcode_code_text',
                            placeholder: 'text/url/anything',
                            name: 'qr_code_text',
                            required: true,
                            value: qrCodeText,
                            onChange: (e) => setQrCodeText(e.target.value),
                            class:
                              'block w-full p-2.5 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500',
                          }
                        )
                      ),
                      /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                        'div',
                        {
                          className: 'w-1/3 m-7',
                        },
                        /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                          'select',
                          {
                            id: 'flexqrcode_select_page_option',
                            name: 'qr_code_input',
                            onChange: (e) => setSelectedInput(e.target.value),
                            class:
                              'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500',
                          },
                          /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                            'option',
                            {
                              value: '',
                            },
                            'Select'
                          ),
                          /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                            'option',
                            {
                              value: 'page',
                            },
                            'page'
                          ),
                          /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                            'option',
                            {
                              value: 'post',
                            },
                            'post'
                          )
                        ),
                        selectedInput === 'page' &&
                          /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                            'td',
                            {
                              id: 'flexqrcode_input_page',
                              style: {
                                display: 'none',
                              },
                            },
                            /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                              'select',
                              {
                                name: 'page-dropdown',
                                style: {
                                  padding: '6px 20px',
                                  margin: '8px 0',
                                  display: 'inline-block',
                                  border: '1px solid #ccc',
                                  borderRadius: '4px',
                                  boxSizing: 'border-box',
                                  width: '300px',
                                },
                              },
                              /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                                'option',
                                {
                                  value: '',
                                },
                                'Select page'
                              ),
                              /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                                'option',
                                {
                                  value:
                                    'http://localhost/Wordpress/sample-page/',
                                },
                                'Sample Page'
                              )
                            )
                          ),
                        selectedInput === 'post' &&
                          /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                            'td',
                            {
                              id: 'flexqrcode_input_post',
                              style: {
                                display: 'none',
                              },
                            },
                            /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                              'select',
                              {
                                name: 'page-dropdown',
                                style: {
                                  padding: '6px 20px',
                                  margin: '8px 0',
                                  display: 'inline-block',
                                  border: '1px solid #ccc',
                                  borderRadius: '4px',
                                  boxSizing: 'border-box',
                                  width: '300px',
                                },
                              },
                              /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                                'option',
                                {
                                  value: '',
                                },
                                'Select Posts'
                              ),
                              /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                                'option',
                                {
                                  value:
                                    'http://localhost/Wordpress/2025/02/13/hello-world/',
                                },
                                'Hello world!'
                              )
                            )
                          ),
                        selectedInput === 'product' &&
                          /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                            'td',
                            {
                              id: 'flexqrcode_input_product',
                              style: {
                                display: 'none',
                              },
                            },
                            /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                              'select',
                              {
                                name: 'page-dropdown',
                                style: {
                                  padding: '6px 20px',
                                  margin: '8px 0',
                                  display: 'inline-block',
                                  border: '1px solid #ccc',
                                  borderRadius: '4px',
                                  boxSizing: 'border-box',
                                  width: '300px',
                                },
                              },
                              /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                                'option',
                                {
                                  value: '',
                                },
                                'Select Product'
                              )
                            )
                          )
                      )
                    ),
                    /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                      'div',
                      {
                        className: 'my-4 w-full flex justify-between',
                      },
                      /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                        'div',
                        null,
                        /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                          'label',
                          {
                            for: 'countries',
                            class:
                              'block mb-2 text-sm font-medium text-gray-900 dark:text-white',
                          },
                          'QR Code Version:'
                        ),
                        /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                          'select',
                          {
                            id: 'version',
                            name: 'version',
                            value: version,
                            onChange: (e) => setVersion(e.target.value),
                            class:
                              'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500',
                          },
                          /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                            'option',
                            {
                              value: '5',
                            },
                            '5'
                          ),
                          /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                            'option',
                            {
                              value: '6',
                            },
                            '6'
                          ),
                          /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                            'option',
                            {
                              value: '7',
                            },
                            '7'
                          ),
                          /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                            'option',
                            {
                              value: '8',
                            },
                            '8'
                          ),
                          /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                            'option',
                            {
                              value: '9',
                            },
                            '9'
                          ),
                          /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                            'option',
                            {
                              value: '10',
                            },
                            '10'
                          )
                        )
                      ),
                      /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                        _components_NumberInputField__WEBPACK_IMPORTED_MODULE_4__[
                          'default'
                        ],
                        {
                          label: 'Circle Radius (0.5 to 0.75)',
                          name: 'circleRadius',
                          value: circleRadius,
                          onChange: (e) => setCircleRadius(e.target.value),
                          min: '0.5',
                          max: '0.75',
                          step: '0.05',
                        }
                      ),
                      /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                        'div',
                        null,
                        /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                          'div',
                          null,
                          /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                            'label',
                            {
                              for: 'hs-color-input',
                              class:
                                'block text-sm font-medium mb-2 dark:text-black',
                            },
                            'Eye Color:'
                          )
                        ),
                        /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                          'div',
                          null,
                          /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                            'input',
                            {
                              type: 'color',
                              id: 'eye_color',
                              name: 'eye_color',
                              value: eyeColor,
                              onChange: (e) => setEyeColor(e.target.value),
                              class:
                                'p-1 h-10 w-14 block bg-white border border-gray-200 cursor-pointer rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700',
                              title: 'Choose your color',
                            }
                          )
                        )
                      ),
                      /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                        'div',
                        null,
                        /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                          'div',
                          null,
                          /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                            'label',
                            {
                              for: 'hs-color-input',
                              class:
                                'block text-sm font-medium mb-2 dark:text-black',
                            },
                            'Dot Color:'
                          )
                        ),
                        /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                          'div',
                          null,
                          /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                            'input',
                            {
                              type: 'color',
                              id: 'dot_color',
                              name: 'dot_color',
                              value: dotColor,
                              onChange: (e) => setDotColor(e.target.value),
                              class:
                                'p-1 h-10 w-14 block bg-white border border-gray-200 cursor-pointer rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700',
                              title: 'Choose your color',
                            }
                          )
                        )
                      ),
                      /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                        'div',
                        null,
                        /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                          'div',
                          null,
                          /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                            'label',
                            {
                              for: 'drawCircularModules',
                              class:
                                'block text-sm font-medium mb-2 dark:text-black',
                            },
                            'Draw Circular Modules:'
                          )
                        ),
                        /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                          'div',
                          {
                            className: 'flex gap-2',
                          },
                          /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                            'div',
                            {
                              className: `w-24 cursor-pointer ${
                                drawCircularModules
                                  ? ''
                                  : 'border-4 border-blue-500'
                              }`,
                              onClick: () => setDrawCircularModules(false),
                            },
                            /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                              'img',
                              {
                                src: `${FLEXQR_CODE_GENERATOR_URI}/round.png`,
                                alt: 'Image 1',
                                className: 'module-preview w-full',
                                id: 'image1',
                              }
                            )
                          ),
                          /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                            'div',
                            {
                              className: `w-24 cursor-pointer ${
                                drawCircularModules
                                  ? 'border-4 border-blue-500'
                                  : ''
                              }`,
                              onClick: () => setDrawCircularModules(true),
                            },
                            /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                              'img',
                              {
                                src: `${FLEXQR_CODE_GENERATOR_URI}/dot.png`,
                                alt: 'Image 2',
                                className: 'w-full module-preview',
                              }
                            )
                          )
                        )
                      )
                    ),
                    /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                      'div',
                      {
                        className: 'my-4 flex gap-2',
                      },
                      /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                        _components_NumberInputField__WEBPACK_IMPORTED_MODULE_4__[
                          'default'
                        ],
                        {
                          label: 'Size(150 X 150):',
                          name: 'qr_code_size',
                          value: qrCodeSize,
                          onChange: (e) => setQrCodeSize(e.target.value),
                          min: '100',
                          max: '1000',
                          step: '50',
                        }
                      ),
                      /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                        _components_NumberInputField__WEBPACK_IMPORTED_MODULE_4__[
                          'default'
                        ],
                        {
                          label: 'Margin:',
                          name: 'qr_code_margin',
                          value: qrCodeMargin,
                          onChange: (e) => setQrCodeMargin(e.target.value),
                          min: '5',
                          max: '100',
                          step: '1',
                        }
                      ),
                      /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                        'div',
                        null,
                        /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                          'label',
                          {
                            class:
                              'block mb-2 text-sm font-medium text-gray-900 dark:text-white',
                            for: 'file_input',
                          },
                          'Upload Logo'
                        ),
                        /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                          'input',
                          {
                            onChange: handleFileChange,
                            class:
                              'block text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400',
                            id: 'qr_code_logo',
                            type: 'file',
                          }
                        )
                      )
                    ),
                    /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                      'div',
                      {
                        className: 'my-4 flex gap-2 items-end',
                      },
                      /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                        _components_Button__WEBPACK_IMPORTED_MODULE_1__[
                          'default'
                        ],
                        {
                          onClick: handleSubmit,
                          value: isLoading ? 'Generating...' : 'Generate',
                          disabled: isLoading,
                        }
                      ),
                      /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                        'div',
                        {
                          className: 'flex gap-2 ml-4 items-end',
                        },
                        /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                          _components_Button__WEBPACK_IMPORTED_MODULE_1__[
                            'default'
                          ],
                          {
                            onClick: (e) => handleSubmit(e, true),
                            value: isQrSaved ? 'Saved' : 'Save',
                            disabled: !isQrGenerated || isQrSaved,
                          }
                        ),
                        /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                          _components_TypeSelector__WEBPACK_IMPORTED_MODULE_2__[
                            'default'
                          ],
                          {
                            setSelectedValue: setDownloadType,
                            selectedValue: downloadType,
                          }
                        ),
                        /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                          _components_Button__WEBPACK_IMPORTED_MODULE_1__[
                            'default'
                          ],
                          {
                            onClick: (e) => handleDownloadQr(e),
                            value: isDownloaded ? 'Downloaded' : 'Download',
                            //   disabled={!isQrGenerated || isDownloaded}
                            disabled: !isQrGenerated,
                          }
                        )
                      )
                    )
                  )
                ),
                /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                  'div',
                  {
                    className: 'w-1/3',
                  },
                  qrCodeOutput &&
                    /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                      'div',
                      {
                        id: 'qrCodeOutput',
                      },
                      /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0___default().createElement(
                        'img',
                        {
                          src: qrCodeOutput,
                          alt: 'Generated QR Code',
                        }
                      )
                    )
                )
              )
            )
          );
        };
        /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ =
          CreateQrForm;

        /***/
      },

    /***/ './src/components/Button.js':
      /*!**********************************!*\
  !*** ./src/components/Button.js ***!
  \**********************************/
      /***/ (
        __unused_webpack_module,
        __webpack_exports__,
        __webpack_require__
      ) => {
        __webpack_require__.r(__webpack_exports__);
        /* harmony export */ __webpack_require__.d(__webpack_exports__, {
          /* harmony export */ default: () => __WEBPACK_DEFAULT_EXPORT__,
          /* harmony export */
        });
        const Button = ({ onClick, value, disabled }) => {
          return /*#__PURE__*/ React.createElement(
            'div',
            null,
            /*#__PURE__*/ React.createElement(
              'button',
              {
                className:
                  'button button-primary inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800',
                onClick: onClick,
                disabled: disabled,
              },
              value
            )
          );
        };
        /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = Button;

        /***/
      },

    /***/ './src/components/NumberInputField.js':
      /*!********************************************!*\
  !*** ./src/components/NumberInputField.js ***!
  \********************************************/
      /***/ (
        __unused_webpack_module,
        __webpack_exports__,
        __webpack_require__
      ) => {
        __webpack_require__.r(__webpack_exports__);
        /* harmony export */ __webpack_require__.d(__webpack_exports__, {
          /* harmony export */ default: () => __WEBPACK_DEFAULT_EXPORT__,
          /* harmony export */
        });
        const NumberInputField = ({
          label,
          name,
          min,
          max,
          step,
          value,
          onChange,
        }) => {
          return /*#__PURE__*/ React.createElement(
            'div',
            null,
            /*#__PURE__*/ React.createElement(
              'label',
              {
                for: name,
                class:
                  'block mb-2 text-sm font-medium text-gray-900 dark:text-white',
              },
              label
            ),
            /*#__PURE__*/ React.createElement('input', {
              type: 'number',
              id: name,
              name: name,
              min: min,
              max: max,
              step: step,
              value: value,
              onChange: onChange,
              'aria-describedby': label,
              class:
                'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500',
              required: true,
            })
          );
        };
        /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ =
          NumberInputField;

        /***/
      },

    /***/ './src/components/TypeSelector.js':
      /*!****************************************!*\
  !*** ./src/components/TypeSelector.js ***!
  \****************************************/
      /***/ (
        __unused_webpack_module,
        __webpack_exports__,
        __webpack_require__
      ) => {
        __webpack_require__.r(__webpack_exports__);
        /* harmony export */ __webpack_require__.d(__webpack_exports__, {
          /* harmony export */ default: () => __WEBPACK_DEFAULT_EXPORT__,
          /* harmony export */
        });
        const TypeSelector = ({ selectedValue, setSelectedValue }) => {
          const values = ['svg', 'png', 'jpg', 'pdf', 'eps'];
          const handleChange = (value) => {
            setSelectedValue(value);
          };
          return /*#__PURE__*/ React.createElement(
            'div',
            {
              className: 'flex flex-col gap-2',
            },
            /*#__PURE__*/ React.createElement(
              'label',
              {
                className: 'text-sm font-medium text-gray-900 dark:text-white',
                htmlFor: 'type-selector',
              },
              'Download As'
            ),
            /*#__PURE__*/ React.createElement(
              'select',
              {
                className:
                  'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500',
                id: 'type-selector',
                onChange: (e) => handleChange(e.target.value),
              },
              values.map((value) => {
                return /*#__PURE__*/ React.createElement(
                  'option',
                  {
                    value: value,
                  },
                  value.toUpperCase()
                );
              })
            )
          );
        };
        /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ =
          TypeSelector;

        /***/
      },

    /***/ './src/helpers/fileTypeConverter.js':
      /*!******************************************!*\
  !*** ./src/helpers/fileTypeConverter.js ***!
  \******************************************/
      /***/ (
        __unused_webpack_module,
        __webpack_exports__,
        __webpack_require__
      ) => {
        __webpack_require__.r(__webpack_exports__);
        /* harmony export */ __webpack_require__.d(__webpack_exports__, {
          /* harmony export */ fileTypeConverter: () =>
            /* binding */ fileTypeConverter,
          /* harmony export */
        });
        async function fileTypeConverter(source, size, format, fileName) {
          const canvas = document.createElement('canvas');
          const img = document.createElement('img');
          img.src = source;
          img.width = size;
          img.height = size;
          const ctx = canvas.getContext('2d');
          canvas.width = size;
          canvas.height = size;

          // Draw image on the canvas
          ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
          let downloadLink = document.createElement('a');
          if (format === 'svg') {
            // Convert to SVG
            const link = document.createElement('a');
            link.href = source;
            link.download = `${fileName}.${format}`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
          } else if (format === 'pdf') {
            // Convert to PDF using jsPDF
            const { jsPDF } = await __webpack_require__
              .e(
                /*! import() */ 'vendors-node_modules_jspdf_dist_jspdf_es_min_js'
              )
              .then(
                __webpack_require__.bind(
                  __webpack_require__,
                  /*! jspdf */ './node_modules/jspdf/dist/jspdf.es.min.js'
                )
              );
            const pdf = new jsPDF();
            pdf.addImage(
              canvas.toDataURL('image/png'),
              'PNG',
              10,
              10,
              180,
              150
            );
            pdf.save('downloaded-image.pdf');
            return;
          } else if (format === 'eps') {
            const link = document.createElement('a');
            link.href = source;
            link.download = `${fileName}.eps`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
          } else {
            // For PNG or JPEG
            downloadLink.href = canvas.toDataURL(`image/${format}`);
            downloadLink.download = `${fileName}.${format}`;
          }
          downloadLink.click();
        }

        /***/
      },

    /***/ react:
      /*!************************!*\
  !*** external "React" ***!
  \************************/
      /***/ (module) => {
        module.exports = window['React'];

        /***/
      },

    /***/ 'react-dom':
      /*!***************************!*\
  !*** external "ReactDOM" ***!
  \***************************/
      /***/ (module) => {
        module.exports = window['ReactDOM'];

        /***/
      },

    /******/
  };
  /************************************************************************/
  /******/ // The module cache
  /******/ var __webpack_module_cache__ = {};
  /******/
  /******/ // The require function
  /******/ function __webpack_require__(moduleId) {
    /******/ // Check if module is in cache
    /******/ var cachedModule = __webpack_module_cache__[moduleId];
    /******/ if (cachedModule !== undefined) {
      /******/ return cachedModule.exports;
      /******/
    }
    /******/ // Create a new module (and put it into the cache)
    /******/ var module = (__webpack_module_cache__[moduleId] = {
      /******/ // no module.id needed
      /******/ // no module.loaded needed
      /******/ exports: {},
      /******/
    });
    /******/
    /******/ // Execute the module function
    /******/ __webpack_modules__[moduleId].call(
      module.exports,
      module,
      module.exports,
      __webpack_require__
    );
    /******/
    /******/ // Return the exports of the module
    /******/ return module.exports;
    /******/
  }
  /******/
  /******/ // expose the modules object (__webpack_modules__)
  /******/ __webpack_require__.m = __webpack_modules__;
  /******/
  /************************************************************************/
  /******/ /* webpack/runtime/compat get default export */
  /******/ (() => {
    /******/ // getDefaultExport function for compatibility with non-harmony modules
    /******/ __webpack_require__.n = (module) => {
      /******/ var getter =
        module && module.__esModule
          ? /******/ () => module['default']
          : /******/ () => module;
      /******/ __webpack_require__.d(getter, { a: getter });
      /******/ return getter;
      /******/
    };
    /******/
  })();
  /******/
  /******/ /* webpack/runtime/create fake namespace object */
  /******/ (() => {
    /******/ var getProto = Object.getPrototypeOf
      ? (obj) => Object.getPrototypeOf(obj)
      : (obj) => obj.__proto__;
    /******/ var leafPrototypes;
    /******/ // create a fake namespace object
    /******/ // mode & 1: value is a module id, require it
    /******/ // mode & 2: merge all properties of value into the ns
    /******/ // mode & 4: return value when already ns object
    /******/ // mode & 16: return value when it's Promise-like
    /******/ // mode & 8|1: behave like require
    /******/ __webpack_require__.t = function (value, mode) {
      /******/ if (mode & 1) value = this(value);
      /******/ if (mode & 8) return value;
      /******/ if (typeof value === 'object' && value) {
        /******/ if (mode & 4 && value.__esModule) return value;
        /******/ if (mode & 16 && typeof value.then === 'function')
          return value;
        /******/
      }
      /******/ var ns = Object.create(null);
      /******/ __webpack_require__.r(ns);
      /******/ var def = {};
      /******/ leafPrototypes = leafPrototypes || [
        null,
        getProto({}),
        getProto([]),
        getProto(getProto),
      ];
      /******/ for (
        var current = mode & 2 && value;
        typeof current == 'object' && !~leafPrototypes.indexOf(current);
        current = getProto(current)
      ) {
        /******/ Object.getOwnPropertyNames(current).forEach(
          (key) => (def[key] = () => value[key])
        );
        /******/
      }
      /******/ def['default'] = () => value;
      /******/ __webpack_require__.d(ns, def);
      /******/ return ns;
      /******/
    };
    /******/
  })();
  /******/
  /******/ /* webpack/runtime/define property getters */
  /******/ (() => {
    /******/ // define getter functions for harmony exports
    /******/ __webpack_require__.d = (exports, definition) => {
      /******/ for (var key in definition) {
        /******/ if (
          __webpack_require__.o(definition, key) &&
          !__webpack_require__.o(exports, key)
        ) {
          /******/ Object.defineProperty(exports, key, {
            enumerable: true,
            get: definition[key],
          });
          /******/
        }
        /******/
      }
      /******/
    };
    /******/
  })();
  /******/
  /******/ /* webpack/runtime/ensure chunk */
  /******/ (() => {
    /******/ __webpack_require__.f = {};
    /******/ // This file contains only the entry chunk.
    /******/ // The chunk loading function for additional chunks
    /******/ __webpack_require__.e = (chunkId) => {
      /******/ return Promise.all(
        Object.keys(__webpack_require__.f).reduce((promises, key) => {
          /******/ __webpack_require__.f[key](chunkId, promises);
          /******/ return promises;
          /******/
        }, [])
      );
      /******/
    };
    /******/
  })();
  /******/
  /******/ /* webpack/runtime/get javascript chunk filename */
  /******/ (() => {
    /******/ // This function allow to reference async chunks
    /******/ __webpack_require__.u = (chunkId) => {
      /******/ // return url for filenames based on template
      /******/ return (
        '' +
        chunkId +
        '.js?ver=' +
        {
          'vendors-node_modules_jspdf_dist_jspdf_es_min_js':
            '741d426fbcc8e3e182e1',
          'vendors-node_modules_html2canvas_dist_html2canvas_js':
            'fa99e85910761296a0ee',
          'vendors-node_modules_dompurify_dist_purify_es_mjs':
            'd3b224e9173e2779442a',
          'vendors-node_modules_canvg_lib_index_es_js': 'bbf16fd0ed102c360bf3',
        }[chunkId] +
        ''
      );
      /******/
    };
    /******/
  })();
  /******/
  /******/ /* webpack/runtime/get mini-css chunk filename */
  /******/ (() => {
    /******/ // This function allow to reference async chunks
    /******/ __webpack_require__.miniCssF = (chunkId) => {
      /******/ // return url for filenames based on template
      /******/ return undefined;
      /******/
    };
    /******/
  })();
  /******/
  /******/ /* webpack/runtime/global */
  /******/ (() => {
    /******/ __webpack_require__.g = (function () {
      /******/ if (typeof globalThis === 'object') return globalThis;
      /******/ try {
        /******/ return this || new Function('return this')();
        /******/
      } catch (e) {
        /******/ if (typeof window === 'object') return window;
        /******/
      }
      /******/
    })();
    /******/
  })();
  /******/
  /******/ /* webpack/runtime/hasOwnProperty shorthand */
  /******/ (() => {
    /******/ __webpack_require__.o = (obj, prop) =>
      Object.prototype.hasOwnProperty.call(obj, prop);
    /******/
  })();
  /******/
  /******/ /* webpack/runtime/load script */
  /******/ (() => {
    /******/ var inProgress = {};
    /******/ var dataWebpackPrefix = 'flex-qr-code-generator:';
    /******/ // loadScript function to load a script via script tag
    /******/ __webpack_require__.l = (url, done, key, chunkId) => {
      /******/ if (inProgress[url]) {
        inProgress[url].push(done);
        return;
      }
      /******/ var script, needAttach;
      /******/ if (key !== undefined) {
        /******/ var scripts = document.getElementsByTagName('script');
        /******/ for (var i = 0; i < scripts.length; i++) {
          /******/ var s = scripts[i];
          /******/ if (
            s.getAttribute('src') == url ||
            s.getAttribute('data-webpack') == dataWebpackPrefix + key
          ) {
            script = s;
            break;
          }
          /******/
        }
        /******/
      }
      /******/ if (!script) {
        /******/ needAttach = true;
        /******/ script = document.createElement('script');
        /******/
        /******/ script.charset = 'utf-8';
        /******/ script.timeout = 120;
        /******/ if (__webpack_require__.nc) {
          /******/ script.setAttribute('nonce', __webpack_require__.nc);
          /******/
        }
        /******/ script.setAttribute('data-webpack', dataWebpackPrefix + key);
        /******/
        /******/ script.src = url;
        /******/
      }
      /******/ inProgress[url] = [done];
      /******/ var onScriptComplete = (prev, event) => {
        /******/ // avoid mem leaks in IE.
        /******/ script.onerror = script.onload = null;
        /******/ clearTimeout(timeout);
        /******/ var doneFns = inProgress[url];
        /******/ delete inProgress[url];
        /******/ script.parentNode && script.parentNode.removeChild(script);
        /******/ doneFns && doneFns.forEach((fn) => fn(event));
        /******/ if (prev) return prev(event);
        /******/
      };
      /******/ var timeout = setTimeout(
        onScriptComplete.bind(null, undefined, {
          type: 'timeout',
          target: script,
        }),
        120000
      );
      /******/ script.onerror = onScriptComplete.bind(null, script.onerror);
      /******/ script.onload = onScriptComplete.bind(null, script.onload);
      /******/ needAttach && document.head.appendChild(script);
      /******/
    };
    /******/
  })();
  /******/
  /******/ /* webpack/runtime/make namespace object */
  /******/ (() => {
    /******/ // define __esModule on exports
    /******/ __webpack_require__.r = (exports) => {
      /******/ if (typeof Symbol !== 'undefined' && Symbol.toStringTag) {
        /******/ Object.defineProperty(exports, Symbol.toStringTag, {
          value: 'Module',
        });
        /******/
      }
      /******/ Object.defineProperty(exports, '__esModule', { value: true });
      /******/
    };
    /******/
  })();
  /******/
  /******/ /* webpack/runtime/publicPath */
  /******/ (() => {
    /******/ var scriptUrl;
    /******/ if (__webpack_require__.g.importScripts)
      scriptUrl = __webpack_require__.g.location + '';
    /******/ var document = __webpack_require__.g.document;
    /******/ if (!scriptUrl && document) {
      /******/ if (
        document.currentScript &&
        document.currentScript.tagName.toUpperCase() === 'SCRIPT'
      )
        /******/ scriptUrl = document.currentScript.src;
      /******/ if (!scriptUrl) {
        /******/ var scripts = document.getElementsByTagName('script');
        /******/ if (scripts.length) {
          /******/ var i = scripts.length - 1;
          /******/ while (
            i > -1 &&
            (!scriptUrl || !/^http(s?):/.test(scriptUrl))
          )
            scriptUrl = scripts[i--].src;
          /******/
        }
        /******/
      }
      /******/
    }
    /******/ // When supporting browsers where an automatic publicPath is not supported you must specify an output.publicPath manually via configuration
    /******/ // or pass an empty string ("") and set the __webpack_public_path__ variable from your code to use your own logic.
    /******/ if (!scriptUrl)
      throw new Error('Automatic publicPath is not supported in this browser');
    /******/ scriptUrl = scriptUrl
      .replace(/^blob:/, '')
      .replace(/#.*$/, '')
      .replace(/\?.*$/, '')
      .replace(/\/[^\/]+$/, '/');
    /******/ __webpack_require__.p = scriptUrl;
    /******/
  })();
  /******/
  /******/ /* webpack/runtime/jsonp chunk loading */
  /******/ (() => {
    /******/ // no baseURI
    /******/
    /******/ // object to store loaded and loading chunks
    /******/ // undefined = chunk not loaded, null = chunk preloaded/prefetched
    /******/ // [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
    /******/ var installedChunks = {
      /******/ admin: 0,
      /******/
    };
    /******/
    /******/ __webpack_require__.f.j = (chunkId, promises) => {
      /******/ // JSONP chunk loading for javascript
      /******/ var installedChunkData = __webpack_require__.o(
        installedChunks,
        chunkId
      )
        ? installedChunks[chunkId]
        : undefined;
      /******/ if (installedChunkData !== 0) {
        // 0 means "already installed".
        /******/
        /******/ // a Promise means "currently loading".
        /******/ if (installedChunkData) {
          /******/ promises.push(installedChunkData[2]);
          /******/
        } else {
          /******/ if (true) {
            // all chunks have JS
            /******/ // setup Promise in chunk cache
            /******/ var promise = new Promise(
              (resolve, reject) =>
                (installedChunkData = installedChunks[chunkId] =
                  [resolve, reject])
            );
            /******/ promises.push((installedChunkData[2] = promise));
            /******/
            /******/ // start chunk loading
            /******/ var url =
              __webpack_require__.p + __webpack_require__.u(chunkId);
            /******/ // create error before stack unwound to get useful stacktrace later
            /******/ var error = new Error();
            /******/ var loadingEnded = (event) => {
              /******/ if (__webpack_require__.o(installedChunks, chunkId)) {
                /******/ installedChunkData = installedChunks[chunkId];
                /******/ if (installedChunkData !== 0)
                  installedChunks[chunkId] = undefined;
                /******/ if (installedChunkData) {
                  /******/ var errorType =
                    event && (event.type === 'load' ? 'missing' : event.type);
                  /******/ var realSrc =
                    event && event.target && event.target.src;
                  /******/ error.message =
                    'Loading chunk ' +
                    chunkId +
                    ' failed.\n(' +
                    errorType +
                    ': ' +
                    realSrc +
                    ')';
                  /******/ error.name = 'ChunkLoadError';
                  /******/ error.type = errorType;
                  /******/ error.request = realSrc;
                  /******/ installedChunkData[1](error);
                  /******/
                }
                /******/
              }
              /******/
            };
            /******/ __webpack_require__.l(
              url,
              loadingEnded,
              'chunk-' + chunkId,
              chunkId
            );
            /******/
          }
          /******/
        }
        /******/
      }
      /******/
    };
    /******/
    /******/ // no prefetching
    /******/
    /******/ // no preloaded
    /******/
    /******/ // no HMR
    /******/
    /******/ // no HMR manifest
    /******/
    /******/ // no on chunks loaded
    /******/
    /******/ // install a JSONP callback for chunk loading
    /******/ var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
      /******/ var [chunkIds, moreModules, runtime] = data;
      /******/ // add "moreModules" to the modules object,
      /******/ // then flag all "chunkIds" as loaded and fire callback
      /******/ var moduleId,
        chunkId,
        i = 0;
      /******/ if (chunkIds.some((id) => installedChunks[id] !== 0)) {
        /******/ for (moduleId in moreModules) {
          /******/ if (__webpack_require__.o(moreModules, moduleId)) {
            /******/ __webpack_require__.m[moduleId] = moreModules[moduleId];
            /******/
          }
          /******/
        }
        /******/ if (runtime) var result = runtime(__webpack_require__);
        /******/
      }
      /******/ if (parentChunkLoadingFunction) parentChunkLoadingFunction(data);
      /******/ for (; i < chunkIds.length; i++) {
        /******/ chunkId = chunkIds[i];
        /******/ if (
          __webpack_require__.o(installedChunks, chunkId) &&
          installedChunks[chunkId]
        ) {
          /******/ installedChunks[chunkId][0]();
          /******/
        }
        /******/ installedChunks[chunkId] = 0;
        /******/
      }
      /******/
      /******/
    };
    /******/
    /******/ var chunkLoadingGlobal = (globalThis[
      'webpackChunkflex_qr_code_generator'
    ] = globalThis['webpackChunkflex_qr_code_generator'] || []);
    /******/ chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
    /******/ chunkLoadingGlobal.push = webpackJsonpCallback.bind(
      null,
      chunkLoadingGlobal.push.bind(chunkLoadingGlobal)
    );
    /******/
  })();
  /******/
  /************************************************************************/
  var __webpack_exports__ = {};
  // This entry needs to be wrapped in an IIFE because it needs to be isolated against other modules in the chunk.
  (() => {
    /*!**********************!*\
  !*** ./src/admin.js ***!
  \**********************/
    __webpack_require__.r(__webpack_exports__);
    /* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ =
      __webpack_require__(/*! react */ 'react');
    /* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default =
      /*#__PURE__*/ __webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
    /* harmony import */ var react_dom__WEBPACK_IMPORTED_MODULE_1__ =
      __webpack_require__(/*! react-dom */ 'react-dom');
    /* harmony import */ var react_dom__WEBPACK_IMPORTED_MODULE_1___default =
      /*#__PURE__*/ __webpack_require__.n(
        react_dom__WEBPACK_IMPORTED_MODULE_1__
      );
    /* harmony import */ var _CreateQrForm__WEBPACK_IMPORTED_MODULE_2__ =
      __webpack_require__(/*! ./CreateQrForm */ './src/CreateQrForm.js');

    react_dom__WEBPACK_IMPORTED_MODULE_1__
      .createRoot(document.getElementById('flex_qr_code_input'))
      .render(
        /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0__.createElement(
          react__WEBPACK_IMPORTED_MODULE_0__.StrictMode,
          null,
          /*#__PURE__*/ react__WEBPACK_IMPORTED_MODULE_0__.createElement(
            _CreateQrForm__WEBPACK_IMPORTED_MODULE_2__['default'],
            null
          )
        )
      );
  })();

  /******/
})();
//# sourceMappingURL=admin.js.map
