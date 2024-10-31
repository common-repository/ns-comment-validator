<div class="wrap">

  <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

  <div id="poststuff">

    <div id="post-body" class="metabox-holder columns-2">

      <!-- main content -->
      <div id="post-body-content">

        <div class="meta-box-sortables ui-sortable">

          <div class="postbox">

            <h3><span><?php _e('Settings', 'ns-comment-validator'); ?></span></h3>
            <div class="inside">
              <div><strong><i><?php _e("If you dont know how to customize, leave it to default options. Plugin will work out of the box.", $this->plugin_slug); ?></i></strong></div>
              <form name="form1" method="post" action="options.php">
              <?php settings_fields('ns-comment-validator-options-group'); ?>
              <table class="form-table">
                <tr valign="top">
                  <th scope="row"><label for="cvns_rules">
                      <?php _e("Validation Rules", 'ns-comment-validator' ); ?>
                      * </label><p class="description"><?php _e("Enter Validation Rules", 'ns-comment-validator' ); ?></p></th>
                  <td><textarea id="cvns_rules" name="cvns_options[cvns_rules]" class="large-text code" rows="10"><?php echo $cvns_rules ; ?></textarea>

                    </td>
                </tr>
                <tr valign="top">
                  <th scope="row"><label for="cvns_error_element">
                    <?php _e("Error Element",  'ns-comment-validator' ); ?>
                  </label><p class="description"><?php _e("Select Error Element",  'ns-comment-validator' ); ?></p></th>
                  <td><select id="cvns_error_element" name="cvns_options[cvns_error_element]">
                                <option value="p" <?php selected( $cvns_error_element, 'p' ); ?>>p</option>
                                <option value="label" <?php selected( $cvns_error_element, 'label' ); ?>>label</option>
                                <option value="span" <?php selected( $cvns_error_element, 'span' ); ?>>span</option>
                                <option value="div" <?php selected( $cvns_error_element, 'div' ); ?>>div</option>
                              </select>
                              </td>
                </tr>
                <tr valign="top">
                  <th scope="row"><label for="cvns_styles">
                      <?php _e("CSS Styling", 'ns-comment-validator' ); ?>
                      * </label><p class="description"><?php _e("Enter CSS Styling", 'ns-comment-validator' ); ?></p></th>
                  <td><textarea id="cvns_styles" name="cvns_options[cvns_styles]" class="large-text code" rows="10"><?php echo $cvns_styles ; ?></textarea>

                    </td>
                </tr>

                <tr valign="top">
                  <th scope="row"><label for="cvns_error_class">
                      <?php _e("Error Class", 'ns-comment-validator' ); ?>
                      * </label><p class="description"><?php _e("Enter Error Class", 'ns-comment-validator' ); ?></p></th>
                  <td>
                  <input id="cvns_error_class" name="cvns_options[cvns_error_class]" value="<?php echo $cvns_error_class; ?>"  class="regular-text code"  type="text"/>
                    </td>
                </tr>

                <tr valign="top">
                  <th scope="row"><label for="cvns_messages">
                      <?php _e("Validation Messages", 'ns-comment-validator' ); ?>
                      * </label><p class="description"><?php _e("Enter Validation Messages", 'ns-comment-validator' ); ?></p></th>
                  <td><textarea id="cvns_messages" name="cvns_options[cvns_messages]" class="large-text code" rows="10"><?php echo $cvns_messages ; ?></textarea>

                    </td>
                </tr>

              </table>
              <?php submit_button(__('Save Changes', 'ns-comment-validator' ) )?>

              </form>


            </div> <!-- .inside -->

          </div> <!-- .postbox -->

        </div> <!-- .meta-box-sortables .ui-sortable -->

      </div> <!-- post-body-content -->

      <!-- sidebar -->
      <div id="postbox-container-1" class="postbox-container">

        <?php require_once( ( plugin_dir_path(__FILE__) ) . 'inc/right.php'); ?>

      </div> <!-- #postbox-container-1 .postbox-container -->

    </div> <!-- #post-body .metabox-holder .columns-2 -->

    <br class="clear">
  </div> <!-- #poststuff -->

</div> <!-- .wrap -->
