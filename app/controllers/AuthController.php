<?php

class AuthController extends \BaseController {

    public function getIndex()
    {

        return View::make('auth/login', array(
            'authFailed' => Session::has('error')
        ));
    }

    public function postCheck()
    {
        // VÃ©rifie les "input" et les accréditations
        if (User::validate(Input::only('email', 'password')) !== true
               || !Auth::attempt(Input::only('email', 'password'))) {
            return Redirect::action('AuthController@getIndex')
                    ->with('error', true);
        }
        else
        {
            //return Redirect::intended('auth');
            echo("<h1>welcome to the HEAVEN, vous pouvez désormais travaillé</h1> <h2> Votre utilisateur </h2>");
            echo (Auth::getUser());
            echo("<h2>Votre groupe</h2>");
            echo (Auth::getUser()->group);
            echo ("<h2>Vos accés (ACL)</h2>");
            echo (Auth::getUser()->group->resources);
            //dd('welcome to the HEAVEN, vous êtes désormais loggé :D en'+ Auth::getUser()->getAuthIdentifier());
        }
    }

    public function getLogout()
    {
        Auth::logout();
        return Redirect::to('/');
    }


}
