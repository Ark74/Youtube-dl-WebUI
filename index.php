<?php
	require_once 'class/Session.php';
	require_once 'class/Downloader.php';
	require_once 'class/FileHandler.php';
	require_once 'locale/language.php';

	$session = Session::getInstance();
	$file = new FileHandler;

	require 'views/header.php';

	if(!$session->is_logged_in())
	{
		header("Location: login.php");
	}
	else
	{
		if(isset($_GET['kill']) && !empty($_GET['kill']) && $_GET['kill'] === "all")
		{
			Downloader::kill_them_all();
		}

		if(isset($_POST['urls']) && !empty($_POST['urls']))
		{
			$audio_only = false;

			if(isset($_POST['audio']) && !empty($_POST['audio']))
			{
				$audio_only = true;
			}

			$downloader = new Downloader($_POST['urls'], $audio_only);
			
			if(!isset($_SESSION['errors']))
			{
				header("Location: index.php");
			}
		}
	}
?>
		<div class="container">
			<h1><?php echo _("Download"); ?></h1>
			<?php

				if(isset($_SESSION['errors']) && $_SESSION['errors'] > 0)
				{
					foreach ($_SESSION['errors'] as $e)
					{
						echo "<div class=\"alert alert-warning\" role=\"alert\">$e</div>";
					}
				}

			?>
			<form id="download-form" class="form-horizontal" action="index.php" method="post">					
				<div class="form-group">
					<div class="col-md-10">
						<input class="form-control" id="url" name="urls" placeholder="<?php echo _("Link(s) separated by a comma"); ?>" type="text">
					</div>
					<div class="col-md-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" name="audio"> <?php echo _("Audio Only"); ?>
							</label>
						</div>
					</div>
				</div>
				<button type="submit" class="btn btn-primary"><?php echo _("Download"); ?></button>
			</form>
			<br>
			<div class="row">
				<div class="col-lg-6">
					<div class="panel panel-info">
						<div class="panel-heading"><h3 class="panel-title"><?php echo _("Info"); ?></h3></div>
						<div class="panel-body">
							<p><?php echo _("Free space"); ?> : <?php echo $file->free_space(); ?></b></p>
							<p><?php echo _("Download folder"); ?> : <?php echo $file->get_downloads_folder(); ?></p>
							<p> 
							<?php echo _("Select a language"); ?> :
							<?  
								function is_current_language($lang)
								{ 
										 return ($lang == $_GET['lang'])? 'selected="selected"': "English";
								}
								$server_location= $_SERVER['SCRIPT_NAME'];
							?>

							<select onchange="if(this.selectedIndex!=0) self.location='<?=$server_location;?>?lang='+this.options[this.selectedIndex].value" name="userLanguage" id="userLanguage">

							   <? foreach($langs as $lang => $langname): ?>
								  <option <?= is_current_language($lang); ?> value="<?= $lang; ?>">
									 <?= $langname; ?>
								  </option>
							   <? endforeach; ?>
							</select>
							</p>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="panel panel-info">
						<div class="panel-heading"><h3 class="panel-title"><?php echo _("Help"); ?></h3></div>
						<div class="panel-body">
							<p><b><?php _("How does it work ?");?></b></p>
							<p><?php echo _('Simply paste your video link in the field and click "Download"'); ?></p>
							<p><b><?php echo _("With which sites does it work?"); ?></b></p>
							<p><?php echo _('<a href="http://rg3.github.io/youtube-dl/supportedsites.html">Here is</a> a list of the supported sites'); ?></p>
							<p><b><?php echo _("How can I download the video on my computer?"); ?></b></p>
							<p><?php echo _("Go to");?> <a href="./list.php?type=v"><?php echo _('List of videos</a> -> choose one -> right click on the link -> "Save target as ..."');?> </p>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
	unset($_SESSION['errors']);
	require 'views/footer.php';
?>
