<?php namespace LittleNinja\Lib;

class Auth
{
    private static $isLoggedIn = false;
    private static $loggedUser = array();

    public function __construct()
    {
        session_set_cookie_params(1800, '/');
        session_start();

        if (!empty($_SESSION['username'])) {
            self::$isLoggedIn = true;
            self::$loggedUser = array(
                'id' => $_SESSION['user_id'],
                'username' => $_SESSION['username']
            );
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

        $query = "SELECT id, email FROM users WHERE email = ? AND password = MD5( ? ) LIMIT 1";
        $statement = $db->prepare($query);

        $statement->bind_param('ss', $email, $password);
        $statement->execute();
        $result_set = $statement->get_result();

        if ($row = $result_set->fetch_assoc()) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['user_id'] = $row['id'];

            return true;
        }

        return false;
    }

    public function register($name, $email, $password)
    {
        $dbObject = Database::getInstance();
        $db = $dbObject->getDb();
        $values = $name . ',' . $email . ',' . password_hash($password, PASSWORD_BCRYPT);
        $query = "INSERT INTO users (name, email, password) VALUES ($values)";
        $statement = $db->prepare($query);
        var_dump($statement);
        $statement->execute();
    }
}
