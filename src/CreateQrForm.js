import React, { useState } from "react";

const CreateQrForm = () => {

    const [qrCodeText, setQrCodeText] = useState('');
    const [qrCodeSize, setQrCodeSize] = useState('');
    const [eyeColor, setEyeColor] = useState('');
    const [dotColor, setDotColor] = useState('');
    const [circleRadius, setCircleRadius] = useState(0.5);
    const [version, setVersion] = useState(7);
    const [qrCodeFormat, setQrCodeFormat] = useState('png');
    const [qrCodeMargin, setQrCodeMargin] = useState('');
    const [selectedInput, setSelectedInput] = useState('');
    
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
                        <form className="my-5" action="/Wordpress/wp-admin/admin.php?page=flexqr-code-generator" method="post" id="qrForm" onSubmit={handleSubmit}>    
                            <input type="hidden" name="action" value="flexqr_generate_qr"/>
                            <input type="hidden" id="qrcode_nonce" name="qrcode_nonce" value="18f8a2af7a"/>
                            <input type="hidden" name="_wp_http_referer" value="/Wordpress/wp-admin/admin.php?page=flexqr-code-generator"/>
                            <div className="my-4">
                                <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select QR Code Version:</label>
                                <select id="version" name="version" value={version} onChange={(e) => setVersion(e.target.value)} class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                </select>
                            </div>
                            
                            <label for="circleRadius">Circle Radius (0.5 to 0.75):</label><input type="number" id="circleRadius" name="circleRadius" min="0.5" max="0.75" step="0.05" value={circleRadius} onChange={(e) => setCircleRadius(e.target.value)}/><br/><br/><table><tbody><tr><td><label for="flexqrcode_code_text">Enter text to encode in QR code:</label></td><td>
                            <textarea id="flexqrcode_code_text" placeholder="text/url/anything" name="qr_code_text" required="" value={qrCodeText} onChange={(e) => setQrCodeText(e.target.value)} style={{padding: "6px 20px", margin: "8px 0", display: "inline-block", border: "1px solid #ccc", borderRadius: "4px", boxSizing: "border-box", width: "300px"}}></textarea>
                            </td>
                            <td>
                            <select id="flexqrcode_select_page_option" name="qr_code_input" style={{padding: "6px 20px", margin: "8px 0", display: "inline-block", border: "1px solid #ccc", borderRadius: "4px", boxSizing: "border-box", width: "300px"}} onChange={(e) => setSelectedInput(e.target.value)}>
                            <option value="">Select</option>
                            <option value="page">page</option>
                            <option value="post">post</option> </select>
                            </td>
                            
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
                        </tr>    

                    <tr><td><label for="eye_color">Eye Color:</label></td>
                    <td><input type="color" id="eye_color" name="eye_color" value={eyeColor} onChange={(e) => setEyeColor(e.target.value)}/></td></tr>

                    <tr><td><label for="dot_color">Dot Color:</label></td>
                    <td><input type="color" id="dot_color" name="dot_color" value={dotColor} onChange={(e) => setDotColor(e.target.value)}/></td></tr>   

                    <tr><td><label for="drawCircularModules">Draw Circular Modules:</label></td>    
                        <td><input style={{width: "1px"}} type="radio" id="image1" name="drawCircularModules" value="1"/>
                        <label for="image1"><img src="http://localhost/Wordpress/wp-content/plugins/flex-qr-code-generator-pro/views/../dot.png" alt="Image 1" className="module-preview"/></label></td>
                        <td><input style={{width: "1px"}} type="radio" id="image2" name="drawCircularModules" value="0" checked=""/>
                        <label for="image2"><img src="http://localhost/Wordpress/wp-content/plugins/flex-qr-code-generator-pro/views/../round.png" alt="Image 2" className="module-preview"/></label></td></tr>

                        <tr><td><label for="qr_code_size">Size(150 X 150):</label></td><td><input type="number" id="qr_code_size" name="qr_code_size" style={{padding: "6px 20px", margin: "8px 0", display: "inline-block", border: "1px solid #ccc", borderRadius: "4px", boxSizing: "border-box", width: "300px"}} value={qrCodeSize} onChange={(e) => setQrCodeSize(e.target.value)}/></td></tr><tr><td><label for="qr_code_format">QR Format:</label></td><td><select id="qr_code_format" name="qr_code_format" style={{padding: "6px 20px", margin: "8px 0", display: "inline-block", border: "1px solid #ccc", borderRadius: "4px", boxSizing: "border-box", width: "300px"}}  value={qrCodeFormat} onChange={(e) => setQrCodeFormat(e.target.value)}>
                        <option value="png">png</option>
                        <option value="gif">gif</option>
                        <option value="jpg">jpg</option>
                        <option value="svg">svg</option>
                        <option value="eps">eps</option>
                        </select></td></tr><tr><td><label for="qr_code_margin">Margin:</label></td><td><input type="number" id="qr_code_margin" name="qr_code_margin" style={{padding: "6px 20px", margin: "8px 0", display: "inline-block", border: "1px solid #ccc", borderRadius: "4px", boxSizing: "border-box", width: "300px"}} value={qrCodeMargin} onChange={(e) => setQrCodeMargin(e.target.value)}/></td></tr><tr><td colspan="2"><input type="submit" className="button button-primary" style={{padding: "7px 20px", margin: "8px 0"}} value="Generate QR Code"/>
                        </td>
                        </tr>
                        </tbody>
                        </table>
                        </form>
                    </div>
                    <div className="w-1/3">
                    
                    </div>
                </div>
                                
                <div id="qrCodeOutput"></div>
                {/* <div id="ReactCodeOutput"><h1>Hello4 from React Component</h1></div> */}
        </div>
    </>
    )
}

export default CreateQrForm;