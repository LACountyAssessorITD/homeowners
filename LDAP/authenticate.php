<?php
include_once "constants.php";
// Connect to LDAP
function authenticateUser($username, $password) {
	echo '<script>console.log("AUTHENTICATE")</script>';
	$server = LDAP_SERVER_NAME;
	echo '<script>console.log("'.$server.'")</script>';
	echo '<script>console.log("'.$username.'")</script>';
	echo '<script>console.log("'.$password.'")</script>';
	$ldap = ldap_connect($server, 389);
	if ($ldap) {
		ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
		ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

		$bind = ldap_bind($ldap, $username, $password);
		if ($bind) {
			$msg = "Authentication successful ";
			echo $msg;
			ldap_close($ldap);
			return TRUE;
		} else {
			$msg = "Invalid email address / password";
			echo $msg;
			return FALSE;
		}
	} else {
		return FALSE;
	}
}
?>
