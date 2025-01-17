<?php

namespace App\Cells;



class AlertCell {

    public function contact () : string {
        return view('cells/alert/alert_session_message');
    }

    public function ajaxFailAlert () : string {
        return view('cells/alert/alert_ajax_fail_message');
    }

    public function formValidation ($name) : string {
        $data['inputName'] = $name;

        return view('cells/alert/form_validation', $data);
    }
    
}
