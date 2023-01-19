<?php

/**
 * Class SampleTest
 *
 * @package Rtclass_Contributors
 */

/**
 * Sample test case.
 */
class RTClass_User extends WP_UnitTestCase {

	private function create_user($user_name = "", $password = "", $email = "", $role = "administrator") {
		$user_name = !empty(trim($user_name)) ? $user_name : 'name_' . rand(999, 999999);
		$password = !empty(trim($password)) ? $password : 'pass_' . rand(999, 999999);
		$email = !empty(trim($email)) ? $email : "email" . rand(999, 999999) . "@example.com";
		$user_id = wp_create_user( $user_name, $password, $email );
		$user = new WP_User( $user_id );
		$user->set_role( $role );
		return $user;
	}

	/**
	 *
	 */
	public function test_get_all_possible_contributors() {
		$this->create_user();
		$this->create_user();

		$rt_user = new \RtClass\Service\RTClass_User();
		$contributors = $rt_user->get_all_contributors();
		$this->assertSame(3, count($contributors));
	}

	/**
	 *
	 */
	public function test_get_all_possible_contributors_if_exists_author()
	{
		$this->create_user("", "", "", \RtClass\Service\RTClass_User::ROLES[0]);
		$this->create_user("", "", "", \RtClass\Service\RTClass_User::ROLES[0]);
		$this->create_user("", "", "", \RtClass\Service\RTClass_User::ROLES[0]);

		$rt_user = new \RtClass\Service\RTClass_User();
		$contributors = $rt_user->get_all_contributors();
		$this->assertSame(4, count($contributors));
	}

	/**
	 *
	 */
	public function test_get_all_possible_contributors_if_exists_editor()
	{
		$this->create_user("", "", "", \RtClass\Service\RTClass_User::ROLES[1]);
		$this->create_user("", "", "", \RtClass\Service\RTClass_User::ROLES[1]);

		$rt_user = new \RtClass\Service\RTClass_User();
		$contributors = $rt_user->get_all_contributors();
		$this->assertSame(3, count($contributors));
	}
}
