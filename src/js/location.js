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
			td.innerHTML = data[i].location_name;
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
	var locationId = locations[id].id;

	// Ajax Call
	$.ajax({
	  method: "GET",
	  url: "locationusers/"+locationId+""
	})
	  .done(function( msg ) {
	  	// console.log(msg);
	  	drawTable(msg);
	  });
}

function drawTable(data)
{
	var table = document.createElement('table');
		table.setAttribute('class','table table-bordered bordered table-striped table-condensed')
		table.setAttribute('id','user-table');

	var thead = document.createElement('thead');
		
	var theader = document.createElement('tr');
			
	var colNames = ['Name','Login','Email'];

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

		// var td = document.createElement('td');
		// 	td.innerHTML = 	'<div class="action-btns">'+
		// 					'<a class="btn btn-primary" onclick="userInfo('+i+')" data-toggle="modal" data-target=".edit-user">Edit</a>'+ 
		// 					'<a href="deactivateuser/'+data[i].id+'" class="btn btn-primary">Deactivate</a></div>';	
		// tr.appendChild(td);		

		console.log(data[i].id);
		tbody.appendChild(tr);	
	}	

	table.appendChild(tbody);
	
	$('.get-users .modal-body').html(table);

	$('#user-table').dataTable();	
}
