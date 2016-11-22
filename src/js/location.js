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
	
	// Ajax Call
	$.ajax({
	  method: "GET",
	  url: "branchdetails/"+locationId+""
	})
	  .done(function( msg ) {
	  	console.log(msg);
	  	formatUsers(msg);
	  });
}

function formatUsers(data)
{
	console.log(data);
	
	var efrontUsers = data.efront_branch_users;
	
	var usersInApp = data.branch_details.users;

	var branch_id = data.branch_details.efront_branch_id;

	var branch_name = data.branch_details.efront_branch_name;

	document.getElementById('efront-users').innerHTML = efrontUsers.length;

	document.getElementById('app-users').innerHTML = usersInApp.length;

	var users = [];
	var usersAppArr = [];
	
	for(var j=0; j<usersInApp.length; j++)
	{
		usersAppArr[j] = parseInt(usersInApp[j].efront_user_id,10);
	}	

	for(var i=0; i<efrontUsers.length; i++)
	{
		users[i] = efrontUsers[i];
		
		users[i].branch_id = branch_id;
		users[i].branch_name = branch_name;

		if(usersAppArr.indexOf(parseInt(efrontUsers[i].id,10)) > -1)
			users[i].flag = true;
		else
			users[i].flag = false;
	}
	
	// console.log(users);
	drawTable(users);
	// console.log(users);	
}

function drawTable(data)
{
	// console.log(data);
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
			td.innerHTML = data[i].name+' '+data[i].surname;
			td.setAttribute('style','text-transform:capitalize');
		tr.appendChild(td);	

		var td = document.createElement('td');
			td.innerHTML = data[i].login;
		tr.appendChild(td);
		
		var td = document.createElement('td');
			td.innerHTML = data[i].email;
		tr.appendChild(td);	

		var addUser = JSON.stringify(data[i]);
		
		if(data[i].flag != true)
		{
			var td = document.createElement('td');
				td.innerHTML = 	"<div class='action-btns'>"+
								"<a data-toggle='modal' data-target='.add-user-to-app' class='btn btn-primary' onclick='addUserToApp(this)' data-info='"+addUser+"'>Add To App</a></div>"; 
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
	
	// console.log(table);

	$('.get-users .modal-body .users-for-location').html(table);

	$('#user-table').dataTable();	
}


// Add User To App
function addUserToApp(t)
{
	var data = JSON.parse(t.getAttribute('data-info'));
	
	console.log(data.branch_name);

	var b = document.getElementById('location_id');

	document.getElementById('employee_id').value = data.login;

	document.getElementById('firstname').value = data.name;

	document.getElementById('lastname').value = data.surname;

	document.getElementById('email_addr').value = data.email;

	document.getElementById('branch_id').value = data.branch_id;

	// document.getElementById('location_id').value = data.branch_name;

}