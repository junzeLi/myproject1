<div id="homepage_all">
<div class="container-fluid d-flex justify-content-around align-items-center align-self-center align-items-lg-center flex-wrap" id="homepage">
    <?php for($i = 0; $i< min($this->session->userdata['homepage_page']*4, $num_post); $i++):?>
        <?php $post = $all_post[$i]?>
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
    <?php endfor ?>
    

    

</div>

<div> 
    <button class="btn btn-primary btn-block action-button load_more">MORE </button>
</div>


<script>
        $(document).ready(function() {
            check_likes();
            load_profiles();
            
            var d = $('#homepage_all');
            d.scrollTop(d.prop("scrollHeight"));

            $(document).on('click','.load_more',function(){
                $current_page = <?php echo $this->session->userdata['homepage_page']?>;
                $num_post = <?php echo $num_post?>;
                if ($current_page * 4 >= $num_post) {
                    $(".load_more").text("No more post");
                    document.getElementsByClassName("load_more")[0].classList.remove("load_more");
                } else {
                    $.ajax({
                        method:'POST',
                        url:"<?php echo base_url(); ?>welcome/load_more",
                        dataType: 'html',
                        success:function(response){
                            if (response != "") {
                                $('#homepage').append(response);
                                check_likes();
                                load_profiles();
                                $current_page = <?php echo $this->session->userdata['homepage_page']?>;
                                $num_post = <?php echo $num_post?>;
                                if ($current_page * 4 >= $num_post) {
                                    $(".load_more").text("No more post");
                                    document.getElementsByClassName("load_more")[0].classList.remove("load_more");
                                }
                            } else {
                                $(".load_more").text("No more post");
                                document.getElementsByClassName("load_more")[0].classList.remove("load_more");
                            }
                        }
                    }) 
                }
            })


            $(document).on('click','.like-counter',function(){
                var postID = $(this).attr('id');
                like_post(postID);
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

            
            
        });
    </script>
</div>