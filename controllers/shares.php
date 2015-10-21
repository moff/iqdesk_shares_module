<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Shares extends MX_Controller
{
    var $check_permissions = true;

    public function index()
    {
        $this->view_data['page_title'] = $this->lang->line("shares");
        $params = array();
        $get = $this->input->get(NULL, TRUE, TRUE);

        $sorting = array();
        if (isset($get['sort-column']) && @$get['sort-column'] != "") {
            $sorting['sort-column'] = $get['sort-column'];
            $sorting['sort-direction'] = "asc";
            if (isset($get['sort-direction'])) {
                if (strtolower($get['sort-direction']) == "asc" || strtolower($get['sort-direction']) == "desc") {
                    $sorting['sort-direction'] = $get['sort-direction'];
                }
            }
        }

        $page = 0;
        if (isset($get['page'])) {
            if (is_numeric($get['page']) && $get['page'] >= 0) {
                $page = $get['page'];
            }
        }

        $this->load->model('SharesModel');
        $this->view_data['items'] = $this->SharesModel->getItems($params, $sorting, $page);
        $total_items = $this->SharesModel->total_count;
        $this->pagination->setNumbers(count($this->view_data['items']), $total_items);
        $sidebar_params = array(
            "name" => "left-sidebar",
            "title" => $this->lang->line("filters"),
            "position" => "left",
            "is_filter" => true,
            "filter_action" => base_url() . "shares/shares/index",
            "submit_button" => $this->lang->line("apply_filters"),
            "reset_button" => $this->lang->line("reset_filters"),
            "filter_event" => "SharesFilterFormRow",
            "elements" => array(
                array(
                    "type" => "text",
                    "name" => "share_name",
                    "placeholder" => $this->lang->line("search_company_name")
                ),
            )
        );
        $this->sidebar->register($sidebar_params);
        $this->load->view('general/header', $this->view_data);
        $this->load->view('listing/index', $this->view_data);
        $this->load->view('general/footer', $this->view_data);

    }

}
