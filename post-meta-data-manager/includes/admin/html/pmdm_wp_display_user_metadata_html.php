<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * User metabox html
 *
 *
 * @package Post Meta Data Manager
 * @since 1.0.2
 */
?><div id="pmdm_wp_user_metabox" class="postbox user_custom_metabox">
    <input type="hidden" id="user_ID" value="<?php echo $user->ID; ?>">
    <div class="postbox-header">
        <h2 class="hndle ui-sortable-handle"><?php echo esc_html__( 'User Metadata Manager', 'pmdm_wp' ); ?></h2>
    </div>

    <div class="inside">

        <table id="pmdm_wp_user_table" class="display" style="width:100%">
            <thead>
                <tr>
                    <th><?php echo esc_html__( 'Key', 'pmdm_wp' ); ?></th>
                    <th><?php echo esc_html__( 'Value', 'pmdm_wp' ); ?></th>
                    <th><?php echo esc_html__( 'Action', 'pmdm_wp' ); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    
                foreach( $user_meta as $meta_key => $value ) {

                        if ( is_array( $value ) ) {	// Check if Array

                            foreach ( $value as $num => $el ) {

                                $value[ $num ] = maybe_unserialize( $el );
                            }
                        }else{
                            $value = $value;
                        }

                        $is_added = isset( $user_meta[ $meta_key ] ) ? false : true;

                        ?>
                            <tr>
                                <td><?php echo esc_html( $meta_key ); ?></td>
                                <td><?php echo esc_html( var_export( $value, true ) ); ?></td>
                                <td>
									<a href="javascript:;" data-id="<?php echo esc_html( $meta_key ); ?>" id="edit-<?php echo esc_html( $meta_key ); ?>" class="edit-meta"><?php echo esc_html__( 'Edit', 'pmdm_wp' ); ?></a> 

									<div id="user_model_window_<?php echo esc_html( $meta_key ); ?>" class="modal-window">
                                        <div>
                                            <a href="javascript:;" title="Close" class="modal-close">x</a>
											<h1><strong><?php echo esc_html__( 'Currently you are editing', 'pmdm_wp' ); ?></strong>: <?php echo esc_html( $meta_key ); ?></h1>
                                            <div class="model-body">
                                                <form method="post" action="">
                                                <?php wp_nonce_field( 'change_user_meta_action', 'change_user_meta_field' ); ?>

                                                <?php 
                                                    $get_meta_field_values = get_user_meta($user->ID, $meta_key, true);
                                                    if(is_array($get_meta_field_values)){
                                                        
                                                        $this->pmdm_wp_get_recursively_inputs($meta_key, $get_meta_field_values);
                                                        
                                                    }else{
                                                        if (is_string($get_meta_field_values)) {
                                                        $get_meta_field_values_len = strlen($get_meta_field_values);
                                                        ?>
                                                            <div class="input_wrapper">
                                                                <p class="display_label_key">Key: <strong><?php echo esc_html($meta_key); ?></strong></p>

                                                                <?php if($get_meta_field_values_len > 20) { ?>
                                                                    <textarea name="<?php echo esc_html($meta_key); ?>" rows="10"><?php echo htmlspecialchars($get_meta_field_values, ENT_QUOTES); ?></textarea>
                                                                <?php } else { ?>
                                                                    <input type="text" name="<?php echo esc_html($meta_key); ?>" class="input_box" value="<?php echo htmlspecialchars($get_meta_field_values, ENT_QUOTES); ?>" />
                                                            <?php } ?> 

                                                            </div>
                                                        <?php
                                                        }
                                                    }
                                                ?>
                                                    <input type="hidden" value="<?php echo esc_html($user->ID); ?>" name="current_user_id" />
                                                    <input type="hidden" value="<?php echo esc_html( $meta_key ); ?>" name="changed_keys" id="changed_keys" />
                                                    <input type="submit" value="<?php echo esc_html__( 'Change', 'pmdm_wp' ); ?>" class="change_btn" />

                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    | 
									<a href="javascript:;" data-id="<?php echo esc_html( $meta_key ); ?>"  id="delete-<?php echo esc_html( $meta_key ); ?>" class="delete-meta"><?php echo esc_html__( 'Delete', 'pmdm_wp' ); ?></a>
                                </td>
                            </tr>


                <?php

                }


                ?>

            </tbody>
        </table>
    
    </div>
</div>
