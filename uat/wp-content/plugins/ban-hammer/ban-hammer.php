<?php
/*
Plugin Name: Ban Hammer
Plugin URI: http://halfelf.org/plugins/ban-hammer/
Description: This plugin prevent people from registering with any email you list.
Version: 2.0
Author: Mika Epstein
Author URI: http://www.ipstenu.org/

Copyright 2009-11 Mika Epstein (email: ipstenu@ipstenu.org)

    This file is part of Ban Hammer, a plugin for WordPress.

    Ban Hammer is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 2 of the License, or
    (at your option) any later version.

    Ban Hammer is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with WordPress.  If not, see <http://www.gnu.org/licenses/>.

*/

// First we check to make sure you meet the requirements
global $wp_version;
$exit_msg_ms  = 'Sorry, but this plugin is not supported (and will not work) on WordPress MultiSite.';
$exit_msg_ver = 'Sorry, but this plugin is no longer supported on pre-3.0 WordPress installs.';
if( is_multisite() ) { exit($exit_msg_ms); }
if (version_compare($wp_version,"2.9","<")) { exit($exit_msg_ver); }

load_plugin_textdomain('banhammer', false, basename( dirname( __FILE__ ) ) . '/languages' );

// Here's the basic plugin for WordPress SANS BuddyPress
function banhammer($user_login, $user_email, $errors) {

        // Get blacklist
        $blacklist_string = get_option('blacklist_keys');
        $blacklist_array = explode("\n", $blacklist_string);
        $blacklist_size = sizeof($blacklist_array);

        // Go through blacklist
        for($i = 0; $i < $blacklist_size; $i++)
        {
                $blacklist_current = trim($blacklist_array[$i]);
                if(stripos($user_email, $blacklist_current) !== false)
                {
                        $errors->add('invalid_email', __( get_option('banhammer_message') ));
                        return;
                }
        }
}

// And here's the plugin for BuddyPress
// Due to how BuddyPress Works, I had to break this out. See the link for why.
// http://codex.buddypress.org/plugin-development/checking-buddypress-is-active/

add_action( 'bp_include', 'banhammer_bp_init' );

function banhammer_bp_init() {
    function banhammer_bp_signup( $result ) {
    	if ( banhammer_bp_bademail( $result['user_email'] ) )
    		$result['errors']->add('user_email',  __( get_option('banhammer_message') ) );
    	return $result;
    }
    add_filter( 'bp_core_validate_user_signup', 'banhammer_bp_signup' );
    
    function banhammer_bp_bademail( $user_email ) {
            // Get blacklist
            $blacklist_string = get_option('blacklist_keys');
            $blacklist_array = explode("\n", $blacklist_string);
            $blacklist_size = sizeof($blacklist_array);
    
            // Go through blacklist
            for($i = 0; $i < $blacklist_size; $i++)
            {
                    $blacklist_current = trim($blacklist_array[$i]);
                    if(stripos($user_email, $blacklist_current) !== false)
                    {
                     return true;
                    }
            }
    }
}

// Create the options for the message and spam assassin and set some defaults.
function banhammer_activate() {
        add_option('banhammer_message', '<strong>ERROR</strong>: Your email has been banned from registration.');
}

// Hooks
add_action('admin_menu', 'banhammer_optionsmenu');
add_action('register_post', 'banhammer', 10, 3);

register_activation_hook( __FILE__, 'banhammer_activate' );

// donate link on manage plugin page
add_filter('plugin_row_meta', 'banhammer_donate_link', 10, 2);
function banhammer_donate_link($links, $file) {
        if ($file == plugin_basename(__FILE__)) {
                $donate_link = '<a href="https://www.wepay.com/donations/halfelf-wp">Donate</a>';
                $links[] = $donate_link;
        }
        return $links;
}

// Options Pages

// add the admin options page
function banhammer_optionsmenu() {
    add_submenu_page('tools.php', __('Ban Hammer', 'banhammer'), __('Ban Hammer', 'banhammer'), 'moderate_comments', 'banhammer', 'banhammer_options');
}

function banhammer_plugin_help() {
	global $banhammer_options_page;
	$screen = get_current_screen();
	if ($screen->id != 'tools_page_banhammer')
		return;
		
	$screen->add_help_tab( array(
		'id'      => 'ippy-banhammer-base',
		'title'   => __('Readme', 'banhammer'),
		'content' => 
		'<h3>' . __('Ban Hammer', 'banhammer') .'</h3>' .
		'<p>' . __( 'We\'ve all had this problem.  A group of spammers from mail.ru are registering to your blog, but you want to keep registration open.  How do you kill the spammers without bothering your clientele?  While you could edit your functions.php and block the domain, once you get past a few bad eggs, you have to escalate.', 'banhammer' ) . '</p>' .
		'<p>' . __( 'Ban Hammer does that for you, preventing unwanted users from registering.', 'banhammer' ) . '</p>' . 
		'<p>' . __( 'Instead of using its own database table, Ban Hammer pulls from your list of blacklisted emails from the Comment Blacklist feature, native to WordPress.  Since emails never equal IP addresses, it simply skips over and ignores them.  This means you only have ONE place to update and maintain your blacklist.  When a blacklisted user attempts to register, they get a customizable message that they cannot register.', 'banhammer' ) . '</p>' .
		'<p>' . __( 'Limited free support can be found in the WordPress forums.','banhammer').'</p>'.
		'<ul>'.
			'<li><a href="http://wordpress.org/support/plugin/ban-hammer">'. __( 'Support Forums','banhammer').'</a></li>'.
			'<li><a href="http://tech.ipstenu.org/my-plugins/ban-hammer/">'. __( 'Plugin Site','banhammer').'</a></li>'.
			'<li><a href="https://www.wepay.com/donations/halfelf-wp">'. __( 'Donate','banhammer').'</a></li>'.
		'</ul>'
	));

}
add_action('contextual_help', 'banhammer_plugin_help', 10, 3);

register_activation_hook( __FILE__, 'banhammer_activate' );

// Settings Page
function banhammer_options() {

        ?>
        <div class="wrap">
        
        <div id="icon-edit-comments" class="icon32"></div>
        <h2><?php _e("Ban Hammer", 'banhammer'); ?></h2>
        
        <?php
        
                if (isset($_POST['update']))
                {
                // Update the Blacklist
                        if ($banhammer_keys = $_POST['blacklist_keys'])
                        {
                                $banhammer_array = explode("\n", $banhammer_keys);
                                sort ($banhammer_array);
                                $banhammer_string = implode("\n", $banhammer_array);
                                update_option('blacklist_keys', $banhammer_string);
                        }
        				
                // Update Ban Message
                        if ($banhammer_newmess = $_POST['banhammer_newmess'])
                        {
                                update_option('banhammer_message', $banhammer_newmess);
                        }
        ?>
                <div id="message" class="updated fade"><p><strong><?php _e('Options Updated!', 'banhammer'); ?></strong></p></div>

<?php   } ?>
        
        <form method="post" width='1'>
        
        <fieldset class="options">
        <legend><h3><?php _e('Personalize the Message', banhammer); ?></h3></legend>
        <p><?php _e('The message below is displayed to users who are not allowed to register on your blog. Edit is as you see fit, but remember you don\'t get a lot of space so keep it simple.', banhammer); ?></p>
        
        <textarea name='banhammer_newmess' cols='80' rows='2'><?php echo get_option('banhammer_message'); ?></textarea>
        </fieldset>
        
        <fieldset class="options">
        <legend><h3><?php _e('Blacklisted Domains', banhammer); ?></h3></legend>
        <p><?php _e('The domains added below will not be allowed to be used during registration.', banhammer); ?></p>
        
        <textarea name="blacklist_keys" cols="40" rows="15"><?php
                $blacklist = get_option('blacklist_keys');
                echo $blacklist;
        ?></textarea>
        </fieldset>
                <p class="submit"><input class='button-primary' type='submit' name='update' value='<?php _e("Update Options", 'banhammer'); ?>' id='submitbutton' /></p>
        
        </form>
        
        </div>
        
        </div> <?php
        }