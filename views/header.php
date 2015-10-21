<!DOCTYPE html>
	<?php 
	require_once 'locale/language.php';
	?>
		
<html>
	<head>
		<meta charset="utf-8">
		<title><?php echo _("Youtube-dl WebUI"); ?></title>
		<link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	</head>
	<body>
		<div class="navbar navbar-default">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href=""><?php echo _("Youtube-dl WebUI"); ?></a>
			</div>
			<div class="navbar-collapse collapse navbar-responsive-collapse">
				<ul class="nav navbar-nav">
					<li><a href="./"><?php echo _("Download"); ?></a></li>
					<li><a href="./list.php?type=v"><?php echo _("List of videos"); ?></a></li>
					<li><a href="./list.php?type=m"><?php echo _("List of songs"); ?></a></li>
					<?php
						if($session->is_logged_in())
						{
					?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
							<?php if(Downloader::background_jobs() > 0) echo "<b>"; ?><?php echo _("Background downloads : "); ?><?php echo Downloader::background_jobs()." / ".Downloader::max_background_jobs(); if(Downloader::background_jobs() > 0) echo "</b>"; ?> <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<?php
								if(Downloader::get_current_background_jobs() != null)
								{
									foreach(Downloader::get_current_background_jobs() as $key)
									{
										if (strpos($key['cmd'], '-x') !== false) //Music
										{
											echo _("<li><a href=\"#\"><i class=\"fa fa-music\"></i> Elapsed time : ".$key['time']."</a></li>");
										}
										else
										{
											echo _("<li><a href=\"#\"><i class=\"fa fa-video-camera\"></i> Elapsed time : ".$key['time']."</a></li>");
										}
									}

									echo "<li class=\"divider\"></li>";
									echo _("<li><a href=\"./index.php?kill=all\">Kill all downloads</a></li>");
								}
								else
								{
									echo _("<li><a>No jobs !</a></li>");
								}

							?>
						</ul>
					</li>
					<?php
						}
					?>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<?php
						if($session->is_logged_in())
						{
							echo _("<li><a href=\"./logout.php\">Logout</a></li>");
						}
					?>
				</ul>
			</div>
		</div>
