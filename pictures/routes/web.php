<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    // return $router->app->version();
   return 'Wellcome to Pictures API <br> /pictures - List all pictures';
});

$router->get('/pictures[/{list}[/{page}[/{text}]]]', function ($list = 20, $page = 1 , $text = null) use ($router) {
    // return $router->app->version();

    $url_allPictures = "https://api.flickr.com/services/rest/?method=flickr.photos.getRecent&api_key=d556e7657e0c62bf5e26eadb44aaf0e6&per_page=".$list."&page=".$page."&text=".$text."&extras=description&privacy_filter=1&format=json&nojsoncallback=1";
    
    $result = json_decode(file_get_contents(
    $url_allPictures), true);

    $array = array();

    if($result){
        // return $result;
        foreach($result as $row){

            for($i = 0; $i < count($row['photo']); $i++){
                $url = "https://api.flickr.com/services/rest/?method=flickr.photos.getSizes&api_key=d556e7657e0c62bf5e26eadb44aaf0e6&photo_id=".$row['photo'][$i]['id']."&format=json&nojsoncallback=1";
                
                $result_picture = json_decode(file_get_contents(
                $url), true);

                $array['id'] = $row['photo'][$i]['id'];
                $array['title'] = $row['photo'][$i]['title'];
                $array['owner'] = $row['photo'][$i]['owner'];
                $array['description'] = $row['photo'][$i]['description']['_content'];
                $array['url'] = $result_picture['sizes']['size'][$i]['source'];
                $array['height'] = $result_picture['sizes']['size'][$i]['height'];
                $array['width'] = $result_picture['sizes']['size'][$i]['width'];

                // print_r($row['photo'][$i]) ;
                // print_r($result_picture['sizes']['size'][$i]);
                
            }
            print_r($array);
            return $array;
        }
        
    }
});

$router->get('/random', function () use ($router) {
    // return $router->app->version();

    $url_allPictures = "https://api.flickr.com/services/rest/?method=flickr.photos.getRecent&api_key=d556e7657e0c62bf5e26eadb44aaf0e6&per_page=1&page=".rand(1, 1000)."&extras=description&privacy_filter=1&format=json&nojsoncallback=1";
    
    $result = json_decode(file_get_contents(
    $url_allPictures), true);

    $array = array();

    if($result){
        // return $result;
        foreach($result as $row){
            for($i = 0; $i < count($row['photo']); $i++){
                $url = "https://api.flickr.com/services/rest/?method=flickr.photos.getSizes&api_key=d556e7657e0c62bf5e26eadb44aaf0e6&photo_id=".$row['photo'][$i]['id']."&format=json&nojsoncallback=1";
                $result_picture = json_decode(file_get_contents(
                $url), true);

                $array['id'] = $row['photo'][$i]['id'];
                $array['title'] = $row['photo'][$i]['title'];
                $array['owner'] = $row['photo'][$i]['owner'];
                $array['description'] = $row['photo'][$i]['description']['_content'];
                $array['url'] = $result_picture['sizes']['size'][$i]['source'];
                $array['height'] = $result_picture['sizes']['size'][$i]['height'];
                $array['width'] = $result_picture['sizes']['size'][$i]['width'];

                 print_r($row['photo'][$i]);
                // print_r($result_picture['sizes']['size'][$i]);
            }
            return $array;
        }
        
    }
});