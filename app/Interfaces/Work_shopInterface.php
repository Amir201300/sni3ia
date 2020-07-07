<?php

namespace App\Interfaces;

interface Work_shopInterface {
    /**
     * @param $request
     * @return mixed
     */
    public function save_live_service($request);

    /**
     * @param $request
     * @return mixed
     */
    public function save_home_service($request);

    /**
     * @param $request
     * @return mixed
     */
    public function save_industrial($request);

}