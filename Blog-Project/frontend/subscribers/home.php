<?php
require_once('header.php');
require_once('../../classes.php');
$user = unserialize(($_SESSION["user"]));
$homePosts = $user->home_posts();
?>

<main>

  <section class="py-5 text-center container">
    <div class="row py-lg-5">
      <div class="col-lg-6 col-md-8 mx-auto">
        <h1 class="fw-light">Welcome <?= $user->name ?></h1>
      </div>
    </div>
  </section>

  <div class="album py-5 bg-body-tertiary">
    <div class="container">


      <div class="col-6 offset-3 mt-5 rounded-2">
        <?php
        foreach ($homePosts as $post) {
        ?>
          <div class="card mt-5">

            <div class="d-flex justify-content-between">
              <div class="d-flex flex-row align-items-center p-3">
                <img style="width: 50px; height:50px; border-radius:50px;" src="<?php if (!empty($post['image'])) echo $post['image'];
                                                                                else echo 'http://bootdey.com/img/Content/avatar/avatar1.png'; ?>" alt="">
                <div class="ms-2 c-details">
                  <h6 class="mb-0"><?= $post["name"] ?></h6> <span><?= $post["created_at"] ?></span>
                </div>
              </div>
            </div>
            <?php
            if (!empty($post['image'])) {
            ?>
              <img class="card-img-top" src="<?= $post["image"] ?>" alt="Title" />
            <?php
            }
            ?>
            <div class="card-body">
              <h4 class="card-title"><?= $post["title"] ?></h4>
              <p class="card-text"><?= $post["content"] ?></p>
            </div>
            <div class="row d-flex justify-content-center">
              <div class="col">
                <div class="card shadow-0 border">
                  <div class="card-body p-4">
                    <form action="store_comment.php" method="POST">
                      <div data-mdb-input-init class="form-outline mb-4">
                        <input type="text" id="addANote" name="comment" class="form-control" placeholder="Type comment..." />
                        <input type="hidden" name="post_id" value="<?= $post["id"] ?>">
                        <button type="submit" class="btn btn-primary mt-2 ms-2">+ Add a note</button>
                      </div>
                    </form>
                    <?php
                    $comments = $user->get_post_comment($post["id"]);
                    foreach ($comments as $comment) {
                    ?>
                      <div class="card mb-4">
                        <div class="card-body">
                          <p><?= $comment["comment"] ?></p>

                          <div class="d-flex justify-content-between">
                            <div class="d-flex flex-row align-items-center">
                              <img src="<?php if (!empty($comment['image'])) echo $comment['image'];
                                        else echo 'http://bootdey.com/img/Content/avatar/avatar1.png'; ?>" alt="avatar" width="25" height="25" />
                              <p class="small mb-0 ms-2"><?= $comment["name"] ?></p>
                            </div>
                            <div class="d-flex flex-row align-items-center">
                              <p class="small text-muted mb-0"><?= $comment["created_at"] ?></p>
                            </div>
                          </div>
                        </div>
                      </div>

                    <?php
                    }
                    ?>


                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php
        }
        ?>


      </div>

    </div>
  </div>
  </div>

</main>


<?php
require_once('footer.php');
?>