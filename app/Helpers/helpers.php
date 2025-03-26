<?php

use App\Models\StaticBlock;

    function getBlock($slug){
        return StaticBlock::where('slug', $slug)->where('status',1)->first();
        // if($block){
        //     return $block->content;
        // }
        // return '';
        // return $block->content;
    }
?>
