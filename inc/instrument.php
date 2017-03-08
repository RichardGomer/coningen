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
        'Participant ID' => false,
    ));
}

$rubric = array_key_exists('rubric', $_POST);
$scoring = array_key_exists('scoring', $_POST);
$showinputs = array_key_exists('inputs', $_POST);

?>

<table class="meta">
    <?php
    foreach($meta as $k=>$v){

        // Meta data set to false is replaced by an input
        if($v === false && $showinputs){
            $n = preg_replace('/[^a-z0-9]/i', '', $k);
            $v = '<input type="text" name="txt_'.$n.'" id="txt_'.$n.'" />';
        }

        echo "<tr><td>$k</td><td>$v</td></tr>";
    }
    ?>
</table>

<?php

if($rubric)
{
    ?>

    <p class="rubric">
        The statements shown below explain things that could be done with the data that this service
        collects about you.  Some of the statements are true, some of them are false.<br /><br />
        For each statement, please indicate whether you <em>expect</em> the service will (or might) use your data
        in the way described, and whether you would be <em>happy</em> for it to do so.
    </p>

    <p class="rubric">
        Select one of the four options for each statement, that reflects both your <em>expectation</em> and
        <em>happiness</em>.  If you feel indifferent about a particular data use, please select "happy".
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

    if($showinputs)
    {
        $n = 'consentfulnessatom_'.$c;
        $in_happy_expect = "<input type=\"radio\" name=\"{$n}\" value=\"happy_expect\" />";
        $in_happy_notexpect = "<input type=\"radio\" name=\"{$n}\" value=\"happy_notexpect\" />";
        $in_nothappy_expect = "<input type=\"radio\" name=\"{$n}\" value=\"nothappy_expect\" />";
        $in_nothappy_notexpect = "<input type=\"radio\" name=\"{$n}\" value=\"nothappy_notexpect\" />";
    }
    else
    {
        $in_happy_expect = '';
        $in_happy_notexpect = '';
        $in_nothappy_expect = '';
        $in_nothappy_notexpect = '';
    }

    // Print the instrument atom
    echo <<<END
    <table class="instrumentatom">
    <tr class="statement"><td colspan="3"><span class="num">$c</span> $intro $st</td></tr>
    <tr><td></td><td class="expect">I expected this</td><td class="notexpect">I did <em>not</em> expect this</td></tr>
    <tr><td class="happy">I am happy for this to take place</td><td>$in_happy_expect</td><td>$in_happy_notexpect</td></tr>
    <tr><td class="nothappy">I am <em>not</em> happy for this to take place</td><td>$in_nothappy_expect</td><td>$in_nothappy_notexpect</td></tr>
    </table>\n\n
END;

    $c++;
}

/**
 * Show scoring chart
 */

if($scoring)
{

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

<?php

} // end scoring section

?>

</div>

<?php
if($showinputs)
{
?>

<div id="save">
    <button id="savebtn">Send Answers</button>
</div>

<script type="text/javascript">

$().ready(function(){

    $('#savebtn').click(function(){

        // Convert input values to attributes

        // input
        $('input').each(function(i, el){
            $(el).attr('value', $(el).val());
        });

        // textarea
        $('textarea').each(function(i, el){
            $(el).text($(el).val());
        });

        // checkbox/radio
        $('input[type="checkbox"],input[type="radio"]').each(function(i, el){

            if($(el).is(':checked'))
            {
                $(el).attr('checked', 'checked');
            }
            else
            {
                $(el).removeAttr('checked');
            }
        });

        // Convert DOM to HTML
        $('#save').remove();
        var html = "<html>\n" + $('html').html() + "\n</html>";

        console.log(html);

        // Send via formspree.io

        $.ajax({
            url: "save.php",
            method: "POST",
            data: {html: html},
            dataType: "json",
            success: function(){
                alert("Your response has been sent");
            }
        });

    })

});

<?php
}
?>

</script>
