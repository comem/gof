<?php

class AuthController extends \BaseController {

    /**
     * Permet d'afficher la page de login
     * @return View::Auth/Login La page de login
     */
    public function getIndex()
    {

        return View::make('auth/login', array(
            'authFailed' => Session::has('error')
        ));
    }

    /**
     * Permet de vérifier si la tentative de login est correcte
     * @return View::Auth/Login La page de login avec une erreur si le login est refusé
     * @return View::Intended La page que l'utilisateur voulait accéder précedemment accéder
     */
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

    /**
     * Permet de se deconnecter
     * @return View::Auth/Login La page de login avec une indication comme quoi le logout c'est bien passé
     */
    public function getLogout()
    {
        Auth::logout();
        return Redirect::action('AuthController@getIndex')
                    ->with('Logout ok, aurevoir', true);

    }


}
