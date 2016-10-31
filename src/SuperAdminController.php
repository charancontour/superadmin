<?php namespace SuperAdmin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Dalata\Repositories\EfrontApiInterface;

use App\User;
use App\branch;
use App\Role;
use App\Location;
use App\Group;

use Hash;
use Auth;
use Config;
use JavaScript;

class SuperAdminController extends Controller {

  public $active_status_id = 1;
  public $efront;
  public $student_role_id = 3;
  public function __construct(EfrontApiInterface $efront)
	{
		$this->efront = $efront;
	}

  public function usersget(){
    JavaScript::put(['users' => User::all()]);
    return view('vendor.superadmin.user-list');
  }

  public function deactivatedusers()
  {
    $users = User::onlyTrashed()->get();
    return response()->json($users);
  }


	public function usercreate(Request $request){
    $input = $request->all();
    $this->validate($request, [
        'login' => 'required|unique',
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
      $user->email = $input['email'];
      if($user->branch_id != $input['branch_id']){
        $result_branch = json_decode($this->efront->AddUserToBranch($user->efront_user_id,$branch->efront_branch_id));
        if($result_branch->success){
          $user->branch_id = $branch->id;
          $user->location_id = $location->id;
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

  public function locationlist(){
    $locations = Location::all();
    return response()->json($locations);
  }

  public function createlocation(Request $request){
    $input = $request->all();
    $branch_input = [];
    $branch_input['name'] = $input['location_name'];
    $branch_input['url'] = $input['location_name'];
    $this->validate($request, [
        'location_name' => 'required|unique:locations,location_name|unique:branches,efront_branch_name',
    ]);

    $result = json_decode($this->efront->CreateBranch($branch_input));
    if($result->success){
      $new_branch = new branch;
      $new_branch->efront_branch_name = $branch_input['name'];
      $new_branch->efront_branch_id = $result->branchId;
      $new_branch->save();
      $new_location = new Location;
      $new_location->location_name = $branch_input['name'];
      $new_location->save();
      \Session::flash('flash_message','Location created Successfully');
    }else{
      \Session::flash('flash_message','Location not created, Contact support team.');
    }

    return redirect()->back();
  }

  public function locationusers($location_id)
  {
    $result = Location::findOrFail($location_id)->users;
    return response()->json($result);
  }

  public function groupusers($group_id)
  {
    $result = Group::findOrFail($group_id)->groupUsers;
    return response()->json($result);
  }

  public function getallgroupusers()
  {
    $result = Group::with('groupUsers')->get();
    return response()->json($result);
  }

  public function assignusertogroup(Request $request)
  {
    $this->validate($request, [
        'group_id' => 'required|exists:groups,id',
        'user_id' => 'required|exists:users,id'
    ]);

    $input = $request->all();
		$user = User::findOrFail($input['user_id']);
		$group = Group::findOrFail($input['group_id']);
		$result = json_decode($this->efront->AddUserToGroup($user->efront_user_id,$group->efront_group_id));
		if($result->success){
			$user = User::find($input['user_id']);
			$user->usergroups()->attach($input['group_id']);
			\Session::flash('flash_message','Student is Assigned to '.$group->group_name);
		}
		else{
			\Session::flash('flash_message','Student has NOT been Assigned to '.$group->group_name);
		}
		return redirect()->back();
  }

  public function removeuserfromgroup(Request $request)
  {
    $this->validate($request, [
        'group_id' => 'required|exists:groups,id',
        'user_id' => 'required|exists:users,id'
    ]);

    $input = $request->all();
		$user = User::findOrFail($input['user_id']);
		$group_user = Group::findOrFail($input['group_id'])->groupUsers()->where('users.id',$user->id)->first();
    $group = Group::findOrFail($input['group_id']);
    if(!$group_user){
      \Session::flash('flash_message','Student is not assigned to '.$group->group_name);
      return redirect()->back()->withErrors(["Student is not assigned to $group->group_name"]);
    }
    $result = json_decode($this->efront->RemoveUserFromGroup($user->efront_user_id,$group->efront_group_id));
    if($result->success){
			$user = User::find($input['user_id']);
			$user->usergroups()->detach($input['group_id']);
			\Session::flash('flash_message','Student is Removed from '.$group->group_name);
		}
		else{
			\Session::flash('flash_message','Student has NOT been Removed from'.$group->group_name);
		}
		return redirect()->back();
  }


}