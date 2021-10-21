<div class="container-fluid d-flex justify-content-around align-items-center align-self-center align-items-lg-center flex-wrap tag-page" >
    <?php foreach($files as $post): ?>
        <div class="post-content">
            <div class="media d-flex d-xl-flex flex-column justify-content-center align-items-center align-content-center justify-content-xl-center align-items-xl-center">
                <a href="<?php echo base_url(); ?>content/load_content/<?php echo $post["file_id"] ?>"> <img class="align-self-center m-auto mr-3 preview-img" src= "<?php echo base_url(); ?>uploads/<?php echo $post["filename"] ?>"> </a>
                <div class="post-info">
                    <p class="post-description"><?php echo $post["description"] ?></p>
                    <div class="d-flex flex-row justify-content-between align-items-center align-content-center justify-content-xl-center align-items-xl-center">
                        <h5 class="d-xl-flex align-items-xl-center post-username"><img class="rounded-circle post-profile profile-photo <?php echo $post["username"] ?>"><?php echo $post["username"] ?></h5>
                        <div class="d-flex d-xl-flex flex-row align-items-xl-center">
                            <button class="btn btn-primary d-flex d-xl-flex flex-row align-items-xl-center like-counter" type="button" id="<?php echo $post["file_id"] ?>">
                                <ion-icon name="heart-outline" class="like-heart"></ion-icon>
                                <span class="like-count"> <?php echo $post["likes"] ?> </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach ?>

    <script>
        $(document).ready(function() {
            check_likes();
            load_profiles();
            function like_post(postID) {
                $.ajax({
                url:"<?php echo base_url(); ?>ajax/like_post",
                method:"GET",
                data:{postID:postID},
                success:function(response) {
                    if (response != "") {
                        var obj = JSON.parse(response);
                        if (obj['user_liked']) {
                            var result = $('<ion-icon name="heart" class="like-heart" style="color:tomato;"></ion-icon> <span class="like-count">' + obj['likes'] +'</span>');
                        } else {
                            var result = $('<ion-icon name="heart-outline" class="like-heart" ></ion-icon> <span class="like-count">' + obj['likes'] +'</span>');
                        }
                        $('#'+postID).html(result);
                    }
                }
                });
            };

            $(".like-counter").click(function() {
                var postID = $(this).attr('id');
                like_post(postID);
            });

            function load_profiles() {
                $('.profile-photo').each(function(i,obj) {
                    var username = $(this).attr('class').substring(42);
                    $.ajax({
                        url:"<?php echo base_url(); ?>welcome/uploader_profile",
                        method:"GET",
                        data:{username:username},
                        success:function(response) {
                        if (response != "") {
                            var obj = JSON.parse(response);
                            var profile_path = obj['profile_path'];
                            $('.'+username).attr("style", "background-image: url('<?php echo base_url()?>"+profile_path+"')");
                        }
                        }
                    }); 
                });
            }


            function check_likes() {
                $('.like-counter').each(function(i, obj) {
                    var postID = $(this).attr('id');
                    $.ajax({
                        url:"<?php echo base_url(); ?>welcome/check_like",
                        method:"GET",
                        data:{file_id:postID},
                        success:function(response) {
                        if (response != "") {
                            var obj = JSON.parse(response);
                            if (obj['liked']) { //liked
                                var result = $('<ion-icon name="heart" class="like-heart" style="color:tomato;"></ion-icon> <span class="like-count">' + obj['likes'] +'</span>');
                            } else {
                              var result = $('<ion-icon name="heart-outline" class="like-heart" ></ion-icon> <span  class="like-count">' + obj['likes'] +'</span>');
                            }
                        $('#'+postID).html(result);
                    }
                }
                }); 
                
                });
            };
            
        });
    </script>

</div>