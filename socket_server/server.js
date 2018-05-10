var io = require('socket.io')(6001),
    Redis = require('ioredis'),
    redis = new Redis();

redis.psubscribe('*', function (error, count) {
    if (error) {
        console.error(error, count);
    }
    console.info('socket work...');
});

redis.on('pmessage', function (pattern, chanel, message) {
    message = JSON.parse(message);
    io.emit(chanel + ':' + message.event, message.data);
    console.log(chanel, message);
});