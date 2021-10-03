<div class="d-flex flex-column  upload_form">
    <h3>Upload</h3>
    <?php echo form_open_multipart('upload/do_upload');?>
        <div class="d-flex flex-row align-items-center upload_box">
            <p>Select file to upload: </p>
                <div class="form-group">
                    <input type="file" name="userfile" size="20" class="choose_file_button"/> 
                </div>
        </div>
        <div class="upload-error">
            <?php echo $error;?>
        </div>  
        <div class="upload-info-box">
            <div class="form-group">
                <input class="form-control upload-description" type="text" placeholder="Description" name="post-description">
            </div>
        </div>  
        <div class="tag-options">
            <p> Choose at most 3 tags for your post and get more people to see it! </p>
            <input type="checkbox" class="tag_box" name="tag[]" id="BEAUTY" value="BEAUTY"><label for="BEAUTY">BEAUTY</label>
            <input type="checkbox" class="tag_box" name="tag[]" id="TRAVEL" value="TRAVEL"><label for="TRAVEL">TRAVEL</label>
            <input type="checkbox" class="tag_box" name="tag[]" id="FOOD" value="FOOD"><label for="FOOD">FOOD</label>
            <input type="checkbox" class="tag_box" name="tag[]" id="FASHION" value="FASHION"><label for="FASHION">FASHION</label>
            <input type="checkbox" class="tag_box" name="tag[]" id="VLOG" value="VLOG"><label for="VLOG">VLOG</label>
            <input type="checkbox" class="tag_box" name="tag[]" id="GAME" value="GAME"><label for="GAME">GAME</label>
            <input type="checkbox" class="tag_box" name="tag[]" id="DANCE" value="DANCE"><label for="DANCE">DANCE</label>
            <input type="checkbox" class="tag_box" name="tag[]" id="MUSIC" value="MUSIC"><label for="MUSIC">MUSIC</label>
            <input type="checkbox" class="tag_box" name="tag[]" id="MOVIE" value="MOVIE"><label for="MOVIE">MOVIE</label>
            <input type="checkbox" class="tag_box" name="tag[]" id="SPORT" value="SPORT"><label for="SPORT">SPORT</label>
            <input type="checkbox" class="tag_box" name="tag[]" id="PLOG" value="PLOG"><label for="PLOG">PLOG</label>
            <input type="checkbox" class="tag_box" name="tag[]" id="PETS" value="PETS"><label for="PETS">PETS</label>
            
            
            <script type="text/javascript">
            // The code was found from the website: https://blog.csdn.net/gongqinglin/article/details/50463719 
            // However, the given code is wrong and not working, I investigated the code and fixed the bug
            // The following code is working, it limits the number of tags user can choose
            $(function(){
                var num=0;
                $(":checkbox").each(function() {
                    $(this).click(function(){
                        if($(this)[0].checked) {
                            ++num;
                            if(num == 3) {
                                $(":checkbox").each(function(){
                                    if(!$(this)[0].checked) {
                                        $(this).attr("disabled", "disabled");
                                    }
                                });
                            }
                        } else {
                            --num;
                            if(num <= 2) {
                                $(":checkbox").each(function(){
                                        $(this).removeAttr("disabled");
                                    
                                });
                            }
                        }
                    });
                });
            })
            </script>
        </div>  


        <div class="d-xl-flex justify-content-xl-end align-items-xl-center form-group">
            <input type="submit" value="upload" class="upload-file"/>
        </div>
            
        
    <?php echo form_close(); ?>

</div>