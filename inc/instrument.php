<div class="instrument">
<?php

echo "<h2>".$_POST['title']."</h2>\n";

$meta = array(
        'title' => $_POST['title'],
        'generated' => date('Y-m-d H:i:s'),
);

if(array_key_exists('extmeta', $_POST))
{
    $meta = array_merge($meta, array(
        'Administered at' => '',
        'Administered by' => '',
        'Recording Device' => '',
        'Participant ID' => '',
    ));
}

?>

<table class="meta">
    <?php
    foreach($meta as $k=>$v){
        echo "<tr><td>$k</td><td>$v</td></tr>";
    }
    ?>
</table>

<?php

if(array_key_exists('rubric', $_POST))
{
    ?>

    <p class="rubric">
        I'm going to read you some statements now.  The statements explain things that could be done with the data that this service
        collects about you.  Some of the statements are true, some of them are false.<br /><br />
        For each statement, I'll ask you to tell me whether you <em>expect</em> the service will (or might) use your data in that way, and
        whether you would be <em>happy</em> for it to do so.
    </p>

    <p class="rubric">
        (example)<br /><br />
        <em>read statement</em><br />
        Would you expect the service to do that?<br />
        And if the service did that, would you be happy or unhappy?
    </p>

    <?php
}

?>

<?php

$c = 1;

$st = explode("\n", $_POST['st']);
$intro = $_POST['intro'];
foreach($st as $statement)
{
    if(strlen(trim($statement)) < 1)
        continue;

    if(strlen($intro) > 0)
        $statement = lcfirst($statement);

    echo <<<END
    <table class="instrumentatom">
    <tr class="statement"><td colspan="3"><span class="num">$c</span> $intro $statement</td></tr>
    <tr><td></td><td class="expect">I expected this</td><td class="notexpect">I did <em>not</em> expect this</td></tr>
    <tr><td class="happy">I am happy for this to take place</td><td></td><td></td></tr>
    <tr><td class="nothappy">I am <em>not</em> happy for this to take place</td><td></td><td></td></tr>
    </table>
END;

    $c++;
}

?>
</div>
