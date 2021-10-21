<div class="container " id="profile-page">
    <div class="d-flex flex-row justify-content-between profile-header">
        <div class="d-flex d-xl-flex flex-row justify-content-xl-start align-items-xl-end profile-userinfo"> 
            <h2 class="d-xl-flex align-items-xl-end profile-username"><img class="rounded-circle profile-photo" style="background-image: url('<?php echo base_url()?><?php echo $this->session->userdata('profile_path') ?>')"><?php echo $this->session->userdata('username') ?></h2>
            
            <?php if(!$this->session->userdata('email_verified')) : ?> 
                <p class="email-verification d-xl-flex align-items-xl-end">Email Unverified <ion-icon name="close-circle"></ion-icon></p>
            <?php endif; ?>
            <?php if($this->session->userdata('email_verified')) : ?>
                <p class="email-verification d-xl-flex align-items-xl-end">Email Verified <ion-icon name="checkmark-circle"></ion-icon></p>
            <?php endif; ?>

            <a class="btn btn-primary d-xl-flex justify-content-xl-center align-items-xl-center edit-profile-btn" type="button" href="<?php echo base_url(); ?>profile/edit_profile">Edit Profile</a>
            <a class="btn btn-primary d-xl-flex justify-content-xl-center align-items-xl-center upgrade-btn" type="button" href="#"> <ion-icon name="ribbon-outline"></ion-icon>Upgrade to Premium</a>
        </div>
        <div class="d-flex flex-row align-items-xl-end follow-info"">
            <a href="#" class="d-flex d-xl-flex flex-column align-items-center align-items-xl-center following-counts" >
                <p class="following-num"><?php echo $following?></p>
                <p class="follow-info-text">Following</p>
            </a>
            <a href="#" class="d-flex d-xl-flex flex-column align-items-center align-items-xl-center follower-counts">
                <p class="follower-num"><?php echo $follower?></p>
                <p class="follow-info-text">Followers</p>
            </a>
        </div>
    </div>
    <div style="border-radius: 13px;">
        <ul class="nav nav-tabs mr-auto profile-nav"> 
            <li class="nav-item profile-nav-item ">
                <p class="nav-link d-xl-flex align-items-xl-end profile-nav-link active" id="profile_nav_link_post" >Posts</p>
            </li>
            <li class="nav-item profile-nav-item ">
                <p class="nav-link d-xl-flex align-items-xl-end profile-nav-link" id="profile_nav_link_collect" >Collects</p>
            </li>
            <li class="nav-item profile-nav-item ">
                <p class="nav-link d-xl-flex align-items-xl-end profile-nav-link" id="profile_nav_link_like" >Liked</p>
            </li>
        </ul>

        <div class="d-xl-flex justify-content-xl-center">
            <div class="d-flex flex-row justify-content-start flex-wrap justify-content-xl-start profile-collects" id="user_post_page"> 
                <?php foreach($user_post as $post): ?>
                    <div class="collected-content" id="<?php echo $post["id"] ?>"> 
                        <div class="media d-flex d-xl-flex flex-column justify-content-center align-items-center align-content-center justify-content-xl-center align-items-xl-center">
                            <a href="<?php echo base_url(); ?>content/load_content/<?php echo $post["id"] ?>"> <img class="align-self-center m-auto mr-3 collected-content-preview" src= "<?php echo base_url(); ?>uploads/<?php echo $post["filename"] ?>" /> </a>
                            <div class="media-body"> 
                                <div class="d-flex d-xl-flex flex-row justify-content-between align-items-xl-center">
                                    <p class="collected-date" id="posted-date">Posted at: <?php echo date('Y-m-d', $post["upload_time"]) ?></p>
                                    <button class="btn btn-primary btn-lg remove_post" data-toggle="modal" data-target="#myModal"><ion-icon name="trash-outline" ></ion-icon></button>
                                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myModalLabel">Deleting Post</h4>
                                                    <button type="button" class="close cancel_delete" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                </div>
                                                <div class="modal-body">Are you sure you want to delete the post? This action cannot be reversed.</div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default cancel_delete" data-dismiss="modal">Cancel</button>
                                                    <button type="button" class="btn btn-primary delete_confirm" >Delete</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>


            <div class=" flex-row justify-content-start flex-wrap justify-content-xl-start profile-collects" id="user_collected_page" style="display: none;"> 
                <div class="collected-content"> 
                    <div class="media d-flex d-xl-flex flex-column justify-content-center align-items-center align-content-center justify-content-xl-center align-items-xl-center">
                        <a href="<?php echo base_url(); ?>content/load_content/<?php echo $post["id"] ?>"> <img class="align-self-center m-auto mr-3 collected-content-preview"> </a>
                        <div class="media-body"> 
                            <h5 class="d-xl-flex align-items-xl-center collected-content-user"><img class="rounded-circle collected-content-profile profile-photo">User Name</h5>
                            <div class="d-flex d-xl-flex flex-row justify-content-between align-items-xl-center">
                                <p class=collected-date >Collected: date</p>
                                <button class="btn btn-primary d-xl-flex justify-content-xl-center align-items-xl-center collected-more" type="button"><ion-icon name="ellipsis-vertical"></ion-icon></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class=" flex-row justify-content-start flex-wrap justify-content-xl-start profile-collects" id="user_liked_page" style="display: none;"> 
                <?php foreach($user_liked as $liked_post): ?>

                    <div class="collected-content"> 
                        <div class="media d-flex d-xl-flex flex-column justify-content-center align-items-center align-content-center justify-content-xl-center align-items-xl-center">
                            <a href="<?php echo base_url(); ?>content/load_content/<?php echo $liked_post["file_id"] ?>"> <img class="align-self-center m-auto mr-3 collected-content-preview" src= "<?php echo base_url(); ?>uploads/<?php echo $liked_post["filename"] ?>" /> </a>
                            <div class="media-body"> 
                                <div class="d-flex d-xl-flex flex-row justify-content-between align-items-xl-center">
                                    <h5 class="d-xl-flex align-items-xl-center collected-content-user"><?php echo $liked_post["username"] ?></h5>
                                    <button class="btn btn-primary d-xl-flex justify-content-xl-center align-items-xl-center collected-more" type="button"><ion-icon name="ellipsis-vertical"></ion-icon></button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>



            </div>

            <script> 
            
            $(document).ready(function() {

                //mark delete posted 
                $(".remove_post").click(function() {
                    $(this).parent().parent().parent().parent().addClass("to_delete");
                })

                //delete post
                $(".delete_confirm").click(function() {
                    var postID = document.getElementsByClassName("to_delete")[0].id;
                    $.ajax({
                        url:"<?php echo base_url(); ?>upload/delete",
                        method:"GET",
                        data:{postID:postID},
                        success:function(response) {
                            $(".modal").modal('hide');
                            document.getElementsByClassName("to_delete")[0].style.display='none';
                        }
                    });
                });

                //cancel delete
                $(".cancel_delete").click(function() {
                    document.getElementsByClassName("to_delete")[0].classList.remove("to_delete");
                })





                // display different pages 
                $(".profile-nav-link").click(function () {
                    $(".profile-nav-link").removeClass("active");
                    $(this).addClass("active");   
                    if ($("#profile_nav_link_post").hasClass("active")) {
                        $("#user_liked_page").removeClass("d-flex");
                        $("#user_liked_page").hide();
                        $("#user_collected_page").removeClass("d-flex");
                        $("#user_collected_page").hide();
                        $("#user_post_page").addClass("d-flex");
                        $("#user_post_page").show();
                    } 
                

                    if ($("#profile_nav_link_collect").hasClass("active")) {
                        $("#user_liked_page").removeClass("d-flex");
                        $("#user_liked_page").hide();
                        $("#user_collected_page").addClass("d-flex");
                        $("#user_collected_page").show();
                        $("#user_post_page").removeClass("d-flex");
                        $("#user_post_page").hide();
                    } 

                    if ($("#profile_nav_link_like").hasClass("active")) {
                        $("#user_liked_page").addClass("d-flex");
                        $("#user_liked_page").show();
                        $("#user_collected_page").removeClass("d-flex");
                        $("#user_collected_page").hide();
                        $("#user_post_page").removeClass("d-flex");
                        $("#user_post_page").hide();
                    } 
                });


                    
                });
            </script>
        </div>
        


    </div>

</div>
