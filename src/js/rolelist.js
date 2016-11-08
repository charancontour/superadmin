var roles = awake.roles;

var rolesWrapper = document.getElementById('rolesTable');

var rolesTable = drawRoleTable(roles);

function drawRoleTable(data)
{
	var table = document.createElement('table');
		table.setAttribute('class','table table-bordered bordered table-striped table-condensed')
		table.setAttribute('id','role-table');

	var thead = document.createElement('thead');
		
	var theader = document.createElement('tr');
			
	var colNames = ['Name','Actions'];

	for(var i=0; i < colNames.length; i++)			
	{
		var th = document.createElement('th');
			th.innerHTML = colNames[i];
		
		theader.appendChild(th);
	}	
	
	thead.appendChild(theader);

	table.appendChild(thead);

	var tbody = document.createElement('tbody');

	for(var i=0; i < data.length; i++)
	{
		var tr = document.createElement('tr');
		
		var td = document.createElement('td');
			td.innerHTML = data[i].role;
			td.setAttribute('style','text-transform:capitalize');
		tr.appendChild(td);	

		var td = document.createElement('td');
			td.innerHTML = 	'<div class="action-btns">'+
							'<a class="btn btn-primary" onclick="getGroups('+data[i].id+')" data-toggle="modal" data-target=".get-groups" data-dismiss="modal">View Groups</a>'+ 
							'<a class="btn btn-primary" onclick="getUsers('+data[i].id+')" data-toggle="modal" data-target=".get-users" data-dismiss="modal">View Users</a>'+ 
							'</div>';	
		tr.appendChild(td);		

		// console.log(data[i].id);
		tbody.appendChild(tr);	
	}	

	table.appendChild(tbody);

	rolesWrapper.appendChild(table);

	var rTable = document.getElementById('role-table');
	
	$(rTable).dataTable();

}

function getGroups(id)
{
	// Ajax Call
	$.ajax({
	  method: "GET",
	  url: "rolegroups/"+id
	})
	  .done(function( msg ) {
	  	// console.log(msg);
	  	rolesInGroups(msg,id);
	  });
}

// Get Users for a specific role
function getUsers(id)
{
	// Ajax Call
	$.ajax({
	  method: "GET",
	  url: "roleusers/"+id
	})
	  .done(function( msg ) {
	  	console.log(msg);
	  	usersForRoles(msg,id);
	  });
}

function rolesInGroups(data,role_id)
{
	var roles_in_groups_array = [];

	var groups_in_role = data.groups_in_role;

	var groups_not_in_role = data.groups_not_in_role;

	for(var i=0; i < data.groups_in_role.length; i++)
	{
		data.groups_in_role[i].flag = true;

		roles_in_groups_array.push(data.groups_in_role[i]);
	}

	for(var i=0; i < data.groups_not_in_role.length; i++)
	{
		data.groups_not_in_role[i].flag = false;

		roles_in_groups_array.push(data.groups_not_in_role[i]);
	}

	drawGroupsInRoleTable(roles_in_groups_array,role_id);
}	  

function usersForRoles(data,role_id)
{
	var users_for_role = [];

	var users_in_role = data.users_in_role;

	var groups_not_in_role = data.groups_not_in_role;

	for(var i=0; i < data.users_in_role.length; i++)
	{
		data.users_in_role[i].flag = true;

		users_for_role.push(data.users_in_role[i]);
	}

	for(var i=0; i < data.users_not_in_role.length; i++)
	{
		data.users_not_in_role[i].flag = false;

		users_for_role.push(data.users_not_in_role[i]);
	}

	drawUsersRoleTable(users_for_role,role_id);
}	


function drawUsersRoleTable(data,role_id)
{
	var table = document.createElement('table');
		table.setAttribute('class','table table-bordered bordered table-striped table-condensed')
		table.setAttribute('id',"users_role_table");

	var thead = document.createElement('thead');
		
	var theader = document.createElement('tr');

	var colNames = ['Name','Login','Email','Actions'];

	for(var i=0; i < colNames.length; i++)			
	{
		var th = document.createElement('th');
			th.innerHTML = colNames[i];
		
		theader.appendChild(th);
	}	
	
	thead.appendChild(theader);

	table.appendChild(thead);

	var tbody = document.createElement('tbody');

	for(var i=0; i < data.length; i++)
	{
		var tr = document.createElement('tr');
		
		var td = document.createElement('td');
			td.innerHTML = data[i].firstname+' '+data[i].lastname;
			td.setAttribute('style','text-transform:capitalize');
		tr.appendChild(td);	

		var td = document.createElement('td');
			td.innerHTML = data[i].login;
			td.setAttribute('style','text-transform:capitalize');
		tr.appendChild(td);

		var td = document.createElement('td');
			td.innerHTML = data[i].email;
			td.setAttribute('style','text-transform:capitalize');
		tr.appendChild(td);

		var user_id = data[i].id;

		if(data[i].flag == true)
		{
		var td = document.createElement('td');
			td.innerHTML = 	'<div class="action-btns">'+
							'<form method="post" style="display:inline" action="/superadmin/removeroleuser" class="form-inline">'+
							'<input type="hidden" name="user_id" value="'+user_id+'">'+
							'<input type="hidden" name="role_id" value="'+role_id+'">'+
							'<button class="btn btn-danger" type="submit" style="width:100%;">'+
							'Remove user From Role'+
							'</button></form>'+ 
							'</div>';	
		}
		else
		{
			var td = document.createElement('td');
			td.innerHTML = 	'<div class="action-btns">'+
							'<form method="post" style="display:inline" action="/superadmin/assignroleuser" class="form-inline">'+
							'<input type="hidden" name="user_id" value="'+user_id+'">'+
							'<input type="hidden" name="role_id" value="'+role_id+'">'+
							'<button class="btn btn-success" type="submit" style="width:100%;">'+
							'Add User To Role'+
							'</button></form>'+ 
							'</div>';
		}
		tr.appendChild(td);		

		tbody.appendChild(tr);		
	}	

	table.appendChild(tbody);
	
	$('.get-users .modal-body').html(table);

	$('#users_role_table').dataTable();
}


function drawGroupsInRoleTable(data,role_id)
{
	var table = document.createElement('table');
		table.setAttribute('class','table table-bordered bordered table-striped table-condensed')
		table.setAttribute('id',"groups_role_table");

	var thead = document.createElement('thead');
		
	var theader = document.createElement('tr');

	var colNames = ['Name','Actions'];

	for(var i=0; i < colNames.length; i++)			
	{
		var th = document.createElement('th');
			th.innerHTML = colNames[i];
		
		theader.appendChild(th);
	}	
	
	thead.appendChild(theader);

	table.appendChild(thead);

	var tbody = document.createElement('tbody');

	for(var i=0; i < data.length; i++)
	{
		var tr = document.createElement('tr');
		
		var td = document.createElement('td');
			td.innerHTML = data[i].group_name;
			td.setAttribute('style','text-transform:capitalize');
		tr.appendChild(td);	

		var group_id = data[i].id;

		if(data[i].flag == true)
		{
		var td = document.createElement('td');
			td.innerHTML = 	'<div class="action-btns">'+
							'<form method="post" style="display:inline" action="/superadmin/removerolegroup" class="form-inline">'+
							'<input type="hidden" name="group_id" value="'+group_id+'">'+
							'<input type="hidden" name="role_id" value="'+role_id+'">'+
							'<button class="btn btn-danger" type="submit" style="width:100%;">'+
							'Remove Group From Role'+
							'</button></form>'+ 
							'</div>';	
		}
		else
		{
			var td = document.createElement('td');
			td.innerHTML = 	'<div class="action-btns">'+
							'<form method="post" style="display:inline" action="/superadmin/assignrolegroup" class="form-inline">'+
							'<input type="hidden" name="group_id" value="'+group_id+'">'+
							'<input type="hidden" name="role_id" value="'+role_id+'">'+
							'<button class="btn btn-success" type="submit" style="width:100%;">'+
							'Add Group To Role'+
							'</button></form>'+ 
							'</div>';
		}
		tr.appendChild(td);		

		tbody.appendChild(tr);		
	}	

	table.appendChild(tbody);
	
	$('.get-groups .modal-body').html(table);

	$('#groups_role_table').dataTable();
}