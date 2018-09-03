<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>iDarts Market Data API</title>

    <!-- Bootstrap core CSS -->
    <link href="plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="plugin/multiple-select/multiple-select.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <!-- Custom styles for this template -->
    <link href="css/simple-sidebar.css" rel="stylesheet">

</head>

<body>

    <div id="wrapper" class="toggled">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#">
                        <h3>iDarts</h3>
                    </a>
                </li>
                <li data-block-id="authentication">
                    <a href="#">Authentication</a>
                </li>
                <li data-block-id="snapshot">
                    <a href="#">Snapshot API</a>
                </li>
                <li data-block-id="eod">
                    <a href="#">EOD API</a>
                </li>
                <li data-block-id="ieod">
                    <a href="#">IEOD API</a>
                </li>
                <li data-block-id="streaming">
                    <a href="#">Streaming API</a>
                </li>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
            	<div class="row">
            		<div class="col-md-6">
            			<div class="block" id="authentication">
            				<h4>Introduction to iDarts Market Data API</h4>
			                <p>This is the sample PHP examples which explains how to connect the iDarts Market Data REST and Streaming API and get the response for different supported API's.  <a href="https://infini.tradeplusonline.com/api/documents" title="API Document">https://infini.tradeplusonline.com/api/documents</a>.</p>
			                <p>Every API request needs to be authenticated with valid authentication key. You can get your authentication key using your account username and password.</p>

						    <span id="authenticateBtn" onclick="getAuthentication()"><a href="#" class="btn btn-success">Get Authentication Key</a></span>
						    <span id="authenticatedBtn" style="display: none;">
						    	<a href="#" class="btn btn-success">Authenticated</a>
						    	<small><a href="#" class="text-danger" onclick="logout()">Logout me!</a></small>
						    </span>
            			</div>

            			<div class="block" id="snapshot">
            				<h4>Snapshot API</h4>
			                <p>POST api/Snapshot/Quotes <BR><a href="http://180.179.151.146/api/snapshot/Quotes" title="API Document">http://180.179.151.146/api/snapshot/Quotes</a>.</p>
			                <p>This API request needs to be authenticated with valid authentication key. You should get your authentication key using your account username and password before try this.</p>

			                <div>
			                	<b>Select the Tokens</b>
			                	<select id="token1" multiple="multiple">
								    <option value="1015083">1015083</option>
								    <option value="1000236">1000236</option>
								    <option value="1005900">1005900</option>
								    <option value="1016669">1016669</option>
								    <option value="1016675">1016675</option>
								</select>
			            	</div><BR>
						    <a href="#" class="btn btn-success" onclick="getSnapshotQuote()">List Quotes</a>
            			</div>

            			<div class="block" id="eod">
            				<h4>EOD API</h4>
			                <p>GET iddataservice/diDataservice.aspx <BR><a href="http://www.dartstech.com/iddataservice/diDataservice.aspx?cmd=hdly&r=1&t=1000022&nd=5" title="API Document">http://www.dartstech.com/iddataservice/diDataservice.aspx?cmd=hdly&r=1&t=1000022&nd=5</a>.</p>
			                <p>
								<b>Parameters</b><BR>

								t 	- Token<BR>
								nd 	- No of Days<BR>
								sd 	- Start Date<BR>
								ed 	- End Date<BR>
							</p>
			                <p>This API request needs to be authenticated with valid authentication key. You should get your authentication key using your account username and password before try this.</p>

			                <div>
			                	<form>
									<div class="form-group">
								    	<label for="eodToken"><b>Select the Token</b></label>
								    	<select id="eodToken" class="form-control form-control-sm">
										    <option value="1015083">1015083</option>
										    <option value="1000236">1000236</option>
										    <option value="1005900">1005900</option>
										    <option value="1016669">1016669</option>
										    <option value="1016675">1016675</option>
										</select>
								  	</div>
									<!-- <div class="form-group">
								    	<label for="eodFilterByType"><b>Filter By Day</b></label>
								    	<input type="checkbox" class="form-control" id="eodFilterByType" checked>
								  	</div>
								  	<div class="form-group">
								    	<label for="eodFilterByType"><b>Number of Days</b></label>
								    	<input type="number" class="form-control form-control-sm" min="1" max="10" id="eodFilterByType">
								  	</div> -->
								  	<div class="form-group">
								    	<label for="eodFilterByType"><b>Select Date Range</b></label>
								    	<input type="text" id="eodDateRange" class="form-control form-control-sm" />
								  	</div>
								  	<a href="#" class="btn btn-success" onclick="getEOD()">Get EOD Values</a>
								</form>
			            	</div>
            			</div>

            			<div class="block" id="ieod">
            				<h4>IEOD API</h4>
			                <p>GET iddataservice/diIntra.aspx <BR><a href="http://www.dartstech.com/iddataservice/diIntra.aspx?cmd=hmin&t=1000022&min=1&sd=20180528&ed=20180828

t=1000022" title="API Document">http://www.dartstech.com/iddataservice/diIntra.aspx?cmd=hmin&t=1000022&min=1&sd=20180528&ed=20180828

t=1000022</a>.</p>
							<p>
								<b>Parameters</b><BR>

								t 	- Token<BR>
								nd 	- No of Days<BR>
								sd 	- Start Date<BR>
								ed 	- End Date<BR>
							</p>
			                <p>This API request needs to be authenticated with valid authentication key. You should get your authentication key using your account username and password before try this.</p>

			                <div>
			                	<form>
									<div class="form-group">
								    	<label for="ieodToken"><b>Select the Token</b></label>
								    	<select id="ieodToken" class="form-control form-control-sm">
										    <option value="1015083">1015083</option>
										    <option value="1000236">1000236</option>
										    <option value="1005900">1005900</option>
										    <option value="1016669">1016669</option>
										    <option value="1016675">1016675</option>
										</select>
								  	</div>
									<div class="form-group">
								    	<label for="eodFilterByType"><b>Select Date Range</b></label>
								    	<input type="text" id="ieodDateRange" class="form-control form-control-sm" />
								  	</div>
								  	<a href="#" class="btn btn-success" onclick="getIEOD()">Get IEOD Values</a>
								</form>
			            	</div>
            			</div>

            			<div class="block" id="streaming">
            				<h4>Streaming API</h4>
			                <p>WebSocket Streaming Data.</p>
			                <p>This API request needs to be authenticated with valid authentication key. You should get your authentication key using your account username and password before try this.</p>
						    <a href="#" class="btn btn-success" id="subscribe" onclick="subscribe()">Subscribe</a>
						    <a href="#" class="btn btn-success" id="unSubscribe" onclick="unSubscribe()" style="display:none">UnSubscribe</a>
            			</div>
            		</div>
            		<div class="col-md-6">
            			<h4>Response</h4>
            			<div class="prettyprint" style="background-color: #30336b; color: #fff; padding: 20px; border-radius: 5px; height: 100%; font-family: Consolas,'Liberation Mono',Courier,monospace; word-wrap: break-word; margin-top: 10px;">
Your response will appear here!
						</div>
            		</div>
            	</div>
                <input type="hidden" id="isAuthenticated" value="0" />
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Bootstrap core JavaScript -->
    <script src="plugin/jquery/jquery.min.js"></script>
    <script src="plugin/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="plugin/multiple-select/multiple-select.js"></script>
    <script src="js/script.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
	<script type="text/javascript" src="plugin/jquery-simple-websocket/jquery.simple.websocket.js"></script>
    <!-- <script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script> -->

    <!-- Menu Toggle Script -->
    <script>
    // $("#menu-toggle").click(function(e) {
    //     e.preventDefault();
    //     $("#wrapper").toggleClass("toggled");
    // });
    </script>

</body>

</html>
