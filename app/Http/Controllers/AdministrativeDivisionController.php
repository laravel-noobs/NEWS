<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
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


    public function getDistricts($province_id)
    {
        return District::with('type')->where('province_id', '=', $province_id)->get();
    }


    public function getWards($district_id)
    {
        return Ward::with('type')->where('district_id', '=', $district_id)->get();
    }
}
