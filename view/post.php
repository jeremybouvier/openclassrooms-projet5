<?php

namespace view;

use Zend\Diactoros\ServerRequestFactory;

$request = ServerRequestFactory::fromGlobals();
$params = $request->getQueryParams();

$post = \app\App::getDB()->prepare('SELECT * FROM post WHERE id=?', [$params['id']]);

?>
<div class="container">
    <div class="row">
        <div class="col-10" style="background-color: grey;">
            <h1><?= $post->title;?></h1>
            <p><?= $post->content ?></p>
            <p><a href="../index/home">Retour a la list des posts</a></p>
        </div>

    </div>
</div>