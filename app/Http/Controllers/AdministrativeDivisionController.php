<?php

namespace App\Http\Controllers;

use App\Province;
use App\District;
use App\Ward;

class AdministrativeDivisionController extends Controller
{
    /**
     * @return mixed
     */
    public function getProvinces()
    {
        return Province::with('type')->get();
    }

    /**
     * @param $province_id
     * @return $this
     */
    public function getDistricts($province_id)
    {
        return District::with('type')->where('province_id', '=', $province_id)->get();
    }

    /**
     * @param $district_id
     * @return $this
     */
    public function getWards($district_id)
    {
        return Ward::with('type')->where('district_id', '=', $district_id)->get();
    }
}
