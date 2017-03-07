<p>Enter statements, one per line</p>

<form action="" method="POST">
    <label>Service/Interaction Name</label>
    <input type="text" name="title" id="title" />

    <label>Enter purpose statements, one per line. Optionally, provide consent signal IDs in brackets first, separated by commas<br />
    eg: &nbsp; <tt>(A,D) send you emails about new products that you might be interested in</tt></label>
    <textarea name="st" id="st"></textarea>

    <label>Statement introduction phrase</label>
    <input type="text" name="intro" id="intro" value="The service will" />

    <label>Include extended meta-section (for printing interview protocol etc.)</label>
    <input type="checkbox" value="1" name="extmeta" id="extmeta" checked="checked" />

    <label>Include standard rubrics and instructions</label>
    <input type="checkbox" value="1" name="rubric" id="rubric" checked="checked" />

    <hr />
    <input type="submit" value="Generate" />
</form>

<h2>Instructions</h2>

<p>This tool generates a consentfulness scoring instrument that can be used to assess the consentfulness of a given service-interaction
pair.  By service, we mean a set of data processes that are contingent on <em>consent signals</em> that received from the data subject
via a <em>consent interaction</em>.  A consent interaction could be, for instance, an online form, or a face-to-face conversation.</p>

<p>Each process is described by one or more <em>purpose statements</em>.  These statements should (taken together) describe  all the reasons
that the data is being processed, and any data derived from that processing.  For instance "use data about your location to identify your
home city" or "use data about your location to choose which advertisements you are shown."</p>

<p>These statements should be entered into the form above, along with the ID of the consent signal that they relate to.  For instance, if
signal 'A' nominally gives consent to email marketing, enter "(A) send you emails about relevant offers from our company".  If a statement
applies to multiple signals (for instance there are multiple consent signals that nominally give consent to a particular process) then enter
them separated by commas, like so "(A,C) purpose statement."</p>

<p>This generator provides a survey instrument that can be administered to participants in a study, plus a scoring table to help
    calculate the individual consentfulness score for that participant.  As exaplined in the notes below, you'll need to repeat the instrument
    with multiple participants to get an overall score.</p>


<h3>Notes on consentfulness</h3>

<p>Consentfulness is, notionally, the proportion of consent <em>signals</em> that are voluntary and do not lead to unexpected actions.</p>

<p>Consentfulness is a tool for population-level analysis of a particular service-interaction combination.  It doesn't make sense to apply
    it to a single person's interactions.  The consentfulness scores from each individual application of the generated instrument should
be averaged across the target population to obtain an estimate of actual consetnfulness.</p>

<p>Consentfulness is population and context specific.  Many important aspects of consent - such as attention, comprehension, and capability -
    are highly dependent on the <em>person</em> who is being asked to give consent, and the <em>context</em> in which they are being asked.  Exercise
    caution when generalising consentfulness scores, and report them along with information about the population and context that was examined.</p>

<h2>About ConInGen</h2>

<p>The Consentfulness Instrument Generator is developed by the <strong><a href="http://www.meaningfulconsent.org/">Meaningful Consent in the Digital Economy
    Project</a></strong> at the University of Southampton.</p>

<p>Consentfulness is a work in progress, please don't rely on it in court.  It might not work at all.</p>
