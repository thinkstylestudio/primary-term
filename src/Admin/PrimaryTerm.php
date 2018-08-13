<?php

namespace Tenup\Admin;

use WP_Post;

require_once __DIR__ . '/../helpers.php';

/**
 * Class PrimaryTerm
 */
class PrimaryTerm {

	/**
	 *   Register/Add the Select Primary Category Meta Box
	 */
	public function register_meta_boxes() {

		add_meta_box( 'display_meta_box_callback', 'Select Primary Category', [
			$this,
			'display_meta_box_callback',
		], 'post', 'side', 'default' );
	}

	/**
	 * Meta box display callback.
	 *
	 * @param WP_Post $post Current post object.
	 */
	public function display_meta_box_callback( $post ) {
		global $post;
		// Nonce field to validate form request came from current site
		wp_nonce_field( basename( __FILE__ ), 'primary_term_nonce' );
		// Get the location data if it's already been entered
		$location = get_post_meta( $post->ID, PRIMARY_TERM, true );
		// get categories currently attached to post
		$categories = get_the_category( $post->ID );

		?>
        <p>
            <label for="<?php echo PRIMARY_TERM ?>"><?php esc_attr_e( 'Primary Category Term:', 'tenup' ); ?></label>
            <select id="<?php echo PRIMARY_TERM ?>" name="<?php echo PRIMARY_TERM ?>">
                <option value=""><?php esc_html_e( '&ndash; Select  &ndash;', 'tenup' ); ?></option>
	            <?php foreach ( $categories as $selectItem ) { ?>
                    <option
                            value="<?php echo esc_attr( $selectItem->term_id ); ?>" <?php selected( $location,
	                    $selectItem->term_id, true ); ?>>
	                    <?php esc_html_e( $selectItem->name, 'tenup' ); ?>
                    </option>
	            <?php } ?>

            </select>
        </p>
		<?php
	}

	/**
	 * Save meta box content.
	 *
	 * @param int $post_id Post ID
	 *
	 * @return int|void Post ID
	 */
	public function save_meta_box( $post_id ) {
		$nonce_name   = $_POST['primary_term_nonce'] ?? '';
		$nonce_action = basename( __FILE__ );

		// Return if the user doesn't have edit permissions.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		// Check if nonce is set.
		if ( ! isset( $nonce_name ) ) {
			return $post_id;
		}

		// Check if nonce is valid.
		if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
			return $post_id;
		}

		// Check if not an autosave.
		if ( wp_is_post_autosave( $post_id ) ) {
			return;
		}

		// Check if not a revision.
		if ( wp_is_post_revision( $post_id ) ) {
			return;
		}

		// authentication done, time to save stuff.

		// This sanitizes the data from the field and saves it into an array $primary.
		/** @var array $meta */
		$meta[ PRIMARY_TERM ] = esc_textarea( $_POST[ PRIMARY_TERM ] );

		// Cycle through the $primary array.
		foreach ( $meta as $key => $value ) {

			if ( get_post_meta( $post_id, $key, false ) ) {
				// has a value already? update it.
				update_post_meta( $post_id, $key, $value );
			} else {
				// no value exists. create one.
				add_post_meta( $post_id, $key, $value );
				//wp_set_post_terms($post_id, $current_category, 'category', true);
			}
			if ( ! $value ) {
				// delete if no value exists
				delete_post_meta( $post_id, $key );
			}
		}
	}

	/**
	 *  register actions that will add the meta box, add the ability to save, and enqueue the necessary JS.
	 */
	public function initialize_meta_box(): void {
		add_action( 'add_meta_boxes', [
			$this,
			'register_meta_boxes',
		] );
		add_action( 'save_post', [
			$this,
			'save_meta_box',
		] );
		add_action( 'admin_print_scripts', [
			$this,
			'enqueue_primary_term_scripts',
		] );

	}

	/**
	 *  register registration function so it only fires on load-post and load-post-new pages
	 */
	public function init(): void {
		if ( is_admin() ) {
			// Call init of box on load post page and ne post pages only.
			add_action( 'load-post.php', [ $this, 'initialize_meta_box' ] );
			add_action( 'load-post-new.php', [ $this, 'initialize_meta_box' ] );
		}
	}

	/**
	 *  enqueue necessary JS scripts
	 */
	public function enqueue_primary_term_scripts() {

		wp_enqueue_script( 'primary_term', plugins_url() . '/' . PLUGIN_DIRECTORY_NAME . '/assets/js/primary_term.js',
			[ 'jquery' ], '1.0' );

	}

}
