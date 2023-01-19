<?php

namespace RtClass\Service;

class RTClass_Post
{

	const METAKEY_CONTRIBUTTORS = 'rtclass_contributors';

	/**
	 *
	 */
	public function set_contributors($post_id, $contributors)
	{
		if( 'post' !== get_post_type( $post_id ) ) {
			return false;
		}
		if( empty( $contributors ) ) {
			return delete_post_meta( $post_id, self::METAKEY_CONTRIBUTTORS );
		}
		return update_post_meta( $post_id, self::METAKEY_CONTRIBUTTORS, $contributors, true );
	}

	/**
	 *
	 */
	public function get_contributors($post_id)
	{
		return get_post_meta($post_id, self::METAKEY_CONTRIBUTTORS);
	}

	/**
	 *
	 */
	public function is_contributor_by_user_id($post_id, $user_id)
	{
		$contributors = $this->get_contributors($post_id);
		if(empty($contributors)) {
			return false;
		}
		return in_array($user_id, $contributors[0]);
	}
}
