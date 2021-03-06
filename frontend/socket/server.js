const express = require("express")
const socketio = require("socket.io")
const http = require('http')

const PORT = process.env.PORT || 6001

const app = express()
const server = http.createServer(app)
const io = socketio(server)

io.on('connection', function(socket){
    console.log('A client had connected on this server ...')

    socket.on('sendMessage', function( data ){
        console.log(`A client send an data: ${data}`)
    })

    socket.on('comment', function(data){
        console.log(`Username ${data.user.name} has just commented!`)
        socket.broadcast.emit('receivedComment', data)  
    })

    socket.on('like', function(data){
        console.log(`Username ${data.user.name} has just liked a post`)
        socket.broadcast.emit('liked', data)
    })

    socket.on('disconnect', function(){
        console.log('A client had been left ...')
    })
})

server.listen(PORT, function(){
    console.log(`Server had started on port ${PORT}`)
})
// console.log(io)