var users = awake.users;

var userListTable = document.getElementById('userListTable');

var userTable = drawTable(users);

function drawTable(data)
{
	var table = document.createElement('table');
		table.setAttribute('class','table table-bordered bordered table-striped table-condensed')
		table.setAttribute('id','user-table');

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
		var userData = JSON.stringify(data[i]);
		var tr = document.createElement('tr');
		
		var td = document.createElement('td');
			td.innerHTML = data[i].firstname+' '+data[i].lastname;
			td.setAttribute('style','text-transform:capitalize');
		tr.appendChild(td);	

		var td = document.createElement('td');
			td.innerHTML = data[i].login;
		tr.appendChild(td);
		
		var td = document.createElement('td');
			td.innerHTML = data[i].email;
		tr.appendChild(td);	

		var td = document.createElement('td');
			td.innerHTML = 	'<div class="action-btns">'+
							'<a class="btn btn-primary" onclick="userInfo('+i+')" data-toggle="modal" data-target=".edit-user" data-dismiss="modal">Edit</a>'+ 
							'<a href="deactivateuser/'+data[i].id+'" class="btn btn-primary">Deactivate</a></div>';	
		tr.appendChild(td);		

		console.log(data[i].id);
		tbody.appendChild(tr);	
	}	

	table.appendChild(tbody);

	userListTable.appendChild(table);

	var uTable = document.getElementById('user-table');
	
	$(uTable).dataTable({
		"columnDefs": [{"targets":[2], "orderable": "false"}]
	});
	
}

function userInfo(data)
{
	console.log(users[data]);
	var userModel = document.getElementsByClassName('edit-user')[0];

	document.getElementById('payroll-number').value = users[data].login;

	document.getElementById('firstname').value = users[data].firstname;
	
	document.getElementById('lastname').value = users[data].lastname;
	
	document.getElementById('email').value = users[data].email;

	document.getElementById('user_id').value = users[data].id;

	document.getElementById('location_id').value = users[data].location_id;
}



// Get Deactivated Users
function getDeactivatedUsers()
{
	// Ajax Call
	$.ajax({
	  method: "GET",
	  url: "deactivatedusers"
	})
	  .done(function( msg ) {
	  	console.log(msg);
	  	drawDeactivatedUsersTable(msg);
	  });
}

// Draw Deactivated Users List
function drawDeactivatedUsersTable(data)
{
	var table = document.createElement('table');
		table.setAttribute('class','table table-bordered bordered table-striped table-condensed')
		table.setAttribute('id','deactivated-table');

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
		var userData = JSON.stringify(data[i]);
		var tr = document.createElement('tr');
		
		var td = document.createElement('td');
			td.innerHTML = data[i].firstname+' '+data[i].lastname;
			td.setAttribute('style','text-transform:capitalize');
		tr.appendChild(td);	

		var td = document.createElement('td');
			td.innerHTML = data[i].login;
		tr.appendChild(td);
		
		var td = document.createElement('td');
			td.innerHTML = data[i].email;
		tr.appendChild(td);	

		var td = document.createElement('td');
			td.innerHTML = 	'<div class="action-btns">'+
							'<a href="activateuser/'+data[i].id+'" class="btn btn-success btn-block">Activate</a></div>';	
		tr.appendChild(td);		

		// console.log(data[i].id);
		tbody.appendChild(tr);	
	}	

	table.appendChild(tbody);

	$('.deactivated-users .modal-body').html(table);

	$('#deactivated-table').dataTable();
}
