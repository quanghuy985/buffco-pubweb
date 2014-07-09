<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>{{Lang::get('emails.forgot_password_content')}}</h2>

        <div>
            {{Lang::get('emails.forgot_password_content')}} {{ URL::action('\BackEnd\LoginController@getChangePassword', array($token)) }}.
        </div>
    </body>
</html>