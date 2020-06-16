<?php

/**
 * @return string
 */
function getUserLang()
{
    return Auth::user()->lang;
}


function get_seetings()
{
    return \App\Models\setting::first();
}