const path = require('path');

module.exports = () => {
    return{
        entry:{
            'admin': path.resolve(__dirname, 'spa/admin/Admin.jsx')
        } ,
        output:{
            filename: 'admin.js',
            path: path.resolve(__dirname, 'spa/build')
        },
        module:{
            rules:[
                {
                test: /\.jsx?$/,
                use: {
                    loader: 'babel-loader',
                    options:{
                        presets:['@babel/preset-react']
                    }
                }
                }
            ]
        }
    }
}