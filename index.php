<?php
require 'vendor/autoload.php';
require 'bootstrap.php';
use Chatter\Models\Message;
use Chatter\Middleware\Logging as ChatterLogging;
use Chatter\Middleware\Authantication as ChatterAuth;

$app = new Slim\App;
$app->add(new ChatterAuth());
$app->add(new ChatterLogging());
$app->get('/messages', function ($request, $response, $args){
    $_message = new Message();
    $messages = $_message->all();
    $payload = [];
    foreach ($messages as $_msg){
        $payload[$_msg->id] = ['body'=> $_msg->body,
                                'user_id' =>$_msg->user_id,
                                'created_at'=>$_msg->created_at
        ];
    }
    return $response->withStatus(200)->withJson($payload);
});
$app->post('/message', function ($request, $response, $args){
    $_message = $request->getParsedBodyParam('message','');
    $message = new Message();
    $message->body = $_message;
    $message->user_id = -1;
    $message->save();

    if($message->id){
        $payload = ['message_id'=>$message->id,
                    'message_uri'=>'/messages/'.$message->id];
        return $response->withStatus(201)->withJson($payload);
    }else{
        return $response->withStatus(400);
    }
});
$app->delete('/message/{message_id}', function ($request, $response, $args){
    $message = Message::find($args['message_id']);
    $message->delete();
    if($message->exists){
        return $response->withStatus(400);
    }else{
        return $response->withStatus(204);
    }
});
$app->run();