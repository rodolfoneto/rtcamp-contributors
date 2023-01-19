<?php

namespace RtClass;

use RtClass\Partials\RtClass_Contributor_List;
use RtClass\Service\RTClass_Post;
use WP_User;

class RtClass_Metabox
{
	protected $rt_contributors;

	public function __construct( $static = false )
	{
		if($static) {
			add_filter( 'the_content', [$this, 'rtclass_content'] );
		}
		$this->rt_contributors = new RTClass_Post();
	}

	public function rtclass_content( $content ) {
		if ( is_admin() || wp_doing_ajax() ) {
			return $content;
		}
		global $post;
		$c = $this->rt_contributors->get_contributors( $post->ID );
		$r = (new RtClass_Contributor_List($c))->show_items();
		// $r = '';
		// foreach( $c[0] as $a ) {
			// $user = new \WP_User( $a );
			// $email = $user->email;
			// $avatar = get_avatar( $email );
			// $r .= '<li>' . $avatar . $user->display_name . '</il>';
		// }
		// $r = '<ul>' . $r . '</ul>';
		return $content . $r;
	}
}
