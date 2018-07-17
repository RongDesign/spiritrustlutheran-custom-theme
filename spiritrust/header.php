<?php
$ga_id               = get_field('google_analytics_account_id', 'option');
$google_maps_api_key = get_field('google_maps_api_key', 'option');
$tk_id               = get_field('typekit_account_id', 'option');
$social_fb           = get_field('facebook_url', 'option');
$social_li           = get_field('linkedin_url', 'option');
$social_yt           = get_field('youtube_url', 'option');
$body_atts           = '';

if ($google_maps_api_key != '') {
	// ADD GOOGLE MAPS API KEY TO BODY (data-key="{key}")
	$body_atts = ' data-key="' . $google_maps_api_key . '"';
}
?><!doctype html>
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="google-site-verification" content="Cus7ojT8oDcDSmscNiQFh0tdP_YUgkwrm1SDQrwBrSo">

	<title>
		<?php if (is_404()): ?>
			<?php echo "Page Not Found"; ?>
		<?php elseif (is_archive()): ?>
			<?php if (get_post_type() == 'careers'): ?>
					<?php echo get_bloginfo('name') . ' | Career Listings'; ?>
				<?php else: ?>
					<?php $current_category = single_cat_title('', false); ?>
					<?php echo get_bloginfo('name') . ' | ' . $current_category; ?>
				<?php endif; ?>
		<?php else: ?>
			<?php wp_title('|', true, 'right'); ?>
		<?php endif; ?>
	</title>

	<link rel="shortcut icon" href="/favicon.ico">
	<link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
	<link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
	<link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96">
	<link rel="apple-touch-icon" href="/apple-touch-icon-57x57.png" sizes="57x57">
	<link rel="apple-touch-icon" href="/apple-touch-icon-60x60.png" sizes="60x60">
	<link rel="apple-touch-icon" href="/apple-touch-icon-72x72.png" sizes="72x72">
	<link rel="apple-touch-icon" href="/apple-touch-icon-76x76.png" sizes="76x76">
	<link rel="apple-touch-icon" href="/apple-touch-icon-114x114.png" sizes="114x114">
	<link rel="apple-touch-icon" href="/apple-touch-icon-120x120.png" sizes="120x120">
	<link rel="apple-touch-icon" href="/apple-touch-icon-144x144.png" sizes="144x144">
	<link rel="apple-touch-icon" href="/apple-touch-icon-152x152.png" sizes="152x152">
	<link rel="apple-touch-icon" href="/apple-touch-icon-180x180.png" sizes="180x180">

	<meta name="msapplication-TileImage" content="/mstile-144x144.png">
	<meta name="msapplication-TileColor" content="#ffffff">

	<?php wp_head(); ?>

	<?php if (!empty($ga_id)): ?>
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', '<?php echo $ga_id; ?>', 'auto', {'allowLinker': true});
		ga('send', 'pageview');
	</script>
	<?php endif; ?>

	<?php if (!empty($tk_id)): ?>
	<script>
		(function(d) {
			var config = {
				kitId: '<?php echo $tk_id; ?>',
				scriptTimeout: 3000
			},
			h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+" wf-inactive";},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+=" wf-loading";tk.src='//use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s)
		})(document);
	</script>
	<?php endif; ?>

	<!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri(); ?>/lib/js/html5shiv.min.js"></script>
	<![endif]-->
</head>

<body <?php body_class($class);?><?php echo $body_atts; ?>>
	<?php if (!is_404()): ?>
	<!-- HEADER -->
	<header id="header">
		<div class="container">
			<div id="logo-wrapper" class="cf">
				<?php if (is_front_page()): ?>
					<h1 id="logo">
						<a href="<?php echo esc_url(home_url('/')); ?>">
							<img src="<?php echo get_template_directory_uri(); ?>/lib/img/logo/spiritrust-lutheran.png" width="400" height="56" alt="SpiriTrust Lutheran">
						</a>
					</h1>
				<?php else : ?>
					<p id="logo">
						<a href="<?php echo esc_url(home_url('/')); ?>">
							<img src="<?php echo get_template_directory_uri(); ?>/lib/img/logo/spiritrust-lutheran.png" width="400" height="56" alt="SpiriTrust Lutheran">
						</a>
					</p>
				<?php endif;
			?>
			</div>

			<nav id="nav">
				<!-- NAVICON (FOR MOBILE) -->
				<a href="#main-menu" id="navicon" rel="nofollow">
					<span class="brd"></span>
					<span class="txt">Menu</span>
				</a>

				<!-- NAVIGATION -->
				<div id="nav-wrapper" class="cf">
					<!-- MAIN NAV -->
					<div id="main-nav-wrapper">
						<?php
							wp_nav_menu(
								array(
									'container'      => '',
									'items_wrap'     => '<ul id="main-nav" class="clist cf">%3$s</ul>',
									'theme_location' => 'main-menu',
									'walker'         => new MainMenu_Walker()
								)
							);
						?>
					</div>

					<!-- SECONDARY NAV -->
					<div id="secondary-nav-wrapper" class="cf">
						<?php
							wp_nav_menu(
								array(
									'container'      => '',
									'items_wrap'     => '<ul id="secondary-nav" class="clist cf">%3$s</ul>',
									'theme_location' => 'secondary-menu',
									'link_before'    => '<span class="bg"></span><span class="txt">',
									'link_after'     => '</span>'
								)
							);
						?>
					</div>

					<!-- TOP NAV -->
					<div id="top-nav-wrapper" class="cf">
						<div id="top-nav">
							<!-- SOCIAL ICONS -->
							<div id="social-nav-wrapper" class="cf">
								<ul id="social-nav" class="clist">
									<?php if (!empty($social_fb)) : ?>
									<li>
										<a href="<?php echo $social_fb; ?>" target="_blank">
											<span class="bg"></span>
											<span class="txt">Facebook</span>
											<span class="icon icon-facebook-square"></span>
										</a>
									</li>
									<?php endif; ?>
									<?php if (!empty($social_li)) : ?>
									<li>
										<a href="<?php echo $social_li; ?>" target="_blank">
											<span class="bg"></span>
											<span class="txt">LinkedIn</span>
											<span class="icon icon-linkedin-square"></span>
										</a>
									</li>
									<?php endif; ?>
									<?php if (!empty($social_yt)) : ?>
									<li>
										<a href="<?php echo $social_yt; ?>" target="_blank">
											<span class="bg"></span>
											<span class="txt">YouTube</span>
											<span class="icon icon-youtube-square"></span>
										</a>
									</li>
									<?php endif; ?>
								</ul>
							</div>

							<!-- SEARCH FORM -->
							<?php get_search_form(); ?>

							<!-- FONT SIZER -->
							<div id="font-size-wrapper" class="cf">
								<p>Font Size</p>
								<ul id="font-size" class="clist">
									<li>
										<button type="button" data-size="small" class="small" title="Update Font Size: Small">
											<span class="txt">Small</span>
											<span class="icon icon-font"></span>
										</button>
									</li>
									<li>
										<button type="button" data-size="medium" class="medium active" title="Update Font Size: Medium">
											<span class="txt">Medium</span>
											<span class="icon icon-font"></span>
										</button>
									</li>
									<li>
										<button type="button" data-size="large" class="large" title="Update Font Size: Large">
											<span class="txt">Large</span>
											<span class="icon icon-font"></span>
										</button>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</nav>
		</div>
	</header>
	<?php endif; ?>

	<!-- PAGE SECTION -->
	<section>
		<?php if (!is_404() && !is_front_page() && !is_page_template('page-templates/landing-banner.php')): ?>
		<?php get_template_part('content', 'hero'); ?>
		<?php get_template_part('content', 'breadcrumbs'); ?>
		<?php endif; ?>
