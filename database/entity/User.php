<?php

    class User
    {
        private $id;
        private $username;
        private $password;
        private $mail;
        private $user_type;
        private $created_at;
        private $updated_at;

        public function __construct($id, $username, $password, $mail, $user_type, $created_at, $updated_at)
        {
            //引数が一つのとき(PDOのStatementオブジェクトのとき)
            if (func_num_args() == 1) {
                $row = $id;
                $this->id = $row['id'];
                $this->username = $row['username'];
                $this->password = $row['password'];
                $this->mail = $row['mail'];
                $this->type = $row['user_type'];
                $this->created_at = $row['created_at'];
                $this->updated_at = $row['updated_at'];
            } else {
                $this->id = $id;
                $this->username = $username;
                $this->password = $password;
                $this->mail = $mail;
                $this->user_type = $user_type;
                $this->created_at = $created_at;
                $this->updated_at = $updated_at;
            }
        }

        public function is_admin()
        {
            return $this->user_type == 0;
        }

        public function is_member()
        {
            return $this->user_type == 1;
        }

        /**
         * @return mixed
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * @param mixed $id
         */
        public function setId($id)
        {
            $this->id = $id;
        }

        /**
         * @return mixed
         */
        public function getUsername()
        {
            return $this->username;
        }

        /**
         * @param mixed $username
         */
        public function setUsername($username)
        {
            $this->username = $username;
        }

        /**
         * @return mixed
         */
        public function getPassword()
        {
            return $this->password;
        }

        /**
         * @param mixed $password
         */
        public function setPassword($password)
        {
            $this->password = $password;
        }

        /**
         * @return mixed
         */
        public function getMail()
        {
            return $this->mail;
        }

        /**
         * @param mixed $mail
         */
        public function setMail($mail)
        {
            $this->mail = $mail;
        }

        /**
         * @return mixed
         */
        public function getUserType()
        {
            return $this->user_type;
        }

        /**
         * @param mixed $type
         */
        public function setUserType($user_type)
        {
            $this->type = $user_type;
        }

        /**
         * @return mixed
         */
        public function getCreatedAt()
        {
            return $this->created_at;
        }

        /**
         * @param mixed $created_at
         */
        public function setCreatedAt($created_at)
        {
            $this->created_at = $created_at;
        }

        /**
         * @return mixed
         */
        public function getUpdatedAt()
        {
            return $this->updated_at;
        }

        /**
         * @param mixed $updated_at
         */
        public function setUpdatedAt($updated_at)
        {
            $this->updated_at = $updated_at;
        }


    }