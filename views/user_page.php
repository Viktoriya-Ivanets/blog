<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="user-info">
                <img src="<?= $user['avatar'] ?>" alt="Default Avatar" class="user-page-img">
                <h1>
                    <?= $user['nickname'] ?>
                </h1>
                <?php if ($user['id'] === $authInfo['id']): ?>
                    <div class="form mt-3">
                        <form method="post" enctype="multipart/form-data">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="inputGroupFile" name="file">
                                    <label class="custom-file-label" for="inputGroupFile">Choose file</label>
                                </div>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit" name="upload_avatar">Upload</button>
                                </div>
                            </div>
                            <?php if ($user['avatar'] !== 'assets/images/default.jpg'): ?>
                                <button type="submit" class="btn btn-primary mt-2" name="delete_avatar">Delete avatar</button>
                            <?php endif; ?>
                            <p>
                                <?= $err ?>
                            </p>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-md-8">
            <div class="user-article">
                <h1>User's articles:</h1>
                <?php foreach ($articles as $article): ?>
                    <h2>
                        <?php echo $article['header'] ?>
                    </h2>
                    <a href="article.php?id=<?= $article['id']; ?>">Read more</a>
                    <hr>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
