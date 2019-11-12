<?php
//create_cat.php
include '../../db.php';
include 'forum.php';

$sql = "SELECT * FROM thema WHERE thema.t_id = " . mysqli_real_escape_string($con, $_GET['id']);


$result = mysqli_query($con,$sql);

if(!$result)
{
	echo 'The topic could not be displayed, please try again later.';
}
else
{
	if(mysqli_num_rows($result) == 0)
	{
		echo 'This topic doesn&prime;t exist.';
	}
	else
	{
		while($row = mysqli_fetch_assoc($result))
		{
			//display post data
			echo '<table class="topic" border="1">
					<tr>
						<th colspan="2">' . $row['t_subject'] . '</th>
					</tr>';
		
			//fetch the posts from the database
			$posts_sql = "SELECT
						posts.p_thema,
						posts.p_inhalt,
						posts.p_date,
						posts.p_ersteller,
						user.user_id,
						user.name
					FROM
						posts
					LEFT JOIN
						user
					ON
						posts.p_ersteller = user.user_id
					WHERE
						posts.p_thema = " .mysqli_real_escape_string($con, $_GET['id']);
						
			$posts_result = mysqli_query($con,$posts_sql);
			
			if(!$posts_result)
			{
				echo '<tr><td>The posts could not be displayed, please try again later.</tr></td></table>';
			} 
			else
			{
			
				while($posts_row = mysqli_fetch_assoc($posts_result))
				{
					echo '<tr class="topic-post">
							<td class="user-post">' . $posts_row['name'] . '<br/>' . date('d-m-Y H:i', strtotime($posts_row['p_date'])) . '</td>
							<td class="post-content">' . htmlentities(stripslashes($posts_row['p_inhalt'])) . '</td>
						  </tr>';
				}
			}
			
			/*if(!$_SESSION['signed_in'])
			{
				echo '<tr><td colspan=2>You must be <a href="signin.php">signed in</a> to reply. You can also <a href="signup.php">sign up</a> for an account.';
			}*/
			#else
			#{
				//show reply box
				echo '<tr><td colspan="2"><h2>Reply:</h2><br />
					<form method="post" action="reply.php?id=' . $row['t_id'] . '">
						<textarea name="reply-content"></textarea><br /><br />
						<input type="submit" value="Submit reply" />
					</form></td></tr>';
			#}
			
			//finish the table
			echo '</table>';
		}
	}
}


?>