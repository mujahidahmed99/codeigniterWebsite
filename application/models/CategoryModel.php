<?php 
    class CategoryModel extends CI_Model
    {
        public function __construct()
        {
            $this->load->database();
        }

        public function get_category_items($category)
        {
            $this->db->where('type', $category);
            // SELECT * FROM categories WHERE type = '$category'
            $query = $this->db->get('categories');
            $data = $query->result();
            return $data;

        }

        public function get_category_id($category)
        {
            $this->db->where('cat_name', $category);
            $query = $this->db->get('categories');

            return $query->result_array();
        }

        public function get_all_categories()
        {
            $query = $this->db->get('categories');
            return $query->result_array();

        }

        public function check_inflow_outflow($category_id)
        {
            $this->db->where('id', $category_id);
            $query = $this->db->get('categories');
            
            if($query->num_rows() == 1)
            {
                $result = $query->row()->type;
                if($result == 'Income'){
                    return 1;
                }
                else
                {
                    return 0;
                }
            }
            else
            {
                return false;
            }
        }
    }


?>