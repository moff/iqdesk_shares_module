<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Shares extends MX_Controller
{
    var $check_permissions = true;

    public function index()
    {
        $this->view_data['page_title'] = $this->lang->line("shares");
        $params = array();
        $get = $this->input->get(NULL, TRUE, TRUE);

        if (isset($get['apply_filters']) && isset($get['filter'])) {
            $params = $get['filter'];
        }

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
                    "placeholder" => $this->lang->line("search_share_name")
                ),
            )
        );
        $this->sidebar->register($sidebar_params);
        $this->load->view('general/header', $this->view_data);
        $this->load->view('shares/shares/index', $this->view_data);
        $this->load->view('general/footer', $this->view_data);

    }

    public function create()
    {
        $this->load->model('SharesModel');
        if ($data = $this->input->post(NULL, TRUE)) {
            if ($this->SharesModel->create($data)) {
                $this->notifications->setMessage($this->lang->line("share_created_successfully"));
            }
            redirect($_SERVER['HTTP_REFERER']);
        }
        $this->load->view('shares/shares/create', $this->view_data);
    }

    public function update()
    {
        $this->load->model('SharesModel');
        if ($this->uri->segment(4) !== FALSE) {
            if ($data = $this->input->post(NULL, TRUE)) {
                if ($this->SharesModel->update($data, $this->uri->segment(4))) {
                    $this->notifications->setMessage($this->lang->line("share_updated_successfully"));
                }
                redirect($_SERVER['HTTP_REFERER']);
            }
            $this->view_data['item'] = $this->SharesModel->getItem($this->uri->segment(4));
            if ($this->view_data['item'] === false) {
                $this->load->view('errors/notfound', $this->view_data);
            } else {
                $this->load->view('shares/shares/update', $this->view_data);
            }
        } else {
            $this->load->view('errors/wrongparameters', $this->view_data);
        }
    }

    public function delete()
    {
        if ($this->uri->segment(4) !== FALSE) {
            $this->load->model('SharesModel');
            if ($this->SharesModel->delete($this->uri->segment(4))) {
                $this->notifications->setMessage($this->lang->line("share_deleted_successfully"));
            }
        } else {
            $this->notifications->setError($this->lang->line("wrong_parameters"));
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

}
