<?php
include_once "C:\Users\megas\Documents\GitHub\ImageSNS\database\\entity\User.php";

class UsersTable
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    //ユーザーの追加
    public function add(User $user)
    {
        $username = $user->getUsername();
        $password = password_hash($user->getPassword(), PASSWORD_DEFAULT);
        $mail = $user->getMail();
        $user_type = $user->getUserType();
        try {
            $stmt = $this->pdo->prepare("INSERT INTO Users(username, password, mail, user_type) VALUES (:username, :password, :mail, :user_type)");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
            $stmt->bindParam(':user_type', $user_type, PDO::PARAM_INT);

            $stmt->execute();

            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }

    //ユーザーの削除
    public function delete($id)
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM Users WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }

    //ユーザの定義が正しいかチェックで認証
    //trueならデータベースに登録してよし
    //falseならデータベースに登録してはいけない(再入力)
    public function validate(User $user)
    {
        $username=$user->getUsername();

        $query = $this->pdo->prepare("SELECT COUNT(*) FROM Users WHERE username=:username");
        $query->bindParam('username', $username);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);

        $result=$query->fetchColumn();

        if ($result>0) return false; else return true;
    }

    //ユーザの存在をチェック
    //存在したらidを返す
    //存在しないなら-1返す
    public function isUserExists($username, $password)
    {
        try {
            $query = $this->pdo->prepare("SELECT id, password FROM Users WHERE username=:username");
            $query->bindParam('username', $username);
           // $query->bindParam('password', $hashedPass, PDO::PARAM_STR);
            $query->execute();
            $result=$query->fetchAll();
            foreach ($result as $row){
                if(password_verify($password, $row['password']))return $row['id'];
            }

            return -1;
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }

}