<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Person;
use App\Models\Freelancer;

use App\Traits\ResponseTrait;

class PersonController extends Controller
{

    use ResponseTrait;
    //
    public function index()
    {
        $persons = Freelancer::all();
        return response()->json($persons);
    }

    public function all()
    {
        $persons = Freelancer::all();
        return $this->returnData($persons, "Success");
    }
}
