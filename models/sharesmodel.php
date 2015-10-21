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

    function create($data)
    {
        $this->event->register("BeforeCreateShare", $data);
        $return = true;
        $this->db->select("id");
        $this->db->from("shares");
        $this->db->where("share_name", $data['share_name']);
        $query = $this->db->get();
        $result = $query->result();
        if (count($result) > 0) {
            $return = false;
            $this->notifications->setError("\"" . $data['share_name'] . "\" " . $this->lang->line("share_name_already_used"));
        }
        if ($return) {
            $insert = array(
                "share_name" => $data['share_name'],
                "buying_price" => $data['buying_price'],
                "selling_price" => $data['selling_price'],
                "quantity" => $data['quantity'],
                "commision" => $data['commision'],
                "status" => $data['status']
            );
            $this->db->insert("shares", $insert);
            $item_id = $this->db->insert_id();
            $this->event->register("AfterCreateShare", $data, $item_id);
            $this->SystemLog->write("shares", "shares", "create", 1, "Share \"" . $data['share_name'] . "\" has been created in the system");
        }
        return $return;
    }

    function getItem($item_id)
    {
        $return = false;
        $this->db->select("shares.*");
        $this->db->from("shares");
        $this->db->where("shares.id", $item_id);
        $this->event->register("BuildShareQuery", $item_id);
        $query = $this->db->get();
        $result = $query->result();
        if (count($result) > 0) {
            $return = $result[0];
        }
        return $return;
    }

    function delete($item_id)
    {
        $this->event->register("BeforeDeleteShare", $item_id);
        $client = $this->getItem($item_id);
        $this->db->where("id", $item_id);
        $this->db->delete("shares");
        $this->event->register("AfterDeleteShare", $item_id);
        $this->SystemLog->write("shares", "shares", "delete", 3, "Share \"" . $client->full_name . "\" has been deleted from the system");
        return true;
    }

}