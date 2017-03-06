<html>
<head>
    <title>ConInGen</title>
    <link rel="stylesheet" href="style.css" />
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
