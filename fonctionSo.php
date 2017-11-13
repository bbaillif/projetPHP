<?php

	function Query($query)
	{
		$r=mysqli_connect('localhost','root','','commandes');
		$t=mysqli_query($r,$query);
		while($nuplet=mysqli_fetch_array($t))
		{
			print($nuplet[0]);
		}
		mysqli_close($r);
?>