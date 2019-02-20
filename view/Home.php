
<div class="container">
    <div class="row">
        <?php foreach (app\App::getDB()->query('SELECT * FROM post') as $post): ?>
            <div class="col-3 m-2" style="background-color: grey;">
                <h2><?= $post->title; ?></h2>
                <p><?= $post->content; ?></p>
                <p style="position: absolute; bottom:0; right: 5px;"><a href="index.php?p=post&id=<?= $post->id;?>" >voir article</a></p>


            </div>



        <?php endforeach; ?>
    </div>
</div>