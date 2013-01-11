<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> 

<title>AdviserVoice <?php wp_title(); ?></title> 

<link rel="stylesheet" href="http://www.adviservoice.com.au/wp-content/themes/adviservoice/style.css" type="text/css" media="screen" />
<link rel="stylesheet" type="text/css" media="print" href="http://www.adviservoice.com.au/wp-content/themes/adviservoice/print.css" />
<link rel="apple-touch-icon" href="http://www.adviservoice.com.au/wp-content/themes/adviservoice/images/global/apple_touch.png" type="image/png" />
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="http://www.adviservoice.com.au/feed/" /> 
<link rel="shortcut icon" href="http://www.adviservoice.com.au/wp-content/themes/adviservoice/images/favicon.ico" />
<script language="javascript" src="http://www.adviservoice.com.au/wp-includes/js/jquery/jquery.js"></script>

<?php wp_head(); ?>

</head>

<body>
<!--[if lte IE 6]><script src="<?php bloginfo('template_directory'); ?>/ie6/warning.js"></script><script>window.onload=function(){e("<?php bloginfo('template_directory'); ?>/ie6/")}</script><![endif]-->

<div id="wrapper">
	<div id="header">
    	
        <div id="masthead">
        
        
        	<div id="branding"><a href="<?php bloginfo('url') ?>"></a></div> <!--end branding-->
            
            <div class="floatR">
            
                <div id="small-menu"> 
                	<ul>
                    	<li class="first homelink"><a href="<?php bloginfo('url') ?>">Home</a></li>
                        <li><a href="<?php bloginfo('url') ?>/about">About us</a></li>
                        <li><a href="<?php bloginfo('url') ?>/forums">Forums</a></li>
                       	<li><a href="<?php bloginfo('url') ?>/advertise">Advertise</a></li>
                        
                    </ul>
                
                </div> <!--end small menu-->
                
                <div id="search"> <a href="<?php bloginfo('url') ?>/search" title="Search on AdviserVoice"></a></div> <!--end search-->

				
				<?php
					if ( is_user_logged_in() ) {?>
                		<a href="<?php echo wp_logout_url(( $_SERVER['REQUEST_URI'])); ?>" title="Logout"><div id="logout"> </div> </a><!--end sign in-->
					
                <?php
				    } else { ?>
                    	
                        <div id="join"> <a href="<?php bloginfo('url') ?>/registration"></div><!--end join-->
                		<a href="<?php echo wp_login_url(( $_SERVER['REQUEST_URI'] )); ?>" class="button" title="Sign In"><div id="sign-in"> </div> </a><!--end sign in-->
					<?php };
				?>
                
        
        	</div> <!--end div floatR-->
        
        </div> <!--end masthead-->
			            
            <div id="access" role="navigation">
            
            	<ul id="main-menu">
					<?php //wp_list_pages('title_li=&depth=2'); ?> 
					<?php wp_list_pages('include=3226,5,8,11,15,3131&title_li=&depth=2'); ?> 
                    <?php wp_list_categories('exclude=499,3,1&title_li=&depth=2&orderby=ID&order=ASC'); ?>
                </ul>
            
            
            </div> <!--end access-->

	</div> <!--end header-->
