    @if (isset($authFailed) && $authFailed)
        <div class="error">
            Authentification error
        </div>
    @endif
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
