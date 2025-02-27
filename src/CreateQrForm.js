import React, { useState } from "react";

const CreateQrForm = () => {

    const [qrCodeText, setQrCodeText] = useState('');
    const [qrCodeSize, setQrCodeSize] = useState('');
    const [eyeColor, setEyeColor] = useState('#2563eb');
    const [dotColor, setDotColor] = useState('#25eb3c');
    const [circleRadius, setCircleRadius] = useState(0.5);
    const [version, setVersion] = useState(7);
    const [qrCodeFormat, setQrCodeFormat] = useState('png');
    const [qrCodeMargin, setQrCodeMargin] = useState('');
    const [selectedInput, setSelectedInput] = useState('');
    const [drawCircularModules, setDrawCircularModules] = useState(false);
    
    const handleSubmit = (event) => {
      event.preventDefault();
      // Handle the form submission logic here (e.g., send data via AJAX)
    };

    return(
        <>
           <div className="flex-qr-code-form" id="flex-qr-code-form">
                <h3 className="text-lg text-black font-bold my-3">Create QR Code </h3>
                <p>You can create QR code for any texts or links. There is option to select page, post or product link. You can select easily from dropdown. Here is also options for select QR code color, size, format and margin. After creating you can see the qr code under table. You can easily copy the Qr code and share it as your own.</p>
                <div className="flex">
                    <div className="w-2/3">
                        <form action="/Wordpress/wp-admin/admin.php?page=flexqr-code-generator" method="post" id="qrForm" onSubmit={handleSubmit}>    
                            <input type="hidden" name="action" value="flexqr_generate_qr"/>
                            <input type="hidden" id="qrcode_nonce" name="qrcode_nonce" value="18f8a2af7a"/>
                            <input type="hidden" name="_wp_http_referer" value="/Wordpress/wp-admin/admin.php?page=flexqr-code-generator"/>
                            <div className="my-4">
                                <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">QR Code Version:</label>
                                <select id="version" name="version" value={version} onChange={(e) => setVersion(e.target.value)} class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                </select>
                            </div>                            
                            <div className="my-4">                                
                                <label for="number-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Circle Radius (0.5 to 0.75):</label>
                                <input type="number" id="circleRadius" name="circleRadius" min="0.5" max="0.75" step="0.05" value={circleRadius} onChange={(e) => setCircleRadius(e.target.value)} aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                            </div>
                            <div className="my-4 flex">                           
                                <div className="w-2/3">                                
                                    <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Enter text to encode in QR code:</label>
                                    <textarea id="flexqrcode_code_text" placeholder="text/url/anything" name="qr_code_text" required="" value={qrCodeText} onChange={(e) => setQrCodeText(e.target.value)} class="block p-2.5 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                                </div>
                                <div className="w-1/3">
                                    <select id="flexqrcode_select_page_option" name="qr_code_input" onChange={(e) => setSelectedInput(e.target.value)} class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="">Select</option>
                                        <option value="page">page</option>
                                        <option value="post">post</option> 
                                    </select>
                                    {selectedInput === 'page' && (
                                    <td id="flexqrcode_input_page" style={{display: "none"}}>
                                    <select name="page-dropdown" style={{padding: "6px 20px", margin: "8px 0", display: "inline-block", border: "1px solid #ccc", borderRadius: "4px", boxSizing: "border-box", width: "300px"}}>
                                    <option value="">Select page</option><option value="http://localhost/Wordpress/sample-page/">Sample Page</option></select>
                                    </td>
                                    )}
                                    {selectedInput === 'post' && (
                                    <td id="flexqrcode_input_post" style={{display: "none"}}>
                                    <select name="page-dropdown" style={{padding: "6px 20px", margin: "8px 0", display: "inline-block", border: "1px solid #ccc", borderRadius: "4px", boxSizing: "border-box", width: "300px"}}>
                                    <option value="">Select Posts</option><option value="http://localhost/Wordpress/2025/02/13/hello-world/">Hello world!</option></select>
                                    </td>
                                    )}
                                    {selectedInput === 'product' && (
                                    <td id="flexqrcode_input_product" style={{display: "none"}}>
                                    <select name="page-dropdown" style={{padding: "6px 20px", margin: "8px 0", display: "inline-block", border: "1px solid #ccc", borderRadius: "4px", boxSizing: "border-box", width: "300px"}}>
                                    <option value="">Select Product</option></select>
                                    </td>
                                    )}
                                </div>
                            </div>
                            <div className="my-4 flex">                                
                                <div className="w-2/3 ">
                                    <label for="hs-color-input" class="block text-sm font-medium mb-2 dark:text-black">Choose Eye Color:</label>
                                </div>
                                <div className="w-1/3 ">
                                    <input type="color" id="eye_color" name="eye_color" value={eyeColor} onChange={(e) => setEyeColor(e.target.value)} class="p-1 h-10 w-14 block bg-white border border-gray-200 cursor-pointer rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700" title="Choose your color"></input>
                                </div>
                            </div>                            
                            <div className="my-4 flex">                                
                                <div className="w-2/3 ">
                                    <label for="hs-color-input" class="block text-sm font-medium mb-2 dark:text-black">Choose Dot Color:</label>
                                </div>
                                <div className="w-1/3 ">
                                    <input type="color" id="dot_color" name="dot_color" value={dotColor} onChange={(e) => setDotColor(e.target.value)} class="p-1 h-10 w-14 block bg-white border border-gray-200 cursor-pointer rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700" title="Choose your color"></input>
                                </div>
                            </div>
                            <div className="my-4 ">
                                <div className="">
                                    <label for="drawCircularModules" class="block text-sm font-medium mb-2 dark:text-black">Draw Circular Modules:</label> 
                                </div>
                                <div className="flex gap-2 ">
                                    <div className={ `w-24 cursor-pointer ${drawCircularModules ? "" : "border-4 border-blue-500"}`} onClick={()=>setDrawCircularModules(false)}><img src={`${FLEXQR_CODE_GENERATOR_URI}/dot.png`} alt="Image 1" className="module-preview w-full" id="image1" /></div>
                                                     
                                    <div className={ `w-24 cursor-pointer ${drawCircularModules ? "border-4 border-blue-500" : ""}`} onClick={()=>setDrawCircularModules(true)}>
                                    <img src={`${FLEXQR_CODE_GENERATOR_URI}/round.png`} alt="Image 2" className="w-full module-preview"/></div>
                                </div>
                            </div>
                            <tr><td><label for="qr_code_size">Size(150 X 150):</label></td><td><input type="number" id="qr_code_size" name="qr_code_size" style={{padding: "6px 20px", margin: "8px 0", display: "inline-block", border: "1px solid #ccc", borderRadius: "4px", boxSizing: "border-box", width: "300px"}} value={qrCodeSize} onChange={(e) => setQrCodeSize(e.target.value)}/></td></tr><tr><td><label for="qr_code_format">QR Format:</label></td><td><select id="qr_code_format" name="qr_code_format" style={{padding: "6px 20px", margin: "8px 0", display: "inline-block", border: "1px solid #ccc", borderRadius: "4px", boxSizing: "border-box", width: "300px"}}  value={qrCodeFormat} onChange={(e) => setQrCodeFormat(e.target.value)}>
                            <option value="png">png</option>
                            <option value="gif">gif</option>
                            <option value="jpg">jpg</option>
                            <option value="svg">svg</option>
                            <option value="eps">eps</option>
                            </select></td></tr><tr><td><label for="qr_code_margin">Margin:</label></td><td><input type="number" id="qr_code_margin" name="qr_code_margin" style={{padding: "6px 20px", margin: "8px 0", display: "inline-block", border: "1px solid #ccc", borderRadius: "4px", boxSizing: "border-box", width: "300px"}} value={qrCodeMargin} onChange={(e) => setQrCodeMargin(e.target.value)}/></td></tr><tr><td colspan="2"><input type="submit" className="button button-primary" style={{padding: "7px 20px", margin: "8px 0"}} value="Generate QR Code"/>
                            </td>
                            </tr>                        
                        </form>
                    </div>
                    <div className="w-1/3">
                        <div id="qrCodeOutput"></div>
                    </div>
                </div>
            </div>
    </>
    )
}

export default CreateQrForm;