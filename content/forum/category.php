<?php
//category.php
include 'db.php';
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
	}

if (!isset($_SESSION)) {
    session_start();
	}


//first select the category based on $_GET['cat_id']
$sql = "SELECT * FROM bereich WHERE b_id = " . mysqli_real_escape_string($con, $_GET['id']);

$result = mysqli_query($con,$sql);

if(!$result)
{
	echo 'The category could not be displayed, please try again later.' . mysqli_error($con);
}
else
{
	if(mysqli_num_rows($result) == 0)
	{
		echo 'This category does not exist.';
	}
	else
	{
		//display category data
		while($row = mysqli_fetch_assoc($result))
		{
			echo '<h2>Topics in &prime;' . $row['b_name'] . '&prime; category</h2><br />';
		}
	
		//do a query for the topics
		$sql = "SELECT * FROM thema WHERE t_bereich = " . mysqli_real_escape_string($con,$_GET['id']);
		
		$result = mysqli_query($con,$sql);
		
		if(!$result)
		{
			echo 'The topics could not be displayed, please try again later.';
		}
		else
		{
			if(mysqli_num_rows($result) == 0)
			{
				echo 'There are no topics in this category yet.';
			}
			else
			{
				//prepare the table
				echo '<table border="1">
					  <tr>
						<th>Topic</th>
						<th>Created at</th>
					  </tr>';	
					
				while($row = mysqli_fetch_assoc($result))
				{				
					echo '<tr>';
						echo '<td class="leftpart">';
							echo '<h3><a href="index.php?content=forum&subnav=topics&id=' . $row['t_id'] . '">' . $row['t_subject'] . '</a><br /><h3>';
						echo '</td>';
						echo '<td class="rightpart">';
							echo date('d-m-Y', strtotime($row['t_date']));
						echo '</td>';
					echo '</tr>';
				}
			}
		}
	}
}

?>