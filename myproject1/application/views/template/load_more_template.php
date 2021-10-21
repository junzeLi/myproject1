<div class="post-content">
    <div class="media d-flex d-xl-flex flex-column justify-content-center align-items-center align-content-center justify-content-xl-center align-items-xl-center">
        <a href="<?php echo base_url(); ?>content/load_content/<?php echo $post["id"] ?>"> <img class="align-self-center m-auto mr-3 preview-img" src= "<?php echo base_url(); ?>uploads/<?php echo $post["filename"] ?>"> </a>
        <div class="post-info">
            <p class="post-description"><?php echo $post["description"] ?></p>
            <div class="d-flex flex-row justify-content-between align-items-center align-content-center justify-content-xl-center align-items-xl-center">
                <h5 class="d-xl-flex align-items-xl-center post-username"> 
                    <img class="rounded-circle post-profile profile-photo <?php echo $post["username"] ?>">
                    <?php echo $post["username"] ?>
                </h5>
                <div class="d-flex d-xl-flex flex-row align-items-xl-center">
                    <button class="btn btn-primary d-flex d-xl-flex flex-row align-items-xl-center like-counter" type="button" id="<?php echo $post["id"] ?>">
                        <ion-icon name="heart-outline" class="like-heart"></ion-icon>
                        <span class="like-count"> <?php echo $post["likes"] ?></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>