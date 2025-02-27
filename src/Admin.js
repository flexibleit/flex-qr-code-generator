import * as React from "react";
import * as ReactDOM from "react-dom";
import CreateQrForm from "./CreateQrForm";


ReactDOM.createRoot(document.getElementById("flex_qr_code_input")).render(
    <React.StrictMode>
        <CreateQrForm />
    </React.StrictMode>
);