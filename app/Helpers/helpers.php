<?php

use App\Models\StaticBlock;

    function getBlock($slug){
        $block=StaticBlock::where('slug', $slug)->first();
        return $block->content;
    }
?>
