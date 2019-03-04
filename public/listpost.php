

<div class="container">
    <div class="row">

            <div class="col-3 m-2" style="background-color: grey;">
                <h2><?= $post->title; ?></h2>
                <p><?= $post->content; ?></p>
                <p style="position: absolute; bottom:0; right: 5px;"><a href="../index/post-<?= $post->id;?>" >voir article</a></p>
            </div>

    </div>
</div>