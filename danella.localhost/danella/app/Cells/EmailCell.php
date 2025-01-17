<?php

namespace App\Cells;



class EmailCell {

    
    public function contactForm ($data) : string {
        return view('cells/email/contact_form', $data);
    }

    public function quoteForm ($data) : string {
        return view('cells/email/quote_form', $data);
    }
    
}
