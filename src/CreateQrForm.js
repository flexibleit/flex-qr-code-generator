import React, { useState } from 'react';
import Button from './components/Button';
import TypeSelector from './components/TypeSelector';
import { fileTypeConverter } from './helpers/fileTypeConverter';
import NumberInputField from './components/NumberInputField';
// import axios from "axios";

const CreateQrForm = () => {
  const [qrCodeText, setQrCodeText] = useState('');
  const [qrCodeSize, setQrCodeSize] = useState('150');
  const [eyeColor, setEyeColor] = useState('#2563eb');
  const [dotColor, setDotColor] = useState('#25eb3c');
  const [circleRadius, setCircleRadius] = useState(0.5);
  const [version, setVersion] = useState(7);
  // const [qrCodeFormat, setQrCodeFormat] = useState('png');
  const [qrCodeMargin, setQrCodeMargin] = useState('5');
  const [selectedInput, setSelectedInput] = useState('');
  const [drawCircularModules, setDrawCircularModules] = useState(false);
  const [isLoading, setIsLoading] = useState(false);
  const [isQrGenerated, setIsQrGenerated] = useState(false);
  const [isQrSaved, setIsQrSaved] = useState(false);
  const [isDownloaded, setIsDownloaded] = useState(false);
  //const [qrUrl, setQrUrl] = useState("");
  const [qrCodeOutput, setQrCodeOutput] = useState(null);
  const [file, setFile] = useState(null);
  const [logoUrlPath, setLogoUrlPath] = useState(null);

  const [downloadType, setDownloadType] = useState('svg');
  const [qrFileName, setQrFileName] = useState('qr_code');

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
    formData.append('qr_code_input', selectedInput);
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

    await fileTypeConverter(qrCodeOutput, qrCodeSize, downloadType, qrFileName);
  };

  return (
    <>
      <div className='flex-qr-code-form' id='flex-qr-code-form'>
        <h3 className='text-lg text-black font-bold my-3'>Create QR Code </h3>
        <p>
          You can create QR code for any texts or links. There is option to
          select page, post or product link. You can select easily from
          dropdown. Here is also options for select QR code color, size, format
          and margin. After creating you can see the qr code under table. You
          can easily copy the Qr code and share it as your own.
        </p>
        <div className='flex'>
          <div className='w-2/3'>
            <form
              onSubmit={handleSubmit}
              action='/Wordpress/wp-admin/admin.php?page=flexqr-code-generator'
              method='post'
              id='qrForm'
            >
              <input type='hidden' name='action' value='flexqr_generate_qr' />
              <input
                type='hidden'
                id='qrcode_nonce'
                name='qrcode_nonce'
                value='18f8a2af7a'
              />
              <input
                type='hidden'
                name='_wp_http_referer'
                value='/Wordpress/wp-admin/admin.php?page=flexqr-code-generator'
              />
              <div className='my-4 flex'>
                <div className='w-2/3'>
                  <label
                    for='message'
                    class='block mb-2 text-sm font-medium text-gray-900 dark:text-white'
                  >
                    Enter text to encode in QR code:
                  </label>
                  <textarea
                    id='flexqrcode_code_text'
                    placeholder='text/url/anything'
                    name='qr_code_text'
                    required
                    value={qrCodeText}
                    onChange={(e) => setQrCodeText(e.target.value)}
                    class='block w-full p-2.5 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'
                  ></textarea>
                </div>
                <div className='w-1/3 m-7'>
                  <select
                    id='flexqrcode_select_page_option'
                    name='qr_code_input'
                    onChange={(e) => setSelectedInput(e.target.value)}
                    class='bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'
                  >
                    <option value=''>Select</option>
                    <option value='page'>page</option>
                    <option value='post'>post</option>
                  </select>
                  {selectedInput === 'page' && (
                    <td id='flexqrcode_input_page' style={{ display: 'none' }}>
                      <select
                        name='page-dropdown'
                        style={{
                          padding: '6px 20px',
                          margin: '8px 0',
                          display: 'inline-block',
                          border: '1px solid #ccc',
                          borderRadius: '4px',
                          boxSizing: 'border-box',
                          width: '300px',
                        }}
                      >
                        <option value=''>Select page</option>
                        <option value='http://localhost/Wordpress/sample-page/'>
                          Sample Page
                        </option>
                      </select>
                    </td>
                  )}
                  {selectedInput === 'post' && (
                    <td id='flexqrcode_input_post' style={{ display: 'none' }}>
                      <select
                        name='page-dropdown'
                        style={{
                          padding: '6px 20px',
                          margin: '8px 0',
                          display: 'inline-block',
                          border: '1px solid #ccc',
                          borderRadius: '4px',
                          boxSizing: 'border-box',
                          width: '300px',
                        }}
                      >
                        <option value=''>Select Posts</option>
                        <option value='http://localhost/Wordpress/2025/02/13/hello-world/'>
                          Hello world!
                        </option>
                      </select>
                    </td>
                  )}
                  {selectedInput === 'product' && (
                    <td
                      id='flexqrcode_input_product'
                      style={{ display: 'none' }}
                    >
                      <select
                        name='page-dropdown'
                        style={{
                          padding: '6px 20px',
                          margin: '8px 0',
                          display: 'inline-block',
                          border: '1px solid #ccc',
                          borderRadius: '4px',
                          boxSizing: 'border-box',
                          width: '300px',
                        }}
                      >
                        <option value=''>Select Product</option>
                      </select>
                    </td>
                  )}
                </div>
              </div>
              <div className='my-4 w-full flex justify-between'>
                <div>
                  <label
                    for='countries'
                    class='block mb-2 text-sm font-medium text-gray-900 dark:text-white'
                  >
                    QR Code Version:
                  </label>
                  <select
                    id='version'
                    name='version'
                    value={version}
                    onChange={(e) => setVersion(e.target.value)}
                    class='bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'
                  >
                    <option value='5'>5</option>
                    <option value='6'>6</option>
                    <option value='7'>7</option>
                    <option value='8'>8</option>
                    <option value='9'>9</option>
                    <option value='10'>10</option>
                  </select>
                </div>

                <NumberInputField
                  label='Circle Radius (0.5 to 0.75)'
                  name='circleRadius'
                  value={circleRadius}
                  onChange={(e) => setCircleRadius(e.target.value)}
                  min='0.5'
                  max='0.75'
                  step='0.05'
                />
                <div>
                  <div>
                    <label
                      for='hs-color-input'
                      class='block text-sm font-medium mb-2 dark:text-black'
                    >
                      Eye Color:
                    </label>
                  </div>
                  <div>
                    <input
                      type='color'
                      id='eye_color'
                      name='eye_color'
                      value={eyeColor}
                      onChange={(e) => setEyeColor(e.target.value)}
                      class='p-1 h-10 w-14 block bg-white border border-gray-200 cursor-pointer rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700'
                      title='Choose your color'
                    ></input>
                  </div>
                </div>
                <div>
                  <div>
                    <label
                      for='hs-color-input'
                      class='block text-sm font-medium mb-2 dark:text-black'
                    >
                      Dot Color:
                    </label>
                  </div>
                  <div>
                    <input
                      type='color'
                      id='dot_color'
                      name='dot_color'
                      value={dotColor}
                      onChange={(e) => setDotColor(e.target.value)}
                      class='p-1 h-10 w-14 block bg-white border border-gray-200 cursor-pointer rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700'
                      title='Choose your color'
                    ></input>
                  </div>
                </div>
                <div>
                  <div>
                    <label
                      for='drawCircularModules'
                      class='block text-sm font-medium mb-2 dark:text-black'
                    >
                      Draw Circular Modules:
                    </label>
                  </div>
                  <div className='flex gap-2'>
                    <div
                      className={`w-24 cursor-pointer ${
                        drawCircularModules ? '' : 'border-4 border-blue-500'
                      }`}
                      onClick={() => setDrawCircularModules(false)}
                    >
                      <img
                        src={`${FLEXQR_CODE_GENERATOR_URI}/round.png`}
                        alt='Image 1'
                        className='module-preview w-full'
                        id='image1'
                      />
                    </div>
                    <div
                      className={`w-24 cursor-pointer ${
                        drawCircularModules ? 'border-4 border-blue-500' : ''
                      }`}
                      onClick={() => setDrawCircularModules(true)}
                    >
                      <img
                        src={`${FLEXQR_CODE_GENERATOR_URI}/dot.png`}
                        alt='Image 2'
                        className='w-full module-preview'
                      />
                    </div>
                  </div>
                </div>
              </div>
              <div className='my-4 flex gap-2'>
                <NumberInputField
                  label='Size(150 X 150):'
                  name='qr_code_size'
                  value={qrCodeSize}
                  onChange={(e) => setQrCodeSize(e.target.value)}
                  min='100'
                  max='1000'
                  step='50'
                />

                <NumberInputField
                  label='Margin:'
                  name='qr_code_margin'
                  value={qrCodeMargin}
                  onChange={(e) => setQrCodeMargin(e.target.value)}
                  min='5'
                  max='100'
                  step='1'
                />
                <div>
                  <label
                    class='block mb-2 text-sm font-medium text-gray-900 dark:text-white'
                    for='file_input'
                  >
                    Upload Logo
                  </label>
                  <input
                    onChange={handleFileChange}
                    class='block text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400'
                    id='qr_code_logo'
                    type='file'
                  />
                </div>
              </div>
              <div className='my-4 flex gap-2 items-end'>
                {/* Buttons */}
                {/* Generate Button */}
                <Button
                  onClick={handleSubmit}
                  value={isLoading ? 'Generating...' : 'Generate'}
                  disabled={isLoading}
                />
                <div className='flex gap-2 ml-4 items-end'>
                  {/* Save Button */}
                  <Button
                    onClick={(e) => handleSubmit(e, true)}
                    value={isQrSaved ? 'Saved' : 'Save'}
                    disabled={!isQrGenerated || isQrSaved}
                  />
                  {/* File Type Selector */}
                  <TypeSelector
                    setSelectedValue={setDownloadType}
                    selectedValue={downloadType}
                  />
                  {/* Download Button */}
                  <Button
                    onClick={(e) => handleDownloadQr(e)}
                    value={isDownloaded ? 'Downloaded' : 'Download'}
                    //   disabled={!isQrGenerated || isDownloaded}
                    disabled={!isQrGenerated}
                  />
                </div>
              </div>
            </form>
          </div>
          <div className='w-1/3'>
            {/* Display QR code if available */}
            {qrCodeOutput && (
              <div id='qrCodeOutput'>
                <img src={qrCodeOutput} alt='Generated QR Code' />
              </div>
            )}
          </div>
        </div>
      </div>
    </>
  );
};

export default CreateQrForm;
