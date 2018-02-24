<?php



if(isset($_GET['location']))
{
    $url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.$_GET['location'].'&key=AIzaSyAJxw3_45jPw0IwpaWQjAnJ78N5q-faXTI';
    $jsonCode =file_get_contents($url);
    $arr =  json_decode($jsonCode,true);
   // echo $arr['results'][0]['geometry']['location']['lat'];
    $latitude =$arr['results'][0]['geometry']['location']['lat'];
    $longitude =$arr['results'][0]['geometry']['location']['lng'];

    $urlForTimeZone ='https://maps.googleapis.com/maps/api/timezone/json?location='.$latitude.','.$longitude.'&timestamp=1331161200&key=AIzaSyDmOIOmedFFCo9rFG-a8EYt-wrgm6EWkjg';
    $jsonCodeTimeZone =file_get_contents($urlForTimeZone);
    $arr2 =  json_decode($jsonCodeTimeZone,true);
   $timeZoneId = $arr2['timeZoneId'];
   $timeZoneName=$arr2['timeZoneName'];


   $weather = 'https://api.weatherbit.io/v2.0/current?city=Raleigh,NC&lat='.$latitude.'&lon='. $longitude.'&key=c5c46c17d708445399f022a28271008a';
    $weatherData =file_get_contents($weather);
    $weatherArr=json_decode($weatherData,true);


    /* flickr api*/
    $flickrURL='https://api.flickr.com/services/feeds/photos_public.gne?format=php_serial&tags='.$_GET['location'];

    $data = unserialize(file_get_contents($flickrURL));
    global $photos;
    $photos = $data['items'];


}





?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>api app</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="js/jquery-min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>
<body>
<section class="search">
    <h1 class="text-center">know more !!!</h1>
    <!-- start  form-->
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <form action="" method="get">
                    <div class="form-group">

                        <input type="text" class="form-control" id="place" name="location" placeholder="know more about....">
                    </div>

                    <button type="submit"  class="btn btn-success btn-block">Submit</button>
                </form>
            </div>
        </div>
    </div>
</section>


<!-- end form -->

<!--start basic information-->
<section class="general-info">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="list-group">
                    <a href="#" class="list-group-item active">General informations</a>
                    <a href="#" class="list-group-item ">formatted address :   <?php if(!empty($arr['results'][0]['formatted_address'])){ echo  $arr['results'][0]['formatted_address'] ;  }  ?></a>
                    <a href="#" class="list-group-item ">long name : <?php        if(!empty($arr['results'][0]['address_components'][0]['long_name'] )){ echo  $arr['results'][0]['address_components'][0]['long_name'] ;  } ?></a>
                    <a href="#" class="list-group-item">latitude : <?php      if(!empty($arr['results'][0]['geometry']['location']['lat'] )){ echo  $arr['results'][0]['geometry']['location']['lat'] ;  }   ?></a>
                    <a href="#" class="list-group-item">longitude : <?php     if(!empty($arr['results'][0]['geometry']['location']['lng'])){ echo $arr['results'][0]['geometry']['location']['lng'];  }    ?></a>
                    <a href="#" class="list-group-item">time now : <?php  if(!empty( $weatherArr['data'][0]['ob_time'])){ echo $weatherArr['data'][0]['ob_time'];}  ?> </a>
                </div>


            </div>
        </div>
    </div>
</section>


<!-- end basic information-->

<!-- start time now in searched place -->

<section class="time">
    <div class="container">
        <div class="row">
            <h3 class="text-center"></h3>
            <div class="col-lg-12">


                <div class="list-group">
                    <li class="list-group-item active">time zone inforamtion </li>
                    <li class="list-group-item"><?php if(!empty($timeZoneId)){echo $timeZoneId ;} ?></li>
                    <li class="list-group-item"><?php  if(!empty($timeZoneName)){echo $timeZoneName;}?></li>
                </div>

            </div>
        </div>
    </div>



</section>

<section class="weather_data">

    <div class="container">
        <h1 class="text-center">weather</h1>
        <div class="row">
            <div class="col">
                <div class="weather-card one">
                    <div class="top">
                        <div class="wrapper">
                            <div class="mynav">

                            </div>
                            <h1 class="heading"> <?php if(!empty($weatherArr['data'][0]['weather']['description'] )){ echo $weatherArr['data'][0]['weather']['description'];} ?></h1>
                            <h3 class="location"><?php if(!empty( $arr['results'][0]['address_components'][0]['long_name'] )){echo  $arr['results'][0]['address_components'][0]['long_name'] ;}  ?></h3>
                            <p class="temp">
                                <span class="temp-value"><?php if(!empty($weatherArr['data'][0]['app_temp'] )){echo $weatherArr['data'][0]['app_temp'];}  ?></span>
                                <span class="deg">0</span>
                                <a href="javascript:;"><span class="temp-type">C</span></a>
                            </p>
                        </div>
                    </div>
                    <div class="bottom">
                        <div class="wrapper">

                        </div>
                    </div>
                </div>
            </div>

</section>

<!-- end time now searche place -->
<!-- start images section -->
<section class="images">
    <div class="container">
    <h1 class="text-center">random images from  <?php $_GET['location'] ?></h1>

    <div class="alert alert-danger">
        <h6 class="text-center ">*this images is a result of random query from flickr website we are not in charge of images content as it may contain Inappropriate content * </h6>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <?php
                foreach ( $photos as $photo)
                {
                    if(!empty($photo['photo_url']))
                    {
                        echo '<div class="image-holder">';
                        echo '<img class="img-responsive" width="90%" src="'.$photo['photo_url'].'">';
                        echo '</div>';
                    }

                }
                ?>
            </div>
        </div>
    </div>
    </div>
    <!-- end  images section -->
</section>



</body>
</html>

