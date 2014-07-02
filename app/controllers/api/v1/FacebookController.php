<?php

namespace api\v1;

use FacebookConnect;

class FacebookController extends \BaseController {

    public static function goFb() {


        // Use a single object of a class throughout the lifetime of an application.
        $application = array(
            'appId' => 'test',
            'secret' => 'YOUR_APP_SECRET'
        );
        $permissions = 'publish_stream';
        $url_app = 'http://laravel-test.local/';

// getInstance
        FacebookConnect::getFacebook($application);


        $getUser = FacebookConnect::getUser($permissions, $url_app); // Return facebook User data

        var_dump($getUser);


// post to wall facebook.
        $message = array(
            'link' => 'http://laravel-test.local/',
            'message' => 'test message',
            'picture' => 'http://laravel-test.local/test.gif',
            'name' => 'test Title',
            'description' => 'test description',
            'access_token' => $getUser['access_token'] // form FacebookConnect::getUser();
        );

        FacebookConnect::postToFacebook($message, 'feed'); // return feed id 1330355140_102030093014XXXXX
    }

}
