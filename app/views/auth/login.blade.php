
<html lang="fr">
    <head>
       <title>Login Event Manager</title>
       <meta charset="utf-8">
       
 

{{ HTML::style('css/style.css') }}
{{ HTML::script('js/jquery.js'); }}
{{ HTML::script('js/jquery-ui.js'); }}
{{ HTML::script('js/modernizr.js'); }}
{{ HTML::script('js/main.js'); }}

    </head>
    <body id="login">

        <div class="header">
            {{ HTML::image('img/mahogany.jpg', 'logoLogin') }}

        </div>
    
       <div class="formulaire">
            
            <form id ="login_form" action="{{ URL::action('AuthController@postCheck'); }}"  method="post" >
                <h1>Login</h1>
                <h2>to continue</h2>
                @if (isset($authFailed) && $authFailed)
 
            <h3>Authentification error</h3>

    @endif
                <div class="input">
                    <div class="blockinput">
                    <input type="text" name="email" placeholder="Username"> <br>
                     <input type="password" name="password"  placeholder="Password">
                    </div>
                    <div class="roundedTwo">
                        <input class="css-checkbox" type="checkbox" value="" id="remember" name="remember"/>
                        <label class="css-label"for="remember">Remember me</label>
                    <div/>
                </div>
                <button>Login</button>
            </form>

       </div>
    </body>
</html>
