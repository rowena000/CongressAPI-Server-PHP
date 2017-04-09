<html>
 <head>
  <meta charset="UTF-8">
  <title>Congress Information Search</title>
  <style type="text/css">
  	
  	table#results_table  {
	    border-collapse: collapse;
	    margin: 0 auto;
	    text-align: center;
	}
	
	table#results_table, table#results_table th, table#results_table td {
	    border: 1px solid black;
	    padding-left: 40px;
	    padding-right: 40px;
	}
	
	table#searchTable td {
		width: 145px;
	}
	
	body {
		width: 100%;
	}
	
	#content {
		width: 90%;
		margin: 0 auto;
		text-align: center;
	}
	
	#details_section {
		text-align: center;
		padding-top: 10px;
	}
	
	form {
		margin-bottom: 0px;
	}
	
	table.details_table {
		padding-top: 10px;
		padding-bottom: 20px;
		text-align: left;
		margin-left: 40px;
	}
	
	table.details_table, table.details_table th, table.details_table td {
		border: none;
		margin: 0 auto;
		width: 600px;
	}
	
	.thumbnail {
		margin-top: 20px;
		margin-bottom: 20px;
	}
	
	#formarea {
		width: 300px; 
		margin: 0 auto;
		border: 1px solid black;
		margin-bottom: 30px;
	}
	
	table.align_center {
		text-align: center;
	}
	
	.td_name {
		text-align: left;
	}
	
  </style>
   <script>
 	function submitSearch() {
 		var alertText = "Please enter the following missing information: ";
		var emptyFields = [];
		var test = document.forms["searchForm"]["congressdb"].value;
		
		if (document.forms["searchForm"]["congressdb"].value == "Select your option") {
			emptyFields.push("Congress Database");
		}
		if (document.forms["searchForm"]["chamber"].value == null) {
			emptyFields.push("Chamber");
		}
		if (document.forms["searchForm"]["keyword"].value == null || document.forms["searchForm"]["keyword"].value == "") {
			keywordLabel = document.getElementById("keyword").innerHTML.replace(/\s+/g, " ");;
			emptyFields.push(keywordLabel);
		}
		
		if (emptyFields.length == 0) {
			return true;
		} else {
			for (var i = 0; i < emptyFields.length; i++) {
				if (i > 0) {
					alertText += ", "
				}
				alertText += emptyFields[i] ;
			}
			alert(alertText);
			return false;
		}
 	}
 	
 	function changeCongressDB() {
		d = document.getElementById("select_db").value;
		if (d == "legislators") {
			document.getElementById("keyword").innerHTML = "State/Representative*";
		} else if (d == "committees") {
			document.getElementById("keyword").innerHTML = "Committee ID*"
		} else if (d == "bills") {
			document.getElementById("keyword").innerHTML = "Bill ID*"
		} else if (d == "amendments") {
			document.getElementById("keyword").innerHTML = "Amendment ID*"
		} else {
			document.getElementById("keyword").innerHTML = "Keyword*"
		}
	}
	
	function renderTableRow(left, right) {
		tableRow = "<tr><td>" + left + "</td><td>" + right + "</td></tr>";
		return tableRow;
	}
	
	function renderLegislatorDetails(guid, title, fullname, term_end, website, office, facebook_id, twitter_id) {
		removeTable();
		var output = "";
		output += "<img class=\"thumbnail\" src=\"https://theunitedstates.io/images/congress/225x275/" + guid + ".jpg\" />";
		output += "<table class=\"details_table\">"
					  + renderTableRow("Full Name", title + " " + fullname)
					  + renderTableRow("Terms Ends on", term_end)
					  + renderTableRow("Website", website == "NA" ? "NA" : "<a href=\"" + website + "\" target=\"_blank\">" + website + "</a>")
					  + renderTableRow("Office", office)
					  + renderTableRow("Facebook", facebook_id == "NA" ? "NA" : "<a href=\"https://www.facebook.com/" + facebook_id + "\" target=\"_blank\">" + fullname + "</a>")
					  + renderTableRow("Twitter", twitter_id == "NA" ? "NA" : "<a href=\"https://twitter.com/" + twitter_id + "\" target=\"_blank\">" + fullname + "</a>");
			
		document.getElementById("details_section").innerHTML = output;
		document.getElementById("details_section").style.border = "1px solid black";
	}
	
	function renderBills(bill_id, short_title, sponsor, introduced_on, last_action, pdflink, pdftitle) {
		removeTable();
		var output = "";
		output += "<table class=\"details_table\">"
					  + renderTableRow("Bill ID", bill_id)
					  + renderTableRow("Bill Title", short_title)
					  + renderTableRow("Sponsor", sponsor)
					  + renderTableRow("Introduced On", introduced_on)
					  + renderTableRow("Last action with date", last_action)
					  + renderTableRow("Bill URL", "<a href=\"" + pdflink + "\" target=\"_blank\">" + pdftitle + "</a>");

		document.getElementById("details_section").innerHTML = output;
		document.getElementById("details_section").style.border = "1px solid black";
	}

	function removeTable() {
		//remove the table
		divcontent = document.getElementById("searchResult");
		resultstable = document.getElementById("results_table");
		divcontent.removeChild(resultstable);	
	}
	
	
	function resetPage() {
		document.getElementById("keyword").innerHTML = "Keyword*";
		document.getElementById("searchResult").innerHTML = "";
		var selected = document.getElementById("select_db");
		selected.selectedIndex = 0;
		document.getElementById("choice1").checked = true;
	    document.getElementById("choice2").checked = false;
	    document.getElementById("keyword_input").value = null;
	    return false;
	}
 </script>
 </head>

 <body>
 	<div id="content">
 		<h1>Congress Information Search</h1>
	 	<div id="formarea">
			<form id="searchForm" method="post" onsubmit="return submitSearch()" onreset="return resetPage()" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
				<table id="searchTable" class="align_center">
					<tr>
						<td>Congress Database</td>
						<td>
							 <select id="select_db" onchange="changeCongressDB()" name="congressdb" value="Select your option">
							 	<option value="Select your option" <?php if(isset($_POST['submit']) && $_POST['congressdb'] == "Select your option") echo "selected=\"selected\""; ?>>Select your option</option>
						   		<option value="legislators" <?php if(isset($_POST['submit']) && $_POST['congressdb'] == "legislators") echo "selected=\"selected\""; ?>>Legislators</option>
						   		<option value="committees" <?php if(isset($_POST['submit']) && $_POST['congressdb'] == "committees") echo "selected=\"selected\""; ?>>Committees</option>
						   		<option value="bills" <?php if(isset($_POST['submit']) && $_POST['congressdb'] == "bills") echo "selected=\"selected\""; ?>>Bills</option>
						   		<option value="amendments" <?php if(isset($_POST['submit']) && $_POST['congressdb'] == "amendments") echo "selected=\"selected\""; ?>>Amendments</option>
						   </select>
						</td>
					</tr>
					<tr>
						<td>Chamber</td>
						<td>
							<input id="choice1" type="radio" value="senate" name="chamber" <?php if(empty($_POST['submit']) || (isset($_POST['submit']) && $_POST['chamber'] == 'senate')) echo "checked=\"checked\""; ?>>Senate
							<input id="choice2" type="radio" value="house" name="chamber" <?php if(isset($_POST['submit']) && $_POST['chamber'] == "house") echo "checked=\"checked\""; ?>>House
						</td>
					</tr>
					<tr>
						<td id="keyword">
							<?php 
								  if(isset($_POST['submit']) && $_POST['congressdb'] == "legislators") {
									echo "State/Representative*";
								  } else if (isset($_POST['submit']) && $_POST['congressdb'] == "committees") {
								  	echo "Committee ID*";
								  } else if (isset($_POST['submit']) && $_POST['congressdb'] == "bills") {
								  	echo "Bill Id*";
								  } else if (isset($_POST['submit']) && $_POST['congressdb'] == "amendments") {
									echo "Amendment ID*";
								  } else {
								  	echo "Keyword*";
								  }
							?>
						</td>
						<td>
							<input id="keyword_input" type="text" name="keyword" <?php 
								  if(isset($_POST['submit'])) {
									echo "value=\"" . $_POST['keyword'] . "\"";
								  }
							?>>
						</td>
					</tr>
					<tr>
						<td></td>
						<td>
							<input type="submit" name="submit" value="Search" >
						   <input type="reset" value="Clear" />
						</td>
					</tr>
					<tr>
						<td colspan="2"><a href="http://sunlightfoundation.com/">Powered by Sunlight Foundation</a></td>
					</tr>
				</table>
			   
			</form>
		</div>
		 <!-- <a href="#" onclick="renderBills('s3271', 'short_title', 'sponsor', 'introduced_on', 'last_action', 'pdflink', 'pdftitle')" >Click me</a> 
		 --> 
		<div id="searchResult">
<?php

function getBaseUrl() {
	return "http://congress.api.sunlightfoundation.com/";
}

function getKey() {
	return "&apikey=ea055b890b9b46f5ac8d06339ed6fa9e";
}

if(isset($_POST['submit'])) 
// if (true)
{	 
	$congressdb = $_POST['congressdb'];
	$chamber = $_POST['chamber'];
	$keyword = $_POST['keyword'];
    $keyword = trim($keyword);
    
	$output = "";
	switch ($congressdb) {
		case "legislators":
			$output = processLegislators($congressdb, $chamber, $keyword);
			break;
		case "committees":
			$output = processCommittees($congressdb, $chamber, $keyword);
			break;
		case "bills":
			$output = processBills($congressdb, $chamber, $keyword);
			break;
		case "amendments":
			$output = processAmendments($congressdb, $chamber, $keyword);
			break;
		default:
			$querykey = "";
	} 
	
	echo $output;
}

function generateTableHeader($columns) {
	$retVal = "<table id=\"results_table\"><tr>";
	foreach ($columns as $column) {
		// if ($value != "") {
			// $retVal = $retVal . "<th width=\"" . $value . "\">" . $key . "</th>";
		// } 
		 $retVal = $retVal . "<th class=\"th_" . $column . "\">" . $column . "</th>";
	}
	
	$retVal = $retVal . "</tr>";
	return $retVal;
}

function generateTableRow($row_values) {
	$retVal = "";
	foreach ($row_values as $value) {
		$retVal = $retVal . "<td>" . $value . "</td>";
	}
	return $retVal;
}

function processLegislators($congressdb, $chamber, $keyword) {
	$states = array( "alabama" => "AL", "alaska" => "AK", "arizona" => "AZ", "arkansas" => "AR", "california" => "CA", "colorado" => "CO", 
			"connecticut" => "CT", "delaware" => "DE", "florida" => "FL", "georgia" => "GA", "gawaii" => "HI", "idaho" => "ID", "illinois" => "IL", "indiana" => "IN", 
			"iowa" => "IA", "kansas" => "KS", "kentucky" => "KY", "louisiana" => "LA", "maine" => "ME", "maryland" => "MD", "massachusetts" => "MA", "michigan" => "MI", 
			"minnesota" => "MN", "mississippi" => "MS", "missouri" => "MO", "montana" => "MT", "nebraska" => "NE", "nevada" => "NV", "new hampshire" => "NH", "new jersey" => "NJ",
			"new mexico" => "NM", "new york" => "NY", "north carolina" => "NC", "north dakota" => "ND", "ohio" => "OH", "oklahoma" => "OK", "oregon" => "OR", "pennsylvania" => "PA", 
			"rhode island" => "RI", "south carolina" => "SC", "south dakota" => "SD", "tennessee" => "TN", "texas" => "TX", "utah" => "UT", "vermont" => "VT", "virginia" => "VA", 
			"washington" => "WA", "west virginia" => "WV", "wisconsin" => "WI", "wyoming" => "WY");
			
	// $legislators_columns = array("Name" => "width: 400px;","State" => "200px","Chamber" => "200px", "Details" => "200px");
	$legislators_columns = array("Name","State","Chamber", "Details");
   
    $url = "";
	if (array_key_exists(strtolower($keyword),$states)) {
		$querykey = "&state=";
		$keyword = $states[strtolower($keyword)];
		$url = getBaseUrl() . $congressdb . "?chamber=" . $chamber . $querykey . urlencode($keyword) . getKey();
	} else {
		$querykey = "&query=";
		
		$splitKeyword = explode(" ", $keyword);
		if (count($splitKeyword) <= 1) {
			$url = getBaseUrl() . $congressdb . "?chamber=" . $chamber . $querykey . urlencode($keyword) . getKey();
		} else {
			$s_firstname = ucwords($splitKeyword[0]);
			$s_lastname = "";
			$first = true;
			foreach ($splitKeyword as $s_keyword) {
				if ($first) {
					$first = false;
					continue;
				}
				$s_lastname .= ucwords($s_keyword) . " ";
			}
			$s_lastname = trim($s_lastname);
			$url = getBaseUrl() . $congressdb . "?chamber=" . $chamber . "&first_name=" . urlencode($s_firstname) 
				. "&last_name=" . urlencode($s_lastname) . getKey();
		}
	}
	
	$response = @file_get_contents($url);
	if (!$response) {
		$error = error_get_last();
        echo "HTTP request failed. Please verify your input or retry";
		return;
	}
	
	$output = generateTableHeader($legislators_columns);
	$response = json_decode($response, true); //decode response as array
	
	//get the first element of response, "results";
	$results = reset($response);
	$results = (array)$results;
	if ($results == null || count($results) == 0) {
		return "The API returned zero results for the request.";
	}
	
	$output_detail = "";
	
	//generate both summanry table row, and detail 
	foreach ($results as $entry) {
	    $output .= "<tr>";	
	    $row_values = [];
		array_push($row_values, $entry['state_name'], $entry['chamber']);
		$output .= "<td class=\"td_name\">" . $entry['first_name']." ".$entry['last_name'] . "</td>";
		$output .= generateTableRow($row_values);
		
		 // renderLegislatorDetails(guid, title, fullname, term_end, website, office, facebook_id, twitter_id)
		 // <a href="#" onclick="renderLegislatorDetails('M001111', 'Sen', 'Patty Murray', '2018' , 'http://www.murray.senate.gov/public', 'office', 'NA', 'PattyMurray')" >Click me</a> 
		$details_values = [];
		array_push($details_values, $entry['bioguide_id'], $entry['title'], $entry['first_name']." ".$entry['last_name'], 
				   $entry['term_end'], $entry['website'] == null?"NA":$entry['website'], $entry['office'],
				   $entry['facebook_id'] == null?"NA":$entry['facebook_id'], $entry['twitter_id'] == null?"NA":$entry['twitter_id']);
		
		$detailsParam = generateDetailsParm($details_values);
		
		// echo $detailsParam; 
		$output .="<td><a href=\"#\" onclick=\"renderLegislatorDetails(" . $detailsParam . ")\">View Details</a></td>";
		$output .= "</tr>";
		
		$output_detail .= "<div id=\"details_section\">";
		
		$output_detail .= "</div>";
	}
	
	$output .= "</table>";
	$output .= $output_detail;
	
	return $output;
}

function generateDetailsParm($array) {
	$retStr = "";
	$first = true;
	foreach ($array as $item) {
		if ($first) {
			$first = false;
			$retStr .= "'" .$item . "'" ;
			continue;
		} else {
			$retStr .=",";
		}
		$retStr .= "'" .$item . "'" ;
	}
	// echo $retStr . "<br>";
	return $retStr;
}


function processCommittees($congressdb, $chamber, $keyword) {
	$committee_columns = array("Committee ID", "Committee Name", "Chamber");
	$url = getBaseUrl() . $congressdb . "?committee_id=" . urlencode(strtoupper($keyword)) . "&chamber=" . $chamber . getKey();
	// echo $url;
	$response = @file_get_contents($url);
	if (!$response) {
		$error = error_get_last();
        echo "HTTP request failed. Please verify your input or retry";
		return;
	}
	$output = generateTableHeader($committee_columns);
	$response = json_decode($response, true); 
	$results = reset($response);
	$results = (array)$results;
	if ($results == null || count($results) == 0) {
		return "The API returned zero results for the request.";
	}
	
	foreach ($results as $entry) {
		$output .= "<tr>";	
	    $row_values = [];
		array_push($row_values, $entry['committee_id'], $entry['name'], $entry['chamber']);
		$output .= generateTableRow($row_values);
		$output .= "</tr>";
	}
	$output = $output . "</table>";
	return $output;
}

function processBills($congressdb, $chamber, $keyword) {
	$bill_columns = array("Bill ID", "Short Title", "Chamber", "Details");
	$url = getBaseUrl() . $congressdb . "?bill_id=" . urlencode(strtolower($keyword)) . "&chamber=" . $chamber . getKey();
	// echo $url;
	$response = file_get_contents($url);
	$output = generateTableHeader($bill_columns);
	$response = json_decode($response, true); 
	$results = reset($response);
	$results = (array)$results;
	if ($results == null || count($results) == 0) {
		return "The API returned zero results for the request.";
	}
	
	foreach ($results as $entry) {
		$output .= "<tr>";	
	    $row_values = [];
		array_push($row_values, $entry['bill_id'], $entry['short_title'] == null? "NA":$entry['short_title'], $entry['chamber']);
		$output .= generateTableRow($row_values);
		
		$sponsor = $entry['sponsor'];
		$sponsorname = $sponsor['title'] . " " . $sponsor['first_name'] . " " . $sponsor['last_name'];
		
		$details_values = [];
		array_push($details_values, $entry['bill_id'], 
				   $entry['short_title'] == null?"NA":$entry['short_title'],
				   $sponsorname, 
				   $entry['introduced_on'], 
				   $entry['last_version']['version_name'] . ", " . $entry['last_action_at'],
				   $entry['last_version']['urls']['pdf'],
				   $entry['short_title'] == null?$entry['bill_id']:$entry['short_title']);
		
		$detailsParam = generateDetailsParm($details_values);
		// echo $detailsParam; 
				
		// renderBills(bill_id, short_title, sponsor, introduced_on, last_action, pdflink, pdftitle)
		$output .="<td><a href=\"#\" onclick=\"renderBills(" . $detailsParam . ")\">View Details</a></td>";
		$output .= "</tr>";
	}
	$output = $output . "</table>";
	return $output;
}	

function processAmendments($congressdb, $chamber, $keyword) {
	$amendment_columns = array("Amendment ID", "Amendment Type", "Chamber", "Introduce on");
	$keyword = urlencode($keyword);
	$url = getBaseUrl() . $congressdb . "?amendment_id=" . urlencode(strtolower($keyword)) . "&chamber=" . $chamber . getKey();
	// echo $url;
	$response = file_get_contents($url);
	$output = generateTableHeader($amendment_columns);
	$response = json_decode($response, true); 
	$results = reset($response);
	$results = (array)$results;
	if ($results == null || count($results) == 0) {
		return "The API returned zero results for the request.";
	}
	
	foreach ($results as $entry) {
		$output .= "<tr>";	
	    $row_values = [];
		array_push($row_values, $entry['amendment_id'], $entry['amendment_type'], $entry['chamber'], $entry['introduced_on']);
		$output .= generateTableRow($row_values);
		$output .= "</tr>";
	}
	$output = $output . "</table>";
	return $output;
}

?>
		
		<div id="details_section"></div>
	</div>
	</div> <!-- end of div #content -->
	<NOSCRIPT>
 </body>
</html>