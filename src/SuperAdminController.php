<?php namespace SuperAdmin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Dalata\Repositories\EfrontApiInterface;

use App\User;
use App\branch;
use App\Role;
use App\Location;

use Hash;
use Auth;
use Config;


class SuperAdminController extends Controller {

  public $active_status_id = 1;
  public $efront;
  public $student_role_id = 3;
  public function __construct(EfrontApiInterface $efront)
	{
		$this->efront = $efront;
	}

  public function usersget(){
    $users = User::all();
    return response()->json($users);
  }


	public function usercreate(Request $request){
    $input = $request->all();
    $this->validate($request, [
        'login' => 'required',
        'firstname' => 'required',
        'lastname' =>'required',
        'email'=>'required|unique:users',
        'location_id'=>'required|exists:locations,id',
        'password'=>'required',
        'confirm-password'=>'required|same:password'
    ]);
    if(is_numeric($input['login'])){
      $input['login'] = Config::get('efront.LoginPrefix') . $input['login'];
    }
    $input['user_status_id'] = $this->active_status_id;
    $location = Location::find($input['location_id']);
    $branch = branch::where('efront_branch_name',$location->location_name)->first();
    $input['branch_id'] = $branch->id;
    $input['role_id'] = $this->student_role_id;
    $result = json_decode($this->efront->CreateUser($input));
    if($result->success){
      $input['password'] = Hash::make($input['password']);
      $input['efront_user_id'] = $result->data->id;
      $result_branch = json_decode($this->efront->AddUserToBranch($input['efront_user_id'],$branch->efront_branch_id));
      if($result_branch->success){
        $user = User::create($input);
      }else{
        return redirect()->back()->withErrors(['unable to create user']);
      }
    }else{
      return redirect()->back()->withErrors(['unable to create user']);
    }
    \Session::flash('flash_message','Student Created Successfully');
    return redirect()->back();

  }

  public function userupdate(Request $request){
    $input = $request->all();
    $user  = User::findOrFail($input['user_id']);
    $this->validate($request, [
        'login' => 'required',
        'firstname' => 'required',
        'lastname' =>'required',
        'email'=>'required|unique:users,login,'.$user->id,
        'location_id'=>'required|exists:locations,id',
        'confirm-password'=>'same:password'
    ]);
    if(is_numeric($input['login'])){
      $input['login'] = Config::get('efront.LoginPrefix') . $input['login'];
    }
    $input['user_status_id'] = $this->active_status_id;
    $location = Location::findOrFail($input['location_id']);
    $branch = branch::where('efront_branch_name',$location->location_name)->first();
    $input['branch_id'] = $branch->id;
    $result = json_decode($this->efront->EditUser($user->efront_user_id,$input));

    if($result->success){
      if($input['password']){
        $input['password'] = Hash::make($input['password']);
        $user->password = $input['password'];
      }
      $user->login = $input['login'];
      $user->firstname = $input['firstname'];
      $user->lastname = $input['lastname'];
      if($user->branch_id != $input['branch_id']){
        $result_branch = json_decode($this->efront->AddUserToBranch($user->efront_user_id,$branch->efront_branch_id));
        if($result_branch->success){
          $user->branch_id = $branch->id;
        }
      }
      $user->save();
    }else{
      return redirect()->back()->withErrors(['unable to create user']);
    }
    \Session::flash('flash_message','Student Updated Successfully');
    return redirect()->back();

  }

  public function userdeactivate($id)
  {
    $user = User::findOrFail($id);
    $result = json_decode($this->efront->DeactivateUser($user->efront_user_id));
    if($result->success){
      $user->delete();
    }else{
      \Session::flash('flash_message','Student not update, please contact the support team.');
      return redirect()->back();
    }
    \Session::flash('flash_message','Student deactivated Successfully');
    return redirect()->back();

  }

  public function useractivate($id)
  {
    $user=User::onlyTrashed()->findOrFail($id);
		$result = json_decode($this->efront->ActivateUser($user->efront_user_id));
		if($result->success){
			$user=User::onlyTrashed()->where('id',$id)->restore();
			\Session::flash('flash_message','Student has been Activated Successfully');
		}
		else{
			\Session::flash('flash_message','Student has not been Activated');
		}
		return redirect('deactivatedstudents');

  }


}
