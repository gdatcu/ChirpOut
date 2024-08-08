<?php
class User {
	private $user;
	private $con;
	private $userFound;

	public function __construct($con, $user){
		$this->con = $con;
		$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$user'");
		$this->user = mysqli_fetch_array($user_details_query);
		$this->userFound = ($this->user !== null);  // Check if user was found
	}

	public function userExists() {
		return $this->userFound;
	}

	public function getUsername() {
		return $this->user['username'] ?? null;
	}

	public function getNumPosts() {
		if (!$this->userFound) return 0;
		$username = $this->user['username'];
		$query = mysqli_query($this->con, "SELECT num_posts FROM users WHERE username='$username'");
		$row = mysqli_fetch_array($query);
		return $row['num_posts'] ?? 0;
	}

	public function getFirstAndLastName() {
		if (!$this->userFound) return "Unknown User";
		$username = $this->user['username'];
		$query = mysqli_query($this->con, "SELECT first_name, last_name FROM users WHERE username='$username'");
		$row = mysqli_fetch_array($query);
		return ($row['first_name'] ?? '') . " " . ($row['last_name'] ?? '');
	}

	public function getProfilePic() {
		if (!$this->userFound) return "default_profile_pic.jpg";  // Return a default profile picture
		$username = $this->user['username'];
		$query = mysqli_query($this->con, "SELECT profile_pic FROM users WHERE username='$username'");
		$row = mysqli_fetch_array($query);
		return $row['profile_pic'] ?? "default_profile_pic.jpg";  // Return a default profile picture
	}

	public function getFriendArray() {
		if (!$this->userFound) return "";
		$username = $this->user['username'];
		$query = mysqli_query($this->con, "SELECT friend_array FROM users WHERE username='$username'");
		$row = mysqli_fetch_array($query);
		return $row['friend_array'] ?? "";
	}

	public function isClosed() {
		if (!$this->userFound) return false;
		$username = $this->user['username'];
		$query = mysqli_query($this->con, "SELECT user_closed FROM users WHERE username='$username'");
		$row = mysqli_fetch_array($query);
		return ($row['user_closed'] ?? '') === 'yes';
	}

	public function isFriend($username_to_check) {
		if (!$this->userFound) return false;
		$usernameComma = "," . $username_to_check . ",";
		return (strstr($this->user['friend_array'] ?? '', $usernameComma) || $username_to_check == $this->user['username']);
	}

	public function didReceiveRequest($user_from) {
		if (!$this->userFound) return false;
		$user_to = $this->user['username'];
		$check_request_query = mysqli_query($this->con, "SELECT * FROM friend_requests WHERE user_to='$user_to' AND user_from='$user_from'");
		return mysqli_num_rows($check_request_query) > 0;
	}

	public function didSendRequest($user_to) {
		if (!$this->userFound) return false;
		$user_from = $this->user['username'];
		$check_request_query = mysqli_query($this->con, "SELECT * FROM friend_requests WHERE user_to='$user_to' AND user_from='$user_from'");
		return mysqli_num_rows($check_request_query) > 0;
	}

	public function removeFriend($user_to_remove) {
		if (!$this->userFound) return false;
		$logged_in_user = $this->user['username'];

		$query = mysqli_query($this->con, "SELECT friend_array FROM users WHERE username='$user_to_remove'");
		$row = mysqli_fetch_array($query);
		$friend_array_username = $row['friend_array'] ?? '';

		$new_friend_array = str_replace($user_to_remove . ",", "", $this->user['friend_array'] ?? '');
		mysqli_query($this->con, "UPDATE users SET friend_array='$new_friend_array' WHERE username='$logged_in_user'");

		$new_friend_array = str_replace($this->user['username'] . ",", "", $friend_array_username);
		mysqli_query($this->con, "UPDATE users SET friend_array='$new_friend_array' WHERE username='$user_to_remove'");
	}

	public function sendRequest($user_to) {
		if (!$this->userFound) return false;
		$user_from = $this->user['username'];
		mysqli_query($this->con, "INSERT INTO friend_requests VALUES(default, '$user_to', '$user_from')");
	}

	public function getMutualFriends($user_to_check) {
		if (!$this->userFound) return 0;
		$mutualFriends = 0;
		$user_array = $this->user['friend_array'] ?? '';
		$user_array_explode = explode(",", $user_array);

		$query = mysqli_query($this->con, "SELECT friend_array FROM users WHERE username='$user_to_check'");
		$row = mysqli_fetch_array($query);
		$user_to_check_array = $row['friend_array'] ?? '';
		$user_to_check_array_explode = explode(",", $user_to_check_array);

		foreach($user_array_explode as $i) {
			foreach($user_to_check_array_explode as $j) {
				if($i == $j && $i != "") {
					$mutualFriends++;
				}
			}
		}
		return $mutualFriends;
	}
}
?>
