<?php

require_once 'base.php';
$id = getVarOrNull(array_merge($_GET, $_POST), 'id');

if ($id) {
	$collection = collection();
	$mId = new MongoId($id);
	$doc = $collection->findOne(['_id' => $mId]);

	// var_dump($doc);
}

?>
<!DOCTYPE html>
<html>
<head>
	<?php
	if (isset($doc)) {
		printf("<script>collegeramaDocument = '%s';</script>", json_encode($doc));
	}
	?>
	<title>ineffable &mdash; TU Delft Collegerama downloader</title>
	<link href='http://fonts.googleapis.com/css?family=Noto+Sans|Quando' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="/cdn/fonts/Jokal/stylesheet.css">
	<link rel="stylesheet" href="layout/style.css">

	<script src="http://code.jquery.com/jquery-2.0.0.min.js"></script>
	<script src="http://malsup.github.com/jquery.form.js"></script>
	<script src="collection.js.php"></script>
	<script src="script/base.js"></script>

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
</head>
<body>
	<section id="header">
		<header>
			<h1>in<span>effable</span>.nl</h1>
			<h2>T<span>U</span> Delft &mdash; Collegerama downloader</h2>
		</header>
	</section>

	<section id="linksHeader" class="noBorder">
		<h1>Collegerama college link</h1>
		<!-- <ul class="sub-menu">
			<li><a target="_blank" href="http://tudelftbb.collegerama.nl/wordpress/all-faculties/college-lr_en/">Aerospace Engineering</a></li>
			<li><a target="_blank" href="http://tudelftbb.collegerama.nl/wordpress/all-faculties/college-tnw_en/">Applied Sciences</a></li>
			<li><a target="_blank" href="http://tudelftbb.collegerama.nl/wordpress/all-faculties/college-bk_en/">Architecture</a></li>
			<li><a target="_blank" href="http://tudelftbb.collegerama.nl/wordpress/all-faculties/college-citg_en/">Civil Engineering and Geosciences</a></li>
			<li><a target="_blank" href="http://tudelftbb.collegerama.nl/wordpress/all-faculties/college-ewi_en/">Electrical Engineering, Mathematics and Computer Sciences</a></li>
			<li><a target="_blank" href="http://tudelftbb.collegerama.nl/wordpress/all-faculties/college-io_en/">Industrial Design Engineering</a></li>
			<li><a target="_blank" href="http://tudelftbb.collegerama.nl/wordpress/all-faculties/college-3me_en/">Mechanical, Maritime and Materials Engineering</a></li>
			<li><a target="_blank" href="http://tudelftbb.collegerama.nl/wordpress/all-faculties/college-tbm_en/">Technology, Policy and Management</a></li>
			<li><a target="_blank" href="http://tudelftbb.collegerama.nl/wordpress/all-faculties/">Recorded Lectures: All faculties</a></li>
			<li><a target="_blank" href="http://tudelftbb.collegerama.nl/wordpress/public-lectures/">Public Lectures</a></li>
		</ul> -->
		<p>
			<a id="linksShow3mE" href="#">Show 3mE Collegerama overview</a>
		</p>
		<p>
			If it asks to login, please do so through Blackboard.
		</p>
	</section>
	
	<section id="linksIframe" class="noPadding noBorder">
		<p>
			You can right-click / copy link address and paste it below
		</p>

		<iframe id="iframe"></iframe>
	</section>

	<section id="linksForm">
		<form method="post" action="download.php" id="form">
			<input type="text" id="link" name="link" value=""/>
			<input type="submit" value="Go get it!"/>
		</form>
	</section>

	<section id="video">
		<div id="videoContent">
			
			<h1>
				<a id="videoSize" href="#">
					<img id="enlarge" src="/cdn/skewed-icons/32x32/enlarge.png"/>
					<img id="shrink" src="/cdn/skewed-icons/32x32/shrink.png"/>
				</a>
				Video
			</h1>

			<div>
				<video controls></video>
			</div>

			<a id="download" href="#" download=""></a>
		</div>
	</section>

	<section id="history">
		<h1>History</h1>

		<ul id="historyList">
		</ul>
	</section>

	<section id="footer">
		<footer>
			<ul>
				<li><a href="http://ineffable.nl/">ineffable bv</a></li>
				<li><a href="mailto:info@ineffable.nl">contact</a></li>
			</ul>
		</footer>
	</section>
</body>
</html>