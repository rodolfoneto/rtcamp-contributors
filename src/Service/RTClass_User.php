<?php

namespace RtClass\Service;

class RTClass_User
{
	const ROLES = array('autho', 'editor', 'administrator');

	public function get_all_contributors()
	{
		$args = array(
			'role__in' => self::ROLES
		);

		$users = get_users( $args );
		return $users;
	}
}
