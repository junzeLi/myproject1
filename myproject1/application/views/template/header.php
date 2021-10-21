<html>
  <head>
      <title>BLUE.</title>
      <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.css">
      <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css">
      <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/jquery.Jcrop.css">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fredoka+One">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
      <script type="module" src="https://unpkg.com/ionicons@5.4.0/dist/ionicons/ionicons.esm.js"></script>
      <script nomodule="" src="https://unpkg.com/ionicons@5.4.0/dist/ionicons/ionicons.js"></script>
      <script src="<?php echo base_url(); ?>assets/js/jquery-3.6.0.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
      <script src="<?php echo base_url(); ?>assets/js/jcrop/jquery.Jcrop.js"></script>
      <script src='https://www.google.com/recaptcha/api.js' async defer ></script>

      <meta http-equiv="refresh" content = "1800; url=<?php echo base_url(); ?>login/timeout">
  </head>
  <body>
    <nav class="navbar navbar-expand-md" id="main-nav">
        <div class="container">
          <a class="navbar-brand" href="<?php echo base_url(); ?>" >BLUE.</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="navbar-collapse d-xl-flex align-items-xl-end" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item d-xl-flex align-items-xl-end" >
                <a class="nav-link d-xl-flex align-items-xl-end" id="explore-page" href="<?php echo base_url(); ?>"> Explore </a>
              </li>
              <li class="nav-item d-xl-flex align-items-xl-end" >
                <a class="nav-link d-xl-flex align-items-xl-end" id="Following-page" href="#">Following</a>
              </li>
              <li class="nav-item d-xl-flex align-items-xl-end" >
                <a class="nav-link d-xl-flex align-items-xl-end" id="share-page" href="<?php echo base_url(); ?>upload">Share</a>
              </li>
            </ul>

            <form class="form-inline my-2 my-lg-0" id="search-bar">
              <?php echo form_open('ajax'); ?>
              <input class="form-control mr-sm-2 border rounded" id="search_text" type="search" placeholder="Search" name="search" aria-label="Search">
              <button class="btn btn-outline-success my-2 my-sm-0 collapsed" id="search-sumbit" type="button" data-toggle="collapse" data-target="#collapseSearch" aria-expanded="false" aria-controls="collapseSearch">
                <ion-icon name="search" class="if-collapsed"></ion-icon>
                <ion-icon name="chevron-up" class="if-not-collapsed"></ion-icon>
              </button>
              <?php echo form_close(); ?>
            </form>

            <ul class="navbar-nav my-lg-0 d-flex d-xl-flex flex-row align-items-xl-center">
              <?php if(!$this->session->userdata('logged_in')) : ?>
                <li class="log-user">
                  <a href="<?php echo base_url(); ?>login" class="btn btn-light action-button" role="button"> Login </a>
                </li>
              <?php endif; ?>
              <?php if($this->session->userdata('logged_in')) : ?>
                <a href="<?php echo base_url(); ?>profile" class="d-xl-flex align-items-xl-center header-username"><img class="rounded-circle header-profile profile-photo" style="background-image: url('<?php echo base_url()?><?php echo $this->session->userdata('profile_path') ?>')"> <?php echo $this->session->userdata('username') ?> </a>
                <li class="log-user d-xl-flex align-items-xl-center">
                  <a href="<?php echo base_url(); ?>login/logout" class="btn btn-light action-button" role="button"> Logout</a>
                </li>
              <?php endif; ?>
            </ul>

          </div>
        </div>
    </nav>

    <div class="search_result_auto">
      <div class="col-md-12 col-md-offset-6 centered" id="auto_result"> </div>
    </div>

    <div class="container">
      <div class="collapse" id="collapseSearch">
        <div class="card card-body" id="result">
        </div>
      </div>
    </div>
    <script>
    $(document).ready(function(){
      load_data();
      function load_data(query){
            $.ajax({
            url:"<?php echo base_url(); ?>ajax/fatch",
            method:"GET",
            data:{query:query},
            success:function(response){
                $('#auto_result').html("");
                if (response == "" ) {
                    $('#result').html(response);
                    $('#auto_result').html("");
                }else{
                    $('#auto_result').html("");
                    var obj = JSON.parse(response);
                    if(obj.length>0){
                        var items=[];
                        var descriptions=[];
                        $.each(obj, function(i,val){
                            items.push($('<p style="font-size:14px; color: #465765;">').text(val.description));
                            //descriptions.push($('<p style="font-size:14px; color: #465765;">').text(val.description));
                            descriptions.push($('<a href="' + '<?php echo base_url(); ?>content/load_content/' + val.id + '" style="font-size:14px; color: #465765;">'+'<p style="font-size:14px; color: #465765;">'+ val.description +'</p> </a>'));
                            
                            if (val.filename.includes("jpg") || val.filename.includes("png")) {
                                items.push($('<a href="' + '<?php echo base_url(); ?>content/load_content/' + val.id + '"> <img class="align-self-center m-auto mr-3 collected-content-preview" style="width:110px; height: 150px;" src= "' +'<?php echo base_url(); ?>uploads/' + val.filename + '" /> </a>'));
                                
                            }else{
                                items.push($('<video width="220" height="300" controls><source  src="' +'<?php echo base_url(); ?>/uploads/' +val.filename + '" type="video/mp4"></video>'));
                            }
                    });
                    $('#result').append.apply($('#result'), items); 
                    $('#auto_result').append.apply($('#auto_result'), descriptions);   
                    $('.search_result_auto').show();  
                    }else{
                    $('#result').html("Not Found!");
                    $('#auto_result').html("");
                    }; 
                };
            }
        });
      }
      $('#search_text').keyup(function(){
            var search = $(this).val();
            if(search != ''){
                load_data(search);
            }else{
                load_data();
                $('.search_result_auto').hide(); 
            }
        });

      });
    </script>

    <style>
      
    </style>



  




