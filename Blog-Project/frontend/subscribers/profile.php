<?php
require_once("header.php");
$user = unserialize($_SESSION['user']);
$myposts = $user->my_posts($user->id);
// var_dump($user);
?>


<section class="w-100 px-4 py-5" style="background-color: #9de2ff; border-radius: .5rem .5rem 0 0;">
    <div class="row d-flex justify-content-center">
        <div class="col col-md-9 col-lg-7 col-xl-6">
            <div class="card" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <!-- Profile picture card-->
                            <div class="card mb-4 mb-xl-0">
                                <div class="card-header">Profile Picture</div>
                                <div class="card-body text-center">
                                    <?php
                                    if (isset($_GET["msg"]) && $_GET["msg"] == 'uius') {
                                    ?>
                                        <div class="alert alert-success" role="alert">
                                            <strong>Done</strong> User Image Updated Successfully
                                        </div>


                                    <?php
                                    }

                                    ?>
                                    <!-- Profile picture image-->
                                    <img class="img-account-profile rounded-circle mb-2" style="width: 150px; height:150px; border-radius:150px" src="<?php if (!empty($user->image)) echo $user->image;
                                                                                                                                                        else echo 'http://bootdey.com/img/Content/avatar/avatar1.png'; ?>" alt="">
                                    <!-- Profile picture help block-->
                                    <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                                    <!-- Profile picture upload button-->
                                    <form action="store_user_image.php" method="POST" enctype="multipart/form-data">
                                        <label for="" class="form-label">image</label>
                                        <input type="file" name="image" id="" class="form-control" placeholder="" aria-describedby="helpId" />
                                        <input type="submit" class="btn btn-success mt-2"></input>

                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="mb-1"><?= $user->name ?></h5>
                            <p class="mb-2 pb-1"><?= $user->role ?></p>
                            <div class="d-flex justify-content-start rounded-3 p-2 mb-2 bg-body-tertiary">
                                <div>
                                    <p class="small text-muted mb-1">Articles</p>
                                    <p class="mb-0">41</p>
                                </div>
                                <div class="px-3">
                                    <p class="small text-muted mb-1">Followers</p>
                                    <p class="mb-0">976</p>
                                </div>
                                <div>
                                    <p class="small text-muted mb-1">Rating</p>
                                    <p class="mb-0">8.5</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <div class="row">



        <div class="col-6 offset-3 mt-5 rounded-2">
            <h1 class="text-white text-center">Share Your Idea</h1>
        </div>
        <form action="storePost.php" method="POST" enctype="multipart/form-data">

            <div class="col-6 offset-3 mt-5 rounded-2">
                <?php
                if (isset($_GET["msg"]) && $_GET["msg"] == 'done') {
                ?>
                    <div class="alert alert-success" role="alert">
                        <strong>Done</strong> Post Added Successfully
                    </div>


                <?php
                }

                ?>
                <?php
                if (isset($_GET["msg"]) && $_GET["msg"] == 'require_fields') {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <strong>Require_Fields</strong> Fields Are Empty
                    </div>


                <?php
                }

                ?>
                <div class="mb-3">
                    <label for="" class="form-label">Title</label>
                    <input type="text" name="title" id="" class="form-control" placeholder="" aria-describedby="helpId" />
                    <small id="helpId" class="text-muted">Help text</small>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Content</label>
                    <textarea type="text" name="content" id="" class="form-control" placeholder="" aria-describedby="helpId" style="resize:none;"></textarea>
                    <small id="helpId" class="text-muted">Help text</small>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">image</label>
                    <input type="file" name="image" id="" class="form-control" placeholder="" aria-describedby="helpId" />
                    <small id="helpId" class="text-muted">Help text</small>
                </div>
                <button type="submit" class="btn btn-primary my-5">
                    Submit
                </button>
            </div>



            <div class="col-6 offset-3 mt-5 rounded-2">
            <?php
            foreach ($myposts as $post) {
            ?>
                
                    <div class="card mt-5">
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







<?php
require_once("footer.php");
?>