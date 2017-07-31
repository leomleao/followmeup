<?php 
	class loginAttempt extends \HXPHP\System\Model
		{
			##static $primary_key = "userid";
			##static $table_name = "login_attempts";

			public static function totalAttempts($userid)
			{
				return count(self::find_all_by_loginAttemptUserID($userid));
			}

			public static function remainingAttempts()
			{
				return intval(5-self::attempts());
			}

			public static function registerAttempts($userid)
			{
				self::create(array(
						'loginattemptuserid' => $userid
					));
			}

			public static function clearAttempts($userid)
			{
				self::delete_all(array(
						'conditions' => array(
								'loginattemptuserid = ?',
								$userid
							)
					));
			}

			public static function attempts ($userid)
			{
				return self::totalAttempts($userid) < 5 ? true : false;
			}
		}