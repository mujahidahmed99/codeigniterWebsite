<?php
    class Users extends CI_Controller{
        public function view($user = 'home'){
            if(!file_exists(APPPATH.'views/users/'.$user.'.php')){
                show_404();
            }
            $data['title'] = ucfirst($user);
            $this->load->view('users/'.$user, $data);
        }

        public function login_validation()
        {
            // Rules are placed on username and password
            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');

            // Checks if the rules are met
            if($this->form_validation->run())
            {
                // true
                $username = $this->input->post('username');
                $password = $this->input->post('password');
                // model function

                // if model returns true
                if($this->usermodel->can_login($username, $password))
                {
                    $user_id = $this->usermodel->get_user_id($username);

                    $session_data = array(
                        'username' => $username,
                        'uid' => $user_id
                    );
                    $this->session->set_userdata($session_data);
                    redirect(base_url() . 'pages/home');
                }
                else
                {
                    $this->session->set_flashdata('user_sign_in_error', 'Invalid Username and Password');
                    redirect(base_url() . 'users/login');
                }
            }
            else
            {
                // false
                $this->load->view('users/login');
            }
        }

        public function register_validation()
        {
            $this->form_validation->set_rules('username', 'Username', 'required|callback_check_username_exists');
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('confirm-password', 'Confirm Password', 'required|matches[password]');

            if($this->form_validation->run())
            {
                $username = $this->input->post('username');
                $password = $this->input->post('password');
                $confirm_password = $this->input->post('confirm-password');
                
                $this->usermodel->register_account($username, $password); // saves user account into database
                $user_id = $this->usermodel->get_user_id($username);
                $session_data = array(
                    'username' => $username,
                    'uid' => $user_id
                );
                $this->session->set_userdata($session_data);
                $userid = $this->session->userdata('uid');
                $card_name = 'savings';
                $balance = 0;
                $this->cardmodel->create_card_and_active($userid, $card_name, $balance, 1);
                redirect(base_url() . 'pages/home');
            }
            else
            {
                $this->load->view('users/register');
            }
            
        }
        
        // check if user name exists
        function check_username_exists($username)
        {
            $this->form_validation->set_message('check_username_exists', 'The username is taken.');
            if ($this->usermodel->check_username_exists($username)) 
            {
                return true;
            } 
            else 
            {
                return false;
            }
            
        }
    }