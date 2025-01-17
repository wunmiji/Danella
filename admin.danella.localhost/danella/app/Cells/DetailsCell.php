<?php

namespace App\Cells;



class DetailsCell {

    public function detailsCardHeader ($data) : string {
        return view('cells/details/details_card_header', $data);
    }

    public function basic ($data) : string {
        return view('cells/details/basic', $data);
    }

    public function basicDl ($data) : string {
        return view('cells/details/basic_dl', $data);
    }
    
}
