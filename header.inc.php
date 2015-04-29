<?php
	require_once("config.inc.php");
	require_once("db.inc.php");

	session_start();
	
	require_once("util.inc.php");

	$currentLevel = "user";

	if (strpos($_SERVER["PHP_SELF"], "/agent/") !== FALSE) {
		$currentLevel = "agent";
	}
	if (strpos($_SERVER["PHP_SELF"], "/admin/") !== FALSE) {
		$currentLevel = "admin";
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo htmlentities(SITE_NAME); ?></title>

		<link rel="stylesheet" href="<?php echo SITE_URL; ?>css/bootstrap.min.css" />
		<link rel="stylesheet" href="<?php echo SITE_URL; ?>css/dropzone.css" />

		<script src="<?php echo SITE_URL; ?>js/jquery-1.11.2.min.js"></script>
		<script src="<?php echo SITE_URL; ?>js/bootstrap.min.js"></script>
		<script src="<?php echo SITE_URL; ?>js/tinymce/tinymce.min.js"></script>
		<script src="<?php echo SITE_URL; ?>js/dropzone.js"></script>
		<script>
			tinymce.init({
				selector: ".tinymce-activate",
				menu : {
					edit  : {title : "Edit"  , items : 'undo redo | selectall'},
					insert: {title : "Insert", items : 'link media | template hr'},
					format: {title : "Format", items : 'bold italic underline strikethrough superscript subscript | formats | removeformat'},
					table : {title : "Table" , items : 'inserttable tableprops deletetable | cell row column'},
					tools : {title : "Tools" , items : 'spellchecker code'}
				}
			});
			$(document).ready(function() {
				$(".dropzone-activate").each(function() {
					$(this).dropzone({ url: $(this).attr("data-action") });
				});
			});
		</script>

		<style>
		body {
			padding-top: 50px;
		}
		footer {
			text-align: center;
		}
		</style>
	</head>
	<body>
		<nav class="navbar navbar-default navbar-fixed-top <?php if ($currentLevel != "user") { echo "navbar-inverse"; } ?>">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="<?php echo SITE_URL; ?>"><?php echo htmlentities(SITE_NAME); ?></a>
				</div>

				<div class="collapse navbar-collapse" id="nav-collapse">
					<ul class="nav navbar-nav">
						<li><a href="#">Link</a></li>
						<li><a href="#">Link</a></li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="#">Action</a></li>
								<li><a href="#">Another action</a></li>
								<li><a href="#">Something else here</a></li>
								<li class="divider"></li>
								<li><a href="#">Separated link</a></li>
								<li class="divider"></li>
								<li><a href="#">One more separated link</a></li>
							</ul>
						</li>
					</ul>
					<form class="navbar-form navbar-left" role="search">
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Search">
						</div>
						<button type="submit" class="btn btn-default">Submit</button>
					</form>
					<ul class="nav navbar-nav navbar-right">
						<?php if ($_SESSION["loggedIn"] && $currentUserRecord["accountLevel"] != "user") { ?>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
									Switch view
									<span class="caret"></span>
								</a>
								<ul class="dropdown-menu" role="menu">
									<?php if ($currentLevel != "user") { ?>
										<li><a href="<?php echo SITE_URL; ?>">User view</a></li>
									<?php } ?>
									<?php if ($currentLevel != "agent" && ($currentUserRecord["accountLevel"] == "admin" || $currentUserRecord["accountLevel"] == "agent")) { ?>
										<li><a href="<?php echo SITE_URL; ?>agent/">Agent view</a></li>
									<?php } ?>
									<?php if ($currentLevel != "admin" && ($currentUserRecord["accountLevel"] == "admin")) { ?>
										<li><a href="<?php echo SITE_URL; ?>admin/">Admin view</a></li>
									<?php } ?>
								</ul>
							</li>
						<?php } ?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
								<?php if ($_SESSION["loggedIn"]) {
									echo htmlentities($currentUserRecord["accountName"]);
								} else { ?>
									Log in/create account
								<?php } ?>
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu" role="menu">
								<?php if ($_SESSION["loggedIn"]) { ?>
									<li><a href="<?php echo SITE_URL; ?>profile.php">Profile</a></li>
									<li><a href="<?php echo SITE_URL; ?>myTickets.php">My tickets</a></li>
									<li class="divider"></li>
									<li><a href="<?php echo SITE_URL; ?>logout.php">Log out</a></li>
								<?php } else { ?>
									<li><a href="<?php echo SITE_URL; ?>createAccount.php">Create account</a></li>
									<li><a href="<?php echo SITE_URL; ?>login.php">Log in</a></li>
								<?php } ?>
							</ul>
						</li>
					</ul>
				</div><!-- /.navbar-collapse -->
			</div><!-- /.container-fluid -->
		</nav>