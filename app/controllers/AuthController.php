<?php

class AuthController extends \BaseController {

    /**
     * Show the login page
     * @return View::Auth/Login The login page
     */
    public function getIndex()
    {

        if (Auth::check())
{
    // The user is logged in...
}
else
{
    return View::make('auth/login', array(
            'authFailed' => Session::has('error')
        ));
}
        
    }

    /**
     * Verify if the credentials are corrcet
     * @return View::Auth/Login The login page if the authentification is refused
     * @return View::Intended The page that the user want to see before the login
     */
    public function postCheck()
    {
        // VÃ©rifie les "input" et les accréditations
        if (User::validate(Input::only('email', 'password')) !== true
               || !Auth::attempt(Input::only('email', 'password'),false)) {

            return Redirect::action('AuthController@getIndex')
                    ->with('error', true);
        }
        else
        {

            return Redirect::intended('/');
        }
    }

    /**
     * Logout the user
     * @return View::Auth/Login The login page with a indication of the logout
     */
    public function getLogout()
    {
        Auth::logout();
        return Redirect::action('AuthController@getIndex')
                    ->with('Logout ok, aurevoir', true);

    }


}
