<?php
    class UserModel extends CI_Model
    {
        public function __construct()
        {
            $this->load->database();
        }

        public function can_login($username, $password)
        {
            $this->db->where('username', $username);
            $this->db->where('password', $password);
            // SELECT * FROM users WHERE username = '$username' AND password = '$password'
            $query = $this->db->get('users');

            // Checks if the database matches, if the num_rows = 0 then there are no matches
            if($query->num_rows() > 0)
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        public function check_username_exists($username)
        {
            $this->db->where('username', $username);

            // SELECT * FROM users WHERE username = '$username'
            $query = $this->db->get('users');

            if(empty($query->row_array()))
            { 
                return true;
            }
            else
            {
                return false;
            }
        }

        public function get_user_id($username)
        {
            $this->db->where('username', $username);
            // SELECT * FROM users WHERE username = '$username'
            $query = $this->db->get('users');
            $user = $query->row();
            return $user->id;

        }

        public function register_account($username, $password)
        {
            $this->db->set('username', $username);
            $this->db->set('password', $password);
            $this->db->insert('users');
        }
    }
?>