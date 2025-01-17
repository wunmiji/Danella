<?php

namespace App\Cells;



class ErrorCell {

    public function error () : string {
        return view('cells/error/error');
    }
    
}
