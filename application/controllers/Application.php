<?php

class Application extends CI_Controller {

    function Application() {
        parent::__construct();
        $this->load->library('HighCharts_lib.php');
    }


    private function index(){
        $data['charts'] = $this->getChart($studentName);
        $this->load->view('admin/charts',$data);
    }

    private function getChart($stuName) {

        $this->highcharts->set_title('Name of Student :' . $stuName);
        $this->highcharts->set_dimensions(740, 300);
        $this->highcharts->set_axis_titles('Date', 'Age');
        $credits->href = base_url();
        $credits->text = "Code 2 Learn : HighCharts";
        $this->highcharts->set_credits($credits);
        $this->highcharts->render_to("content_top");

        $result = $this->student_name->getStudentDetails($stuName);

        if ($myrow = mysql_fetch_array($result)) {
            do {
                $value[] = intval($myrow["age"]);
                $date[] = ($myrow["date"]);
            } while ($myrow = mysql_fetch_array($result));
        }

        $this->highcharts->push_xcategorie($date);

        $serie['data'] = $value;
        $this->highcharts->export_file("Code 2 Learn Chart".date('d M Y'));
        $this->highcharts->set_serie($serie, "Age");

        return $this->highcharts->render();

    }
}

?>