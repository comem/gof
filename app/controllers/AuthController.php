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
        // VÃ©rifie les "input", les acrÃ©ditations, et refuse les shadow accounts
        if (User::validate(Input::only('email', 'password')) !== true
               || !Auth::attempt(Input::only('email', 'password'))) {
            return Redirect::action('AuthController@getIndex')
                    ->with('error', true);
        }
        else
        {
            return Redirect::intended('index');
        }
    }

    public function getLogout()
    {
        Auth::logout();
        return Redirect::to('/');
    }


}
