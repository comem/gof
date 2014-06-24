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
               || !Auth::attempt(Input::only('email', 'password'),true)) {
            return Redirect::action('AuthController@getIndex')
                    ->with('error', true);
        }
        else
        {
            return Redirect::intended('/');
        }
    }

    public function getLogout()
    {
        Auth::logout();
        //return Redirect::to('/');
        echo("Logout ok, aurevoir");
    }


}
