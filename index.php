<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<link rel="stylesheet" href="dplay/DPlayer.min.css" />
<script src="hls/hls.min.js"></script>
<script src="dplay/DPlayer.min.js"></script>
<body>
<div id="dplayer" style="width: 500px"></div>
</body>
<script>
    const dp = new DPlayer({
        container: document.getElementById('dplayer'),  //div
        live: true,
        danmaku: true,
        apiBackend: {
            //页面加载即触发 在此连接websocket服务器
            read: function(endpoint) {
                wsServer = 'ws://47.102.101.13:9502'; //
                websocket = new WebSocket(wsServer);  //创建ws对象
                websocket.onopen = function (evt) {       //创建连接对象
                    console.log('连接成功')
                };
                endpoint.success()
            },
            //发送弹幕触发,在此向服务端提交弹幕
            send: function(endpoint) {
                websocket.send(endpoint.data.text);
            },
        },
        video: {
            url: 'http://ivi.bupt.edu.cn/hls/cctv1hd.m3u8',
            pic: 'c11fd16064.jpg',
            type: 'hls',
        },
    });
    //接受客户但推送过来的消息
    websocket.onmessage = function (evt) {       //创建连接对象
        console.log(evt.data);
        const danmaku = {
            text: evt.data,
            color: '#fff',
            type: 'right',
        };
        dp.danmaku.draw(danmaku);
    };
</script>
</html>
