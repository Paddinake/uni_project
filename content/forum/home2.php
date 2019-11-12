<?php
//create_cat.php
include 'db.php';



$sql = "SELECT
			bereich.b_id,
			bereich.b_name,
			bereich.b_inhalt,
			COUNT(thema.t_id) AS thema
		FROM
			bereich
		LEFT JOIN
			thema
		ON
			thema.t_id = bereich.b_id
		GROUP BY
			bereich.b_name, bereich.b_inhalt, bereich.b_id";

$result = mysqli_query($con, $sql);

if(!$result)
{
	echo 'The categories could not be displayed, please try again later.';
}
else
{
	if(mysqli_num_rows($result) == 0)
	{
		echo 'No categories defined yet.';
	}
	else
	{
		//prepare the table
		echo '<table border="1">
			  <tr>
				<th>Category</th>
				<th>Last topic</th>
			  </tr>';	
			
		while($row = mysqli_fetch_assoc($result))
		{				
			echo '<tr>';
				echo '<td class="leftpart">';
					echo '<h3><a href="index.php?content=forum&subnav=category&id=' . $row['b_id'] . '">' . $row['b_name'] . '</a></h3>' . $row['b_inhalt'];
				echo '</td>';
				echo '<td class="rightpart">';
				
				//fetch last topic for each cat
					$topicsql = "SELECT
									t_id,
									t_subject,
									t_date,
									t_bereich
								FROM
									thema
								WHERE
									t_bereich = " . $row['b_id'] . "
								ORDER BY
									t_date
								DESC
								LIMIT
									1";
								
					$topicsresult = mysqli_query($con, $topicsql);
				
					if(!$topicsresult)
					{
						echo 'Last topic could not be displayed.';
					}
					else
					{
						if(mysqli_num_rows($topicsresult) == 0)
						{
							echo 'no topics';
						}
						else
						{
							while($topicrow = mysqli_fetch_assoc($topicsresult))
							echo '<a href="index.php?content=forum&subnav=topics&id=' . $topicrow['t_id'] . '">' . $topicrow['t_subject'] . '</a> at ' . date('d-m-Y', strtotime($topicrow['t_date']));
						}
					}
				echo '</td>';
			echo '</tr>';
		}
	}
}


?>
<?php

if (isset($_SESSION['user_id']))
{
	$y= $_SESSION['user_id'];
	if($y==52){
		echo '<div class="sidebar">
		<a href="home2.php"> Home</a>
		<a href="t_erst.php"> Create a topic</a>
		<a href="k_erst.php"> Create a category</a> </div>';
	}
	else
	{
		echo '<div class="sidebar">
		<a href="home2.php"> Home</a>
		<a href="t_erst.php"> Create a topic</a>
		 </div>';
	}
}
?>
