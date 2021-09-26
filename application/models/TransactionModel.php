<?php 
    class TransactionModel extends CI_Model
    {
        public function __construct()
        {
            $this->load->database();
        }

        public function add_transaction($uid, $wallet_id, $category_id, $amount, $date, $note, $flow)
        {
            $this->db->set('user_id', $uid);
            $this->db->set('wallet_id', $wallet_id);
            $this->db->set('category_id', $category_id);
            $this->db->set('amount', $amount);
            $this->db->set('date', $date);
            $this->db->set('note', $note);
            $this->db->set('inflow', $flow);
            $this->db->insert('transactions');
        }

        public function get_all_transactions($uid, $wallet_id)
        {
            $this->db->where('user_id', $uid);
            $this->db->where('wallet_id', $wallet_id);
            $query = $this->db->get('transactions');

            return $query->result_array();
        }

        public function get_total_inflow($uid, $wallet_id)
        {
            $total = 0;
            $this->db->where('user_id', $uid);
            $this->db->where('wallet_id', $wallet_id);
            $this->db->where('inflow', 1);
            $query = $this->db->get('transactions');

            foreach($query->result() as $row)
            {
                $total += $row->amount;
            }
            return $total;
        }

        public function get_total_outflow($uid, $wallet_id)
        {
            $total = 0;
            $this->db->where('user_id', $uid);
            $this->db->where('wallet_id', $wallet_id);
            $this->db->where('inflow', 0);
            $query = $this->db->get('transactions');

            foreach($query->result() as $row)
            {
                $total+= $row->amount;
            }
            return $total;
        }

        public function group_all_transactions($uid, $wallet_id)
        {
            $this->db->select('*');
            $this->db->from('transactions a');
            $this->db->where('a.user_id', $uid);
            $this->db->where('a.wallet_id', $wallet_id);
            $this->db->join('categories b', 'b.id=a.category_id', 'left');
            $this->db->join('wallets c', 'c.id=a.wallet_id', 'left');
            $query = $this->db->get();
            if($query->num_rows() != 0)
            {
                return $query->result_array();
            }
            else
            {
                return 'not true';
            }
        }

        public function get_transaction_filtered($uid, $wallet_id, $month, $year)
        {
            $this->db->select('*');
            $this->db->from('transactions a');
            $this->db->where('a.user_id', $uid);
            $this->db->where('a.wallet_id', $wallet_id);
            $this->db->where('month(a.date)', $month);
            $this->db->where('year(a.date)', $year);
            $this->db->join('categories b', 'a.category_id=b.id', 'left inner');
            $this->db->join('wallets c', 'a.wallet_id=c.id', 'left inner');
            $query = $this->db->get();
            if($query->num_rows() >=1){
                return $query->result_array();
            }
            else
            {
                return false;
            }
        }

        public function get_total_outflow_month($uid, $wallet_id, $month, $year)
        {
            $total = 0;
            $this->db->where('user_id', $uid);
            $this->db->where('wallet_id', $wallet_id);
            $this->db->where('month(date)', $month);
            $this->db->where('year(date)', $year);
            $this->db->where('inflow', 0);
            $query = $this->db->get('transactions');

            foreach($query->result() as $row)
            {
                $total+= $row->amount;
            }
            return $total;

        }
        public function get_total_inflow_month($uid, $wallet_id, $month, $year)
        {
            $total = 0;
            $this->db->where('user_id', $uid);
            $this->db->where('wallet_id', $wallet_id);
            $this->db->where('month(date)', $month);
            $this->db->where('year(date)', $year);
            $this->db->where('inflow', 1);
            $query = $this->db->get('transactions');

            foreach($query->result() as $row)
            {
                $total+= $row->amount;
            }
            return $total;

        }

        public function get_by_id($uid, $wallet_id, $id){
            $this->db->select('*');
            $this->db->from('transactions a');
            $this->db->where('a.user_id', $uid);
            $this->db->where('a.wallet_id', $wallet_id);
            $this->db->where('a.transaction_id',$id);
            $this->db->join('categories b', 'a.category_id=b.id', 'left inner');
            $this->db->join('wallets c', 'a.wallet_id=c.id', 'left inner');
            $query = $this->db->get();
            if($query->num_rows() == 1){
                return $query->result_array();
            }
            else
            return false;
        }

        public function delete_record($uid, $wallet_id, $id){
            $this->db->where('transaction_id', $id);
            $this->db->where('user_id', $uid);
            $this->db->where('wallet_id', $wallet_id);
            $this->db->delete('transactions');
        }

        public function get_sum_year($month, $year){
            $uid = 3;
            $wallet_id = 4;
            $this->db->select_sum('amount');
            $this->db->from('transactions a');
            $this->db->where('a.user_id', $uid);
            $this->db->where('a.wallet_id', $wallet_id);
            $this->db->where('a.inflow', 0);
            $this->db->where('month(date)', $month);
            $this->db->where('year(date)', $year);
            $this->db->join('categories b', 'a.category_id=b.id', 'left inner');
            $this->db->join('wallets c', 'a.wallet_id=c.id', 'left inner');
            $this->db->select('b.cat_name');
            $this->db->group_by('b.cat_name');
            $query = $this->db->get();
            if($query->num_rows() > 0){
                return $query->result_array();
            }
        }
    }
?>