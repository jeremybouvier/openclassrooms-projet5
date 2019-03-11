<?php


use Application\App;

$post = App::getDB()->prepare('SELECT * FROM post WHERE id=?', [$id]);
?>

<div class="container">
    <div class="row">
        <div class="col-10" style="background-color: grey;">
            <h1><?= $post->title;?></h1>
            <p><?= $post->content ?></p>
            <p><a href="../listpost">Retour a la list des posts</a></p>
        </div>

    </div>
</div>