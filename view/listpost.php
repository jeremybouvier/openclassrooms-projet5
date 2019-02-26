<?php namespace view;

/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 22/02/19
 * Time: 21:03
 */
?>

<div class="container">
    <div class="row">
        <?php foreach (\app\App::getDB()->query('SELECT * FROM post') as $post): ?>
            <div class="col-3 m-2" style="background-color: grey;">
                <h2><?= $post->title; ?></h2>
                <p><?= $post->content; ?></p>
                <p style="position: absolute; bottom:0; right: 5px;"><a href="../index/post-<?= $post->id;?>" >voir article</a></p>


            </div>



        <?php endforeach; ?>

    </div>
</div>