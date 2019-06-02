<?php

class Session
{
    private $signed_in = false;
    public $admin_id;

    function __construct()
    {
        session_start();
        $this->check_the_login();
    }

    public function is_signed_in()
    {
        try {
            return $this->signed_in;
        } catch (Exception $exception) {
            echo "Error " . $exception->getMessage();
        }
    }

    public function login($admin)
    {
        try {
            if ($admin) {
                //var_dump($user);
                $this->admin_id = $_SESSION['admin_id'] = $admin->id;
                $this->signed_in = true;
                //header("Location:index.php");
            }
        } catch (Exception $exception) {
            echo "Error " . $exception->getMessage();
        }
    }

    public function logout()
    {
        try {
            unset($_SESSION['admin_id']);
            unset($this->admin_id);
            $this->signed_in = false;
        } catch (Exception $exception) {
            echo "Error " . $exception->getMessage();
        }
    }

    private function check_the_login()
    {
        try {
            if (isset($_SESSION['admin_id'])) {
                $this->admin_id = $_SESSION['admin_id'];
                $this->signed_in = true;
            } else {
                unset($this->admin_id);
                $this->signed_in = false;
            }
        } catch (Exception $exception) {
            echo "Error " . $exception->getMessage();
        }
    }
}

$session = new Session();

?>