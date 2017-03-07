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

$rubric = array_key_exists('rubric', $_POST);

?>

<table class="meta">
    <?php
    foreach($meta as $k=>$v){
        echo "<tr><td>$k</td><td>$v</td></tr>";
    }
    ?>
</table>

<?php

if($rubric)
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

$rawstatements = explode("\n", $_POST['st']);
$intro = $_POST['intro'];

$signals = array();

foreach($rawstatements as $st)
{
    if(strlen(trim($st)) < 1)
        continue;

    if(strlen($intro) > 0)
        $st = lcfirst($st);

    // Get the signal identifier, if there is one
    if(preg_match('/^\((.+)\)(.+)/', $st, $matches))
    {
        $sigs = explode(',', $matches[1]);
        $st = trim($matches[2]);
    }
    else
    {
        $sigs = array(false);
    }

    // Store the statement itself
    $statements[$c] = $st;

    // Store the statement ID against the signals it relates to
    foreach($sigs as $sig)
    {
        if(!array_key_exists($sig, $signals))
        {
            $signals[$sig] = array();
        }

        $signals[$sig][] = $c;
    }

    // Print the instrument atom
    echo <<<END
    <table class="instrumentatom">
    <tr class="statement"><td colspan="3"><span class="num">$c</span> $intro $st</td></tr>
    <tr><td></td><td class="expect">I expected this</td><td class="notexpect">I did <em>not</em> expect this</td></tr>
    <tr><td class="happy">I am happy for this to take place</td><td></td><td></td></tr>
    <tr><td class="nothappy">I am <em>not</em> happy for this to take place</td><td></td><td></td></tr>
    </table>
END;

    $c++;
}

/**
 * Show scoring chart
 */
?>
<h2>Scoring</h2>

<?php if($rubric) { ?>
<p>Each atom is scored on two criteria: Expectation, based on the columns; and Voluntariness,
based on the rows.  It may pass or fail either, independently.</p>
<p>Use this table to score the overall instrument.  If a statement is failed (it was unexpected, or
involuntary) mark all boxes on that row. You may score for expectation, voluntariness or both.  If
scoring for both, mark statements that fail on <em>either</em> of the criteria.</p>

<p>In the failure row, mark the boxes if there are ANY failures in that column.</p>

<p>Let failed_signals = the number of failures in the last row</p>
<math display="block">
    <mi>consentfulness</mi> <mo>=</mo>
    <mn>1</mn> <mo>-</mo>
    <mfrac>
        <mi>failed_signals</mi>
        <mn><?php echo count($signals); ?></mn>
    </mfrac>
</math>
<?php }

echo '
<table class="score">
<tr><td></td>';
foreach($signals as $sig=>$stids)
{
    echo "<td>$sig</td>";
}
echo "</tr>\n";

foreach($statements as $sid=>$st)
{
    echo "<tr><td>$sid: $st</td>";

    // Show a scoring box against each relevant signal
    foreach($signals as $sig=>$stids)
    {
        if(in_array($sid, $stids))
        {
            echo "<td class=\"scorebox\"></td>";
        }
        else
        {
            echo "<td class=\"ignorebox\"></td>";
        }
    }

    echo "</tr>\n";
}

echo '<tr><td>FAIL</td>';
foreach($signals as $sig=>$stids)
{
    echo "<td class=\"totbox\"></td>";
}
echo "</tr>\n</table>\n";

?>

<div id="results">
</div>

</div>
