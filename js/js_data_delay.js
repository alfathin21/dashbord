$(document).ready(function(){
	$.ajax({
		url: "http://localhost/GMF/data_grafik_delay.php",
		method: "GET",
		success: function(data) {
			console.log(data);
			var date = [];
			var delay = [];

			for(var i in data) {
				date.push(data[i].DateEvent);
				delay.push(data[i].delay);
			}

			var chartdata = {
				labels: date,
				datasets : [
					{
						label: 'Date',
						backgroundColor: 'rgba(200, 200, 200, 0.75)',
						borderColor: 'rgba(200, 200, 200, 0.75)',
						hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
						hoverBorderColor: 'rgba(200, 200, 200, 1)',
						data: delay
					}
				]
			};

			var ctx = $("#graf_data_delay");

			var barGraph = new Chart(ctx, {
				type: 'bar',
				data: chartdata
			});
		},
		error: function(data) {
			console.log(data);
		}
	});
});