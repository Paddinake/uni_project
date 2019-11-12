<?php
//create_topic.php
include 'db.php';

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
	}

if (!isset($_SESSION)) {
    session_start();
	}


echo '<h2>Create a topic</h2>';

	if($_SERVER['REQUEST_METHOD'] != 'POST')
	{	
		//the form hasn't been posted yet, display it
		//retrieve the categories from the database for use in the dropdown
		$sql = "SELECT * FROM bereich";
		
		$result = mysqli_query($con, $sql);
		
		if(!$result)
		{
			//the query failed, uh-oh :-(
			echo 'Error while selecting from database. Please try again later.';
		}
		else
		{
			if(mysqli_num_rows($result) == 0)
			{
				//there are no categories, so a topic can't be posted
				if($_SESSION['user_level'] == 1)
				{
					echo 'You have not created categories yet.';
				}
				else
				{
					echo 'Before you can post a topic, you must wait for an admin to create some categories.';
				}
			}
			else
			{
			echo '<form method="post" action="">
					Subject: <input type="text" name="t_subject" /><br />
					Category:'; 
				
				echo '<select name="t_bereich">';
					while($row = mysqli_fetch_assoc($result))
					{
						echo '<option value="' . $row['b_id'] . '">' . $row['b_name'] . '</option>';
					}
				echo '</select><br />';	
					
				echo 'Message: <br /><textarea name="post_content" /></textarea><br /><br />
					<input type="submit" value="Create topic" />
				 </form>';
			}
		}
	}
	else
	{
		//start the transaction
		$query  = "BEGIN WORK;";
		$result = mysqli_query($con, $query);
		
		if(!$result)
		{
			//Damn! the query failed, quit
			echo 'An error occured while creating your topic. Please try again later.';
		}
		else
		{
	
			//the form has been posted, so save it
			//insert the topic into the topics table first, then we'll save the post into the posts table
			$sql = "INSERT INTO thema(t_subject,t_date, t_bereich, t_ersteller)
				   VALUES('" . mysqli_real_escape_string($con, $_POST['t_subject']) . "',
							   NOW(),
							   " . mysqli_real_escape_string($con, $_POST['t_bereich']) . ",
							   " . $_SESSION['user_id'] . "
							   )";
					 
			$result = mysqli_query($con, $sql);
			if(!$result)
			{
				//something went wrong, display the error
				echo 'An error occured while inserting your data. Please try again later.<br /><br />' . mysqli_error();
				$sql = "ROLLBACK;";
				$result = mysqli_query($con, $sql);
			}
			else
			{
				//the first query worked, now start the second, posts query
				//retrieve the id of the freshly created topic for usage in the posts query
				$topicid = mysqli_insert_id($con);
				
				$sql = "INSERT INTO posts(p_inhalt, p_date, p_thema, p_ersteller) VALUES
							('" . mysqli_real_escape_string($con, $_POST['post_content']) . "',
								  NOW(), " . $topicid . ", " . $_SESSION['user_id'] . ")";
				$result = mysqli_query($con, $sql);
				
				if(!$result)
				{
					//something went wrong, display the error
					echo 'An error occured while inserting your post. Please try again later.<br /><br />' . mysqli_error($con);
					$sql = "ROLLBACK;";
					$result = mysqli_query($con, $sql);
				}
				else
				{
					$sql = "COMMIT;";
					$result = mysqli_query($con, $sql);
					
					//after a lot of work, the query succeeded!
					echo 'You have succesfully created <a href="topics.php?id='. $topicid . '">your new topic</a>.';
				}
			}
		}
	
}


?>
