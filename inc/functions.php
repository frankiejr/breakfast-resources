<?php

$br = "\n";
////////////////////////////////////////////////////////////////////////////////
//	Get all htm, html, & php files in a directory
function listFiles($dir){
	global $br;
	global $templateDirectory;
	$dir = $dir . '/';
	$pages = array();

	// Open the directory and create an array out of all the files
	if ($dh = opendir($dir)) {
		while (($file = readdir($dh)) !== false) {
			if (!is_dir($file) && preg_match("/\.(htm|html|shtml|php)$/", $file)) {
				if( $file === 'config.php' || $file === 'index.php') {
					// Reserved
				} else {
					// If the file isn't config.php or index.php, add it to the array
					array_push($pages, $file);
				}
			}
		}
		closedir($dh);
		// Sort the array so the generated list is alphabetical
		sort($pages);
	}

	// Count the pages, echo the value
	echo '				<ul class="linklist">' . $br;
	foreach ($pages as $page) {
		// Save the old $pageTitle to compare later
		$oldPT = $pageTitle;
		// As long as this is a breakfast template, include the page
		if( $templateDirectory ) {
			include $dir . $page;
		};
		// If the new file has no $pageTitle, is the same as the last item,
		// or doesn't exist, use the filename instead
		if( $pageTitle == $oldPT ) {
			$pageTitle = $page;
		};
		echo '					<li><a href="' . $dir . $page . '" title="' . $page . '">' . $pageTitle . '</a></li>' . $br;
	}
	echo '				</ul>' . $br;
}

////////////////////////////////////////////////////////////////////////////////
// List files, directories, and the children in each directory
function listDirectories($dir) {
	global $br;
	global $projectLocation;
	global $templateDirectory;
	global $subfolders;
	global $projects;
	$dir = $dir . '/';
	$directories = array();
	$files       = array();
	if ($handle = opendir($dir)) {
		while (($file = readdir($handle)) !== false) {
			$type = filetype($dir . $file);
			// If this item is a directory, add it to $directories
			if ( $type == 'dir' && $file !== '.' && $file !== '..' ) {
				array_push($directories, $file);
			}
			// If this item is a predefined filetype, add it to $files
			else if ( $file !== '.' && $file !== '..' && !is_dir($file) && preg_match("/\.(htm|html|shtml|php)$/", $file) ) {
				array_push($files, $file);
			};
		}
		closedir($dh);
		// Sort the arrays so the generated lists are alphabetical
		sort($directories);
		sort($files);
		// If there are files, list them first
		$dirCount = count($directories);
		$fileCount = count($files);

		// If breakfast templates are being used & there are files in the template or
		// project root directory
		if ( $templateDirectory && $fileCount > 0 ) {
			echo '		<div class="base content wrap">' . $br;
			if ( $templateDirectory ) {
				echo '			<h4 class="list head">Base Templates</h4>';
			};
			echo '			<ul class="linklist">' . $br;
			foreach ($files as $item) {
				echo '				<li><a href="' . $dir . $item . '" title="' . $item . '">' . $item . '</a></li>' . $br;
			};
			echo '			</ul>' . $br;
			echo '		</div><!-- /content wrap -->' . $br;
		}

		// If breakfast templates are not being used and there are files in the
		// project root directory
		else if ( !$templateDirectory ) {
			// Ignore the breakfast template config files
			if ( $fileCount > 2 ) {
				echo '		<div class="base content wrap">' . $br;
				echo '			<ul class="linklist">' . $br;
				// If breakfast templates are being used
				foreach ($files as $item) {
					// Ignore breakfast setup files
					if ( $item !== 'index.php' && $item !== 'config.php' ) {
						echo '				<li><a href="' . $item . '" title="' . $item . '">' . $item . '</a></li>' . $br;
					};
				};
				echo '			</ul>' . $br;
				echo '		</div><!-- /content wrap -->' . $br;
			};
		}

		// If there is a template directory, but it's empty
		else if ($dirCount == 0) {
			echo '		<div class="content wrap">' . $br;
			echo '			<h4 class="list head">Templates</h4>';
			echo '			<p>There aren\'t any templates yet. Get building!</p>' . $br;
			echo '		</div><!-- /content wrap -->' . $br;
		}

		// If the item is a directory, Get the name and list its files
		foreach ($directories as $item) {
			// Create projects directory: Several folders, one project per folder
			if ( $subfoldres !== 0 && $projects == 1 ) {
				include $dir . $item;
				echo '		<div class="content wrap">' . $br;
				echo '			<h4 class="list head"><a href="/' . $item . '/">' . $item . '&nbsp;&rarr;</a></h4>' . $br;
				echo '		</div><!-- /content wrap -->' . $br;
			}
			// Only show subdirectories if $subfolders is not set to 0
			else if ( $subfolders !== 0 ) {
				include $dir . $item;
				echo '		<div class="content wrap">' . $br;
				echo '			<h4 class="list head">' . $item . '</h4>' . $br;
				// Look in the current directory to see if the description file exists
				$filename = $projectLocation . $templateDirectory . '/' . $item . '/description.txt';
				if (file_exists($filename)) {
					// If the description file exists, get its contents and echo them
					$desc = file_get_contents($filename);
					echo "<div class=\"description\">";
					echo $desc;
					echo "</div>";
				} else {
					// Reserved for later function
				}
				if( $templateDirectory ) {
					// If we're using breakfast templates
					listFiles($dir . $item);
				}
				else {
					// If we're not using breakfast templates
					listFiles($item);
				};
				echo '		</div><!-- /content wrap -->' . $br;
			};
		}
	}
	else {
		// If the directory can't be found, echo an error message instead
			echo '		<div id="noHTMLdir" class="content wrap">' . $br;
			echo '			<h4 class="list head">Oops!</h4>' . $br;
			echo '			<p>We can\'t find the template directory called <code>"' . $dir . '"</code>. Check the configuration file for this project, Make sure the directory exists, and try again.</p>';
			echo '		</div><!-- /content wrap -->' . $br;
	};
}

?>	