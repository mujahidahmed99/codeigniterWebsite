<?php
    class CardModel extends CI_Model
    {
        public function __construct()
        {
            $this->load->database();
        }
    
        public function create_card($userid, $card_name, $balance)
        {
            $this->db->set('user_id', $userid);
            $this->db->set('wallet_name',$card_name);
            $this->db->set('balance',$balance);            
            $this->db->insert('wallets');
        }

        public function create_card_and_active($userid, $card_name, $balance, $active){
            $this->db->set('user_id', $userid);
            $this->db->set('wallet_name',$card_name);
            $this->db->set('balance',$balance); 
            $this->db->set('active_wallet',$active);            
            $this->db->insert('wallets');
        }

        public function check_cardname_exists($uid, $card_name)
        {
            $this->db->where('user_id', $uid);
            $this->db->where('name', $card_name);
            // SELECT * FROM wallets WHERE user_id = '$uid' AND name = '$card_name'
            $query = $this->db->get('wallets');

            // Checks if the database matches, if the num_rows = 0 then there are no matches
            if($query->num_rows() == 0)
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        public function get_cards($uid)
        {
            $this->db->where('user_id', $uid);
            $query = $this->db->get('wallets');
            $this->db->order_by("active_wallet", "asc");

            return $query->result_array();

        }
        public function get_active_card($uid)
        {
            $active = 1;
            $this->db->where('user_id', $uid);
            $this->db->where('active_wallet',$active);
            $query = $this->db->get('wallets');

            if($query->num_rows() == 1){
                return $query->result_array();
            }
            else
            {
                return false;
            }
        }

        public function get_card_by_id($card_id, $user_id){
            $this->db->where('id', $card_id);
            $this->db->where('user_id', $user_id);
            $query = $this->db->get('wallets');
            if($query->num_rows() == 1){
                return $query->result_array();
            }
            else
            {
                return false;
            }
        }

        public function set_card_inactive($uid)
        {
            $data = array(
                'active_wallet' => 0
            );
            $this->db->set('active_wallet', 0);
            $this->db->where('user_id', $uid);
            $this->db->where('active_wallet', 1);
            $this->db->update('wallets', $data);
            if($this->db->affected_rows() > 0)
            {
                return true;
            }
            else {
                return false;
            }
        }
        
        public function set_active($uid, $wallet_id)
        {
            $data = array(
                'active_wallet' => 1
            );
            $this->db->where('user_id', $uid);
            $this->db->where('id', $wallet_id);
            $this->db->update('wallets', $data);
            if($this->db->affected_rows() > 0)
            {
                return true;
            }
            else {
                return false;
            }
        }
    }
?>