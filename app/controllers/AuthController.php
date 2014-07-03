<?php

class AuthController extends \BaseController {

    /**
     * Show the login page
     * @return View::Auth/Login The login page
     */
    public function getIndex() {

        if (Auth::check()) {
            return View::make('app/app');
        } else {
            return View::make('auth/login', array(
                        'authFailed' => Session::has('error'),
                        'logout' => Session::has('logout')
            ));
        }
    }

    /**
     * Verify if the credentials are corrcet
     * @return View::Auth/Login The login page if the authentification is refused
     * @return View::Intended The page that the user want to see before the login
     */
    public function postCheck() {
        $remember = Input::get('remember');
        if(isset($remember)) {
            $bool = true;
        } else {
            $bool = false;
        }
        // VÃ©rifie les "input" et les accréditations
        if (User::validate(Input::only('email', 'password')) !== true || !Auth::attempt(Input::only('email', 'password'), $bool)) {

            return Redirect::action('AuthController@getIndex')
                            ->with('error', true);
        } else {
            return View::make('app/app');
            //return Redirect::intended('/');
        }
    }

    /**
     * Logout the user
     * @return View::Auth/Login The login page with a indication of the logout
     */
    public function getLogout() {

        Auth::logout();
        return Redirect::action('AuthController@getIndex')
                        ->with('logout', true);
    }

}
