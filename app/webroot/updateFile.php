<?php

	require_once('db_connect.php');


	function updateJsonFile($lat, $long, $phoneId){

		$filename = SCRIPT_PATH . 'points.json';
		$filenameNew = SCRIPT_PATH . 'points.jsonNew';

		$longLat = $lat . "," . $long;
		$content = "";
		$dbContent="";
		$textFound = FALSE;

		//create the new file
		touch($filenameNew);

		if (is_readable($filename) && is_writable($filenameNew)) {

			if (!$handle = fopen($filename, 'r')) {
				 return "Cannot open file ($filename)";
				 exit;
			}
			if (!$handleNew = fopen($filenameNew, 'w')) {
					 return "Cannot open file ($filenameNew)";
					 exit;
			}

			while (!feof($handle)) {
				$position = ftell($handle);
				// Write $some content to our opened file.
				$contents = fgets($handle); //read line from file
				$tableInfo = "";
				//$found = stristr($contents, $lat);
				if (stristr($contents, $lat) && stristr($contents, $long))
					$found =TRUE;
				else
					$found=FALSE;

				//$tableInfo = "<br/><table border=1> <tr><th>Drugs</th> <th>POS Bottles Before MDA</th><th>Tablet Bottles Before MDA</th><th>Number of Treatments Distributed</th><th>POS Bottles After MDA</th><th>Tablet Bottles After MDA</th> </tr> ";
				//$tableInfo = $tableInfo . "<tr><th>ALB</th><td/><td/><td/><td/><td/></tr> </table>";
				if ($found == TRUE) {
					$textFound = TRUE;
					echo "FOUND: " . $contents . "\n";
					//write the current points line
					fwrite($handleNew, $contents);
					//move pointer to next line with information
					$contents = fgets($handle);

					prepareTable($dbContent, $lat, $long, $phoneId);


					//$dbContent="\"information\": \"Seshego District Hospital " . $tableInfo ."\",\n";
					fwrite($handleNew, $dbContent);
					echo "UPDATING: " . $dbContent . "\n";


				} else {

				//see if we are at the end of the file and add new clicnic if so

					if ((FALSE != stristr($contents, "] }") ) && $textFound == FALSE) {
						// get infomration from database;
						//$query = "SELECT * FROM locations WHERE locationLongitude = '". $long . "' AND locationLatitude = '" . $lat . "' limit 1";
						prepareTable( $dbContent, $lat, $long, $phoneId);

						//$dbContent="\"information\": \"Seshego District Hospital " . $tableInfo ."\",\n";

						fwrite($handleNew, ",{" . "\n");
						//fwrite($handleNew, "\"point\": new GLatLng(" . $longLat . ")," . "\n");

						fwrite($handleNew, "\"point\": {\"latitude\":\"" . $lat . "\",\"longitude\":\"" . $long. "\"},"  . "\n");
						fwrite($handleNew, $dbContent);
						fwrite($handleNew, "\"markerImage\":\"http://google-maps-icons.googlecode.com/files/hospital.png\" \n}\n");
						fwrite($handleNew, "] }");

						echo "NEW:"  . $dbContent . "\n";

						//add new entry here
						echo "END OF FILE";
					} else {
						fwrite($handleNew, $contents);
						echo "COPYING: " . $contents . "\n";
					}
				}


			}
			fclose($handle);
			fclose($handleNew);

			//delete and rename the new file
			unlink ($filename);
			rename ($filenameNew, $filename);

		} else {
			echo "The file $filename is not writable";
		}

	}

	function prepareTable( & $dbContent, $lat, $long, $phoneId) {

			//@ $db = new mysqli('localhost', 'root', '', 'sms_2');

			//if (mysqli_connect_errno())
			//{
			//	echo "Error: Could not connect to database. Please try again";
			//	exit;
			//}

			//$result = $db->query($query);

			//if (!$result)
			//	echo "DB_ERROR: " . $db->error;

			//check if this location exists in the database
			//if ($result->num_rows == 0) {
			//	echo "Error: Location with coordinates (" . $longLat . ") not found in database! \n" ;
			//	exit;
			//}

			$query = "SELECT * FROM locations WHERE locationLongitude = '". $long . "' AND locationLatitude = '" . $lat . "' limit 1";

			$result = runQuery($query);

			$locationId = -1;
			while ($row = $result->fetch_assoc()) {
				$dbContent = "\"html\": \"<p><strong>" . $row['name'] . "</strong></p>";
				$locationId = $row['id'];
			}


			//$dbContent .= "<table><tr><td>";

			//get the table with drugs
			$query = "SELECT quantity, drugs.name as dname ";
			$query .= "FROM stats st, drugs ";
			$query .= "WHERE st.drug_id = drugs.id ";
			$query .= "AND st.id = (select max(s.id) from stats s where s.drug_id = st.drug_id  ";
			$query .= "AND location_id =" . $locationId . " ) ";
			$query .= "AND location_id =" . $locationId . " ";
			$query .= "ORDER by created DESC ";

			$result = runQuery($query);

			//prepare header
			$dbContent .= "<p><table><tr><td>Drug Code</td> ";
			$dbContent .= 						"<th>Quantity</th>";
			$dbContent .= 					"</tr> ";


			for ($i = 0; $i < $result->num_rows; $i++){
						$row = $result->fetch_assoc();

						$dbContent .= "<tr><th>" . $row['dname'] . "</th>";
						$dbContent .= "<td>" . $row['quantity'] . " </td>";
						$dbContent .= "</tr>";

			}

			//closing table for html
			$dbContent .= "</table></p> <p>&nbsp;</p>";

			//$dbContent .= "</td>";


			//get the table with treatments
			$query = "SELECT quantity, treatments.code as dname ";
			$query .= "FROM stats st, treatments ";
			$query .= "WHERE st.treatment_id = treatments.id ";
			$query .= "AND st.id = (select max(s.id) from stats s where s.treatment_id = st.treatment_id ";
			$query .= "AND location_id =" . $locationId . " ) ";
			$query .= "AND location_id =" . $locationId . " ";
			$query .= "ORDER by created DESC ";

			$result = runQuery($query);

			//prepare header
			$dbContent .= "<p><table><tr><td>Treatment Code</td> ";
			$dbContent .= 						"<th>Quantity</th>";
			$dbContent .= 					"</tr> ";


			for ($i = 0; $i < $result->num_rows; $i++){
						$row = $result->fetch_assoc();

						$dbContent .= "<tr><th>" . $row['dname'] . "</th>";
						$dbContent .= "<td>" . $row['quantity'] . " </td>";
						$dbContent .= "</tr>";

			}

			//closing table for html
			$dbContent .= "</table></p> <p>&nbsp;</p>\",\n";
			//$dbContent .= "</td></tr></table>\",\n";
	}

?>
