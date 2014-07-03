<?php

namespace api\v1;

use \FacebookConnect;

/**
 * Facebook controller
 * 
 *
 * @category  Application services
 * @version   1.0
 * @author    gof
 */
class FacebookController extends \BaseController {
    

    /**
     * Allows to post a Night on Facebook.
     */
    public static function search() {


        // Use a single object of a class throughout the lifetime of an application.
        $application = array(
            'appId' => '633123843450489',
            'secret' => '91a52c205a79953f5e610e49aa43abcb'
        );

        $permissions = 'publish_stream';
        $url_app = 'http://pingouin.heig-vd.ch/gof';

// getInstance
        FacebookConnect::getFacebook($application);


        $getUser = FacebookConnect::getUser($permissions, $url_app); // Return facebook User data

        var_dump($getUser);


// post to wall facebook.
        $message = array(
            'link' => 'http://pingouin.heig-vd.ch/gof',
            'message' => 'test message',
            'picture' => 'http://laravel-test.local/test.gif',
            'name' => 'test Title',
            'description' => 'test description',
            'access_token' => $getUser['access_token'] // form FacebookConnect::getUser();
        );

        FacebookConnect::postToFacebook($message, 'feed'); // return feed id 1330355140_102030093014XXXXX
    }

}
