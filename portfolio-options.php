<?php
/*
 * Create option page
 */

if ( is_admin() )
{
    add_action( 'admin_menu', 'lcb_portfolio_menu' );
    add_action( 'admin_init', 'lcb_portfolio_register_settings' );
}

function lcb_portfolio_register_settings() 
{
    register_setting( 'lcb-portfolio-option', 'column_number' );
}

function lcb_portfolio_menu() 
{
    add_options_page( 'Portfolio Display Settings', 'Portfolio', 'manage_options', 'lcb-portfolio-settings', 'lcb_portfolio_options' );
}

function lcb_portfolio_options() 
{
    if ( !current_user_can( 'manage_options' ) )  {
	wp_die( __( 'You do not have sufficient permissions to access this page.', 'lcb-portfolio' ) );
	}?>
	<div class="wrap">
        <h2><?php _e('Portfolio Display Settings', 'lcb-portfolio') ?></h2>
        <form method="post" action="options.php">
        <?php settings_fields( 'lcb-portfolio-option' );
        do_settings_sections( 'lcb-portfolio-option' );?>
        <table class="form-table">
        <tr valign="top">
        <th scope="row"><?php _e('Number of column', 'lcb-portfolio') ?></th>
        <td><select name="column_number">
                <?php $option = get_option('column_number'); ?>
                <option value="1" <?php echo ($option == 1) ? 'selected' : false ?>>1 <?php _e('column', 'lcb-portfolio')?></option>
                <option value="2" <?php echo ($option == 2) ? 'selected' : false ?>>2 <?php _e('columns', 'lcb-portfolio')?></option>
                <option value="3" <?php echo ($option == 3) ? 'selected' : false ?>>3 <?php _e('columns', 'lcb-portfolio')?></option>
                <option value="4" <?php echo ($option == 4) ? 'selected' : false ?>>4 <?php _e('columns', 'lcb-portfolio')?></option>
            </select></td>
        </tr>
    </table>
        <?php submit_button(); ?>
        </form>
	</div> 
<?php }
