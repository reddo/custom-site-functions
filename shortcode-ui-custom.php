<?php
/**
 * Plugin Name: Shortcode UI Custom
 * Version: v1.0
 * Description: Adds custom shortcodes and also adds said shortcodes to Shorcode UI.
 * Author: Lateral
 * Author URI: http://lateral-inc.com/
 * Text Domain: shortcode-ui
 * License: MIT
 *
 * Copyright (c) 2016 Lateral
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

/**
 * Plugin initialization
 */
require_once( dirname( __FILE__ ) . '/lib/init.php' );

/**
 * If Shortcake isn't active, then this demo plugin doesn't work either
 */
function shortcode_ui_detection() {
  if ( !function_exists( 'shortcode_ui_register_for_shortcode' ) ) {
    add_action( 'admin_notices', 'shortcode_ui_dev_example_notices' );
  }
}

function shortcode_ui_dev_example_notices() {
  if ( current_user_can( 'activate_plugins' ) ) {
    echo '<div class="error message"><p>Shortcode UI plugin must be active for Shortcode UI Example plugin to function.</p></div>';
  }
}

/**
 * Register a UI for the Shortcode.
 * Pass the shortcode tag (string)
 * and an array or args.
 */
function shortcode_ui_register_shortcodes() {
  /**
   * Register UI for your shortcode
   *
   * @param string $shortcode_tag
   * @param array $ui_args
   */
  shortcode_ui_register_for_shortcode( 'shortcake_dev', 
    array(
      /*
       * How the shortcode should be labeled in the UI. Required argument.
       */
      'label' => esc_html__( 'Shortcake Dev', 'shortcode-ui' ),
      /*
       * Include an icon with your shortcode. Optional.
       * Use a dashicon, or full URL to image.
       */
      'listItemImage' => 'dashicons-editor-quote',
      /*
       * Limit this shortcode UI to specific posts. Optional.
       */
      // 'post_type' => array( 'post' ),
      /*
       * Register UI for the "inner content" of the shortcode. Optional.
       * If no UI is registered for the inner content, then any inner content
       * data present will be backed up during editing.
       */
      'inner_content' => array(
        'label'        => esc_html__( 'Quote', 'shortcode-ui' ),
        'description'  => esc_html__( 'Include a statement from someone famous.', 'shortcode-ui' ),
      ),
      /*
       * Register UI for attributes of the shortcode. Optional.
       *
       * If no UI is registered for an attribute, then the attribute will 
       * not be editable through Shortcake's UI. However, the value of any 
       * unregistered attributes will be preserved when editing.
       * 
       * Each array must include 'attr', 'type', and 'label'.
       * 'attr' should be the name of the attribute.
       * 'type' options include: text, checkbox, textarea, radio, select, email, 
       *     url, number, and date, post_select, attachment, color.
       * Use 'meta' to add arbitrary attributes to the HTML of the field.
       * Use 'encode' to encode attribute data. Requires customization to callback to decode.
       * Depending on 'type', additional arguments may be available.
       */
      'attrs' => array(
        array(
          'label'       => esc_html__( 'Attachment', 'shortcode-ui' ),
          'attr'        => 'attachment',
          'type'        => 'attachment',
          /*
           * These arguments are passed to the instantiation of the media library:
           * 'libraryType' - Type of media to make available.
           * 'addButton' - Text for the button to open media library.
           * 'frameTitle' - Title for the modal UI once the library is open.
           */
          'libraryType' => array( 'image' ),
          'addButton'   => esc_html__( 'Select Image', 'shortcode-ui' ),
          'frameTitle'  => esc_html__( 'Select Image', 'shortcode-ui ' ),
        ),
        array(
          'label'  => esc_html__( 'Citation Source', 'shortcode-ui' ),
          'attr'   => 'source',
          'type'   => 'text',
          'encode' => true,
          'meta'   => array(
            'placeholder' => esc_html__( 'Test placeholder', 'shortcode-ui' ),
            'data-test'   => 1,
          ),
        ),
        array(
          'label' => esc_html__( 'Select Page', 'shortcode-ui' ),
          'attr' => 'page',
          'type' => 'post_select',
          'query' => array( 'post_type' => 'page' ),
          'multiple' => true,
        ),
        array(
          'label' => __( 'Select Whatever', 'shortcode-ui' ),
          'attr' => 'select',
          'type' => 'select',
          'options' => array( 
            'option_1_value' => 'Option 1',
            'option_2_value' => 'Option 2'
            ),
          'multiple' => true
        )
      )
    )
  );

  /**
   * Register bootstrap's [column] shortcode
   */
  /* shortcode_ui_register_for_shortcode( 'column', 
    array(
    'label' => __( 'BS Column', 'shortcode-ui' ),
      'listItemImage' => '<img src="http://getbootstrap.com/apple-touch-icon.png" alt="Bootstrap">',  
      'inner_content' => array(
        'label'        => __( 'Content', 'shortcode-ui' )
      ),
      'attrs' => array(
        array(
          'label'  => __( 'Extra Class(es)', 'shortcode-ui' ),
          'attr'   => 'xclass',
          'type'   => 'text',
          'description'  => __( 'Any extra classes you want to add', 'shortcode-ui' )
        ),
        array(
          'label' => __('col-xs-'),
          'attr' => 'xs',
          'type' => 'text',
          'description' => __( 'Size of column on extra small screens (less than 768px); optional;    1-12    false', 'shortcode-ui')
        ),
        array(
          'label' => __('col-sm-'),
          'attr' => 'sm',
          'type' => 'text',
          'description' => __( 'Size of column on small screens (greater than 768px); optional;   1-12    false', 'shortcode-ui')
        ),
        array(
          'label' => __('col-md-'),
          'attr' => 'md',
          'type' => 'text',
          'description' => __( 'Size of column on medium screens (greater than 992px);    optional;   1-12    false', 'shortcode-ui')
        ),
        array(
          'label' => __('col-lg-'),
          'attr' => 'lg',
          'type' => 'text',
          'description' => __( 'Size of column on large screens (greater than 1200px);    optional;   1-12    false', 'shortcode-ui')
        ),
        array(
          'label' => __('col-xs-offset-'),
          'attr' => 'offset_xs',
          'type' => 'text',
          'description' => __( 'Offset on extra small screens;    optional;   1-12    false', 'shortcode-ui')
        ),
        array(
          'label' => __('col-sm-offset-'),
          'attr' => 'offset_sm',
          'type' => 'text',
          'description' => __( 'Offset on small screens;  optional;   1-12    false', 'shortcode-ui')
        ),
        array(
          'label' => __('col-md-offset-'),
          'attr' => 'offset_md',
          'type' => 'text',
          'description' => __( 'Offset on column on medium screens;   optional;   1-12    false', 'shortcode-ui')
        ),
        array(
          'label' => __('col-lg-offset-'),
          'attr' => 'offset_lg',
          'type' => 'text',
          'description' => __( 'Offset on column on large screens;    optional;   1-12    false', 'shortcode-ui')
        ),
        array(
          'label' => __('pull-xs-'),
          'attr' => 'pull_xs',
          'type' => 'text',
          'description' => __( 'Pull on extra small screens;  optional;   1-12    false', 'shortcode-ui')
        ),
        array(
          'label' => __('pull-sm-'),
          'attr' => 'pull_sm',
          'type' => 'text',
          'description' => __( 'Pull on small screens;    optional;   1-12    false', 'shortcode-ui')
        ),
        array(
          'label' => __('pull-md-'),
          'attr' => 'pull_md',
          'type' => 'text',
          'description' => __( 'Pull on column on medium screens; optional;   1-12    false', 'shortcode-ui')
        ),
        array(
          'label' => __('pull-lg-'),
          'attr' => 'pull_lg',
          'type' => 'text',
          'description' => __( 'Pull on column on large screens;  optional;   1-12    false', 'shortcode-ui')
        ),
        array(
          'label' => __('pull-xs-'),
          'attr' => 'push_xs',
          'type' => 'text',
          'description' => __( 'Push on extra small screens;  optional;   1-12    false', 'shortcode-ui')
        ),
        array(
          'label' => __('pull-sm-'),
          'attr' => 'push_sm',
          'type' => 'text',
          'description' => __( 'Push on small screens;    optional;   1-12    false', 'shortcode-ui')
        ),
        array(
          'label' => __('pull-md-'),
          'attr' => 'push_md',
          'type' => 'text',
          'description' => __( 'Push on column on medium screens; optional;   1-12    false', 'shortcode-ui')
        ),
        array(
          'label' => __('pull-lg-'),
          'attr' => 'push_lg',
          'type' => 'text',
          'description' => __( 'Push on column on large screens;  optional;   1-12    false', 'shortcode-ui')
        ),
        array(
          'label' => __('Data attribute(s)'),
          'attr' => 'data',
          'type' => 'text',
          'description' => __( 'Data attribute and value pairs separated by a comma. Pairs separated by pipe (see example at Button Dropdowns).;  optional;   any text    none', 'shortcode-ui')
        )
      )
    )
  ); */

  $tableMarkup = '<table>
    <tr>
      <td>...</td>
      <td>...</td>
    </tr>
  </table>';

  /**
   * Add some bootstrap shortcodes if the bootstrap-3-shortcodes plugin is activated
   */
  if (is_plugin_active('bootstrap-3-shortcodes/bootstrap-shortcodes.php')) :

    /**
     * Register UI for bootstrap's [lead] shortcode
     */
    shortcode_ui_register_for_shortcode( 'lead', 
      array(
      'label' => __( 'BS lead copy', 'shortcode-ui' ),
        'listItemImage' => '<img src="http://getbootstrap.com/apple-touch-icon.png" alt="Bootstrap">',  
        'inner_content' => array(
          'label'        => __( 'Content', 'shortcode-ui' )
        ),
        'attrs' => array(
          array(
            'label'  => __( 'Extra Class(es)', 'shortcode-ui' ),
            'attr'   => 'xclass',
            'type'   => 'text',
            'description'  => __( 'Any extra classes you want to add', 'shortcode-ui' )
          ),
          array(
            'label' => __('Data attribute(s)'),
            'attr' => 'data',
            'type' => 'text',
            'description' => __( 'Data attribute and value pairs separated by a comma. Pairs separated by pipe', 'shortcode-ui'),
            'meta'   => array(
              'placeholder' => __( 'attribute,value|another-attr,value', 'shortcode-ui' )
            )
          )
        )
      )
    );

    /**
     * Register bootstrap's [emphasis] shortcode
     */
    shortcode_ui_register_for_shortcode( 'emphasis', 
      array(
      'label' => __( 'BS emphasis', 'shortcode-ui' ),
        'listItemImage' => '<img src="http://getbootstrap.com/apple-touch-icon.png" alt="Bootstrap">',  
        'inner_content' => array(
          'label'        => __( 'Content', 'shortcode-ui' )
        ),
        'attrs' => array(
          array(
            'label' => __( 'Type', 'shortcode-ui' ),
            'attr' => 'type',
            'type' => 'select',
            'options' => array(
              'primary' => 'primary',
              'success' => 'success',
              'info' => 'info',
              'warning' => 'warning',
              'danger' => 'danger',
              'muted' => 'muted' 
            ),
            'multiple' => false,
            'description'  => __( 'The type of emphasis to display', 'shortcode-ui' )
          ),
          array(
            'label'  => __( 'Extra Class(es)', 'shortcode-ui' ),
            'attr'   => 'xclass',
            'type'   => 'text',
            'description'  => __( 'Any extra classes you want to add', 'shortcode-ui' )
          ),
          array(
            'label' => __('Data attribute(s)'),
            'attr' => 'data',
            'type' => 'text',
            'description' => __( 'Data attribute and value pairs separated by a comma. Pairs separated by pipe', 'shortcode-ui'),
            'meta'   => array(
              'placeholder' => __( 'attribute,value|another-attr,value', 'shortcode-ui' )
            )
          )
        )
      )
    );

    /**
     * Register bootstrap's [code] shortcode
     */
    shortcode_ui_register_for_shortcode( 'code', 
      array(
      'label' => __( 'BS code', 'shortcode-ui' ),
        'listItemImage' => '<img src="http://getbootstrap.com/apple-touch-icon.png" alt="Bootstrap">',  
        'inner_content' => array(
          'label'        => __( 'Content', 'shortcode-ui' )
        ),
        'attrs' => array(
          array(
            'label' => __( 'Inline?', 'shortcode-ui' ),
            'attr' => 'inline',
            'type' => 'radio',
            'options' => array(
              '' => 'false',
              'true' => 'true'
            ),
            'description'  => __( 'Display the code inline?', 'shortcode-ui' )
          ),
          array(
            'label' => __( 'Scrollable?', 'shortcode-ui' ),
            'attr' => 'scrollable',
            'type' => 'radio',
            'options' => array(
              '' => 'false',
              'true' => 'true'
            ),
            'description'  => __( 'Set a max height of 350px and provide a scroll bar. Not usable if inline is true.', 'shortcode-ui' )
          ),
          array(
            'label'  => __( 'Extra Class(es)', 'shortcode-ui' ),
            'attr'   => 'xclass',
            'type'   => 'text',
            'description'  => __( 'Any extra classes you want to add', 'shortcode-ui' )
          ),
          array(
            'label' => __('Data attribute(s)'),
            'attr' => 'data',
            'type' => 'text',
            'description' => __( 'Data attribute and value pairs separated by a comma. Pairs separated by pipe', 'shortcode-ui'),
            'meta'   => array(
              'placeholder' => __( 'attribute,value|another-attr,value', 'shortcode-ui' )
            )
          )
        )
      )
    );

    /**
     * Register bootstrap's [button] shortcode
     */
    shortcode_ui_register_for_shortcode( 'button', 
      array(
      'label' => __( 'BS button', 'shortcode-ui' ),
        'listItemImage' => '<img src="http://getbootstrap.com/apple-touch-icon.png" alt="Bootstrap">',  
        'inner_content' => array(
          'label'        => __( 'Content', 'shortcode-ui' )
        ),
        'attrs' => array(
          array(
            'label' => __( 'Type', 'shortcode-ui' ),
            'attr' => 'type',
            'type' => 'select',
            'options' => array(
              '' => 'default',
              'primary' => 'primary',
              'success' => 'success',
              'info' => 'info',
              'warning' => 'warning',
              'danger' => 'danger',
              'link' => 'link'
            ),
            'multiple' => false,
            'description'  => __( 'The type of button to display', 'shortcode-ui' )
          ),
          array(
            'label' => __( 'Size', 'shortcode-ui' ),
            'attr' => 'size',
            'type' => 'select',
            'options' => array(
              '' => 'default',
              'xs' => 'xs',
              'sm' => 'sm',
              'lg' => 'lg'
            ),
            'multiple' => false,
            'description'  => __( 'The size of the button', 'shortcode-ui' )
          ),
          array(
            'label' => __( 'Block', 'shortcode-ui' ),
            'attr' => 'block',
            'type' => 'radio',
            'options' => array(
              '' => 'false',
              'true' => 'true'
            ),
            'description'  => __( 'Whether the button should be a block-level button', 'shortcode-ui' )
          ),
          array(
            'label' => __( 'Dropdown', 'shortcode-ui' ),
            'attr' => 'dropdown',
            'type' => 'radio',
            'options' => array(
              'false' => 'false',
              'true' => 'true'
            ),
            'description'  => __( 'Whether the button triggers a dropdown menu', 'shortcode-ui' )
          ),
          array(
            'label' => __( 'Active', 'shortcode-ui' ),
            'attr' => 'active',
            'type' => 'radio',
            'options' => array(
              '' => 'false',
              'true' => 'true'
            ),
            'description'  => __( 'Apply the "active" style', 'shortcode-ui' )
          ),
          array(
            'label' => __( 'Disabled', 'shortcode-ui' ),
            'attr' => 'disabled',
            'type' => 'radio',
            'options' => array(
              '' => 'false',
              'true' => 'true'
            ),
            'description'  => __( 'Whether the button be disabled', 'shortcode-ui' )
          ),
          array(
            'label'  => __( 'Link of the button', 'shortcode-ui' ),
            'attr'   => 'link',
            'type'   => 'text',
            'description'  => __( 'The url you want the button to link to', 'shortcode-ui' )
          ),
          array(
            'label' => __( 'Target', 'shortcode-ui' ),
            'attr' => 'target',
            'type' => 'text',
            'multiple' => false,
            'description'  => __( 'Target where the link should open', 'shortcode-ui' ),
            'meta'   => array(
              'placeholder' => __( '_blank|_self|_parent|_top|framename', 'shortcode-ui' )
            )
          ),
          array(
            'label'  => __( 'Extra Class(es)', 'shortcode-ui' ),
            'attr'   => 'xclass',
            'type'   => 'text',
            'description'  => __( 'Any extra classes you want to add', 'shortcode-ui' )
          ),
          array(
            'label' => __('Data attribute(s)'),
            'attr' => 'data',
            'type' => 'text',
            'description' => __( 'Data attribute and value pairs separated by a comma. Pairs separated by pipe', 'shortcode-ui'),
            'meta'   => array(
              'placeholder' => __( 'attribute,value|another-attr,value', 'shortcode-ui' )
            )
          )
        )
      )
    );

    /**
     * Register bootstrap's [responsive] shortcode
     */
    shortcode_ui_register_for_shortcode( 'responsive', 
      array(
      'label' => __( 'BS responsive', 'shortcode-ui' ),
        'listItemImage' => '<img src="http://getbootstrap.com/apple-touch-icon.png" alt="Bootstrap">',  
        'inner_content' => array(
          'label'        => __( 'Content', 'shortcode-ui' )
        ),
        'attrs' => array(
          array(
            'label' => __( 'Visible', 'shortcode-ui' ),
            'attr' => 'visible',
            'type' => 'text',
            'multiple' => false,
            'description'  => __( 'Sizes at which this element is visible (separated by spaces)<br>
              <strong>NOTE: as of Bootstrap 3.2 "visible" is deprecated in favor of "block", "inline", and "inline-block" (see below)</strong>', 'shortcode-ui' ),
            'meta'   => array(
              'placeholder' => __( 'xs sm md lg', 'shortcode-ui' )
            )
          ),
          array(
            'label' => __( 'Hidden', 'shortcode-ui' ),
            'attr' => 'hidden',
            'type' => 'text',
            'multiple' => false,
            'description'  => __( 'Sizes at which this element is hidden (separated by spaces)', 'shortcode-ui' ),
            'meta'   => array(
              'placeholder' => __( 'xs sm md lg', 'shortcode-ui' )
            )
          ),
          array(
            'label' => __( 'Block', 'shortcode-ui' ),
            'attr' => 'block',
            'type' => 'text',
            'multiple' => false,
            'description'  => __( 'Sizes at which this element is visible and displayed as a "block" element (separated by spaces)', 'shortcode-ui' ),
            'meta'   => array(
              'placeholder' => __( 'xs sm md lg', 'shortcode-ui' )
            )
          ),
          array(
            'label' => __( 'Inline', 'shortcode-ui' ),
            'attr' => 'inline',
            'type' => 'text',
            'multiple' => false,
            'description'  => __( 'Sizes at which this element is visible and displayed as an "inline" element (separated by spaces)', 'shortcode-ui' ),
            'meta'   => array(
              'placeholder' => __( 'xs sm md lg', 'shortcode-ui' )
            )
          ),
          array(
            'label' => __( 'Inline-block', 'shortcode-ui' ),
            'attr' => 'inline_block',
            'type' => 'text',
            'multiple' => false,
            'description'  => __( 'Sizes at which this element is visible and displayed as an "inline-block" element (separated by spaces)', 'shortcode-ui' ),
            'meta'   => array(
              'placeholder' => __( 'xs sm md lg', 'shortcode-ui' )
            )
          ),
          array(
            'label'  => __( 'Extra Class(es)', 'shortcode-ui' ),
            'attr'   => 'xclass',
            'type'   => 'text',
            'description'  => __( 'Any extra classes you want to add', 'shortcode-ui' )
          ),
          array(
            'label' => __('Data attribute(s)'),
            'attr' => 'data',
            'type' => 'text',
            'description' => __( 'Data attribute and value pairs separated by a comma. Pairs separated by pipe', 'shortcode-ui'),
            'meta'   => array(
              'placeholder' => __( 'attribute,value|another-attr,value', 'shortcode-ui' )
            )
          )
        )
      )
    );

    /**
     * Register bootstrap's [icon] shortcode
     */
    shortcode_ui_register_for_shortcode( 'icon', 
      array(
      'label' => __( 'BS glyphicon', 'shortcode-ui' ),
        'listItemImage' => '<img src="http://getbootstrap.com/apple-touch-icon.png" alt="Bootstrap">',  
        'inner_content' => array(
          'label'        => __( 'Content', 'shortcode-ui' )
        ),
        'attrs' => array(
          array(
            'label'  => __( 'Type', 'shortcode-ui' ),
            'attr'   => 'type',
            'type'   => 'text',
            'description'  => __( 'See <a href="http://getbootstrap.com/components/#glyphicons-glyphs" target="_blank">Bootstrap docs</a>.', 'shortcode-ui' ),
            'meta'   => array(
              'placeholder' => __( 'glyphicon-star', 'shortcode-ui' )
            )
          ),
          array(
            'label'  => __( 'Extra Class(es)', 'shortcode-ui' ),
            'attr'   => 'xclass',
            'type'   => 'text',
            'description'  => __( 'Any extra classes you want to add', 'shortcode-ui' )
          ),
          array(
            'label' => __('Data attribute(s)'),
            'attr' => 'data',
            'type' => 'text',
            'description' => __( 'Data attribute and value pairs separated by a comma. Pairs separated by pipe', 'shortcode-ui'),
            'meta'   => array(
              'placeholder' => __( 'attribute,value|another-attr,value', 'shortcode-ui' )
            )
          )
        )
      )
    );

    /**
     * Register bootstrap's [label] shortcode
     */
    shortcode_ui_register_for_shortcode( 'label', 
      array(
      'label' => __( 'BS label', 'shortcode-ui' ),
        'listItemImage' => '<img src="http://getbootstrap.com/apple-touch-icon.png" alt="Bootstrap">',  
        'inner_content' => array(
          'label'        => __( 'Content', 'shortcode-ui' )
        ),
        'attrs' => array(
          array(
            'label' => __( 'Type', 'shortcode-ui' ),
            'attr' => 'type',
            'type' => 'select',
            'options' => array(
              '' => 'default',
              'primary' => 'primary',
              'success' => 'success',
              'info' => 'info',
              'warning' => 'warning',
              'danger' => 'danger'
            ),
            'multiple' => false,
            'description'  => __( 'The type of label to display', 'shortcode-ui' )
          ),
          array(
            'label'  => __( 'Extra Class(es)', 'shortcode-ui' ),
            'attr'   => 'xclass',
            'type'   => 'text',
            'description'  => __( 'Any extra classes you want to add', 'shortcode-ui' )
          ),
          array(
            'label' => __('Data attribute(s)'),
            'attr' => 'data',
            'type' => 'text',
            'description' => __( 'Data attribute and value pairs separated by a comma. Pairs separated by pipe', 'shortcode-ui'),
            'meta'   => array(
              'placeholder' => __( 'attribute,value|another-attr,value', 'shortcode-ui' )
            )
          )
        )
      )
    );

    /**
     * Register bootstrap's [badge] shortcode
     */
    shortcode_ui_register_for_shortcode( 'badge', 
      array(
      'label' => __( 'BS badge', 'shortcode-ui' ),
        'listItemImage' => '<img src="http://getbootstrap.com/apple-touch-icon.png" alt="Bootstrap">',  
        'inner_content' => array(
          'label'        => __( 'Content', 'shortcode-ui' )
        ),
        'attrs' => array(
          array(
            'label' => __( 'Right', 'shortcode-ui' ),
            'attr' => 'right',
            'type' => 'radio',
            'options' => array(
              '' => 'false',
              'true' => 'true'
            ),
            'description'  => __( 'Whether the badge should align to the right of its container', 'shortcode-ui' )
          ),
          array(
            'label'  => __( 'Extra Class(es)', 'shortcode-ui' ),
            'attr'   => 'xclass',
            'type'   => 'text',
            'description'  => __( 'Any extra classes you want to add', 'shortcode-ui' )
          ),
          array(
            'label' => __('Data attribute(s)'),
            'attr' => 'data',
            'type' => 'text',
            'description' => __( 'Data attribute and value pairs separated by a comma. Pairs separated by pipe', 'shortcode-ui'),
            'meta'   => array(
              'placeholder' => __( 'attribute,value|another-attr,value', 'shortcode-ui' )
            )
          )
        )
      )
    );

    /**
     * Register bootstrap's [jumbotron] shortcode
     */
    shortcode_ui_register_for_shortcode( 'jumbotron', 
      array(
      'label' => __( 'BS jumbotron', 'shortcode-ui' ),
        'listItemImage' => '<img src="http://getbootstrap.com/apple-touch-icon.png" alt="Bootstrap">',  
        'inner_content' => array(
          'label'        => __( 'Content', 'shortcode-ui' ),
          'description'  => __( '<a href="http://getbootstrap.com/components/#jumbotron" target="_blank">Bootstrap jumbotron documentation</a>', 'shortcode-ui' )
        ),
        'attrs' => array(
          array(
            'label'  => __( 'Title', 'shortcode-ui' ),
            'attr'   => 'title',
            'type'   => 'text',
            'description'  => __( 'The jumbotron title', 'shortcode-ui' )
          ),
          array(
            'label'  => __( 'Extra Class(es)', 'shortcode-ui' ),
            'attr'   => 'xclass',
            'type'   => 'text',
            'description'  => __( 'Any extra classes you want to add', 'shortcode-ui' )
          ),
          array(
            'label' => __('Data attribute(s)'),
            'attr' => 'data',
            'type' => 'text',
            'description' => __( 'Data attribute and value pairs separated by a comma. Pairs separated by pipe', 'shortcode-ui'),
            'meta'   => array(
              'placeholder' => __( 'attribute,value|another-attr,value', 'shortcode-ui' )
            )
          )
        )
      )
    );

    /**
     * Register bootstrap's [page-header] shortcode
     */
    shortcode_ui_register_for_shortcode( 'page-header', 
      array(
      'label' => __( 'BS page-header', 'shortcode-ui' ),
        'listItemImage' => '<img src="http://getbootstrap.com/apple-touch-icon.png" alt="Bootstrap">',  
        'inner_content' => array(
          'label'        => __( 'Content', 'shortcode-ui' ),
          'description'  => __( 'Automatically inserts H1 tag if not present', 'shortcode-ui' )
        ),
        'attrs' => array(
          array(
            'label'  => __( 'Extra Class(es)', 'shortcode-ui' ),
            'attr'   => 'xclass',
            'type'   => 'text',
            'description'  => __( 'Any extra classes you want to add', 'shortcode-ui' )
          ),
          array(
            'label' => __('Data attribute(s)'),
            'attr' => 'data',
            'type' => 'text',
            'description' => __( 'Data attribute and value pairs separated by a comma. Pairs separated by pipe', 'shortcode-ui'),
            'meta'   => array(
              'placeholder' => __( 'attribute,value|another-attr,value', 'shortcode-ui' )
            )
          )
        )
      )
    );

    /**
     * Register bootstrap's [alert] shortcode
     */
    shortcode_ui_register_for_shortcode( 'alert', 
      array(
      'label' => __( 'BS alert', 'shortcode-ui' ),
        'listItemImage' => '<img src="http://getbootstrap.com/apple-touch-icon.png" alt="Bootstrap">',  
        'inner_content' => array(
          'label'        => __( 'Content', 'shortcode-ui' )
        ),
        'attrs' => array(
          array(
            'label' => __( 'Type', 'shortcode-ui' ),
            'attr' => 'type',
            'type' => 'select',
            'options' => array(
              'primary' => 'primary',
              'success' => 'success',
              'info' => 'info',
              'warning' => 'warning',
              'danger' => 'danger'
            ),
            'multiple' => false,
            'description'  => __( 'The type of the alert', 'shortcode-ui' )
          ),
          array(
            'label' => __( 'Dismissable', 'shortcode-ui' ),
            'attr' => 'dismissable',
            'type' => 'radio',
            'options' => array(
              '' => 'false',
              'true' => 'true'
            ),
            'description'  => __( 'If the alert should be dismissable', 'shortcode-ui' )
          ),
          array(
            'label'  => __( 'Extra Class(es)', 'shortcode-ui' ),
            'attr'   => 'xclass',
            'type'   => 'text',
            'description'  => __( 'Any extra classes you want to add', 'shortcode-ui' )
          ),
          array(
            'label' => __('Data attribute(s)'),
            'attr' => 'data',
            'type' => 'text',
            'description' => __( 'Data attribute and value pairs separated by a comma. Pairs separated by pipe', 'shortcode-ui'),
            'meta'   => array(
              'placeholder' => __( 'attribute,value|another-attr,value', 'shortcode-ui' )
            )
          )
        )
      )
    );

    /**
     * Register bootstrap's [panel] shortcode
     */
    shortcode_ui_register_for_shortcode( 'panel', 
      array(
      'label' => __( 'BS panel', 'shortcode-ui' ),
        'listItemImage' => '<img src="http://getbootstrap.com/apple-touch-icon.png" alt="Bootstrap">',  
        'inner_content' => array(
          'label'        => __( 'Content', 'shortcode-ui' )
        ),
        'attrs' => array(
          array(
            'label' => __( 'Type', 'shortcode-ui' ),
            'attr' => 'type',
            'type' => 'select',
            'options' => array(
              '' => 'default',
              'primary' => 'primary',
              'success' => 'success',
              'info' => 'info',
              'warning' => 'warning',
              'danger' => 'danger'
            ),
            'multiple' => false,
            'description'  => __( 'The type of the panel', 'shortcode-ui' )
          ),
          array(
            'label'  => __( 'Heading', 'shortcode-ui' ),
            'attr'   => 'heading',
            'type'   => 'text',
            'description'  => __( 'The panel heading', 'shortcode-ui' )
          ),
          array(
            'label' => __( 'Title', 'shortcode-ui' ),
            'attr' => 'title',
            'type' => 'radio',
            'options' => array(
              '' => 'false',
              'true' => 'true'
            ),
            'description'  => __( 'Whether the panel heading should have a title tag around it', 'shortcode-ui' )
          ),
          array(
            'label'  => __( 'Footer', 'shortcode-ui' ),
            'attr'   => 'footer',
            'type'   => 'text',
            'description'  => __( 'The panel footer text if desired ', 'shortcode-ui' )
          ),
          array(
            'label'  => __( 'Extra Class(es)', 'shortcode-ui' ),
            'attr'   => 'xclass',
            'type'   => 'text',
            'description'  => __( 'Any extra classes you want to add', 'shortcode-ui' )
          ),
          array(
            'label' => __('Data attribute(s)'),
            'attr' => 'data',
            'type' => 'text',
            'description' => __( 'Data attribute and value pairs separated by a comma. Pairs separated by pipe', 'shortcode-ui'),
            'meta'   => array(
              'placeholder' => __( 'attribute,value|another-attr,value', 'shortcode-ui' )
            )
          )
        )
      )
    );

    /**
     * Register bootstrap's [well] shortcode
     */
    shortcode_ui_register_for_shortcode( 'well', 
      array(
      'label' => __( 'BS well', 'shortcode-ui' ),
        'listItemImage' => '<img src="http://getbootstrap.com/apple-touch-icon.png" alt="Bootstrap">',  
        'inner_content' => array(
          'label'        => __( 'Content', 'shortcode-ui' )
        ),
        'attrs' => array(
          array(
            'label' => __( 'Size', 'shortcode-ui' ),
            'attr' => 'size',
            'type' => 'select',
            'options' => array(
              '' => 'normal',
              'sm' => 'sm',
              'lg' => 'lg'
            ),
            'multiple' => false,
            'description'  => __( 'Modifies the amount of padding inside the well', 'shortcode-ui' )
          ),
          array(
            'label'  => __( 'Extra Class(es)', 'shortcode-ui' ),
            'attr'   => 'xclass',
            'type'   => 'text',
            'description'  => __( 'Any extra classes you want to add', 'shortcode-ui' )
          ),
          array(
            'label' => __('Data attribute(s)'),
            'attr' => 'data',
            'type' => 'text',
            'description' => __( 'Data attribute and value pairs separated by a comma. Pairs separated by pipe', 'shortcode-ui'),
            'meta'   => array(
              'placeholder' => __( 'attribute,value|another-attr,value', 'shortcode-ui' )
            )
          )
        )
      )
    );

    /**
     * Register bootstrap's [tooltip] shortcode
     */
    shortcode_ui_register_for_shortcode( 'tooltip', 
      array(
      'label' => __( 'BS tooltip', 'shortcode-ui' ),
        'listItemImage' => '<img src="http://getbootstrap.com/apple-touch-icon.png" alt="Bootstrap">',  
        'inner_content' => array(
          'label'        => __( 'Content', 'shortcode-ui' )
        ),
        'attrs' => array(
          array(
            'label' => __( 'Title', 'shortcode-ui' ),
            'attr' => 'title',
            'type' => 'text',
            'description'  => __( 'The text of the tooltip', 'shortcode-ui' )
          ),
          array(
            'label' => __( 'Placement', 'shortcode-ui' ),
            'attr' => 'placement',
            'type' => 'select',
            'options' => array(
              'left' => 'left', 
              '' => 'top', 
              'bottom' => 'bottom', 
              'right' => 'right'
            ),
            'multiple' => false,
            'description'  => __( 'The placement of the tooltip', 'shortcode-ui' )
          ),
          array(
            'label' => __( 'Animation', 'shortcode-ui' ),
            'attr' => 'animation',
            'type' => 'text',
            'description'  => __( 'Apply a CSS fade transition to the tooltip', 'shortcode-ui' )
          ),
          array(
            'label' => __( 'Html', 'shortcode-ui' ),
            'attr' => 'html',
            'type' => 'radio',
            'options' => array(
              '' => 'false',
              'true' => 'true'
            ),
            'description'  => __( 'Insert HTML into the tooltip', 'shortcode-ui' )
          )
        )
      )
    );

    /**
     * Register bootstrap's [popover] shortcode
     */
    shortcode_ui_register_for_shortcode( 'popover', 
      array(
      'label' => __( 'BS popover', 'shortcode-ui' ),
        'listItemImage' => '<img src="http://getbootstrap.com/apple-touch-icon.png" alt="Bootstrap">',  
        'inner_content' => array(
          'label'        => __( 'Content', 'shortcode-ui' )
        ),
        'attrs' => array(
          array(
            'label' => __( 'Title', 'shortcode-ui' ),
            'attr' => 'title',
            'type' => 'text',
            'description'  => __( 'The title of the popover', 'shortcode-ui' )
          ),
          array(
            'label' => __( 'Text', 'shortcode-ui' ),
            'attr' => 'text',
            'type' => 'text',
            'description'  => __( 'The text of the popover', 'shortcode-ui' )
          ),
          array(
            'label' => __( 'Placement', 'shortcode-ui' ),
            'attr' => 'placement',
            'type' => 'select',
            'options' => array(
              'left' => 'left', 
              '' => 'top', 
              'bottom' => 'bottom', 
              'right' => 'right'
            ),
            'multiple' => false,
            'description'  => __( 'The placement of the popover', 'shortcode-ui' )
          ),
          array(
            'label' => __( 'Animation', 'shortcode-ui' ),
            'attr' => 'animation',
            'type' => 'text',
            'description'  => __( 'Apply a CSS fade transition to the popover', 'shortcode-ui' )
          ),
          array(
            'label' => __( 'Html', 'shortcode-ui' ),
            'attr' => 'html',
            'type' => 'radio',
            'options' => array(
              '' => 'false',
              'true' => 'true'
            ),
            'description'  => __( 'Insert HTML into the popover', 'shortcode-ui' )
          )
        )
      )
    );

    /**
     * Register bootstrap's [table-wrap] shortcode
     */
    shortcode_ui_register_for_shortcode( 'table-wrap', 
      array(
      'label' => __( 'BS table-wrap', 'shortcode-ui' ),
        'listItemImage' => '<img src="http://getbootstrap.com/apple-touch-icon.png" alt="Bootstrap">',  
        'inner_content' => array(
          'label'        => __( 'Content', 'shortcode-ui' ),
          'description'  => esc_html__( 'Standard HTML table code goes here. Including opening (<table>) and closing (</table>) tags.', 'shortcode-ui' ),
          'meta'   => array(
            'placeholder' => $tableMarkup
          )
        ),
        'attrs' => array(
          array(
            'label' => __( 'Bordered', 'shortcode-ui' ),
            'attr' => 'bordered',
            'type' => 'radio',
            'options' => array(
              '' => 'false',
              'true' => 'true'
            ),
            'description'  => __( 'Set "bordered" table style (see Bootstrap documentation)', 'shortcode-ui' )
          ),
          array(
            'label' => __( 'Striped', 'shortcode-ui' ),
            'attr' => 'striped',
            'type' => 'radio',
            'options' => array(
              '' => 'false',
              'true' => 'true'
            ),
            'description'  => __( 'Set "striped" table style (see Bootstrap documentation)', 'shortcode-ui' )
          ),
          array(
            'label' => __( 'Hover', 'shortcode-ui' ),
            'attr' => 'hover',
            'type' => 'radio',
            'options' => array(
              '' => 'false',
              'true' => 'true'
            ),
            'description'  => __( 'Set "hover" table style (see Bootstrap documentation)', 'shortcode-ui' )
          ),
          array(
            'label' => __( 'Condensed', 'shortcode-ui' ),
            'attr' => 'condensed',
            'type' => 'radio',
            'options' => array(
              '' => 'false',
              'true' => 'true'
            ),
            'description'  => __( 'Set "condensed" table style (see Bootstrap documentation)', 'shortcode-ui' )
          ),
          array(
            'label' => __( 'Responsive', 'shortcode-ui' ),
            'attr' => 'responsive',
            'type' => 'radio',
            'options' => array(
              '' => 'false',
              'true' => 'true'
            ),
            'description'  => __( 'Wrap the table in a div with the class "table-responsive" (see Bootstrap documentation)', 'shortcode-ui' )
          ),
          array(
            'label'  => __( 'Extra Class(es)', 'shortcode-ui' ),
            'attr'   => 'xclass',
            'type'   => 'text',
            'description'  => __( 'Any extra classes you want to add', 'shortcode-ui' )
          ),
          array(
            'label' => __('Data attribute(s)'),
            'attr' => 'data',
            'type' => 'text',
            'description' => __( 'Data attribute and value pairs separated by a comma. Pairs separated by pipe', 'shortcode-ui'),
            'meta'   => array(
              'placeholder' => __( 'attribute,value|another-attr,value', 'shortcode-ui' )
            )
          )
        )
      )
    );

  endif;
}

/**
 * Render the shortcode based on supplied attributes
 */
function shortcode_ui_dev_shortcode( $attr, $content = '' ) {

  $attr = shortcode_atts( array(
    'source'     => '',
    'attachment' => 0,
    'source'     => null,
  ), $attr );

  ob_start();

  ?>

  <section class="pullquote" style="padding: 20px; background: rgba(0,0,0,0.1);">
    <p style="margin:0; padding: 0;">
    <b>Content:</b> <?php echo wpautop( wp_kses_post( $content ) ); ?></br>
    <b>Source:</b> <?php echo wp_kses_post( $attr[ 'source' ] ); ?></br>
    <b>Image:</b> <?php echo wp_kses_post( wp_get_attachment_image( $attr[ 'attachment' ], array( 50, 50 ) ) ); ?></br>
    </p>
  </section>

  <?php

  return ob_get_clean();

}

/**
 * Register the shortcodes independently of their UI.
 * Shortcodes should always be registered, but shortcode UI should only
 * be registered when Shortcake is active.
 */
function shortcode_ui_dev_register_shortcodes() {
  // This is a simple example for a pullquote with a citation.
  add_shortcode( 'shortcake_dev', 'shortcode_ui_dev_shortcode' );
}