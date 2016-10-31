var groups = awake.group_users;

var groupsWrapper = document.getElementById('groupsTable');

var groupTable = drawGroupTable(groups);

function drawGroupTable(data)
{
	var table = document.createElement('table');
		table.setAttribute('class','table table-bordered bordered table-striped table-condensed')
		table.setAttribute('id','groups-table');

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

		var td = document.createElement('td');
			td.innerHTML = 	'<div class="action-btns">'+
							'<a class="btn btn-primary" onclick="getGroupUsers('+i+')" data-toggle="modal" data-target=".get-users" data-dismiss="modal">Group Users</a>'+ 
							'</div>';	
		tr.appendChild(td);		

		// console.log(data[i].id);
		tbody.appendChild(tr);	
	}	

	table.appendChild(tbody);

	groupsWrapper.appendChild(table);	

	var gTable = document.getElementById('groups-table');
	
	$(gTable).dataTable();
}

function getGroupUsers(id)
{
	var group_users = groups[id].group_users;
	
	var group_id = groups[id].id;

	var table = document.createElement('table');
		table.setAttribute('class','table table-bordered bordered table-striped table-condensed')
		table.setAttribute('id','groups-users-table');

	var thead = document.createElement('thead');
		
	var theader = document.createElement('tr');
			
	var colNames = ['Name','Email','Actions'];

	for(var i=0; i < colNames.length; i++)			
	{
		var th = document.createElement('th');
			th.innerHTML = colNames[i];
		
		theader.appendChild(th);
	}	
	
	thead.appendChild(theader);

	table.appendChild(thead);

	var tbody = document.createElement('tbody');

	for(var i=0; i < group_users.length; i++)
	{
		var tr = document.createElement('tr');
		
		var td = document.createElement('td');
			td.innerHTML = group_users[i].firstname+' '+group_users[i].lastname;
			td.setAttribute('style','text-transform:capitalize');
		tr.appendChild(td);	

		var td = document.createElement('td');
			td.innerHTML = group_users[i].email;
		tr.appendChild(td);

		var user_id = group_users[i].id;

		var td = document.createElement('td');
			td.innerHTML = 	'<div class="action-btns">'+
							'<form method="post" style="display:inline" action="/superadmin/removeuserfromgroup" class="form-inline">'+
							'<input type="hidden" name="group_id" value="'+group_id+'">'+
							'<input type="hidden" name="user_id" value="'+user_id+'">'+
							'<button class="btn btn-primary" type="submit">'+
							'Remove User From Group'+
							'</button></form>'+ 
							'</div>';	
		tr.appendChild(td);		

		tbody.appendChild(tr);	
	}	

	table.appendChild(tbody);
	
	$('.get-users .modal-body').html(table);

	$('#groups-users-table').dataTable();	
}