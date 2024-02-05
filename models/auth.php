<?php
    include_once('core/db.php');
	function authGetUser() : ?array{
		$user = null;
		$expire = date("Y-m-d H:i:s");

		$token = $_SESSION['token'] ?? $_COOKIE['token'] ?? null;

		if($token !== null){
			$session = sessionsOne($token);
			
			if ($session !== null && strtotime($session['dt_expire']) >= strtotime($expire)) {
				$user = usersById($session['id_user']);
				deleteExpiredSessions();
			}
			else{
				unset($_SESSION['token']);
				setcookie('token', '', time() - 1, '/php_lessons/php-hw2-sample-src/');
			}
		}

		return $user;
	}
	function deleteExpiredSessions() {
		$sql = "DELETE FROM sessions WHERE dt_expire < NOW()";
		$query = dbQuery($sql);
		return true;
	}
	function sessionsAdd(int $idUser, string $token) : bool{
		$params = ['uid' => $idUser, 'token' => $token];
		$sql = "INSERT sessions (id_user, token) VALUES (:uid, :token)";
		dbQuery($sql, $params);
		return true;
	}

	function sessionsOne(string $token) : ?array{
		$sql = "SELECT * FROM sessions WHERE token=:token";
		$query = dbQuery($sql, ['token' => $token]);
		$session = $query->fetch();
		return $session === false ? null : $session;
	}

	function usersById(string $id) : ?array{
		$sql = "SELECT id,login,email,nickname, role FROM users WHERE id=:id";
		$query = dbQuery($sql, ['id' => $id]);
		$user = $query->fetch();
		return $user === false ? null : $user;
	}

	function usersOne(string $login) : ?array{
		$sql = "SELECT id,password FROM users WHERE login=:login";
		$query = dbQuery($sql, ['login' => $login]);
		$user = $query->fetch();
		return $user === false ? null : $user;
	}

	function generatePassword(string $password) {
		return password_hash($password, PASSWORD_BCRYPT);
	}

	function generateToken() {
		return substr(bin2hex(random_bytes(128)), 0, 128);
	}

	function addUser(array $fields): bool {
		$sql = "INSERT users (login, password, email, nickname) VALUES (:login, :password, :email, :nickname)";
		dbQuery($sql, $fields);
		return true;
	}