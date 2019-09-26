<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/app.css')}}">
    <title>@yield('title', "Wexo Photo Studio")</title>
</head>
<body>

@yield('content')

<script src="{{asset('/js/app.js')}}"></script>
</body>
</html>
