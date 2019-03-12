




            <div class="col-3 m-2 pb-5" style="background-color: grey;">
                <h2><?= $post->getTitle(); ?></h2>
                <p><?= $post->getContent(); ?></p>
                <p style="position: absolute; bottom:0; right: 5px;"><a href="../post/<?= $post->getId();?>" >Voir article</a></p>
            </div>

