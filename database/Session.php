<?php

    class Session
    {
        //セッションスタート
        public function __construct()
        {
            session_start();
        }

        /*
         *
         * Method
         *
         * */

        //ログイン
        public function login($username, $user_id)
        {
            //CSRFトークンが正しければ
            if ($this->validate_token()) {
                session_regenerate_id(true);
                $this->set_session('username', $username);
                $this->set_session('user_id', $user_id);
                $_SESSION['csrf_token'] = $this->generate_token();
                header('Location: /');
                exit;
            }
            return false;
        }

        //ログアウト
        public function logout()
        {
            $_SESSION = array();
            session_destroy();
        }

        /*
         *
         * CSRF
         *
         * */

        //CSRFtokenを作成
        public function generate_token()
        {
            return hash('sha256', session_id());
        }

        //CSRFtokenの確認
        public function validate_token()
        {
            return $_SESSION['csrf_token'] === $this->generate_token();
        }


        /*
         *
         * State
         *
         * */

        //ログインしているか
        public function is_login()
        {
            return $this->validate_token() && $this->get_session('username') && $this->get_session('user_id');
        }

        //ログアウトしているか
        public function is_logout()
        {
            return !$this->is_login();
        }


        /*
         *
         * Helper
         *
         * */

        //セッション変数の設定
        private function set_session($key, $value)
        {
            $_SESSION[$key] = $value;
        }

        //セッション変数の取得
        private function get_session($key)
        {
            return isset($_SESSION[$key]) ? $_SESSION[$key] : false;
        }

        //セッション変数の消去
        private function delete_session($key)
        {
            if (isset($_SESSION[$key])) unset($_SESSION[$key]);
        }

    }