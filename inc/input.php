<p>Enter statements, one per line</p>

<form action="" method="POST">
    <label>Service/Interaction Name</label>
    <input type="text" name="title" id="title" />

    <label>Enter purpose statements, one per line</label>
    <textarea name="st" id="st"></textarea>

    <label>Statement introduction phrase</label>
    <input type="text" name="intro" id="intro" value="The service will" />

    <label>Include extended meta-section (for printing interview protocol etc.)</label>
    <input type="checkbox" value="1" name="extmeta" id="extmeta" checked="checked" />

    <label>Include standard rubrics</label>
    <input type="checkbox" value="1" name="rubric" id="rubric" checked="checked" />

    <hr />
    <input type="submit" value="Generate" />
</form>
