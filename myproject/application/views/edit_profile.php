<div class="d-flex flex-column  upload_form">
    <?php echo form_open_multipart();?>
        <div class="d-flex d-xl-flex flex-column justify-content-xl-center align-items-xl-center upload_box">
            
            <div class="d-flex d-xl-flex flex-column justify-content-xl-center align-items-xl-center">
                <h2><?php echo $this->session->userdata('username') ?></h2>
                <img class="rounded-circle profile-photo" id="current_profile" style="background-image: url('<?php echo base_url()?><?php echo $this->session->userdata('profile_path') ?>')">
                <div class="form-group d-xl-flex justify-content-xl-center align-items-xl-center update_profile">
                    <p>Update profile photo: </p> 
                    <input class="justify-content-xl-center align-items-xl-center" type="file" name="profilePhoto"  id="profile_upload" class="choose_file_button" style="width: 200px;"/> 
                </div>
            </div>
            <div class="upload-error">
            </div>  
        </div>

        <div class='previewHolder' style="display: none">
        <div class="previewWrapper d-flex d-xl-flex flex-column justify-content-xl-center align-items-xl-center" id="previewWrapper">
            <div id="previewBox"></div>
            <form action="" method="post"> 
                <input type="hidden" id="x" name="x" />
                <input type="hidden" id="y" name="y" />
                <input type="hidden" id="w" name="w" />
                <input type="hidden" id="h" name="h" />
                <input type="hidden" id="img_url" name="src">
                <p class="crop-tip">Please select the area you want to use</p>
                <div class="previewBtn d-xl-flex justify-content-xl-end align-items-xl-center">
                <a href="javascript:;" id="confirm" class="upload-file">Upload</a>
                </div>
            </form>
                
        </div>  
        </div>

        <div class="d-flex d-xl-flex flex-column justify-content-xl-center align-items-xl-center">
            <a href="<?php echo base_url(); ?>login/reset" class="btn btn-light action-button" role="button"> Reset Password </a>
        </div>

        <?php echo form_open(base_url().'profile/change_email'); ?>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="New Email Address" name="new_email">
            </div>
            <div class="form-group d-flex d-xl-flex flex-column justify-content-xl-center align-items-xl-center">
                <button type="submit" class="btn btn-primary btn-block" id="reset_username_submit">Submit</button>
            </div>
        <?php echo form_close(); ?>
        
        <script> 
        $(document).ready(function() {
            $('#profile_upload').change(function(e){
                var file = this.files[0];
                var form = new FormData();
                form.append('profilePhoto', file);
                $.ajax({
                url:"<?php echo base_url(); ?>Profile/upload_profile_photo",
                method:"POST",
                data:form,
                cache: false,
                contentType: false,
                processData: false,
                success:function(response) {
                    if (response != "") {
                        var profile_path = JSON.parse(response);
                        if (profile_path['error'] != '') {
                            var error = $('<p>' + profile_path['error'] + '</p>');
                            $('.upload-error').html(error);
                        } else {
                            var error = $('<p>' + profile_path['error'] + '</p>');
                            var imageUrl = '<?php echo base_url(); ?>uploads/' + profile_path['profile_path'];
                            $('.upload-error').html(error);
                            $('.previewHolder').show();
                            $('#previewWrapper').show();
                            var $image = $("<img />");
                            var previewBox = $("#previewBox");
                            previewBox.append( $image );
                            previewBox.children('img').attr('src', imageUrl +'?t='+ Math.random());
                            $("#img_url").val(imageUrl);
                            $image.attr('id', 'previewImg');
                            var $previewImg = $("#previewImg");
                            var img = new Image();
                            img.src = imageUrl +'?t='+ Math.random();

                            /* code modified from https://blog.csdn.net/dengqiu9793/article/details/101475042 */
                            img.onload = function() {
                                var img_width = 0,
                                    img_height = 0,
                                    real_width = img.width,
                                    real_height = img.height;
                                if (real_width > real_height && real_width > 400) {
                                    var ratio = real_width / 400;
                                    real_width = 400;
                                    real_height = real_height / ratio;
                                }else if(real_height > real_width && real_height > 400) {
                                    var ratio = real_height / 400;
                                    real_height = 400;
                                    real_width = real_width /ratio;
                                }
                                if(real_height < 400) {
                                    img_height = (400 - real_height)/2;
                                }
                                if (real_width < 400) {
                                    img_width = (400- real_width)/2;
                                }
                                previewBox.css({
                                    width: (400 - img_width) + 'px', 
                                    height: (400 - img_height) + 'px',
                                    paddingTop: (400 - real_height)/2
                                });
                            }

                            $("#previewImg").Jcrop({
                                bgFade : false,
                                aspectRatio : 1,
                                minSize : [10, 10],
                                boxWidth : 400,
                                boxHeight : 400,
                                allowSelect: true, 
                                allowResize: true, 
                                allowMove:true,
                                trackDocument:true,
                                
                                baseClass:'jcrop',
                                addClass:null,
                                bgColor:'black',
                                bgOpacity: 0.6,
                                borderOpacity: 0.4,
                                handleOpacity: 0.5,
                                handleSize:null,
                                keySupport:true,
                                createHandles: ['n','s','e','w','nw','ne','se','sw'],
                                createDragbars: ['n','s','e','w'],
                                createBorders: ['n','s','e','w'],
                                drawBorders:true,
                                dragEdges:true,
                                fixedSupport:true,
                                touchSupport:null,
                                shade:null,

                                fadeTime: 400,
                                animationDelay: 20,
                                swingSpeed: 3,

                                onChange : showPreview, 
                                onSelect: showPreview,  
                                setSelect : [0, 0, 120, 120]
                            });

                            var CutJson = {};

                            function showPreview(coords) {
                                var img_width = $("#previewImg").width();
                                var img_height = $("#previewImg").height();
                                var img_url = $("#img_url").val();
                                CutJson = {
                                    'path': img_url,
                                    'x': Math.floor(coords.x),
                                    'y': Math.floor(coords.y),
                                    'w': Math.floor(coords.w),
                                    'h': Math.floor(coords.h)
                                };
                                console.log(CutJson);
                            }

                            $("#confirm").click(function() {
                                $path = './uploads/' + profile_path['profile_path'];
                        　　　　　$.ajax({
                        　　　　　　url:"<?php echo base_url(); ?>crop/crop_and_save",
                                  method: "POST",
                        　　　　　　data:{crop:CutJson, url:$path},
                        　　　　　　success:function(response) {
                                    var error = $('<p> Upload Success! Refresh the page to see your new profile photo!</p>');
                                    $('.upload-error').html(error);
                                    $('.previewHolder').hide();
                        　　　　　　　　}
                        　　　　　});
                        　　})
                        }   
                    }
                }
                });
            });
        })
    
        </script>

        
        
        
    <?php echo form_close(); ?>

</div>