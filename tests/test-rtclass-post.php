<?php

/**
 * Class Test
 *
 * @package Rtclass_Contributors
 */

/**
 * test case.
 */
class RTClass_Post extends WP_UnitTestCase {

	private function create_user($user_name = "", $password = "", $email = "", $role = "administrator") {
		$user_name = !empty(trim($user_name)) ? $user_name : 'name_' . rand(999, 999999);
		$password = !empty(trim($password)) ? $password : 'pass_' . rand(999, 999999);
		$email = !empty(trim($email)) ? $email : "email" . rand(999, 999999) . "@example.com";
		$user_id = wp_create_user( $user_name, $password, $email );
		$user = new WP_User( $user_id );
		$user->set_role( $role );
		return $user;
	}

	private function create_post($author_id, $post_type = 'post') {
		$post_data = array(
			'post_title' => 'A New Post',
			'post_content' => 'This is the content of a new post.',
			'post_status' => 'publish',
			'post_author' => $author_id,
			'post_type' => $post_type
		);
		$post_id = wp_insert_post( $post_data );
		return $post_id;
	}

	/**
	 *
	 */
	public function test_save_contributor_in_a_post() {
		$author = $this->create_user();
		$contributor = $this->create_user();
		$contributor2 = $this->create_user();
		$post_id = $this->create_post($author->ID);

		(new \RtClass\Service\RTClass_Post())->set_contributors($post_id, [$contributor->ID, $contributor2->ID]);
		$meta = get_post_meta($post_id, \RtClass\Service\RTClass_Post::METAKEY_CONTRIBUTTORS);
		$this->assertSame([0 => [$contributor->ID, $contributor2->ID]], $meta);
	}

	/**
	 *
	 */
	public function test_verify_cant_save_contributors_in_a_post_type_page() {
		$author = $this->create_user();
		$contributor = $this->create_user();
		$post_id = $this->create_post($author->ID, 'page');
		(new \RtClass\Service\RTClass_Post())->set_contributors($post_id, [$contributor->ID]);
		$meta = get_post_meta($post_id, \RtClass\Service\RTClass_Post::METAKEY_CONTRIBUTTORS);
		$this->assertSame([], $meta);
	}


	public function test_verify_a_contributor_in_a_post() {
		$author = $this->create_user();
		$contributor = $this->create_user();
		$post_id = $this->create_post($author->ID);
		(new \RtClass\Service\RTClass_Post())->set_contributors($post_id, [$contributor->ID]);
		$verified = (new \RtClass\Service\RTClass_Post())->is_contributor_by_user_id($post_id, $contributor->ID);
		$this->assertSame(true, $verified);
	}

	public function test_verify_a_contributor_in_a_post_when_has_many() {
		$author = $this->create_user();
		$c1 = $this->create_user();
		$c2 = $this->create_user();
		$c3 = $this->create_user();
		$c4 = $this->create_user();
		$c5 = $this->create_user();
		$post_id = $this->create_post($author->ID);
		(new \RtClass\Service\RTClass_Post())->set_contributors($post_id, [$c1->ID, $c5->ID, $c3->ID, $c4->ID]);
		$verified = (new \RtClass\Service\RTClass_Post())->is_contributor_by_user_id($post_id, $c3->ID);
		$this->assertSame(true, $verified);
	}

	public function test_verify_a_not_contributor_in_a_post_when_has_many() {
		$author = $this->create_user();
		$c1 = $this->create_user();
		$c2 = $this->create_user();
		$c3 = $this->create_user();
		$c4 = $this->create_user();
		$c5 = $this->create_user();

		$post_id = $this->create_post($author->ID);
		(new \RtClass\Service\RTClass_Post())->set_contributors($post_id, [$c1->ID, $c5->ID, $c3->ID, $c4->ID]);
		$verified = (new \RtClass\Service\RTClass_Post())->is_contributor_by_user_id($post_id, $c2->ID);
		$this->assertSame(false, $verified);
	}

	public function test_verify_a_contributor_when_not_exists() {
		$author = $this->create_user();

		$post_id = $this->create_post($author->ID);
		$verified = (new \RtClass\Service\RTClass_Post())->is_contributor_by_user_id($post_id, $author->ID);
		$this->assertSame(false, $verified);
	}

	public function test_verify_a_contributor_when_not_is_removed() {
		$author = $this->create_user();
		$c1 = $this->create_user();

		$post_id = $this->create_post($author->ID);
		(new \RtClass\Service\RTClass_Post())->set_contributors($post_id, [$c1->ID]);
		(new \RtClass\Service\RTClass_Post())->set_contributors($post_id, null);
		$verified = (new \RtClass\Service\RTClass_Post())->is_contributor_by_user_id($post_id, $c1->ID);
		$this->assertSame(false, $verified);
	}

	public function test_verify_a_contributor_when_is_removed_all() {
		$author = $this->create_user();
		$c1 = $this->create_user();

		$post_id = $this->create_post($author->ID);
		(new \RtClass\Service\RTClass_Post())->set_contributors($post_id, [$c1->ID]);
		(new \RtClass\Service\RTClass_Post())->set_contributors($post_id, []);
		$contributors = (new \RtClass\Service\RTClass_Post())->get_contributors($post_id);
		$this->assertSame(0, count($contributors));
	}
}
