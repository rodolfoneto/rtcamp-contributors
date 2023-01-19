<?php

namespace RtClass\Partials;

/**
 * Class to Create a list os the contributors
 */

class RtClass_Contributor_List
{

	protected $contributers_ids_list;
	protected $itens_list;

	/**
	 * @param array
	 */
	public function __construct($contributers_list)
	{
		$this->contributers_ids_list = $contributers_list[0] ?? [];
		$this->mount_items();
	}

	/**
	 *	Montu the itens
	 */
	protected function mount_items()
	{
		$itens_list = [];
		foreach($this->contributers_ids_list as $item) {
			$user = new \WP_User($item);
			if($user->exists()) {
				$itens_list[] = [
					'id' => $user->ID,
					'display_name' => $user->display_name,
					'avatar' => get_avatar($user->ID, 45, '', $user->display_name, ['class' => "user-avatar"]),
				];
			}
		}
		$this->itens_list = $itens_list;
	}

	/**
	 *
	 */
	public function show_items()
	{
		$html_content = '';
		foreach($this->itens_list as $item) {
			$html_content .= $this->render_item_render( $item  );
		}
		return $this->render_header() . $html_content . $this->render_footer();
	}

	/**
	 *
	 */
	public function render_header()
	{
		//Filter to change class
		$ul_class = apply_filters('rtclas-list-header', 'user-list');
		return "<h5>". __("Contributors") . "</h5><ul class=\"{$ul_class}\">";
	}


	/**
	 *
	 */
	public function render_footer()
	{
		//Filter to change the footer of the list
		return apply_filters('rtclass-list-footer', '</ul>');
	}


	/**
	 *
	 */
	public function render_item_render($item)
	{
		ob_start(); ?>
			<a href="<?= get_author_posts_url($item['id']); ?>">
				<li class="user">
					<?= $item['avatar']; ?>
					<span class="user-name"><?= $item['display_name']; ?></span>
				</li>
			</a>
		<?php
		return ob_get_clean();
	}
}
