<?php


abstract class User
{

    public $id;
    public $name;
    public $email;
    public $phone;
    public $image;
    public $role = "subscriber";
    protected $password;
    public $created_at;
    public $updated_at;


    function __construct($id, $name, $email, $phone, $image, $role, $created_at, $updated_at)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->image = $image;
        $this->role = $role;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }


    public static function login($email, $password)
    {
        $user = null;
        $qry = "SELECT * FROM USERS WHERE email='$email' AND password='$password'";
        require_once('config.php');
        $cn = mysqli_connect(DB_HOST, DB_USER_NAME, DB_USER_PASSWORD, DB_NAME);
        $rslt = mysqli_query($cn, $qry);
        if ($arr = mysqli_fetch_assoc($rslt)) {
            var_dump($arr);
            switch ($arr["role"]) {
                case 'subscriber':
                    $user = new Subscriber($arr["id"], $arr["name"], $arr["email"], $arr["phone"], "test", $arr["role"], $arr["created_at"], $arr["updated_at"]);

                    break;
                case 'admin':
                    $user = new Admin($arr["id"], $arr["name"], $arr["email"], $arr["phone"], "test", $arr["role"], $arr["created_at"], $arr["updated_at"]);
                    break;
            }
        }

        mysqli_close($cn);
        return $user;
    }
}

class Subscriber extends User
{

    public $role = "subscriber";
    public static function register($name, $email, $password, $phone)
    {
        $qry = "INSERT INTO USERS (name,email,password,phone,role)
        VALUES('$name','$email','$password','$phone','subscriber')";
        require_once('config.php');
        $cn = mysqli_connect(DB_HOST, DB_USER_NAME, DB_USER_PASSWORD, DB_NAME);
        $rslt = mysqli_query($cn, $qry);
        mysqli_close($cn);
        return $rslt;
    }
    public function store_post($title, $content, $imageName, $user_id)
    {
        $qry = "INSERT INTO POSTS (title, content, image, user_id) VALUES ('$title', '$content', '$imageName', '$user_id')";
        require_once('config.php');
        $cn = mysqli_connect(DB_HOST, DB_USER_NAME, DB_USER_PASSWORD, DB_NAME);
        $rslt = mysqli_query($cn, $qry);
        mysqli_close($cn);
        return $rslt;
    }
    public function store_comment($comment, $post_id, $user_id)
    {
        $qry = "INSERT INTO comments (comment,post_id,user_id) VALUES ('$comment', '$post_id','$user_id')";
        require_once('config.php');
        $cn = mysqli_connect(DB_HOST, DB_USER_NAME, DB_USER_PASSWORD, DB_NAME);
        $rslt = mysqli_query($cn, $qry);
        mysqli_close($cn);
        return $rslt;
    }


    public function my_posts($user_id)
    {
        $qry = "SELECT * FROM POSTS WHERE USER_ID = $user_id ORDER BY CREATED_AT DESC";
        require_once('config.php');
        $cn = mysqli_connect(DB_HOST, DB_USER_NAME, DB_USER_PASSWORD, DB_NAME);
        $rslt = mysqli_query($cn, $qry);
        $data = mysqli_fetch_all($rslt, MYSQLI_ASSOC);
        mysqli_close($cn);
        return $data;
    }
    public function home_posts()
    {
        $qry = "SELECT * FROM POSTS join users on posts.user_id = users.id ORDER BY posts.CREATED_AT DESC LIMIT 10";
        require_once('config.php');
        $cn = mysqli_connect(DB_HOST, DB_USER_NAME, DB_USER_PASSWORD, DB_NAME);
        $rslt = mysqli_query($cn, $qry);
        $data = mysqli_fetch_all($rslt, MYSQLI_ASSOC);
        mysqli_close($cn);
        return $data;
    }

    public function update_profile_pic($imagePath, $user_id)
    {
        $qry = "UPDATE USERS SET IMAGE = '$imagePath' WHERE id = $user_id";
        require_once('config.php');
        $cn = mysqli_connect(DB_HOST, DB_USER_NAME, DB_USER_PASSWORD, DB_NAME);
        $rslt = mysqli_query($cn, $qry); // Use $query instead of $qry
        mysqli_close($cn);
        return $rslt;
    }
    public function get_post_comment($post_id)
    {
        $qry = "SELECT * FROM COMMENTS join users on comments.user_id = users.id WHERE POST_ID = $post_id ORDER BY comments.CREATED_AT DESC";
        require_once('config.php');
        $cn = mysqli_connect(DB_HOST, DB_USER_NAME, DB_USER_PASSWORD, DB_NAME);
        $rslt = mysqli_query($cn, $qry); // Use $query instead of $qry
        $data = mysqli_fetch_all($rslt, MYSQLI_ASSOC);
        mysqli_close($cn);
        return $data;
    }
}


class Admin extends User
{
    public $role = "admin";

    function get_all_users()
    {
        $qry = "SELECT * FROM USERS ORDER BY CREATED_AT";
        require_once('config.php');
        $cn = mysqli_connect(DB_HOST, DB_USER_NAME, DB_USER_PASSWORD, DB_NAME);
        $rslt = mysqli_query($cn, $qry);
        $data = mysqli_fetch_all($rslt, MYSQLI_ASSOC);
        mysqli_close($cn);
        return $data;
    }
    function Delete_Account($user_id)
    {
        $qry = "DELETE FROM USERS WHERE id=$user_id";
        require_once('config.php');
        $cn = mysqli_connect(DB_HOST, DB_USER_NAME, DB_USER_PASSWORD, DB_NAME);
        $rslt = mysqli_query($cn, $qry);
        mysqli_close($cn);
        return $rslt;
    }
}
