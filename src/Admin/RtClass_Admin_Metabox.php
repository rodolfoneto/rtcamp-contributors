<?php

namespace RtClass\Admin;

use RtClass\Service\{ RTClass_User, RTClass_Post };

class RtClass_Admin_Metabox
{

	public function __construct( $static = false )
	{
		if($static) {
			add_action( 'add_meta_boxes', [$this, 'rtclass_add_metabox'] );
		}
	}

	public function rtclass_add_metabox()
	{
		add_meta_box( 'rtclass_contributors_populate', __('Contributors'), [$this, 'rt_box_populate_callback'], 'post', 'side' );
	}

	public function rt_box_populate_callback( $post )
	{
		$rt_user = new RTClass_User();
		$rt_post = new RTClass_Post();
		$users = $rt_user->get_all_contributors();
		ob_start();
		foreach($users as $user) :
			$checked = $rt_post->is_contributor_by_user_id($post->ID, $user->ID) ? 'checked=""' : '';
		?>
			<div class="components-base-control__field">
				<input id="colaborator-<?= $user->ID; ?>" type="checkbox" value="<?= $user->ID; ?>" name="contributors[]" <?= $checked; ?>>
				<label for="colaborator-<?= $user->ID; ?>"><?= $user->display_name; ?></label>
			</div>
		<?php
		endforeach;

		ob_get_flush();
	}
}
