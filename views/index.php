{%include "/includes/header.php"%}

<body class="homepage">
{%include "/includes/nav.php"%}

<!-- Banner -->
<div id="banner-wrapper">
  <div id="banner" class="box container">
    <div class="row">
      <div class="7u">
        <h2>So you want to apply for work?</h2>
        <p>Get feedback from experienced stakeholders before you submit</p>
      </div>
      <div class="5u">
        <ul>
          <li><a href="#form" class="button big icon fa-arrow-circle-right">Submit</a></li>
          <li><a href="/volunteer" class="button alt big icon fa-question-circle">Volunteer</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>

<!-- Main -->
<div id="banner-wrapper">
  <div  class="container box">

    <div class="row" id="about">
      <div class="4u">


      </div>
      <div class="12u important(collapse)">

        <!-- Content -->
        <div id="content">
          <section class="last">
            <h2>So what's this all about?</h2>
            <p>
            Applying for work is stressful and full of second-guessing. We want everyone to
            have the best advice possible when building their resume.
            </p>
            <p>
            We can't cure impostor syndrome, or guarantee an offer, but we can give you helpful,
            constructive feedback on your resumes, before you submit.
            </p>
            <p>
            Submit a <a href="https://drive.google.com">Google Doc</a> link in the form below, and
            we'll get it in front of some of the best reviewers in the community.
            </p>
          </section>
        </div>
      </div>
      <div class="12u important(collapse)">
        <div id="volunteers">
          <section class="widget thumbnails">
            <h2>Volunteers</h2>
            <div class="grid">
              <div class="row no-collapse 50%">
                {% for volunteer in volunteers %}
                {%include "/volunteer_block.php" %}
                {% endfor %}
              </div>
            </div>
          </section>
        </div>
      </div>
      <!--                        {%include "/tips.php"%}-->


      {%include "/resume_form.php"%}

    </div>
  </div>
</div>

<!-- Footer -->
{%include "/includes/footer.php"%}

</body>
</html>
