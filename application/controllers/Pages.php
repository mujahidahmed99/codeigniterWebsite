<?php
    class Pages extends CI_Controller{
    
    public $pusher;
    function __construct() {
        parent::__construct();
        $options = array(
            'cluster' => 'eu',
            'useTLS' => true
        );

        $this->pusher = new Pusher\Pusher('581290458e10eb5de59c','4434df030771ce7359a6','1234633',$options);
        $json = file_get_contents('php://input');
        $values = json_decode($json, true);
        $this->pusher->trigger('my-channel', 'my-event', $values);
        
    }

        public function view($page = 'home'){
            if(!file_exists(APPPATH.'views/pages/'.$page.'.php')){
                show_404();
            }

            if($this->session->userdata('username') != '')
            {
                $username = $this->session->userdata('username');
                $userid = $this->session->userdata('uid');
                $cards = $this->cardmodel->get_cards($userid);
                $active_card = $this->cardmodel->get_active_card($userid);
                $category_items = $this->categorymodel->get_all_categories();
                $wallet_id = $active_card[0]['id'];
                $transactions = $this->transactionmodel->get_transaction_filtered($userid, $wallet_id, date('m'), date('Y'));
                $graph = $this->transactionmodel->get_sum_year(date('m'), date('Y'));
                $tan = $this->transactionmodel->get_all_transactions($userid, $wallet_id);
                $inflow_total = $this->transactionmodel->get_total_inflow_month($userid,$wallet_id, date('m'), date('Y'));
                $outflow_total = $this->transactionmodel->get_total_outflow_month($userid,$wallet_id, date('m'), date('Y'));
                $data['title'] = ucfirst($page);
                $data['username'] = $username;
                $data['uid'] = $userid;
                $data['cards'] = $cards;
                $data['categories'] = $category_items;
                $data['active_card'] = $active_card;
                $data['transactions'] = $transactions;
                $data['inflow_total'] = $inflow_total;
                $data['outflow_total'] = $outflow_total;
                
            
                $this->load->view('templates/header');
                $this->load->view('pages/'.$page, $data);
                $this->load->view('templates/footer');
            }
            else
            {
                redirect(base_url() . 'users/login');
            }

        }

        public function logout()
        {
            $this->session->unset_userdata('username');
            $this->session->unset_userdata('uid');
            redirect(base_url() . 'users/login');
        }

        public function create_card()
        {
             // Rules are placed on username and password
             $this->form_validation->set_rules('wallet', 'Wallet', 'required');
             $this->form_validation->set_rules('balance', 'Balance', 'required');
 
             // Checks if the rules are met
             if($this->form_validation->run())
             {
                $userid = $this->session->userdata('uid');
                 // true
                 $wallet_name = $this->input->post('Wallet');
                 $balance = $this->input->post('Balance');
                 $this->cardmodel->create_card_and_active($userid, $cardname, $balance);
                 
                 redirect(base_url() . 'pages/home');
                }
            else
            {
                $this->session->set_flashdata('user_sign_in_error', 'Invalid Username and Password');
                redirect(base_url() . 'users/login');
             }
        }

        public function add_card() 
        {
            $this->form_validation->set_rules('cardname', 'Card Name', 'required');
            $this->form_validation->set_rules('balance', 'Initial Balance', 'required|numeric');

            if($this->form_validation->run())
            {
                $userid = $this->session->userdata('uid');
                $cardname = $this->input->post('cardname');
                $balance = $this->input->post('balance');
                if($this->cardmodel->check_cardname_exists($userid, $cardname))
                {
                    $this->cardmodel->create_card($userid, $cardname, $balance);
                    $array = array(
                        'success' => true
                    );
                }
                else
                {
                    $array = array(
                        'error' => true,
                        'cardname_exists' => '<p>This card name already exists.</P>'
                    );
                }
            }
            else{
                $array = array(
                    'error' => true,
                    'cardname' => form_error('cardname'),
                    'balance' => form_error('balance')

                );
            }
            echo json_encode($array);
        }

        public function request_card($card_id){
            $userid = $this->session->userdata('uid');
            $data = $this->cardmodel->get_card_by_id($card_id, $userid);

            if($data === false){
                $array = array(
                    'success' => false
                );
            }else{
                $array = array(
                    'success' => true,
                    'data' => $data
                );
            }
            echo json_encode($array);
        }
    
        public function request_item_transaction($item_id){
            $userid = $this->session->userdata('uid');
            $active_card = $this->cardmodel->get_active_card($userid);
            $wallet_id = $active_card[0]['id'];

            $result_data = $this->transactionmodel->get_by_id($userid, $wallet_id, $item_id);
            $array = array(
                'success' => true,
                'data' => $result_data
            );
            echo json_encode($array);
        }

        public function request_category($category)
        {
            $items = $this->categorymodel->get_category_items($category);
            echo json_encode($items);
        }

        public function add_transaction()
        {
            $this->form_validation->set_rules('wallet', 'Wallet', 'required');
            $this->form_validation->set_rules('category', 'Category', 'required');
            $this->form_validation->set_rules('amount', 'Amount', 'required|numeric');
            $this->form_validation->set_rules('date', 'Date', 'required');
            $this->form_validation->set_rules('location', 'Location', 'required');

            if($this->form_validation->run())
            {
                $wallet = $this->input->post('wallet');
                $category = $this->input->post('category');
                $amount = $this->input->post('amount');
                $date = $this->input->post('date');
                $location = $this->input->post('location');
                $notes = $this->input->post('notes');

                $userid = $this->session->userdata('uid');
                $active_card = $this->cardmodel->get_active_card($userid);
                $wallet_id = $active_card[0]['id'];
                $category_id = $this->categorymodel->get_category_id($category);
                $category_id = $category_id[0]['id'];
                $inflow = $this->categorymodel->check_inflow_outflow($category_id);
                
                $this->transactionmodel->add_transaction($userid, $wallet_id, $category_id, $amount, $date, $notes, $inflow);

                $array = array(
                    'success' => true,
                    'message' => 'Transaction success'
                );
                
            }
            else
            {
                $array = array(
                    'fail' => true,
                    'wallet' => form_error('wallet'),
                    'category' => form_error('category'),
                    'amount' => form_error('amount'),
                    'date' => form_error('date'),
                    'location'=> form_error('location')
                );
            }
            echo json_encode($array);
        }

        public function filter_transaction(){
            $this->form_validation->set_rules('year', 'Year', 'required');
            $this->form_validation->set_rules('month', 'Month', 'required');

            if($this->form_validation->run())
            {
                $year = $this->input->post('year');
                $month = $this->input->post('month');
                $userid = $this->session->userdata('uid');
                $active_card = $this->cardmodel->get_active_card($userid);
                $wallet_id = $active_card[0]['id'];
    
                $transaction_data = $this->transactionmodel->get_transaction_filtered($userid, $wallet_id, $month, $year);
                $inflow_total = $this->transactionmodel->get_total_inflow_month($userid,$wallet_id, $month, $year);
                $outflow_total = $this->transactionmodel->get_total_outflow_month($userid,$wallet_id, $month, $year);
                $array = array(
                    'success' => true,
                    'data' => $transaction_data,
                    'inflow' => $inflow_total,
                    'outflow' => $outflow_total,
                    'total' => ($inflow_total-$outflow_total)
                );
            }
            else
            {
                $array = array(
                    'fail' => true,
                    'message' => 'try again'
                );
            }
            echo json_encode($array);
        }

        public function make_card_active($wallet_id)
        {
            
            $userid = $this->session->userdata('uid');   
            $response = $this->cardmodel->set_card_inactive($userid);
            $active_response = $this->cardmodel->set_active($userid, $wallet_id);
            if($response)
            {
                $array = array(
                    'success' => true,
                    'message' => 'added succesfully'
                );
                
            }
            else{
                $array = array(
                    'fail' => true,
                    'message' => 'try again'
                );
            }
            echo json_encode($array);
            
        }

        public function get_chart_data($month, $year)
        {
            $response = $this->transactionmodel->get_sum_year($month, $year);
            echo json_encode($response);
        }

        public function filter_chart()
        {
            $this->form_validation->set_rules('year', 'Year', 'required');
            $this->form_validation->set_rules('month', 'Month', 'required');

            if($this->form_validation->run()){
                $year = $this->input->post('year');
                $month = $this->input->post('month');
                
                $response = $this->transactionmodel->get_sum_year($month, $year);

                
                echo json_encode($response);
            }
        }

        public function filter_category($category_type)
        {
            if($category_type == "debt"){
                $value = "Debt";
                $data = $this->categorymodel->get_category_items($value);
                $array = array(
                    'success' => true,
                    'data' => $data
                );
            }elseif($category_type == "expense"){
                $value = "Expense";
                $data = $this->categorymodel->get_category_items($value);
                $array = array(
                    'success' => true,
                    'data' => $data
                );
            } elseif($category_type == "income"){
                $value = "Income";
                $data = $this->categorymodel->get_category_items($value);
                $array = array(
                    'success' => true,
                    'data' => $data
                );
            } else {
                $array = array(
                    'success' => false,
                    'message' => 'fail'
                );
            }
            echo json_encode($array);
        }

        public function delete_transaction_by_id($id){
            $userid = $this->session->userdata('uid');
            $active_card = $this->cardmodel->get_active_card($userid);
            $wallet_id = $active_card[0]['id'];
            
            $this->transactionmodel->delete_record($userid, $wallet_id, $id);

            $array = array(
                'success' => true,
                'id' => $id
            );

            echo json_encode($array);
        }
    }

    