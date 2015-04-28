<?php namespace LittleNinja\Lib;

class Auth
{
    private static $isLoggedIn = false;
    private static $loggedUser = array();
    public $errors = array();
    private $dbConnection = null;

    public function __construct()
    {
        session_set_cookie_params(1800, '/');
        session_start();

        if (!empty($_SESSION['email'])) {
            self::$isLoggedIn = true;
            self::$loggedUser = array(
                'id' => $_SESSION['user_id'],
                'email' => $_SESSION['email'],
                'role' => $_SESSION['role']
            );
        }
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
        $dbObject = Database::getInstance();
        $db = $dbObject->getDb();
        $query = "SELECT id, email, pass, role FROM users WHERE email = ? LIMIT 1";
        if ($statement = $db->prepare($query)) {
            $statement->bind_param('s', $email);
            $statement->execute();
        } else {
            var_dump($db->error);
        }

        $result_set = $statement->get_result();
        $row = $result_set->fetch_assoc();
        if ($row !== null && password_verify($password, $row['pass'])) {
            $_SESSION['email'] = $row['email'];
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role'] = $row['role'];

            return true;
        }

        return false;
    }

    public function register($name, $email, $pass, $pass_repeat)
    {
        $email = trim($email);

        if (empty($email)) {
            $this->errors[] = MESSAGE_EMAIL_EMPTY;
            $email = null;
        }
        if (empty($name)) {
            $this->errors[] = MESSAGE_NAME_EMPTY;
        }
        if (empty($pass) || empty($pass_repeat)) {
            $this->errors[] = MESSAGE_PASSWORD_EMPTY;
        }
        if ($pass !== $pass_repeat) {
            $this->errors[] = MESSAGE_PASSWORD_BAD_CONFIRM;
        }
        if (strlen($pass) < 6) {
            $this->errors[] = MESSAGE_PASSWORD_TOO_SHORT;
        }
        if (strlen($email) > 255) {
            $this->errors[] = MESSAGE_EMAIL_TOO_LONG;
        }
        if (strlen($name) > 255) {
            $this->errors[] = MESSAGE_NAME_BAD_LENGTH;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = MESSAGE_EMAIL_INVALID;
        }
        if ($this->databaseConnection()) {
            $queryCheckUser = $this->dbConnection->prepare("SELECT email FROM users WHERE email=?");
            $queryCheckUser->bind_param('s', $email);
            $queryCheckUser->execute();
            $result = $queryCheckUser->fetch();

            if (count($result) > 0) {
                $this->errors[] = MESSAGE_EMAIL_ALREADY_EXISTS;
            } else {
                $passHash = password_hash($pass, PASSWORD_BCRYPT);
//                $activationHash = sha1(uniqid(mt_rand(), true));

                $queryInsertUser = $this->dbConnection->prepare("INSERT INTO users (name, email, pass) VALUES (?,?,?)");
                $queryInsertUser->bind_param('sss', $name, $email, $passHash);
                $queryInsertUser->execute();
            }
        }
        /*$dbObject = Database::getInstance();
        $db = $dbObject->getDb();
        $query = "INSERT INTO users (name, email, pass) VALUES (?,?,?)";
        if ($statement = $db->prepare($query)) {
            $validator = new Validator();
            $validator->addValidation($name, 'req', 'Please fill name');
            $validator->addValidation($email, 'req', 'Please fill email');
            if ($validator->validateForm()) {
                $statement->bind_param('sss', $name, $email, password_hash($pass, PASSWORD_BCRYPT));
                $statement->execute();
            } else {
                $error_hash = $validator->getErrors();
//                foreach ($error_hash as $inp_err) {
                    $this->errors[] = $error_hash;
//                }
            }
        } else {
            var_dump($db->error);
        }*/
    }

    public function logout()
    {
        session_start();
        session_destroy();

        header('Location: /');
        exit;
    }
}
