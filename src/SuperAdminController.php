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
use Queue;

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
    // return view('vendor.superadmin.deactivatedusers',$users);
    return response()->json($users);
  }


	public function usercreate(Request $request){
    $input = $request->all();
    $this->validate($request, [
        'login' => 'required|unique:users',
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
    if(!$branch){
      $Admin_user = User::where('location_id',$input['location_id'])->where('role_id',2)->first();
      if(!$Admin_user){
        return redirect()->back()->withErrors(['Unable to find Location.']);
      }
      $branch = branch::find($Admin_user->branch_id);
    }
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
        return redirect()->back()->withErrors(['Unable to create user.']);
      }
    }else{
      return redirect()->back()->withErrors(['Unable to create user.']);
    }
    \Session::flash('success_message','Student Created Successfully');
    return redirect()->back();

  }

  public function userupdate(Request $request){
    $input = $request->all();
    $user  = User::findOrFail($input['user_id']);
    $this->validate($request, [
        'login' => 'required|unique:users,login,'.$user->id,
        'firstname' => 'required',
        'lastname' =>'required',
        'email'=>'required|unique:users,email,'.$user->id,
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
    \Session::flash('success_message','Student Updated Successfully');
    return redirect()->back();

  }

  public function userdeactivate($id)
  {
    $user = User::findOrFail($id);
    $result = json_decode($this->efront->DeactivateUser($user->efront_user_id));
    if($result->success){
      $user->delete();
    }else{
      \Session::flash('fail_message','Student not update, please contact the support team.');
      return redirect()->back();
    }
    \Session::flash('success_message','Student deactivated Successfully');
    return redirect()->back();

  }

  public function useractivate($id)
  {
    $user=User::onlyTrashed()->findOrFail($id);
		$result = json_decode($this->efront->ActivateUser($user->efront_user_id));
		if($result->success){
			$user=User::onlyTrashed()->where('id',$id)->restore();
			\Session::flash('success_message','Student has been Activated Successfully');
		}
		else{
			\Session::flash('fail_message','Student has not been Activated');
		}
		return redirect()->back();

  }

  public function locationlist(){
    JavaScript::put(['locations' => Location::all()]);
    return view('vendor.superadmin.locations');
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
      \Session::flash('success_message','Location created Successfully');
    }else{
      \Session::flash('fail_message','Location not created, Contact support team.');
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
    $group = Group::find($group_id);
    if(!$group){
      return "Given group Id is wrong";
    }
    $groupUsers = Group::find($group_id)->groupUsers;
    if(!$groupUsers){
      $groupUsers = [];
    }
    $usersNotInGroup = Group::findOrFail($group_id)->usersNotInGroup();
    if(!$usersNotInGroup){
      $usersNotInGroup = [];
    }
    $result = ['users_in_group'=>$groupUsers,'users_not_in_group'=>$usersNotInGroup];
    return response()->json($result);
  }

  public function getallgroupusers()
  {
    JavaScript::put(['group_users' => Group::with('groupUsers')->get()]);
    return view('vendor.superadmin.groupusers');
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
			\Session::flash('success_message','Student is Assigned to '.$group->group_name);
		}
		else{
			\Session::flash('fail_message','Student has NOT been Assigned to '.$group->group_name);
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
      \Session::flash('fail_message','Student is not assigned to '.$group->group_name);
      return redirect()->back()->withErrors(["Student is not assigned to $group->group_name"]);
    }
    $result = json_decode($this->efront->RemoveUserFromGroup($user->efront_user_id,$group->efront_group_id));
    if($result->success){
			$user = User::find($input['user_id']);
			$user->usergroups()->detach($input['group_id']);
			\Session::flash('success_message','Student is Removed from '.$group->group_name);
		}
		else{
			\Session::flash('fail_message','Student has NOT been Removed from'.$group->group_name);
		}
		return redirect()->back();
  }
  public function grouplist()
  {
    $result = Group::all();
    return response()->json($result);
  }
  public function rolelist()
  {
    JavaScript::put(['roles' => Role::orderBy('role')->get()]);
    return view('vendor.superadmin.rolelist');
  }
  public function rolegroups($role_id)
  {
    $role = Role::findOrFail($role_id);
    $groups_in_role = $role->groups()->get();
    $groups_not_in_role = $role->groupsNotInRole();
    return response()->json(['groups_in_role'=>$groups_in_role,'groups_not_in_role'=>$groups_not_in_role]);

  }
  public function rolestore(Request $request)
  {
    $this->validate($request, [
        'role_name' => 'required|unique:roles,role',
    ]);
    $input = $request->all();
    $role = Role::create(['role'=>$input['role_name']]);
    \Session::flash('success_message','Role is Successfully created');
    return redirect()->back();
  }
  public function assignrolegroup(Request $request)
  {
    $this->validate($request,[
          'role_id' => 'required|exists:roles,id',
          'group_id'=> 'required|exists:groups,id'
      ]);
    $input = $request->all();
    $role = Role::findOrFail($input['role_id']);
    $group = Group::findOrFail($input['group_id']);
    $role_groups = $role->groups()->where('group_id',$input['group_id'])->get();
    if(!$role_groups){
      return redirect()->back()->withErrors(["group is already assigned with the role"]);
    }
    $role->groups()->attach($input['group_id']);
    $role_users = $role->users()->get();
    foreach($role_users as $role_user){
      Queue::push(new userAssignToGroup(['efront_user_id'=>$role_user->efront_user_id,'efront_group_id'=>$group->efront_group_id]));
      $role_user->usersgroups()->attach($group->id);
    }
    \Session::flash('success_message','Group is assigned to the role');
    return redirect()->back();
  }

  public function removerolegroup(Request $request)
  {
    $this->validate($request,[
      'role_id'=>'required|exists:roles,id',
      'group_id'=> 'required|exists:groups,id'
    ]);
    $input = $request->all();
    $role = Role::findOrFail($input['role_id']);
    $group = Role::findOrFail($input['group_id']);
    $role->groups()->detach($input['group_id']);
    $role_users = $role->users()->get();
    foreach($role_users as $role_user){
      Queue::push(new userRemoveFromGroup(['efront_user_id'=>$role_user->efront_user_id,'efront_group_id'=>$group->efront_group_id]));
      $role_user->usergroups()->detach($group->id);
    }
    \Session::flash('success_message','Group is removed from the role');
    return redirect()->back();
  }

  public function roleusers($role_id)
  {
    $role = Role::findOrFail($role_id);
    $users_in_role = $role->users;
    $users_not_in_role = $role->usersNotInRole();
    return response()->json(['users_in_role'=>$users_in_role,'users_not_in_role'=>$users_not_in_role]);
  }

  public function assignroleuser(Request $request){
    $this->validate($request,[
      'role_id'=>'required|exists:roles,id',
      'user_id'=> 'required|exists:users,id'
    ]);
    $input = $request->all();
    $role = Role::findOrFail($input['role_id']);
    $user = User::findOrFail($input['user_id']);
    $user_groups = $user->usergroups;
    foreach($user_groups as $group){
      Queue::push(new userRemoveFromGroup(['efront_user_id'=>$user->efront_user_id,'efront_group_id'=>$group->efront_group_id]));
      $user->usergroups()->detach($group->id);
    }
    $user->role_id = $role->id;
    $user->save();
    $role_groups = $role->groups;
    foreach($role_groups as $group){
      Queue::push(new userAssignToGroup(['efront_user_id'=>$user->efront_user_id,'efront_group_id'=>$group->efront_group_id]));
      $user->usergroups()->attach($group->id);
    }
    \Session::flash('success_message','User is assigned to the role');
    return redirect()->back();
  }

  public function removeroleuser(Request $request){
    $this->validate($request,[
      'role_id'=>'required|exists:roles,id',
      'user_id'=> 'required|exists:users,id'
    ]);
    $input = $request->all();
    $role = Role::findOrFail($input['role_id']);
    $user = User::findOrFail($input['user_id']);
    $user_groups = $user->usergroups;
    foreach($user_groups as $group){
      Queue::push(new userRemoveFromGroup(['efront_user_id'=>$user->efront_user_id,'efront_group_id'=>$group->efront_group_id]));
      $user->usergroups()->detach($group->id);
    }
    $user->role_id = $this->student_role_id;
    $user->save();
    \Session::flash('success_message',"User is removed from the role $role->role and assigned to Student Role");
    return redirect()->back();
  }

}
