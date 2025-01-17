<?php

namespace App\Cells;



class MainCell {

    public function carousel ($data) : string {
        return view('cells/main/carousel', $data);
    }

    public function testimonial ($data) : string {
        return view('cells/main/testimonial', $data);
    }

    public function anchorElement ($data) : string {
        return view('cells/main/anchor_element', $data);
    }
    
}
