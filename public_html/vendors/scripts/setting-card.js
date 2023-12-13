// pobla select de citys
$("select[name='state']").on("change", () => {
	let id = $("select[name='state'] option:selected").val()
	console.log(id)
	let fData = new FormData();
	fData.append("stateId", id)
	$.ajax({
		type: "POST",
		url: "/cards/getCitysByState",
		contentType: false,
		processData : false,
		data: fData,
		dataType: 'html',
		success: function(response, textStatus, xhr) {
			console.log("response: ",  response, "text: " , textStatus, "xhr: " , xhr)
			$("select[name='city']").empty().append(response);	
		}
	})
	.fail(function(error){
		console.log(error)
	})

})

