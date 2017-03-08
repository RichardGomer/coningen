<!doctype html>
<html>
<head>
    <title>ConInGen</title>
    <link rel="stylesheet" href="/style.css" />

    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
</head>

<body>

<div id="page">
<h1>ConInGen</h1>

<?php

if(!array_key_exists('st', $_POST))
{
    require 'inc/input.php';
}
else
{
    require 'inc/instrument.php';
}



?>
</div>
</body>
</html>
