var locations = awake.locations;

var locationsWrapper = document.getElementById('locationsTable');

var locationTable = drawLocationTable(locations);

function drawLocationTable(data)
{
	console.log(data);
	var table = document.createElement('table');
		table.setAttribute('class','table table-bordered bordered table-striped table-condensed')
		table.setAttribute('id','location-table');

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
			td.innerHTML = data[i].efront_branch_name;
			td.setAttribute('style','text-transform:capitalize');
		tr.appendChild(td);	

		var td = document.createElement('td');
			td.innerHTML = 	'<div class="action-btns">'+
							'<a class="btn btn-primary" onclick="getUsers('+i+')" data-toggle="modal" data-target=".get-users" data-dismiss="modal">Get Users</a>'+ 
							'</div>';	
		tr.appendChild(td);		

		// console.log(data[i].id);
		tbody.appendChild(tr);	
	}	

	table.appendChild(tbody);

	locationsWrapper.appendChild(table);

	var lTable = document.getElementById('location-table');
	
	$(lTable).dataTable();
}

function getUsers(id)
{
	document.getElementById('efront-users').innerHTML = '';

	document.getElementById('app-users').innerHTML = '';

	$('.get-users .modal-body .users-for-location').html('');

	var locationId = locations[id].id;
	// console.log(locations[id]);
	// Ajax Call
	$.ajax({
	  method: "GET",
	  url: "branchdetails/"+locationId+""
	})
	  .done(function( msg ) {
	  	// console.log(msg);
	  	formatUsers(msg);
	  });
}

function formatUsers(data)
{
	var efrontUsers = data.efront_branch_users;
	
	var usersInApp = data.branch_details.users;

	document.getElementById('efront-users').innerHTML = efrontUsers.length;

	document.getElementById('app-users').innerHTML = usersInApp.length;

	var users = [];
	var efrontUsersArr = [];
	
	for(var j=0; j<efrontUsers.length; j++)
	{
		efrontUsersArr[j] = parseInt(efrontUsers[j].id,10);
	}	

	for(var i=0; i<usersInApp.length; i++)
	{
		users[i] = usersInApp[i];

		if(efrontUsersArr.indexOf(usersInApp[i].efront_user_id) > -1)
			users[i].flag = true;
		else
			users[i].flag = false;
	}
	
	// console.log(efrontUsersArr);
	drawTable(users);
	// console.log(users);	
}

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

		if(data[i].flag != true)
		{
			var td = document.createElement('td');
				td.innerHTML = 	'<div class="action-btns">'+
								'<a class="btn btn-primary" data-toggle="modal" data-target=".edit-user">Add To App</a>'; 
			tr.appendChild(td);		
		}
		else 
		{
			var td = document.createElement('td');
				td.innerHTML = '';
			tr.appendChild(td);	
		}	
		// console.log(data[i].id);
		tbody.appendChild(tr);	
	}	

	table.appendChild(tbody);
	
	console.log(table);

	$('.get-users .modal-body .users-for-location').html(table);

	$('#user-table').dataTable();	
}
