<?php
namespace App\Http\Controllers;
use App\User;
use App\Model\UserJob; // <-- your model islocated inside Models Folder
use Illuminate\Http\Response; // Response Components
use App\Traits\ApiResponse; // <-- use to standardized our code for api response
use Illuminate\Http\Request; // <-- handling http request in lumen
//use DB; // <-- if your not using lumen eloquent you can use DBcomponent in lumen

Class UserJobController extends Controller {

    use ApiResponse;
    private $request;

    public function __construct(Request $request){
        $this->request = $request;
    }

    public function index(){
        $usersjob = UserJob::all();
        return $this->successResponse($usersjob);

    }

    public function show($id){
        $userjob = UserJob::findOrFail($id);
        return $this->successResponse($userjob);
    }
}