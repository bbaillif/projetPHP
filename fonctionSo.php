<?php

	function Query($query)
	{
		$r=mysqli_connect('localhost','root','','commandes');
		$t=mysqli_query($r,$query);
		mysqli_close($r);
		return ($t);
	}
	
	function Printresults($tableau,$type)
	{
		if ($type = "checkbox")
		{
			while($nuplet=mysqli_fetch_array($t))
			{
				print("<input type=\"checkbox\" name=\"value[]\" value=\"".$nuplet[0]."\" id= b> ");
				print("<label for= \"b\">".$nuplet[0]."\n</label><br><br>");
			}
		}
		else
		{
			while($nuplet=mysqli_fetch_array($t))
			{
				print("<input type=\"radio\" name=\"val\" value=\"".$nuplet[0]."\" id= b> ");
				print("<label for= \"b\">".$nuplet[0]."\n</label><br><br>");
			}
		}
	}
			
?>