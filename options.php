<div class="wrap">
	
    <?php screen_icon(); ?>
    
	<h2>Switch Blog Theme Options</h2>
    
    <form method="post" action="options.php">
    
	<?php settings_fields( 'junaidbhura-sbt_options' ); ?>
    
    <table class="form-table">
        <tbody>
        
            <tr valign="top">
                <th scope="row"><label for="junaidbhura_sbt_blog_theme">Select the blog theme ( for blog pages )</label></th>
                <td>
                    <select name="junaidbhura_sbt_blog_theme">
                     	<option value=""></option>
						<?php
						// Get themes
						$themes = wp_get_themes();
						foreach ( $themes as $key => $theme ):
						?>
                        <option value="<?php echo $key; ?>"<?php if ( $key == get_option( 'junaidbhura_sbt_blog_theme' ) ): ?> selected="selected"<?php endif; ?>><?php echo $key; ?></option>
                        <?php endforeach; ?>
                     </select>
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"><label for="junaidbhura_sbt_default_theme">Select the default theme ( for non-blog pages )</label></th>
                <td>
                    <select name="junaidbhura_sbt_default_theme">
                     	<option value=""></option>
						<?php
						// Get themes
						$themes = wp_get_themes();
						foreach ( $themes as $key => $theme ):
						?>
                        <option value="<?php echo $key; ?>"<?php if ( $key == get_option( 'junaidbhura_sbt_default_theme' ) ): ?> selected="selected"<?php endif; ?>><?php echo $key; ?></option>
                        <?php endforeach; ?>
                     </select>
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"><label for="junaidbhura_sbt_blog_base">Enter the base for the blog pages</label></th>
                <td>
                    <input type="text" name="junaidbhura_sbt_blog_base" value="<?php echo get_option( 'junaidbhura_sbt_blog_base' ); ?>" />
                </td>
            </tr>
        
        </tbody>
    </table>
    
    <?php submit_button(); ?>
    
	</form>
    
</div>