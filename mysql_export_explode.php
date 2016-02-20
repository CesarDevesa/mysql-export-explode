<?php 

	
	class mysql_export_explode
	{
		
		
		var $db;
		var $rows;
		

		function connect($host,$user,$pass)
		{	
			mysql_connect($host,$user,$pass) or die(mysql_error());
			$this->select_db();
		}


		function select_db()
		{
			mysql_select_db($this->db) or die(mysql_error());
		}


		function exportTable($table,$fracciones)
		{	



			$numRows = mysql_fetch_object(mysql_query( " SELECT count(*) total FROM $table " )) or die(mysql_error());

			$resto 		= $numRows->total % $fracciones;
			$tempLote 	= $numRows->total - $resto;
			$f = $tempLote / $fracciones;

			if ($resto)
			{
				#echo "La exportacion se dividira en $fracciones fraccion(es) de $f registros mas 1 fraccion(es) de $resto registros<br>";
			}
			else
			{
				
				#echo "La exportacion se dividira en $fracciones fraccion(es) de $f registros<br>";
			}
				

			$comienzo = 0;
			
			foreach ($this->rows as $r) {$tempRows .= "$r,";} 
			$tempRows = trim($tempRows, ',');

				for ($i=0; $i < (($resto) ? ($fracciones+1) : $fracciones) ; $i++) { 
					
					if ($numRows->total >= $tempRecorrido + $f)
					{	
						

						$result = mysql_query("SELECT $tempRows FROM $table limit  $comienzo , $f ") or die(mysql_error());
							
						$ar=fopen( $table . "_" . $i . ".sql","a") or die("Problemas en la creacion del archivo");
						
						while ($row = mysql_fetch_array($result))
						{	
							
							foreach($row as $key => $r)
							{
								if (!is_numeric($key))
								{
										$keys .= "$key,";
										$values .= "'$row[$key]',";
								}
							}

							$keys = trim($keys, ',');$values = trim($values, ',');
							fputs($ar,"INSERT INTO `$table` ($keys) VALUES($values);");
						  	fputs($ar,"\n");
							$values = false;
							$keys = false;
						
						} // End while

						  fclose($ar);


						$comienzo += $f;
						$tempRecorrido += $f;
						
					} // End if
					elseif($numRows->total == $tempRecorrido + $resto)
					{
						

						$result = mysql_query("SELECT $tempRows FROM $table limit  $comienzo , $f ");
							
						$ar=fopen( $table . "_" . $i . ".sql","a") or die("Problemas en la creacion");
						
						while ($row = mysql_fetch_array($result))
						{	


							foreach($row as $key => $r)
							{
								if (!is_numeric($key))
								{		
										$keys .= "$key,";
										$values .= "'$row[$key]',";
								}
							} // End foreach

							$keys = trim($keys, ',');
							$values = trim($values, ',');
							
							fputs($ar,"INSERT INTO `$table` ($keys) VALUES($values);");
						  	fputs($ar,"\n");
							
							$values = false;
							$keys = false;

						} // End while

						  fclose($ar);

						$comienzo += $resto;
						$tempRecorrido += $resto;
						
					} // End elseif
					
				} // End for

		} // End exportTable method

	}