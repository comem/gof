    @if (isset($authFailed) && $authFailed)
        <div class="error">
            Authentification error
        </div>
    @endif

        <div class="ok">
            <?php

//Hayoz Charly
//COMEM

 //return Redirect::intended('auth');
            if (Auth::check())
            {
            echo("<h1>welcome to the HEAVEN, vous pouvez désormais travaillé</h1> <h2> Votre utilisateur </h2>");
            echo (Auth::getUser());
            echo("<h2>Votre groupe</h2>");
            echo (Auth::getUser()->group);
            echo ("<h2>Vos accés (ACL)</h2>");
            echo (Auth::getUser()->group->resources);
            //dd('welcome to the HEAVEN, vous êtes désormais loggé :D en'+ Auth::getUser()->getAuthIdentifier());
            }
?>

        </div>

    <form action="{{ URL::action('AuthController@postCheck'); }}" method="post" id="form_login">
        <fieldset>
            <legend>Login</legend>
            <div class="field">
                <label for="email">email : </label>
                <input type="text" name="email" placeholder="email" autofocus required>
            </div>
            <div class="field">
                <label for="password">Password : </label>
                <input type="password" name="password" placeholder="********" required>
            </div>
        </fieldset>
        <input type="submit" value="Login">
    </form>
    <form action="{{ URL::action('AuthController@getLogout'); }}" method="get" id="form_logout">
       
        <input type="submit" value="Logout">
    </form>
