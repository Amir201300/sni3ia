<?php

/**
 * @return string
 */
function getUserLang()
{
    return Auth::user()->lang;
}