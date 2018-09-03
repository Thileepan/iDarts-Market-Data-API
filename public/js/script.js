var initialResponseText = "Please click 'Get Authentication Key' button to receive the authentication key before try other API";

$(function() {
	$(".block").hide();
	$("#authentication").show();
	$(".prettyprint").text(initialResponseText);
	getAuthentication();

	$("#sidebar-wrapper > ul > li").click(function() {
		$(".block").hide();
		var blockId = $(this).attr("data-block-id");
		$("#" + blockId).show();

		if(blockId !== 'authentication') {
			if($('#isAuthenticated').val()) {
				$(".prettyprint").text("API response will appear here...");
			} else {
				$(".prettyprint").text(initialResponseText);
			}
		}
	});

	$("#token1").multipleSelect({
        width: 460
    });

    var start = moment().subtract(29, 'days');
    var end = moment();

    $("#eodDateRange").daterangepicker({
    	startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           //'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    });

    $("#ieodDateRange").daterangepicker({
    	startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           //'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    });
});

function logout()
{
	$.ajax({
		type: "POST",
		url: "request.php",
		data: "action=Logout",
		dataType: "json",
		cache: false,
		success: function(response) {
			$("#authenticateBtn").show();
    		$("#authenticatedBtn").hide();
    		$(".prettyprint").text(initialResponseText);
		},
		error: function (jqXhr, textStatus, errorMessage) { // error callback 
	        alert(errorMessage);
	    }
	});
}

function getAuthentication()
{
	$.ajax({
		type: "POST",
		url: "request.php",
		data: "action=Authentication",
		dataType: "json",
		cache: false,
		success: function(response) {
			if(response.key !== '') {
	    		$("#authenticateBtn").hide();
	    		$("#authenticatedBtn").show();
	    		$(".prettyprint").text(response.key);
	    		$("#isAuthenticated").val(0);
	    	} else {
	    		$(".prettyprint").text(response.msg);
	    	}
		},
		error: function (jqXhr, textStatus, errorMessage) { // error callback 
	        alert(errorMessage);
	    }
	});
}

function getSnapshotQuote()
{
	var tokens = $("#token1").multipleSelect("getSelects");

	$.ajax({
		type: "POST",
		url: "request.php",
		data: "action=Snapshot&tokens=" + tokens,
		dataType: "json",
		cache: false,
		success: function(response){
			if(response.status) {
				console.log(response.data);
				$(".prettyprint").text(JSON.stringify(response.data));
			} else {
				$(".prettyprint").text(response.msg);
			}
		},
		error: function (jqXhr, textStatus, errorMessage) { // error callback 
	        alert(errorMessage);
	    }
	});
}

function getEOD()
{
	var token = $("#eodToken option:selected").val();
	var noOfDays = 0;
	var eodDateRange = $("#eodDateRange").val();
	var eodDateArr = eodDateRange.split("-");
	var startDateArr = eodDateArr[0].trim().split("/");
	var endDateArr = eodDateArr[1].trim().split("/");
	var startDate = startDateArr[2] + startDateArr[0] + startDateArr[1];
	var endDate = endDateArr[2] + endDateArr[0] + endDateArr[1];

	$.ajax({
		type: "POST",
		url: "request.php",
		data: "action=EOD&token=" + token + "&noOfDays=" + noOfDays + "&start_date=" + startDate + "&end_date=" + endDate,
		dataType: "json",
		cache: false,
		success: function(response){
	    	if(response.status) {
				$(".prettyprint").text(response.data);
			} else {
				$(".prettyprint").text(response.msg);
			}
		},
		error: function (jqXhr, textStatus, errorMessage) { // error callback 
	        alert(errorMessage);
	    }
	});
}

function getIEOD()
{
	var token = $("#ieodToken option:selected").val();
	var noOfDays = 0;
	var eodDateRange = $("#ieodDateRange").val();
	var eodDateArr = eodDateRange.split("-");
	var startDateArr = eodDateArr[0].trim().split("/");
	var endDateArr = eodDateArr[1].trim().split("/");
	var startDate = startDateArr[2] + startDateArr[0] + startDateArr[1];
	var endDate = endDateArr[2] + endDateArr[0] + endDateArr[1];

	$.ajax({
		type: "POST",
		url: "request.php",
		data: "action=IEOD&token=" + token + "&noOfDays=" + noOfDays + "&start_date=" + startDate + "&end_date=" + endDate,
		dataType: "json",
		cache: false,
		success: function(response){
	    	if(response.status) {
				$(".prettyprint").text(response.data);
			} else {
				$(".prettyprint").text(response.msg);
			}
		},
		error: function (jqXhr, textStatus, errorMessage) { // error callback 
	        alert(errorMessage);
	    }
	});
}

var webSocket;

function subscribe()
{
	$("#subscribe").hide();
	$("#unSubscribe").show();
	$(".prettyprint").text("");
	webSocket = $.simpleWebSocket({ url: 'wss://infini.tradeplusonline.com/signalr/connect?transport=webSockets&clientProtocol=1.5&connectionToken=AQAAANCMnd8BFdERjHoAwE%2FCl%2BsBAAAAsbDn8%2B63pUmOUNYluhb9jQAAAAACAAAAAAAQZgAAAAEAACAAAACoEALn7K655xgSlaAHXDbcDo0alwRTrKLhxuz%2FZTTCXAAAAAAOgAAAAAIAACAAAABlQWCE9zib9anWFcmwMh25Vtt3pkiE2j4r7qCsKD9KSDAAAACss13y%2FN%2BgqpGFUpKlExOKqJvsw604Ff7kv2utfA6T97v%2BOsO%2FWj1%2Bz7Mqvb5CEnhAAAAAnx5ic5aR2Xe3l%2F798%2BKN3gKC6gsTYJNFqxXfkznCT1lPi2AgqdZ9qiueN5GiEwZZ6htOG326pPpmC5wJ3m%2FYiQ%3D%3D&connectionData=%5B%7B%22name%22%3A%22streaminghub%22%7D%5D&tid=10' });
    
    // reconnected listening
    webSocket.listen(function(message) {
    	console.log(message);
        $(".prettyprint").append("<br>" + JSON.stringify(message));
    });
}

function unSubscribe()
{
	$("#subscribe").show();
	$("#unSubscribe").hide();
	$(".prettyprint").text("");
	webSocket.close();
}