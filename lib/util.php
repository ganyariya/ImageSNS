<?php

    function h($string) {
        if (is_array($string)) {
            return array_map("myhtmlspecialchars", $string);
        } else {
            return htmlspecialchars($string, ENT_QUOTES);
        }
    }