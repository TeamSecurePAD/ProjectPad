<?php

	function confirm_query($result_set)
	{
		if (!$result_set)
		{
			die("Database query failed.");
		}
	}

	function password_check($password, $existing_hash)
	{
		// Existing hash contains format and salt at start
		$hash = ($password);

		if ($hash === $existing_hash)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function find_acount_by_username ($username)
	{
		global $connection;
			
		$safe_username = mysqli_real_escape_string($connection, $username);
		
		$query  = "SELECT * ";
		$query .= "FROM acount ";
		$query .= "WHERE gebruikersnaam = '{$username}' ";
		$query .= "LIMIT 1";

		$username_set = mysqli_query($connection, $query);

		confirm_query($username_set);
		
		if($username = mysqli_fetch_assoc($gebruikersnaam))
		{
			return $user;
		}
		else
		{
			return null;
		}
	}

	function attempt_login($username, $password)
	{
		$user = find_acount_by_username($username);

		if ($user)
		{
			// Found admin, now check password
			if (password_check($password, $user["wachtwoord"]))
			{
				// Password matches
				return $user;
			}
			else
			{
				// Password does not match
				return false;
			}
		}
		else
		{
			// Admin not found
			return false;
		}
	}

?>