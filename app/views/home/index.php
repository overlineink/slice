<?php
    $this->start('body');
    $b = '';
    if(empty($GLOBALS['render']))
    {
        $b = 'hidden';
    }
?>
<section class="section">
    <div <?=$b?> class="container">
        <div class="notification is-primary" style="margin-bottom: 10px;">
            <?=$GLOBALS['message']?>
        </div>
    </div>
    <div class="container">
        <h1 class="title">
            Hello World 🌍
        </h1>
        <p class="subtitle">Slice is an open source MVC framework written in php used to teach junior developers to
            meet and build a demo of the MVC pattern. 🐱‍💻</p>
        <pre>First, choose an picture and then press upload to see what happens.</pre>
        <div <?=$b?> >
            <div class="box">
                <article class="media">
                    <div class="media-left">
                        <figure class="image is-64x64">
                            <img src="<?= $GLOBALS['render'] ?>" alt="Image">
                        </figure>
                    </div>
                    <div class="media-content">
                        <div class="content">
                            <p>
                                <strong>Jorge Dacosta</strong> <small>@overlineink</small> <small>31m</small>
                                <br>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean efficitur sit amet
                                massa fringilla egestas. Nullam condimentum luctus turpis.
                            </p>
                        </div>
                        <nav class="level is-mobile">
                            <div class="level-left">
                                <a class="level-item" aria-label="reply">
                                    <span class="icon is-small">
                                        <i class="fas fa-reply" aria-hidden="true"></i>
                                    </span>
                                </a>
                                <a class="level-item" aria-label="retweet">
                                    <span class="icon is-small">
                                        <i class="fas fa-retweet" aria-hidden="true"></i>
                                    </span>
                                </a>
                                <a class="level-item" aria-label="like">
                                    <span class="icon is-small">
                                        <i class="fas fa-heart" aria-hidden="true"></i>
                                    </span>
                                </a>
                            </div>
                        </nav>
                    </div>
                </article>
            </div>
        </div>
    </div>
    <div class="container" style="margin-top: 10px;">
        <div class="row">
            <form action="" class="form-group" method="POST" enctype="multipart/form-data">
                <div class="control">
                    <input type="file" name="image" required />

                    <button type="submit" class="button is-primary">
                        <span class="icon">
                            <i class="fa fa-cloud"></i>
                        </span>
                        <span>Upload</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
<?php $this->end(); ?>