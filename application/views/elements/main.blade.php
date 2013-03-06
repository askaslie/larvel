<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <meta name="author" content="Си-Норд">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"><!-- For mobile devises -->
    <title>Тест</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/bootstrap-responsive.css">
    <link rel="stylesheet" href="../css/kengry.css">
    <script src="../js/jquery.js"></script>

</head>

<body>
<div class="container">

    <div class="navbar navbar-inverse">
        <div class="navbar-inner">
            <div class="container">
                <ul class="nav">
                    <li><a href="/main">Тест</a></li>
                    <li><a href="/projects">Города</a></li>
                    <li><a href="/logout">Выход</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            @yield('content')
        </div>
    </div>
</body>
</html>




