<?php
	global $htmlDirectory;
	global $projectLocation;
	global $resourcesURL;
?>
<!DOCTYPE html>
<!--[if IE 7 ]><html lang="en" class="ie7"><![endif]-->
<!--[if IE 8 ]><html lang="en" class="ie8"><![endif]-->
<!--[if IE 9 ]><html lang="en" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="en">
<!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title><?php echo $clientName; ?> - <?php echo $projectName; ?></title>
	<meta name="description" content="Description of page">
	<meta name="keywords" content="Keywords for page">
	<meta name="copyright" content="Copyright information">
	<meta name="Robots" content="NOINDEX,NOFOLLOW">
	<!--[if (gt IE 6)|!(IE)]><!--><link rel="stylesheet" href="<?php echo $resourcesURL; ?>/styles/global.css">
	<link href='http://fonts.googleapis.com/css?family=Rokkitt:400,700' rel='stylesheet' type='text/css'><!--<![endif]-->
</head>
<body>
	<div id="masthead" class="wrap">
		<h1 id="siteLogo">GLOBAL_SITE_NAME</h1>
		<div id="filterBox">
			<label class="accessibility" for="searchTerm">Filter this list: </label><input id="filter" type="text" name="searchTerm" tabindex="1" value="Filter this list&hellip;">
		</div><!-- /search -->
	</div>
<?php
	// Headlines!
	if( $clientName || $projectName ) {
		echo '	<div id="pageTitles" class="wrap">' . $br;
		// If there is both .head & .subhead
		if ( $clientName && $projectName ) {
			// If .head & .subhead are the same
			if ( $clientName == $projectName ) {
				echo '		<h2 class="subhead">' . $projectName . '</h2>' . $br;
			// If .head & .subhead are different
			} else {
				echo '		<h2 class="head">' . $clientName . '</h2>' . $br;
				echo '		<h2 class="subhead">' . $projectName . '</h2>' . $br;
			}
		// If there is .head but NOT .subhead
		} else if ( $clientName && !$projectName ) {
			echo '		<h2 class="subhead">' . $clientName . '</h2>' . $br;
		// If there is .subhead but NOT .head
		} else if ( !$clientName && $projectName ) {
			echo '		<h2 class="subhead">' . $projectName . '</h2>' . $br;
		}
		echo '	</div><!-- /wrap -->' . $br;
	}
?>
	<div id="container">
<!-- START HERE -->
<?php
	if ( $templateDirectory ) {
		listDirectories($templateDirectory);
	} else {
		listDirectories($projectLocation);
//		echo $projectLocation;
	};
?>
<!-- END HERE -->
		<div class="extra content wrap">
