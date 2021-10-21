<div class="container content-page">
    <div class="media d-flex d-xl-flex flex-row justify-content-center align-items-center align-content-center justify-content-xl-start align-items-xl-start content-media" >
        <div>
            <img class="align-self-center m-auto mr-3 content-preview" src="<?php echo base_url(); ?>uploads/<?php echo $file["filename"] ?>">
            <div class="d-flex flex-row justify-content-between align-items-xl-start content-buttons-box">
                <ion-icon name="download-outline"></ion-icon>
                <div class="d-flex d-xl-flex flex-row align-items-xl-center">
                    <ion-icon name="star-outline"></ion-icon>
                    <button class="btn btn-primary d-flex d-xl-flex flex-row align-items-xl-center like-counter" type="button" id="<?php echo $file["id"] ?>">
                        <ion-icon name="heart-outline" class="like-heart"></ion-icon>
                        <span class="like-count"> <?php echo $file["likes"] ?> </span>
                    </button>
                </div>
            </div>
        </div>
        <div class="media-body content-media-body">
            <div class="d-flex flex-row justify-content-start align-items-xl-center content-post-info">
                <h5 class="d-xl-flex align-items-xl-center post-username">
                    <img class="rounded-circle post-profile profile-photo <?php echo $file["username"] ?>">
                    <?php echo $file["username"] ?>
                </h5>
                <button class="btn btn-primary post-info-follow-button" type="button">Follow</button>
            </div>
            <p class="post-description"><?php echo $file["description"] ?></p>
            <div class="d-flex flex-row justify-content-between">
                <div class="d-flex justify-content-xl-start align-items-xl-start">
                    <?php foreach($tags as $tag_info):?>
                        <a class="post-tag" href="<?php echo base_url(); ?>welcome/load_tagged_content/<?php echo $tag_info['tag'] ?>"> #<?php echo $tag_info['tag'] ?></a>
                    <?php endforeach ?> 
                </div>
            </div>
            <div class="content-comment-board">
                <h2 class="comment-board-heading">Comment</h2>
                <div class="comments">
                    <form>
                    <div class="d-flex d-xl-flex flex-row justify-content-between align-items-xl-end comment-box">
                        <div class= "form-group">
                            <input class="d-xl-flex write-comment-section form-control" type="text" placeholder="Write your comment here :)" name="comment"/>
                        </div>
                        <div class = "d-xl-flex justify-content-xl-end align-items-xl-center form-group">
                            <input type = "submit" class="btn btn-primary comment-button" value="Comment"/>
                        </div>
                    </div>

                    </form>
                    
                    <?php foreach($comments as $comment): ?>
                    <div class="d-flex flex-row justify-content-between comment-block">
                        
                        <div class="d-flex flex-column align-items-xl-start">
                            <h5 class="d-xl-flex align-items-xl-center post-username"><?php echo $comment['username'] ?></h5>
                            <p><?php echo $comment['comment_time'] ?></p>
                            <p><?php echo $comment['comment'] ?></p>
                        </div>  
                        
                       
                    </div>
                    <?php endforeach ?>

                    
 

                </div>
            </div>
            


    <script>
        $(document).ready(function() {
            check_likes();
            load_profiles();

            $(".comment-button").click(function () {
                event.preventDefault();
                var file_id = $(".like-counter").attr('id');
                var comment = $(".write-comment-section").val();
                $.ajax({
                    url:"<?php echo base_url(); ?>content/post_comment",
                    method:"GET",
                    data:{file_id:file_id, comment:comment},
                    success:function(response) {
                        
                    }
                });
                location.reload();
            });

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
    </div>
</div>