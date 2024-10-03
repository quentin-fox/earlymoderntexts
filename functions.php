<?php
	// send a query to MySQL server.
	// display an error message if there
	// was some error in the query
	function MySQLQuery($query)
	{
		global $conn;
		$success= mysqli_query($conn, $query);

		if(!$success)
		{	
			echo mysqli_errno($conn).": ".mysqli_error($conn)."<BR>";
			echo "<hr>";
			echo $query;
			echo "<hr>\r\n";
		}
		
		if(substr($query, 0, 6) != "select") // for all queries other than SELECT
		{
			$strLog = $query . " - " . mysqli_errno($conn) . " - " . mysqli_error($conn);
		//	logToFile($strLog);		// log to file
		}
		
		return $success;
	}

	/*	the function insert a record in strTable with
		the values given by the associated array

		strTable:		table name where record will be inserted
		arrValue:		assoicated array with key-val pairs
		returns:		ID of the record inserted
	*/
	function InsertRec($strTable, $arrValue)
	{
		global $conn;
		$strQuery = "	insert into $strTable (";

		reset($arrValue);
		while(list ($strKey, $strVal) = each($arrValue))
		{
			$strQuery .= $strKey . ",";
		}

		// remove last comma
		$strQuery = substr($strQuery, 0, strlen($strQuery) - 1);

		$strQuery .= ") values (";

		reset($arrValue);
		while(list ($strKey, $strVal) = each($arrValue))
		{
			$strQuery .= "'" . FixString($strVal) . "',";
		}

		// remove last comma
		$strQuery = substr($strQuery, 0, strlen($strQuery) - 1);
		$strQuery .= ");";

		// execute query
		//echo $strQuery; die;
		MySQLQuery($strQuery);
		//echo $strQuery . "<br>";
		
		// return id of last insert record
		return mysqli_insert_id($conn);
	}

	// Get IP Address
	function getRealIpAddr()
	{
	    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
	    {
	      $ip=$_SERVER['HTTP_CLIENT_IP'];
	    }
	    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
	    {
	      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	    }
	    else
	    {
	      $ip=$_SERVER['REMOTE_ADDR'];
	    }
	    return $ip;
	}

	/*	the function remove single quote from the string
		and replace it with two single quotes

		strString:		string to be fixed
		returns:		fixed string
	*/
	function FixString($strString)
	{
		$strString = str_replace("'", "''", $strString);
		$strString = str_replace("\'", "'", $strString);
		
		return $strString;
	}
?>