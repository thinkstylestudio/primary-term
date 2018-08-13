<?php

namespace Tenup\Frontend;

use WP_Error;
use WP_Post;

require_once __DIR__ . '/../helpers.php';

/**
 * Class PrimaryTerm
 */
class PrimaryTerm {

	protected $post_id;
	protected $taxonomy_name;

	/**
	 * PrimaryTerm constructor.
	 */
	public function __construct() {
		$this->setPostId( (int) $_GET['post'] );
		$this->setTaxonomyName( 'category' );

	}

	/**
	 *  Call to register front end filters
	 */
	public function init(): void {
		add_filter( 'post_link_category', [ $this, 'change_primary_category_post_link' ], 10, 3 );
		add_filter( 'get_the_terms', [ $this, 'show_primary_term_first' ], 10, 3 );
	}

	/**
	 * Filter the list of terms for a post and show the primary term first.
	 *
	 * @param array  $taxonomy_terms List of attached terms.
	 * @param int    $post_id        Post ID.
	 * @param string $taxonomy       Name of the taxonomy.
	 *
	 * @return mixed
	 */
	public function show_primary_term_first( $taxonomy_terms, $post_id, $taxonomy ) {

		// is the taxonomy aloud to have a primary terms? "thou shalt not pass"
		if ( $this->getTaxonomyName() !== $taxonomy ) {
			return $taxonomy_terms;
		}

		// no terms? "thou shalt not pass"
		if ( empty( $taxonomy_terms ) ) {
			return $taxonomy_terms;
		}

		$current_term_id = $this->get_primary_term();

		$primary_term = [];
		$other_terms  = [];
		foreach ( $taxonomy_terms as $term ) {
			if ( (int) $current_term_id === (int) $term->term_id ) {
				$primary_term[] = $term;
			} else {
				$other_terms[] = $term;
			}
		}
		// check if there is a primary term. If none return the unmodified terms.
		if ( empty( $primary_term ) ) {
			return $taxonomy_terms;
		}

		// Hulk smash primary /w all other terms together in the correct order.
		return array_merge( $primary_term, $other_terms );

	}

	/**
	 * Get the Taxonomy Name.
	 * @return mixed
	 */
	public function getTaxonomyName() {
		return $this->taxonomy_name;
	}

	/**
	 * Set the Taxonomy Name
	 *
	 * @param mixed $taxonomy_name
	 */
	public function setTaxonomyName( $taxonomy_name ): void {
		$this->taxonomy_name = $taxonomy_name;
	}

	/**
	 * Retrieve primary term that is attached to the current post.
	 * Returns the primary term ID
	 * @return int|bool
	 */
	public function get_primary_term() {
		$primary_term = get_post_meta( $this->getPostId(), PRIMARY_TERM, true );

		$terms = wp_get_object_terms( $this->getPostId(), $this->getTaxonomyName() );

		if ( ! \is_array( $terms ) ) {
			$terms = [];
		}

		if ( ! \in_array( $primary_term, wp_list_pluck( $terms, 'term_id' ) ) ) {
			$primary_term = false;
		}

		$primary_term = (int) $primary_term;

		return $primary_term ? $primary_term : false;
	}

	/**
	 * Get the Post Id.
	 * @return mixed
	 */
	public function getPostId() {
		return $this->post_id;
	}

	/*
	 * from https://github.com/Yoast/wordpress-seo/ with some adjustments made.
	 * */

	/**
	 * Set the Post Id.
	 *
	 * @param mixed $post_id
	 */
	public function setPostId( $post_id ): void {
		$this->post_id = $post_id;
	}

	/**
	 * Filters change_primary_category_post_link to change the category to the chosen primary category
	 *
	 * @param stdClass $category   The category that is now used for the post link.
	 * @param array    $categories This parameter is not used.
	 * @param WP_Post  $post       The post in question.
	 *
	 * @return array|null|object|WP_Error The category we want to use for the post link.
	 */
	public function change_primary_category_post_link( $category, $categories = null, $post = null ) {
		$post = get_post( $post );

		$primary_category = $this->get_primary_category( $post );

		if ( $primary_category !== false && $primary_category !== $category->cat_ID ) {
			$category = get_category( $primary_category );
		}

		return $category;
	}

	/**
	 * Get the id of the primary category.
	 *
	 * @param WP_Post $post The post in question.
	 *
	 * @return int Primary category id.
	 */
	protected function get_primary_category( $post = null ) {

		if ( $post === null ) {
			return false;
		}

		return $this->get_primary_term();
	}

}
