const http = require('http');
const api = require('./api_app');

const port = process.env.PORT || 3000;

const server = http.createServer(api);
server.listen(port);
