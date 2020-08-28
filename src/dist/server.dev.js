"use strict";

var PORT = 6002;

var io = require('socket.io')(PORT);

console.log("Connected to port ".concat(PORT));
io.on('error', function (socket) {
  console.log('error');
});
io.on('connection', function (socket) {
  console.log('A client ' + socket.id + 'just connected to Server ...');
  socket.on('chatMessage', function (msg) {
    io.emit('message', msg);
  });
  socket.on('sentMessage', function (data) {
    io.emit('receivedMessage', data);
    console.log("Sent message ".concat(data, " to client!"));
  });
});