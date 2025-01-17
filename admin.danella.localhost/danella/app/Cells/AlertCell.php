<?php

namespace App\Cells;



class AlertCell {

    
    public function alertPost () : string {
        return view('cells/alert/alert_message');
    }

    public function formValidation ($name) : string {
        $data['inputName'] = $name;

        return view('cells/alert/form_validation', $data);
    }
    
}
