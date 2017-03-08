<?php

if(!file_exists('saved'))
{
    mkdir('saved');
    file_put_contents(' ', 'saved/index.html');
}

$id = uniqid(date('Y-m-d_h_i_')).'.html';

$url = 'http://'.$_SERVER['SERVER_NAME'].'/saved/'.$id;

if(file_put_contents('saved/'.$id, $_POST['html']))
    echo "{status: \"ok\", href: \"$url\"}";
else
    echo "{status: \"failed\"}";

?>
