<?php
define ('constants', TRUE);
include 'tsq_constants.php';
?>


<html>
<head>
<title>The Saturday Quiz Sim</title>
<link rel='stylesheet' href='style.css' id='styler'>

</head>
<body>
<div class="container">
<div id="nocustom">
<header id="myHeader"></header>
<nav id="navBar">



</nav>
<article>
<br>
<br>

<b>DISCLAIMERS: </b>
<ul>
<li>The contestant names you see were either made up or randomly generated by <a href="http://www.fakenamegenerator.com/" target="new">Fake Name Generator</a>.  Any relation to any persons, living or dead, are entirely coincidental, especially with Show #1; that was just a lucky roll of the virtual dice!</li>
<li><b><u>NO REAL MONEY NOR PRIZES ARE AWARDED.</u></b>  This is just a simulation.</li>
<li>There is no trademark for The Saturday Quiz.  If anyone legally owns the name The Saturday Quiz, please <a href="mailto:tsd@thesweepingdeveloper.com">e-mail me</a> to request removal.</li>
</ul>

<?php



for ($a = 0; $a <= 2; $a++)
{
	$contestant_occupation_vowel[$a] = 0;
	for ($b = 0; $b <= 9; $b++)
	{
		if (substr($contestant_occupation[$a],0,1) == $vowel[$b])
		{
			$contestant_occupation_vowel[$a] = 1;
		}
	}
}



?>
<h2><p align="center">
<?php

	
	$query = "SELECT * FROM `TSQ100 Games` WHERE id = ".$_GET["game_id"];

	$result = mysqli_query($db, $query) or die ('Error querying game data.');
	$row = mysqli_fetch_array($result);
	
	
	$season = $row['season'] - 1;
	
	if ($season > 1)
	{
		$season = 1;
	}

	$mode = $row['mode'];
	
	if ($mode == 1)
	{
		$rebound_pot = 40000;
	}
	if ($mode == 2)
	{
		$rebound_pot = 100000;
	}
	

	echo '<h1>'.$row['air_date'].'</h1>';
	
	
	$contestant_level[0] = $row['c1_level'];
	$contestant_level[1] = $row['c2_level'];
	$contestant_level[2] = $row['c3_level'];
	
	$contestant_championships[0] = $row['c1_championships'];
	$contestant_championships[1] = $row['c2_championships'];
	$contestant_championships[2] = $row['c3_championships'];
	
	$contestant_prior_winnings[0] = $row['c1_prior_winnings'];
	$contestant_prior_winnings[1] = $row['c2_prior_winnings'];
	$contestant_prior_winnings[2] = $row['c3_prior_winnings'];
	
	$contestant_game_skill_level[0] = $row['c1_game_skill_level'];
	$contestant_game_skill_level[1] = $row['c2_game_skill_level'];
	$contestant_game_skill_level[2] = $row['c3_game_skill_level'];
	
	
	
	$p1_query = "SELECT * FROM `TSQ100 Contestants` WHERE id = ".$row['c1_id'];
	$p1_result = mysqli_query($db, $p1_query) or die ('Error querying contestant 1 data.');
	$p1_row = mysqli_fetch_array($p1_result);
	
	$p2_query = "SELECT * FROM `TSQ100 Contestants` WHERE id = ".$row['c2_id'];
	$p2_result = mysqli_query($db, $p2_query) or die ('Error querying contestant 2 data.');
	$p2_row = mysqli_fetch_array($p2_result);
	
	$p3_query = "SELECT * FROM `TSQ100 Contestants` WHERE id = ".$row['c3_id'];
	$p3_result = mysqli_query($db, $p3_query) or die ('Error querying contestant 3 data.');
	$p3_row = mysqli_fetch_array($p3_result);
	
	$data_stream = $row['data_stream'];
	$data_stream_timestamp = $row['timestamp'];
	
	$contestant_id[0] = $p1_row['id'];
	$contestant_fname[0] = $p1_row['fname'];
	$contestant_lname[0] = $p1_row['lname'];
	$contestant_occupation[0] = $p1_row['occupation'];
	$contestant_city[0] = $p1_row['city'];
	$contestant_state[0] = $p1_row['state'];
	$contestant_initial_skill_level[0] = $p1_row['init_skill_level'];
	
	$contestant_id[1] = $p2_row['id'];
	$contestant_fname[1] = $p2_row['fname'];
	$contestant_lname[1] = $p2_row['lname'];
	$contestant_occupation[1] = $p2_row['occupation'];
	$contestant_city[1] = $p2_row['city'];
	$contestant_state[1] = $p2_row['state'];
	$contestant_initial_skill_level[1] = $p2_row['init_skill_level'];

	
	$contestant_id[2] = $p3_row['id'];
	$contestant_fname[2] = $p3_row['fname'];
	$contestant_lname[2] = $p3_row['lname'];
	$contestant_occupation[2] = $p3_row['occupation'];
	$contestant_city[2] = $p3_row['city'];
	$contestant_state[2] = $p3_row['state'];
	$contestant_initial_skill_level[2] = $p3_row['init_skill_level'];

	

?>
</p></h2>

<?php
if (substr($row['comments'],0,1) == "*")
{
	$description = str_replace("*", "", $row['comments']);
}
else
{
	$description = $row['comments'];
}

echo "<p align='center'>".$description."</p>";


?>

<p align="left">
<?php 
#$championships = [0,0,0];



	for ($a = 0; $a <= 2; $a++)
	{
		if ($season == 0 and $contestant_championships[$a] == 7)
		{
			$contestant_championships[$a] = 6;
		}
		else if ($season > 0 and $contestant_championships[$a] == 5)
		{
			$contestant_championships[$a] = 4;
		}
		
		if ($mode == 0)
		{
			if ($contestant_championships[$a] % 10 == 0)
			{
				echo "Player ".($a+1).": ".$contestant_fname[$a] . " " . $contestant_lname[$a].", from ". $contestant_city[$a] . ", " . $contestant_state[$a] ."</br>";
			}
			else
			{
				echo "Player ".($a+1).": <b>".$contestant_fname[$a] . " " . $contestant_lname[$a].
					 ", from ". $contestant_city[$a] . ", " . $contestant_state[$a] .
					 ", ". $contestant_championships[$a] % 10 . " win(s)".
					 ", Level ".$contestant_level[$a].", $". number_format($contestant_prior_winnings[$a]) ."</b></br>";
								 
			}
		}
		if ($mode > 0)
		{
				echo "Player ".($a+1).": <b>".$contestant_fname[$a] . " " . $contestant_lname[$a].
					 ", from ". $contestant_city[$a] . ", " . $contestant_state[$a] .
					 ", prior winnings of $". number_format($contestant_prior_winnings[$a]) ."</b></br>";

		}
		
	}
	
?>
</p>

<?php
	for ($a = 0; $a <= 2; $a++)
	{
		$round = 1;
		$victory = 0;
		$fail = 0;
		echo '<h2>' . $contestant_fname[$a] . ' ' . $contestant_lname[$a] . '</h2>';
		
		if ($contestant_initial_skill_level[$a] == 0) 
			{
				$contestant_initial_skill_level[$a] = getNextNumber();
				$game_query = "UPDATE `sdevelop_youtube`.`TSQ100 Contestants` SET `init_skill_level` = '".$contestant_initial_skill_level[$a]."' WHERE `TSQ100 Contestants`.`id` = '".$contestant_id[$a]."'";
				$game_result = mysqli_query($db, $game_query) or die ('Error querying initial skill level of Contestant '.$a.'.');
				//$game_row = mysqli_fetch_array($game_result);
			}
		
		if ($contestant_game_skill_level[$a] == 0) 
			{
				$contestant_game_skill_level[$a] = getNextNumber();
			}

			   //if ($a == 0)  {$game_query = "UPDATE `TSQ Games` SET `c1_game_skill_level` = '".$contestant_game_skill_level[0]."' WHERE `id` = '".$_GET["game_id"]."'";}
			   //if ($a == 1)  {$game_query = "UPDATE `TSQ Games` SET `c2_game_skill_level` = '".$contestant_game_skill_level[1]."' WHERE `id` = '".$_GET["game_id"]."'";}
			   //if ($a == 2)  {$game_query = "UPDATE `TSQ Games` SET `c3_game_skill_level` = '".$contestant_game_skill_level[2]."' WHERE `id` = '".$_GET["game_id"]."'";}
				//$game_result = mysqli_query($db, $game_query) or die ('Error querying game skill level of Contestant '.$a.'.');
				//$game_row = mysqli_fetch_array($game_result);		//Error here.
		
		$total_skill_level = $contestant_initial_skill_level[$a] + $contestant_game_skill_level[$a];
		
		
		echo '<b>Initial Skill Level: ' . $contestant_initial_skill_level[$a].'</b><br>';
		echo '<b>Game Skill Level: '.$contestant_game_skill_level[$a].', for a total of '.$total_skill_level . '<br><br>';
	
		echo '<table border="1">';
		do		//Beginning of Round.
		{
			
			echo '<tr>';
			if ($contestant_level[$a] == 1)
			{
				echo '<td style="color:white; text-shadow: 2px 2px 3px black">$'.number_format($round_values[$season][$round - 1]).'</td>';
			}
			if ($contestant_level[$a] == 2)
			{
				echo '<td style="color:white; text-shadow: 2px 2px 3px black">$'.number_format($round_values[$season][$round - 1] * 2).'</td>';
			}
			if ($contestant_level[$a] == 3 && $season == 0)
			{
				echo '<td style="color:white; text-shadow: 2px 2px 3px black">$'.number_format($round_values[$season][$round - 1] * 4).'</td>';
			}
			if ($contestant_level[$a] == 3 && $season > 0 && $round < 7)
			{
				echo '<td style="color:linear-gradient(gold, yellow); text-shadow: 2px 2px 3px black">$'.number_format($round_values[$season][$round - 1] * 5).'</td>';
			}
			if ($contestant_level[$a] == 3 && $season > 0 && $round == 7)
			{
				if ($mode == 0)
				{
					echo '<td style="background: linear-gradient(gold, yellow); color:Black; text-shadow: 2px 2px 3px white"><b>$1 MILLION</b></td>';
				}
				if ($mode == 2)
				{
					echo '<td style="color:white; text-shadow: 2px 2px 3px black">$500,000</td>';
				}
				
			}				
			
			if ($contestant_level[$a] == 4 && $round < 7) 
			{
				echo '<td style="color:gold; text-shadow: 2px 2px 3px black">$'.number_format($round_values[$season][$round - 1] * 10).'</td>';
			}
			if ($contestant_level[$a] == 4 && $round == 7)
			{
				echo '<td style="background: linear-gradient(gold, yellow); color: Black; text-shadow: 2px 2px 3px white"><b>$1 MILLION</b></td>';
			}

			
			$questions_left = 7 + $contestant_wildcards[$a];
			$questions_get = 0;
			$questions_used = 0;
 
			//Question Routine.
			do
			{
				echo '<td';
				$data_stream_value = getNextNumber();
				if ($data_stream_value >= $skill_correct_first_roll[$total_skill_level])
				{
					echo ' style="background: linear-gradient(green, lime); color:black"><b>O</b>';
					$questions_get++;
					//echo "<br><u>Correct! Questions Get: ".strval($questions_get)."</u><br>";
				}
				else
				{
					if ($skill_correct_second_roll_needed[$total_skill_level] == 1)
					{
						$data_stream_value = getNextNumber();
						if ($data_stream_value >= $skill_correct_second_roll[$total_skill_level])
						{
							echo ' style="background: linear-gradient(green, lime); color:black"><b>O</b>';
							$questions_get++;
							//echo "<br><i>Correct! Questions Get: ".strval($questions_get)."</i><br>";
						}
						else
						{
							echo ' style="background: linear-gradient(maroon, red); color:black"><b>X</b>';
						}
					}
					else
					{
						echo ' style="background: linear-gradient(maroon, red); color:black"><b>X</b>';
					}
				}
				echo '</td>';
				$questions_left--;
				$questions_used++;
				
			}
			while ($questions_get < $questions_needed[$round-1] && $questions_get + $questions_left >= $questions_needed[$round-1] && $questions_left > 0);
			echo '</tr>';
			
			if ($questions_used > 7) {$contestant_wildcards[$a] += 7-$questions_used;}
			
			//Check for failure.
			if ($questions_get + $questions_left < $questions_needed[$round-1])
			{
				//echo ("<br>Questions Get: ".$questions_get."<br>");
				//echo ("<br>Questions Left: ".$questions_left."<br>");
				//echo ("<br>Questions Needed: ".$questions_needed[$round - 1]."<br>");
				$fail = 1;
			}
			
			//Check for a victory (Clearing all seven rounds in a level).
			if ($fail == 0 && $round == 7)
			{
				$victory = 1;
			}				
			
			//Check for a continue condition if the player didn't fail nor cleared the board.
			if ($fail == 0 && $victory == 0 && $questions_left <= 3)
			{                
				$roll_index = (($round-1)*4 + (3-$questions_left))+ $skill_table_round_adj[$contestant_level[$a] - 1] + $skill_table_skill_adj[$total_skill_level];
				//echo $round.', '.$questions_left.', '.$skill_table_round_adj[$contestant_level[$a] - 1].', '.$skill_table_skill_adj[$total_skill_level].'<br>';
				$data_stream_value = getNextNumber();
				//echo 'Questions left: '.$questions_left.', Round: '.$round.', Roll Index: '.$roll_index.', Roll #'.$data_stream_counter.': '.$data_stream_value.' vs. '.$skill_table_first_roll[$roll_index].'<br>'; 
				if ($data_stream_value >= $skill_table_first_roll[$roll_index])
				{
					$continue = 1;
				}
				else
				{
					if ($skill_table_second_roll_needed[($round-1)*4 + (3-$questions_left)] == 1)
					{
						
						$data_stream_value = getNextNumber();
						//echo 'Roll #'.$data_stream_counter.' is a second chance, and it is: '.$data_stream_value.'<br>';
						//echo 'OK, what is the skill table second roll dude?<br>';
						//echo 'Computer: It is '.$skill_table_second_roll[$roll_index].'<br>';
						if ($data_stream_value >= $skill_table_second_roll[$roll_index])
						{
							$continue = 1;
						}
						else
						{
							$continue = 0;
						}
					}
					else
					{
						$continue = 0;
					}
					
				}
			}
			else
			{
				$continue = 1;
			}
			
			
			
			
			$round++;
		}
		while ($continue == 1 && $victory == 0 && $fail == 0);
		
		
		

	echo '</table><br>';
	//echo 'Contestant wildcards left: '.$contestant_wildcards[$a].'<br>';
		
	

		if ($continue == 0 && $fail == 0 && $victory == 0)
		{
			echo '<div id="dropout">';
			if ($season == 0)
			{
				$contestant_round_reached[$a] = $round - 2;
				
				if ($round_to_beat < $contestant_round_reached[$a])  {$round_to_beat = $contestant_round_reached[$a];}
					
				if ($contestant_level[$a] == 1) {$contestant_winnings[$a] += $round_values[$season][$round - 2]; echo $contestant_fname[$a]. ' stops on $'. number_format($round_values[$season][$round - 2]).'.';}
				if ($contestant_level[$a] == 2) {$contestant_winnings[$a] += $round_values[$season][$round - 2] * 2; echo $contestant_fname[$a]. ' stops on $'. number_format($round_values[$season][$round - 2] * 2).'.';}
				if ($contestant_level[$a] == 3) {$contestant_winnings[$a] += $round_values[$season][$round - 2] * 4; echo $contestant_fname[$a]. ' stops on $'. number_format($round_values[$season][$round - 2] * 4).'.';}
				if ($contestant_level[$a] == 4) {$contestant_winnings[$a] += $round_values[$season][$round - 2] * 10; echo $contestant_fname[$a]. ' stops on $'. number_format($round_values[$season][$round - 2] * 10).'.';}

			}
			else if ($season > 0)
			{
				$contestant_round_reached[$a] = $round - 2;
				
				if ($round_to_beat < $contestant_round_reached[$a])  {$round_to_beat = $contestant_round_reached[$a];}
					
				if ($contestant_level[$a] == 1) {$contestant_winnings[$a] += $round_values[$season][$round - 2]; echo $contestant_fname[$a]. ' stops on $'. number_format($round_values[$season][$round - 2]).'.';}
				if ($contestant_level[$a] == 2) {$contestant_winnings[$a] += $round_values[$season][$round - 2] * 2; echo $contestant_fname[$a]. ' stops on $'. number_format($round_values[$season][$round - 2] * 2).'.';}
				if ($contestant_level[$a] == 3) {$contestant_winnings[$a] += $round_values[$season][$round - 2] * 5; echo $contestant_fname[$a]. ' stops on $'. number_format($round_values[$season][$round - 2] * 5).'.';}

			}
			echo '</div><br>';
		}
		
	
		if ($victory == 1)
		{
			echo '<div id="seikai">';
			if ($season == 0)
			{
				if ($contestant_level[$a] == 1) {$contestant_winnings[$a] += 50000;  echo $contestant_fname[$a]. ' clears Level 1 and wins $50,000!';}
				if ($contestant_level[$a] == 2) {$contestant_winnings[$a] += 100000; echo $contestant_fname[$a]. ' clears Level 2 and wins $100,000!';}
				if ($contestant_level[$a] == 3) {$contestant_winnings[$a] += 200000; echo $contestant_fname[$a]. ' clears Level 3 and wins $200,000!';}
				if ($contestant_level[$a] == 4) 
					{$contestant_winnings[$a] += 1000000;  echo '<u><i>'.$contestant_fname[$a]. ' CLEARS LEVEL 4 AND WINS $1 MILLION!</i></u>';}
				$contestant_level[$a]++;
				$contestant_round_reached[$a] = $round - 2;
				if ($round_to_beat < $contestant_round_reached[$a])  {$round_to_beat = $contestant_round_reached[$a];}				
			}
			else if ($season > 0)
			{
				if ($contestant_level[$a] == 1) {$contestant_winnings[$a] += 100000;  echo $contestant_fname[$a]. ' clears Level 1 and wins $100,000!</b></h2><br>';}
				if ($contestant_level[$a] == 2) 
					{
						if ($mode == 0)
						{
							$contestant_winnings[$a] += 200000; echo $contestant_fname[$a]. ' clears Level 2 and wins $200,000!</b></h2><br>';
						}
						if ($mode > 0)
						{
							$contestant_winnings[$a] += 200000; echo $contestant_fname[$a]. ' clears the board and wins $200,000!</b></h2><br>';
						}

					}
				if ($contestant_level[$a] == 3) 
					{
						if ($mode == 0)
						{
							$contestant_winnings[$a] += 1000000;  echo '<u><i>'.$contestant_fname[$a]. ' JUST WON A MILLION DOLLARS!</i></u>';
						}
						if ($mode > 0)
						{
							$contestant_winnings[$a] += 500000;  echo $contestant_fname[$a]. ' clears the board and wins $500,000!';
						}
						
						
						
					}
				$contestant_level[$a]++;
				$contestant_round_reached[$a] = $round - 2;
				if ($round_to_beat < $contestant_round_reached[$a])  {$round_to_beat = $contestant_round_reached[$a];}				
			}
			echo '</div></b><br>';
		}
		
		
		if ($fail == 1 && $round > 1)
		{
			echo '<div id="zannen">';
			if ($season == 0)
			{
				if ($contestant_level[$a] == 1) { $rebound_pot += $round_values[$season][$round - 3]; echo '$'.number_format($round_values[$season][$round - 3]). ' put in pot.';}
				if ($contestant_level[$a] == 2) { $rebound_pot += $round_values[$season][$round - 3] * 2; echo '$'.number_format($round_values[$season][$round - 3] * 2). ' put in pot.';}
				if ($contestant_level[$a] == 3) { $rebound_pot += $round_values[$season][$round - 3] * 4; echo '$'.number_format($round_values[$season][$round - 3] * 4). ' put in pot.';}
				if ($contestant_level[$a] == 4) { $rebound_pot += $round_values[$season][$round - 3] * 10; echo 'ZANNEN!!!  $'.number_format($round_values[$season][$round - 3] * 10). ' put in pot.';}
			}
			else if ($season > 0)
			{
				if ($contestant_level[$a] == 1) { $rebound_pot += $round_values[$season][$round - 3]; echo '$'.number_format($round_values[$season][$round - 3]). ' put in pot.';}
				if ($contestant_level[$a] == 2) { $rebound_pot += $round_values[$season][$round - 3] * 2; echo '$'.number_format($round_values[$season][$round - 3] * 2). ' put in pot.';}
				if ($contestant_level[$a] == 3) { $rebound_pot += $round_values[$season][$round - 3] * 5; echo 'ZANNEN!!!  $'.number_format($round_values[$season][$round - 3] * 5). ' put in pot.';}
			}
			echo '</div><br>';
		}
		if ($fail == 1)
		{
			$contestant_round_reached[$a] = 0;
		}
				//echo 'Round reached: '.($contestant_round_reached[$a]+1).'<br>';
		//$data_stream_counter--;
	}	//End of Regular part of show.
?>



<?php
	
	if ($rebound_pot > 0)
	{
		if ($mode == 1)
		{
			echo '<br><br><b>For the tournament semifinals, we add $40,000 to the Rebound Pot.  At the end of the Rebound Game, the player with the most money moves on to the Finals.</b>';
		}
		if ($mode == 2)
		{
			echo '<br><br><b>For the tournament finals, we add $100,000 to the Rebound Pot.</b>';
		}
		
		

		//Rebound game.
		echo '<br><br><b>Rebound Pot: $'.number_format($rebound_pot).'</b><br><br>';
		echo '<table border="1"><tr><td><b>Player</b></td><td><b>Score</b></td></tr>';
		for ($a = 0; $a <= 2; $a++)
		{	
			$rebound_score[$a] = 0;
			
			echo '<tr><td>'.$contestant_fname[$a].'</td><td>'.$rebound_score[$a].'</td></tr>';
		}
		echo '</table><br><br>';

		//I stopped here.  1/13/2018   10:09 PM
		do
		{
			//echo 'Rebound question...'.$data_stream_counter;
			for ($a = 0; $a <= 2; $a++){$rebound_active[$a] = 1;}
			
			$rebound_gofor = getNextNumber();
			if ($rebound_gofor > 1)
			{
				$rebound_first_pick = getNextNumber();
				$rebound_first_pick = ($rebound_first_pick - 1) % 3; 
				echo '<b>'.$contestant_fname[$rebound_first_pick].': </b>';
				
				$total_skill_level = $contestant_initial_skill_level[$rebound_first_pick] + $contestant_game_skill_level[$rebound_first_pick];

				
				//Determines whether or not your answer is correct.
				$data_stream_value = getNextNumber();
				if ($data_stream_value >= $skill_correct_first_roll[$total_skill_level])
				{
					//Correct
					$rebound_score[$rebound_first_pick]++;
					$rebound_right = 1;
					
					echo 'RIGHT<br><br>';
					displayReboundTable();
			
				}
				else
				{
					if ($skill_correct_second_roll_needed[$total_skill_level] == 1)
					{
						$data_stream_value = getNextNumber();
						if ($data_stream_value >= $skill_correct_second_roll[$total_skill_level])
						{
							//Correct
							$rebound_score[$rebound_first_pick]++;
							$rebound_right = 1;
							
							echo 'RIGHT<br><br>';
							displayReboundTable();
						}
						else
						{
							
							//Wrong
							$rebound_right = -1;
							$rebound_active[$rebound_first_pick] = 0;
							
							echo 'WRONG<br>';
							
						}
					}
					else
					{
						//Wrong
						$rebound_right = -1;
						$rebound_active[$rebound_first_pick] = 0;
						
						echo 'WRONG<br>';
					}
				}
				
				//If the first player is wrong, try another player.
				if ($rebound_right < 0)
				{
					if ($rebound_active[0] == 0) { $rebound_second_available[0] = 1; $rebound_second_available[1] = 2;}
					if ($rebound_active[1] == 0) { $rebound_second_available[0] = 0; $rebound_second_available[1] = 2;}
					if ($rebound_active[2] == 0) { $rebound_second_available[0] = 0; $rebound_second_available[1] = 1;}
					$rebound_gofor = getNextNumber();
					
					//If no one's chicken...
					if ($rebound_gofor > 1)
					{
						$rebound_second_pick = getNextNumber();
						$rebound_second_pick = $rebound_second_available[$rebound_second_pick % 2];
						$total_skill_level = $contestant_initial_skill_level[$rebound_second_pick] + $contestant_game_skill_level[$rebound_second_pick];
						echo '<b>'.$contestant_fname[$rebound_second_pick].': </b>';
						
						//Is that person right?
						$data_stream_value = getNextNumber();
						if ($data_stream_value >= $skill_correct_first_roll[$total_skill_level])
						{
							//Correct
							$rebound_score[$rebound_second_pick]++;
							$rebound_right = 1;
							
							echo 'RIGHT<br><br>';
							displayReboundTable();
						}
						else
						{
							if ($skill_correct_second_roll_needed[$total_skill_level] == 1)
							{
								$data_stream_value = getNextNumber();
								if ($data_stream_value >= $skill_correct_second_roll[$total_skill_level])
								{
									//Correct
									$rebound_score[$rebound_second_pick]++;
									$rebound_right = 1;
									
									echo 'RIGHT<br><br>';
									displayReboundTable();
								}
								else
								{
									
									//Wrong
									$rebound_right = -1;
									$rebound_active[$rebound_second_pick] = 0;
									
									echo 'WRONG<br>';
								}
							}
							else
							{
								//Wrong
								$rebound_right = -1;
								$rebound_active[$rebound_second_pick] = 0;
								
								echo 'WRONG<br>';
							}
						}	
								
						//If the second player is also wrong...
						if ($rebound_right < 0)
						{
							for ($a = 0; $a <= 2; $a++)  { if ($rebound_active[$a] == 1)  { $rebound_third_pick = $a; } }
							$total_skill_level = $contestant_initial_skill_level[$rebound_third_pick] + $contestant_game_skill_level[$rebound_third_pick];
							
							//echo ("Second player is also wrong in regular play.");
							$rebound_gofor = getNextNumber();
							
							//Stopped here: 6:47PM  1/14/2018
							
							if ($rebound_gofor > 1)
							{
								echo '<b>'.$contestant_fname[$rebound_third_pick].': </b>';
								//Is that person right?
								$data_stream_value = getNextNumber();
								if ($data_stream_value >= $skill_correct_first_roll[$total_skill_level])
								{
									//Correct
									$rebound_score[$rebound_third_pick]++;
									$rebound_right = 1;
									
									echo 'RIGHT<br><br>';
									displayReboundTable();
								}
								else
								{
									if ($skill_correct_second_roll_needed[$total_skill_level] == 1)
									{
										$data_stream_value = getNextNumber();
										if ($data_stream_value >= $skill_correct_second_roll[$total_skill_level])
										{
											//Correct
											$rebound_score[$rebound_third_pick]++;
											$rebound_right = 1;
											
											echo 'RIGHT<br><br>';
											displayReboundTable();
										}
										else
										{
											
											//Wrong
											$rebound_right = -1;
											$rebound_active[$rebound_third_pick] = 0;
											
											echo 'WRONG<br><br>';
										}
									}
									else
									{
										//Wrong
										$rebound_right = -1;
										$rebound_active[$rebound_third_pick] = 0;
										
										echo 'WRONG<br><br>';
									}
								}	

							}
							
							
							
							
							
						}
						
					}
					
					
				}
				
			}
		
			echo '<br>';	
		}
		while ($rebound_score[0] < 5 && $rebound_score[1] < 5 && $rebound_score[2] < 5);
			
		for ($a = 0; $a <= 2; $a++)
		{
			if ($rebound_score[$a] >= 5) 
			{
				echo '<h2>'.$contestant_fname[$a].' wins the rebound pot of $'.number_format($rebound_pot).'!</h2><br><br>';
				$contestant_winnings[$a] += $rebound_pot;
				
				//Just in case everyone loses, the Rebound game determines the returning champion.
				if ($contestant_round_reached[0] == 0 && $contestant_round_reached[1] == 0 && $contestant_round_reached[2] == 0) {$contestant_round_reached[$a]++;  $round_to_beat = $contestant_round_reached[$a];}
			}

		}

		
	}
	
	//Add all the winnings to the prior winnings.
	for ($a = 0; $a <= 2; $a++)
	{
		$contestant_winnings[$a] += $contestant_prior_winnings[$a];
		
		
	}
	
	
	
	//Final Scores for Regular Play.
	if ($mode == 0)
	{
		for ($a = 0; $a <= 2; $a++)
		{
			if ($contestant_round_reached[$a] >= $round_to_beat) 
			{
				if ($season == 0)
				{
					if ($contestant_championships[$a] % 10 < 6 && $contestant_level[$a] < 5)
					{
						echo '<h3>'.$contestant_fname[$a].' '.$contestant_lname[$a].' is coming back to play Level '.$contestant_level[$a].' with $'.number_format($contestant_winnings[$a]).'.</h3>';
					}
					else if ($contestant_championships[$a] % 10 > 5 && $contestant_level[$a] < 5)
					{
						$contestant_winnings[$a] += 1000000;
						echo '<h3>'.$contestant_fname[$a].' '.$contestant_lname[$a].' LEAVES AS A 7-TIME UNDEFEATED CHAMPION WITH $'.number_format($contestant_winnings[$a]).'!</h3>';
					}
					else if ($contestant_championships[$a] % 10 < 6 && $contestant_level[$a] > 4)
					{
						echo '<h3>'.$contestant_fname[$a].' '.$contestant_lname[$a].' is going home quite wealthy with $'.number_format($contestant_winnings[$a]).'.</h3>';
					}
					else if ($contestant_championships[$a] % 10 > 5 && $contestant_level[$a] > 4)
					{
						$contestant_winnings[$a] += 1000000;
						echo '<h3>Amazing.  '.$contestant_fname[$a].' '.$contestant_lname[$a].' has won both million dollar bonuses and is going home quite wealthy with $'.number_format($contestant_winnings[$a]).'.</h3>';
					}
				}
				else if ($season > 0)
				{
					if ($contestant_championships[$a] % 10 < 4 && $contestant_level[$a] < 4)
					{
						echo '<h3>'.$contestant_fname[$a].' '.$contestant_lname[$a].' is coming back to play Level '.$contestant_level[$a].' with $'.number_format($contestant_winnings[$a]).'.</h3>';
					}
					else if ($contestant_championships[$a] % 10 > 3 && $contestant_level[$a] < 4)
					{
						$contestant_winnings[$a] += 1000000;
						echo '<h3>'.$contestant_fname[$a].' '.$contestant_lname[$a].' LEAVES AS A 5-TIME UNDEFEATED CHAMPION WITH $'.number_format($contestant_winnings[$a]).'!</h3>';
					}
					else if ($contestant_championships[$a] % 10 < 4 && $contestant_level[$a] > 3)
					{
						echo '<h3>'.$contestant_fname[$a].' '.$contestant_lname[$a].' is going home quite wealthy with $'.number_format($contestant_winnings[$a]).'.</h3>';
					}
					else if ($contestant_championships[$a] % 10 > 3 && $contestant_level[$a] > 3)
					{
						$contestant_winnings[$a] += 1000000;
						echo '<h3>Amazing.  '.$contestant_fname[$a].' '.$contestant_lname[$a].' has won both million dollar bonuses and is going home quite wealthy with $'.number_format($contestant_winnings[$a]).'.</h3>';
					}
					
				}
				else
				{
					echo '<h3>Head-On.  Apply directly to the forehead.</h3>';
				}
				
			}
			else
			{
				echo '<h3>'.$contestant_fname[$a].' '.$contestant_lname[$a].' leaves with $'.number_format($contestant_winnings[$a]).'.</h3>';
			}
			
			
				   //if ($a == 0)  {$game_query = "UPDATE `TSQ100 Games` SET `c1_winnings` = ".$contestant_winnings[0]." WHERE `id` = '".$_GET["game_id"]."'";}
				   //if ($a == 1)  {$game_query = "UPDATE `TSQ100 Games` SET `c2_winnings` = ".$contestant_winnings[1]." WHERE `id` = '".$_GET["game_id"]."'";}
				   //if ($a == 2)  {$game_query = "UPDATE `TSQ100 Games` SET `c3_winnings` = ".$contestant_winnings[2]." WHERE `id` = '".$_GET["game_id"]."'";}
					//$game_result = mysqli_query($db, $game_query) or die ('Error querying day winnings of Contestant '.$a.'.');
					//$game_row = mysqli_fetch_array($game_result);

		}

	}
	
	//Final Scores for Tournament Semifinals.
	if ($mode == 1)
	{
		for ($a = 0; $a <= 2; $a++)
		{
			$contestant_winnings[$a] -= $contestant_prior_winnings[$a];
		}
		
		
		$leader = array(0,0,0);
		$tie_flag = 0;
		
		$leader[0] = 1;
		$curldr = 0;
		if ($contestant_winnings[1] > $contestant_winnings[0]) {$leader[1] = 1; $leader[0] = 0; $curldr = 1;}
		if ($contestant_winnings[1] == $contestant_winnings[0]) {$leader[1] = 1; $tie_flag = 1;}		
		if ($contestant_winnings[2] > $contestant_winnings[$curldr]) {$leader[2] = 1; $leader[1] = 0; $leader[0] = 0; $curldr = 2; $tie_flag = 0;}
		if ($contestant_winnings[2] == $contestant_winnings[$curldr] && $curldr != 2) {$leader[2] = 1; $tie_flag = 1;}
	
		
		
		//Tiebreaker.
		if ($tie_flag == 1)
		{
			echo '<h3>We have a tie!  Here are the results:</h3>';
			echo '<h3>'.$contestant_fname[0].': $'.number_format($contestant_winnings[0]).'</h3>';
			echo '<h3>'.$contestant_fname[1].': $'.number_format($contestant_winnings[1]).'</h3>';
			echo '<h3>'.$contestant_fname[2].': $'.number_format($contestant_winnings[2]).'</h3>';
			
			
			echo '<p>It\'s time to play another Rebound game between just the leaders to one point.  Remember, "you can\'t win by default, you must give a correct response."</p>';
			
			$rebound_score[0] = 0;
			$rebound_score[1] = 0;
			$rebound_score[2] = 0;
			do
			{
				//echo 'Rebound question...'.$data_stream_counter;
				for ($a = 0; $a <= 2; $a++){$rebound_active[$a] = 1;}
				
				$rebound_gofor = getNextNumber();
				if ($rebound_gofor > 1)
				{
					do
					{
						$rebound_first_pick = getNextNumber();
						$rebound_first_pick = ($rebound_first_pick - 1) % 3; 
					}
					while ($leader[$rebound_first_pick] == 0);	//Tiebreaker only applies to the leaders.
						
					echo '<b>'.$contestant_fname[$rebound_first_pick].': </b>';
					
					$total_skill_level = $contestant_initial_skill_level[$rebound_first_pick] + $contestant_game_skill_level[$rebound_first_pick];

					
					//Determines whether or not your answer is correct.
					$data_stream_value = getNextNumber();
					if ($data_stream_value >= $skill_correct_first_roll[$total_skill_level])
					{
						//Correct
						$rebound_score[$rebound_first_pick]++;
						$rebound_right = 1;
						
						echo 'RIGHT<br><br>';
						displayReboundTable();
				
					}
					else
					{
						if ($skill_correct_second_roll_needed[$total_skill_level] == 1)
						{
							$data_stream_value = getNextNumber();
							if ($data_stream_value >= $skill_correct_second_roll[$total_skill_level])
							{
								//Correct
								$rebound_score[$rebound_first_pick]++;
								$rebound_right = 1;
								
								echo 'RIGHT<br><br>';
								displayReboundTable();
							}
							else
							{
								
								//Wrong
								$rebound_right = -1;
								$rebound_active[$rebound_first_pick] = 0;
								
								echo 'WRONG<br>';
								
							}
						}
						else
						{
							//Wrong
							$rebound_right = -1;
							$rebound_active[$rebound_first_pick] = 0;
							
							echo 'WRONG<br>';
						}
					}
					
					//If the first player is wrong, try another player.
					if ($rebound_right < 0)
					{
						if ($rebound_active[0] == 0) { $rebound_second_available[0] = 1; $rebound_second_available[1] = 2;}
						if ($rebound_active[1] == 0) { $rebound_second_available[0] = 0; $rebound_second_available[1] = 2;}
						if ($rebound_active[2] == 0) { $rebound_second_available[0] = 0; $rebound_second_available[1] = 1;}
						$rebound_gofor = getNextNumber();
						
						//If no one's chicken...
						if ($rebound_gofor > 1)
						{
							do
							{
								$rebound_second_pick = getNextNumber();
								$rebound_second_pick = $rebound_second_available[$rebound_second_pick % 2];
							}
							while ($leader[$rebound_second_pick] == 0);
								
							$total_skill_level = $contestant_initial_skill_level[$rebound_second_pick] + $contestant_game_skill_level[$rebound_second_pick];
							echo '<b>'.$contestant_fname[$rebound_second_pick].': </b>';
							
							//Is that person right?
							$data_stream_value = getNextNumber();
							if ($data_stream_value >= $skill_correct_first_roll[$total_skill_level])
							{
								//Correct
								$rebound_score[$rebound_second_pick]++;
								$rebound_right = 1;
								
								echo 'RIGHT<br><br>';
								displayReboundTable();
							}
							else
							{
								if ($skill_correct_second_roll_needed[$total_skill_level] == 1)
								{
									$data_stream_value = getNextNumber();
									if ($data_stream_value >= $skill_correct_second_roll[$total_skill_level])
									{
										//Correct
										$rebound_score[$rebound_second_pick]++;
										$rebound_right = 1;
										
										echo 'RIGHT<br><br>';
										displayReboundTable();
									}
									else
									{
										
										//Wrong
										$rebound_right = -1;
										$rebound_active[$rebound_second_pick] = 0;
										
										echo 'WRONG<br>';
									}
								}
								else
								{
									//Wrong
									$rebound_right = -1;
									$rebound_active[$rebound_second_pick] = 0;
									
									echo 'WRONG<br>';
								}
							}	
									
							//If the second player is also wrong...
							if ($rebound_right < 0)
							{
								for ($a = 0; $a <= 2; $a++)  { if ($rebound_active[$a] == 1)  { $rebound_third_pick = $a; } }
								$total_skill_level = $contestant_initial_skill_level[$rebound_third_pick] + $contestant_game_skill_level[$rebound_third_pick];
								
								$rebound_gofor = getNextNumber();
								
								if ($leader[$rebound_third_pick] == 0) {$rebound_gofor = 1;}	//If the third player isn't the leader, skip to the next question.
								
								//Stopped here: 6:47PM  1/14/2018
								
								if ($rebond_gofor > 1)
								{
									echo '<b>'.$contestant_fname[$rebound_third_pick].': </b>';
									//Is that person right?
									$data_stream_value = getNextNumber();
									if ($data_stream_value >= $skill_correct_first_roll[$total_skill_level])
									{
										//Correct
										$rebound_score[$rebound_third_pick]++;
										$rebound_right = 1;
										
										echo 'RIGHT<br><br>';
										displayReboundTable();
									}
									else
									{
										if ($skill_correct_second_roll_needed[$total_skill_level] == 1)
										{
											$data_stream_value = getNextNumber();
											if ($data_stream_value >= $skill_correct_second_roll[$total_skill_level])
											{
												//Correct
												$rebound_score[$rebound_third_pick]++;
												$rebound_right = 1;
												
												echo 'RIGHT<br><br>';
												displayReboundTable();
											}
											else
											{
												
												//Wrong
												$rebound_right = -1;
												$rebound_active[$rebound_second_pick] = 0;
												
												echo 'WRONG<br><br>';
											}
										}
										else
										{
											//Wrong
											$rebound_right = -1;
											$rebound_active[$rebound_second_pick] = 0;
											
											echo 'WRONG<br><br>';
										}
									}	

								}
								
								
								
								
								
							}
							
						}
						
						
					}
					
				}
			
				echo '<br>';	
			}
			while ($rebound_score[0] < 1 && $rebound_score[1] < 1 && $rebound_score[2] < 1);
		
			for ($a = 0; $a <= 2; $a++)
			{
				if ($rebound_score[$a] == 1)
				{
					echo '<h3>'.$contestant_fname[$a].' '.$contestant_lname[$a].' advances to the Finals with $'.number_format($contestant_winnings[$a]).' today, for a total of $'.number_format($contestant_winnings[$a] + $contestant_prior_winnings[$a]).'!</h3>';
				}
				else
				{
					echo '<h3>'.$contestant_fname[$a].' '.$contestant_lname[$a].' leaves with $'.number_format($contestant_winnings[$a]).' today, for a total of $'.number_format($contestant_winnings[$a] + $contestant_prior_winnings[$a]).'!</h3>';
				}	
			}

		}
		
		if ($tie_flag == 0)
		{
			for ($a = 0; $a <= 2; $a++)
			{
				if ($leader[$a] == 1)
				{
					echo '<h3>'.$contestant_fname[$a].' '.$contestant_lname[$a].' advances to the Finals with $'.number_format($contestant_winnings[$a]).' today, for a total of $'.number_format($contestant_winnings[$a] + $contestant_prior_winnings[$a]).'!</h3>';
				}
				else
				{
					echo '<h3>'.$contestant_fname[$a].' '.$contestant_lname[$a].' leaves with $'.number_format($contestant_winnings[$a]).' today, for a total of $'.number_format($contestant_winnings[$a] + $contestant_prior_winnings[$a]).'!</h3>';
				}	
			}
		}
		
	}
	
	//Final Scores for Tournament Finals.
	if ($mode == 2)
	{
		for ($a = 0; $a <= 2; $a++)
		{
			$contestant_winnings[$a] -= $contestant_prior_winnings[$a];
		}
		
		for ($a = 0; $a <= 2; $a++)
		{
			echo '<h3>'.$contestant_fname[$a].' '.$contestant_lname[$a].' leaves with $'.number_format($contestant_winnings[$a]).' today, for a total of $'.number_format($contestant_winnings[$a] + $contestant_prior_winnings[$a]).'!</h3>';
		}
	}
	
	
	echo '<br><br><br>Timestamp: '.$data_stream_timestamp.'<br>Simulated Dice Rolls (courtesy of <a href="http://www.random.org" target="new">RANDOM.ORG</a>): '.$data_stream.'<br>';


?>
</article>
<footer id="myFooter"></footer>
<script src="elements.js"></script>
<!--</div>-->
</div>
</body>
</html>


<?php
	function getNextNumber()
	{
		global $data_stream,$data_stream_value, $data_stream_counter;
		$data_stream_counter++;
		//echo substr($data_stream,$data_stream_counter,1);
		//echo ("<br>Next number: ".substr($data_stream,$data_stream_counter,1)."<br>");

		return substr($data_stream,$data_stream_counter,1);
		
	}
?>

<?php
	function displayReboundTable()
	{
		global $contestant_fname, $rebound_score;
		
		echo '<table border="1"><tr><td><b>Player</b></td><td><b>Score</b></td></tr>';
			for ($a = 0; $a <= 2; $a++)
			{
				echo '<tr><td>'.$contestant_fname[$a].'</td><td>'.$rebound_score[$a].'</td></tr>';
			}
			echo '</table><br>';
	}

?>


