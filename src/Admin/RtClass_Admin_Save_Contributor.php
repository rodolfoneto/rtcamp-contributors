<?php

namespace RtClass\Admin;

use RtClass\Service\{ RTClass_User, RTClass_Post };

class RtClass_Admin_Save_Contributor
{

	public function __construct( $static = false )
	{
		if($static) {
			add_action( 'save_post', [$this, 'rtclass_save_data'], 10, 2 );
		}
	}

	public function rtclass_save_data($post_id, $post)
	{
		if ( 'post' !== $post->post_type ) {
			return;
		}
		if ( wp_is_post_autosave( $post_id ) || wp_is_post_revision( $post_id ) ) {
			return;
		}

		$contributors = filter_input(INPUT_POST, 'contributors', FILTER_VALIDATE_INT, FILTER_REQUIRE_ARRAY);
		$rtclass_post = new RTClass_Post();
		if(!empty($contributors)) {
			$rtclass_post->set_contributors($post_id, $contributors);
		} else {
			$rtclass_post->set_contributors($post_id, null);
		}
		return $post_id;
	}
}
