<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Page</title>
</head>
<body>
    <a href="https://api.instagram.com/oauth/authorize?client_id={{ env('INSTAGRAM_APP_ID') }}&redirect_uri={{ route('auth.success') }}&scope=user_profile,&response_type=code">Login To Instagram</a>
</body>
</html>