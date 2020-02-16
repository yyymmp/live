<?php
//创建websocket服务器对象，监听0.0.0.0:9502端口
use Swoole\Coroutine\Redis;

$ws = new swoole_websocket_server("0.0.0.0", 9502);

//监听WebSocket连接打开事件
$ws->on('open', function ($ws, $request) {

     $ws->push($request->fd, "hello, welcome\n");
//    $ws->push($request->fd, "hello, welcome\n");  //发送数据到客户端$request->fd
});

//监听WebSocket消息事件
/**
 * $ws  存着所有的webSocket连接
 */
$ws->on('message', function ($ws, $frame) {
    $data = $frame->data;
    var_dump($data);
    foreach ($ws->connections as  $fd){
        if ($fd != $frame->fd) {
            $ws->push($fd, $data);
        }
    }
});

//监听WebSocket连接关闭事件
$ws->on('close', function ($ws, $fd) {
    echo "client-{$fd} is closed\n";
});

$ws->start();