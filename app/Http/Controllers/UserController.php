<?php

namespace App\Http\Controllers;
use App\Model\UserJob;
use Illuminate\Http\Request;
use App\Model\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

Class UserController extends Controller
{
    use ApiResponse;

    private $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    // =========== FRONT END PART ===========
    public function login(){
        return view('login');
    }

    public function submit(){
        $user = $_POST["username"];
        $pass = $_POST["password"];

        $data = User::all();

        foreach ($data as $acc){
            $realUser = $acc->username;
            if($user == $realUser){
                $realPass = $acc->password;
                if($pass == $realPass){
                    return 'You have successfully login!';
                }
                if($pass != $realPass){
                    return 'Username or password is incorrect.';
                }
            }
//            if($user != $realUser){
//                return  'Username or password is incorrect.';
//            }


        }

    }

    // ============== CRUD PART  ============
    public function getUsers()
    {
        $users = User::all();
        //return response()->json($users, 200);
        return $this->successResponse($users);
    }

    //show all data
    public function index(){
        $users = User::all();
        return $this->successResponse($users);
    }

    //add new record
    public function addUser(Request $request){
        $rule=[
            'username' => 'required|max:20',
            'password' => 'required|max:20',
            'jobid' => 'required|numeric|min:1|not_in:0',

        ];
        
        $this->validate($request, $rule);//parameters(the request, the rule)

        $userjob = UserJob::findOrFail($request->jobid);
        $user = User::create($request -> all());
        if($userjob->isClean()){
            return $this->successResponse2();
        }else{
            return $this->errorResponse("job id does not exist .",Response::HTTP_NOT_FOUND);
        }
        
    }

    //display user by id
    public function showUser($id){
        //$user = User::findOrFail($id);
        $user = User::where('id',$id)->first();
        if ($user){
            return $this->successResponse($user);
        }else{
            return $this->errorResponse("user not found.",Response::HTTP_NOT_FOUND);
        }

    }

    //update a record
    public function updateUsers(Request $request, $id){
        $rule=[
            'username' => 'max:20',
            'password' => 'max:20',
            'jobid' => 'required|numeric|min:1|not_in:0',

        ];
        $this->validate($request, $rules);
        //$user = User::findOrFail($id);

        $userjob = UserJob::findOrFail($request->jobid);

        $user = User::where('id',$id)->first();
        if($user){
            $user->fill($request->all());

            if($user->isClean()){
                return $this->errorResponse("No changes have been made.", Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }else{
            return $this->errorResponse("user not found.",Response::HTTP_NOT_FOUND);
        }

        $user->save();
        return $this->successResponse($user);
    }

    //Delete a record
    public function removeUser($id){
        $user = User::where('id', $id)->first();//contains id // id = 4
        if($user){

            $user->delete();
            return $this->successResponse4();
        }else{
            return $this->errorResponse("user not found.", Response::HTTP_NOT_FOUND);
        }
    }
}
?>
