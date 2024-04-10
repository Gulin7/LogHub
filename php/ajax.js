function getLogReports() {
	$.ajax({
		url: './log-reports-api/get-logs.php',
		type: 'GET',
		success: function (data) {
			// console.log(data)
			var logs = JSON.parse(data)
			// console.log(logs)
			if (logs.status === 200) {
				var logData = logs.data
				var tableBody = ''
				for (var i = 0; i < logData.length; i++) {
					tableBody +=
						'<tr><td>' +
						logData[i].log_type +
						'</td><td>' +
						logData[i].log_severity +
						'</td><td>' +
						logData[i].log_date +
						'</td><td>' +
						logData[i].log_message +
						'</td>' +
						'<td><button class="btn btn-danger" onclick="deleteLog(' +
						logData[i].log_id +
						')">Delete</button></td>' +
						'<td><button class="btn btn-primary" onclick="editLog(' +
						logData[i].log_id +
						')">Edit</button></td></tr>'
				}
				$('#logs-table').html(tableBody)
			} else {
				alert(logs.message)
			}
		},
		error: function (error) {
			console.error(error)
		},
	})
}

$('#view-all-logs').click(function () {
	getLogReports()
})

function getUserLogReports() {
	$.ajax({
		url: './log-reports-api/get-logs.php?user_id=' + user_id,
		type: 'GET',
		success: function (data) {
			var logs = JSON.parse(data)
			// console.log(logs)
			if (logs.status === 200) {
				var logData = logs.data
				var tableBody = ''
				for (var i = 0; i < logData.length; i++) {
					tableBody +=
						'<tr><td>' +
						logData[i].log_type +
						'</td><td>' +
						logData[i].log_severity +
						'</td><td>' +
						logData[i].log_date +
						'</td><td>' +
						logData[i].log_message +
						'</td>' +
						'<td><button class="btn btn-danger" onclick="deleteLog(' +
						logData[i].log_id +
						')">Delete</button></td>' +
						'<td><button class="btn btn-primary" onclick="editLog(' +
						logData[i].log_id +
						')">Edit</button></td></tr>'
				}
				$('#logs-table').html(tableBody)
			} else {
				alert(logs.message)
			}
		},
		error: function (error) {
			console.error(error)
		},
	})
}

$('#view-my-logs').click(function () {
	getUserLogReports()
})

function getTypeLogReports() {
	if ($('#view-type-logs').val() == 'all') {
		getLogReports()
		return
	}
	$.ajax({
		url: './log-reports-api/get-logs.php?log_type=' + $('#view-type-logs').val(),
		type: 'GET',
		success: function (data) {
			var logs = JSON.parse(data)
			if (logs.status === 200) {
				var logData = logs.data
				var tableBody = ''
				for (var i = 0; i < logData.length; i++) {
					tableBody +=
						'<><td>' +
						logData[i].log_type +
						'</td><td>' +
						logData[i].log_severity +
						'</td><td>' +
						logData[i].log_date +
						'</td><td>' +
						logData[i].log_message +
						'</td>' +
						'<td><button class="btn btn-danger" onclick="deleteLog(' +
						logData[i].log_id +
						')">Delete</button></td>' +
						'<td><button class="btn btn-primary" onclick="editLog(' +
						logData[i].log_id +
						')">Edit</button></td></tr>'
				}
				$('#logs-table').html(tableBody)
			} else {
				alert(logs.message)
			}
		},
		error: function (error) {
			console.error(error)
		},
	})
}

$('#view-type-logs').change(function () {
	getTypeLogReports()
})

function getSeverityLogReports() {
	$.ajax({
		url: './log-reports-api/get-logs.php?log_severity=' + $('#view-severity-logs').val(),
		type: 'GET',
		success: function (data) {
			var logs = JSON.parse(data)
			if (logs.status === 200) {
				var logData = logs.data
				var tableBody = ''
				for (var i = 0; i < logData.length; i++) {
					tableBody +=
						'<tr><td>' +
						logData[i].log_type +
						'</td><td>' +
						logData[i].log_severity +
						'</td><td>' +
						logData[i].log_date +
						'</td><td>' +
						logData[i].log_message +
						'</td>' +
						'<td><button class="btn btn-danger" onclick="deleteLog(' +
						logData[i].log_id +
						')">Delete</button></td>' +
						'<td><button class="btn btn-primary" onclick="editLog(' +
						logData[i].log_id +
						')">Edit</button></td></tr>'
				}
				$('#logs-table').html(tableBody)
			} else {
				alert(logs.message)
			}
		},
	})
}

$('#view-severity-logs').change(function () {
	getSeverityLogReports()
})

function deleteLog(log_id) {
	$.ajax({
		url: './log-reports-api/delete-log.php?log_id=' + log_id,
		type: 'DELETE',
		success: function (data, textStatus) {
			// console.log(textStatus)
			getLogReports()
			// var logs = JSON.parse(data)
			// if (logs.status === 204) {
			// 	alert(logs.message)
			// 	getLogReports()
			// } else {
			// 	alert(logs.message)
			// }
		},
		error: function (error) {
			console.error(error)
		},
	})
}

function editLog(log_id) {
	$.ajax({
		url: './log-reports-api/get-log.php?log_id=' + log_id,
		type: 'GET',
		success: function (data) {
			var logs = JSON.parse(data)
			if (logs.status === 200) {
				var logData = logs.data
			} else {
				alert(logs.message)
			}
		},
		error: function (error) {
			console.error(error)
		},
	})
}
