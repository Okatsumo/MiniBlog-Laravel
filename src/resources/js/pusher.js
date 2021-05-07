import Echo from "laravel-echo"
window.Pusher = require('pusher-js');


window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '2d8ece5da4c27dde126c',
    wsHost: window.location.hostname,
    // wsHost: '192.168.1.94',
    wsPort: 6001,
    forceTLS: false,
    disableStats: true,
    enabledTransports: ['ws']
});
