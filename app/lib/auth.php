<?php namespace LittleNinja\Lib;

use LittleNinja\Controllers\BaseController;

class Auth
{
    private static $isLoggedIn = false;
    private static $loggedUser = array();
    public $errors = array();
    private $dbConnection = null;

    public function __construct()
    {
        session_start();

        if (!empty($_SESSION['user'])) {
            self::$isLoggedIn = true;
            self::$loggedUser = $_SESSION['user'];
        }
    }

    public static function getInstance()
    {
        static $instance = null;
        if ($instance === null) {
            $instance = new static();
        }
        return $instance;
    }

    public function isLoggedIn()
    {
        return self::$isLoggedIn;
    }

    public function getLoggedUser()
    {
        return self::$loggedUser;
    }

    public function login($email, $password)
    {

        self::databaseConnection();
        $db = $this->dbConnection;

        $query = 'SELECT id, email, password, role FROM users WHERE email = ? LIMIT 1';
        if ($statement = $db->prepare($query)) {
            $statement->bind_param('s', $email);
            $statement->execute();
        } else {
            var_dump($db->error);

            return false;
        }

        $id = '';
        $em = '';
        $pass = '';
        $role = '';
        $statement->bind_result($id, $em, $pass, $role);
        $row = $statement->fetch();

        if ($row !== null && password_verify($password, $pass)) {
            $_SESSION['user'] = [
                'email' => $em,
                'id' => $id,
                'role' => $role
            ];

            return true;
        }

        if ($row === null) {
            $this->errors['email'] = MESSAGE_USER_DOES_NOT_EXIST;
        } elseif (!password_verify($password, $row['password'])) {
            $this->errors['password'] = MESSAGE_PASSWORD_WRONG;
        }

        return false;
    }

    private function databaseConnection()
    {
        if ($this->dbConnection != null) {
            return true;
        } else {
            try {
                $dbObject = Database::getInstance();
                $this->dbConnection = $dbObject->getDb();
                return true;
            } catch (\Exception $e) {
                $this->errors[] = MESSAGE_DATABASE_ERROR;
                return false;
            }
        }
    }

    public function register($name, $email, $password, $confirm_password)
    {
        list($name, $email) = BaseController::validateUserInput($name, $email);

        if (empty($password) || empty($confirm_password)) {
            $this->errors['password'] = MESSAGE_PASSWORD_EMPTY;
        }
        if (strlen($password) < 6) {
            $this->errors['password'] = MESSAGE_PASSWORD_TOO_SHORT;
        }
        if ($password !== $confirm_password) {
            $this->errors['password_confirmation'] = MESSAGE_PASSWORD_BAD_CONFIRM;
        }

        if (self::databaseConnection() && empty($this->errors)) {
            if ($queryCheckUser = $this->dbConnection->prepare('SELECT email FROM users WHERE email=?')) {
                $queryCheckUser->bind_param('s', $email);
                $queryCheckUser->execute();
                $result = $queryCheckUser->fetch();
                if (count($result) > 0) {
                    $this->errors['email'] = MESSAGE_EMAIL_ALREADY_EXISTS;

                    return false;
                } else {
                    $passHash = password_hash($password, PASSWORD_BCRYPT);
                    ($email === 'alexander.stoimenov@outlook.com') ? $role = 'admin' : $role = '';
                    if ($queryInsertUser =
                        $this->dbConnection->prepare('INSERT INTO users (name, email, password, role) VALUES (?,?,?,?)')
                    ) {
                        $queryInsertUser->bind_param('ssss', $name, $email, $passHash, $role);
                        $queryInsertUser->execute();

                        return true;
                    } else {
                        var_dump($this->dbConnection->error);

                        return false;
                    }
                }
            } else {
                var_dump($this->dbConnection->error);

                return false;
            }
        } else {
            return false;
        }
    }

    public function logout()
    {
        unset($_SESSION['user']);

        Redirect::home();
    }
}
