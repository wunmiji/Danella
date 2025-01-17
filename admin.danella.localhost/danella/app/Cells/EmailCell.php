<?php

namespace App\Cells;



class EmailCell {

    public function passwordReset ($data) : string {
        return view('cells/email/password_reset', $data);
    }
    
}
