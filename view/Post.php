<?php

$post = app\App::getDB()->prepare('SELECT * FROM post WHERE id=?', [$_GET['id']]);

?>
<div class="container">
    <div class="row">
        <div class="col-10" style="background-color: grey;">
            <h1><?= $post->title;?></h1>
            <p><?= $post->content ?></p>
            <p><a href="index.php?p=home"></a></p>
        </div>

    </div>
</div>