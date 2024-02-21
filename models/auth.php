<?php
include_once('core/db.php');
function authGetUser(): ?array
{
	$user = null;
	$expire = date("Y-m-d H:i:s");

	$token = $_SESSION['token'] ?? $_COOKIE['token'] ?? null;

	if ($token !== null) {
		$session = sessionsOne($token);

		if ($session !== null && strtotime($session['dt_expire']) >= strtotime($expire)) {
			$user = usersById($session['id_user']);
			deleteExpiredSessions();
		} else {
			unset($_SESSION['token']);
			setcookie('token', '', time() - 1, '/php_lessons/php-hw2-sample-src/');
		}
	}

	return $user;
}
function deleteExpiredSessions()
{
	$sql = "DELETE FROM sessions WHERE dt_expire < NOW()";
	$query = dbQuery($sql);
	return true;
}
function sessionsAdd(int $idUser, string $token): bool
{
	$params = ['uid' => $idUser, 'token' => $token];
	$sql = "INSERT sessions (id_user, token) VALUES (:uid, :token)";
	dbQuery($sql, $params);
	return true;
}

function sessionsOne(string $token): ?array
{
	$sql = "SELECT id_user, dt_expire FROM sessions WHERE token=:token";
	$query = dbQuery($sql, ['token' => $token]);
	$session = $query->fetch();
	return $session === false ? null : $session;
}

function usersById(int $id): ?array
{
	$sql = "SELECT id, role, nickname, avatar FROM users WHERE id=:id";
	$query = dbQuery($sql, ['id' => $id]);
	$user = $query->fetch();
	return $user === false ? null : $user;
}

function usersOne(string $login): ?array
{
	$sql = "SELECT id,password FROM users WHERE login=:login";
	$query = dbQuery($sql, ['login' => $login]);
	$user = $query->fetch();
	return $user === false ? null : $user;
}

function generatePassword(string $password)
{
	return password_hash($password, PASSWORD_BCRYPT);
}

function generateToken()
{
	return substr(bin2hex(random_bytes(128)), 0, 128);
}

function addUser(array $fields): bool
{
	$sql = "INSERT users (login, password, email, nickname) VALUES (:login, :password, :email, :nickname)";
	dbQuery($sql, $fields);
	return true;
}
function renewAvatar(int $id, string $avatar)
{
	$params = ['id' => $id, 'avatar' => $avatar];
	$sql = "UPDATE users SET avatar = :avatar WHERE id = :id";
	dbQuery($sql, $params);
	return true;
}
function setDefaultAvatar(int $id)
{
	$sql = "UPDATE users SET avatar = 'assets/images/default.jpg' WHERE id = :id";
	dbQuery($sql, ['id' => $id]);
	return true;
}

function validateAvatar(array $file){
	$errors = [];
	if ($file['name'] === '') {
        $errors[] = 'Choose file!';
    }
	if ($file['size'] === 0 && $file['name'] !== '') {
		$errors[] = 'File too large!';
    }
	if (!checkImageName($file['name']) && $file['name'] !== '') {
        $errors[] = 'Only jpg';
	}
	return $errors;
}

function checkNickname(string $nickname){
	$sql = "SELECT nickname FROM users WHERE nickname=:nickname";
	$query = dbQuery($sql, ['nickname' => $nickname]);
	$user = $query->fetch();
	return $user === false ? null : $user;
}
function validateRegistration(array $fields){
	$errors = [];
	$checkLogin = usersOne($fields['login']);
	$checkNick = checkNickname($fields['nickname']);
	if ($fields['login'] === '' || $fields['password'] === '' || $fields['nickname'] === '') {
		$errors[] = 'Fill required fields at least';
	}
	if($checkNick != null ){
		$errors[] = 'Such nick already exist';
	}
	if($checkLogin != null ){
		$errors[] = 'Such login already exist';
	}
	if(mb_strlen($fields['password']) < 6){
		$errors[] = 'Password must be at least 6 chars';
	}
	return $errors;
}