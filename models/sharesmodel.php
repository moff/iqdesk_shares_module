<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class SharesModel extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function getItems($params = array(), $sorting = array(), $page = -1)
    {
        $return = array();
        $this->db->select("shares.*");
        $this->db->from("shares as shares");

        if (isset($params['share_name'])) {
            if (str_replace(" ", "", $params['share_name']) != "") {
                $this->db->where("shares.`share_name` LIKE '%" . $this->db->escape_like_str($params['share_name']) . "%'", NULL, false);
            }
        }

        if (isset($sorting['sort-column']) && isset($sorting['sort-direction'])) {
            $this->db->order_by($sorting['sort-column'], $sorting['sort-direction']);
        } else {
            $this->db->order_by("shares.share_name", "asc");
        }

        $this->event->register("BuildSharesQuery");
        $this->total_count = $this->db->get_total_count();

        if ($page != -1) {
            $this->db->limit($this->pagination->count_per_page, $page * $this->pagination->count_per_page);
        }

        $query = $this->db->get();
        $return = $query->result();

        return $return;
    }

}