<?php
include 'tsq_constants.php';
?>

<html>
<head>
<title>The Saturday Quiz Sim</title>
<link rel='stylesheet' href='style.css' id='styler'>

</head>
<body>
<div class="container">
<header id="myHeader"></header>
<nav id="navBar"></nav>
<article>

<br>
<br>

<?php

include 'disclaimer.php';


$contestant_counter = 0;

$game_script = array('','','','');
$contestant_championships = array(0,0,0);
$contestant_prior_winnings = array(0,0,0);
$contestant_level = array(1,1,1);

$contestant_game_skill_level = array(0,0,0);
$current_air_date = '2019-03-16';
$new_order = array(0,1,2);

$result_string = "0*1*0*0*0*1*0*0*0*1*0*0*";		//First result string.
$result_array = [];


//Generate random game skill level values for the first game.
echo ('About to generate game skill levels for first game.<br>');


echo ('<br>Starting 100 game simulation.<br>');


// *** START OF 100 GAME SIMULATION LOOP ***
for ($g = 1; $g <= 100; $g++)
{
	$data_stream_counter = -1;
	$rebound_pot = 0;
	$round_to_beat = -1;
	$contestant_wildcards = array(3,3,3);
	$contestant_round_reached = array(0,0,0);
	
	//Decode Result String.
	decodeResultString($result_string);
	
	for ($a = 0; $a <= 2; $a++)
	{	
		$rebound_score[$a] = 0;
	}

	echo ('Start of Game #'.$g.'.<br>');
	
	for ($a = 0; $a <= 2; $a++)
	{
		if ($contestant_id[$a] == 0)
		{
			$contestant_id[$a] = getNextContestant();
		}
		$contestant_winnings[$a] = 0;
	}
	
	for ($a = 0; $a <= 2; $a++)
	{
		$contestant_game_skill_level[$a] = rand(1,6);
	}

	//Generate data stream.
	echo ('Generating data stream for Game # '.strval($g).'.<br>');
	
	$data_stream = "";
	for ($a = 1; $a <= 250; $a++)
	{
		$data_stream = $data_stream . strval(rand(1,6));
	}
	echo ('Data stream is: '.$data_stream.'<br>');
	
	
	//Generate game.
	echo ('Querying Game #'.$g.' into MySQL server.<br>');
	$game_query = 
	"INSERT INTO `sdevelop_youtube`.`TSQ100 Games`
	(`id`, `timestamp`,`air_date`, `season`,`mode`,
	`c1_id`, `c1_game_skill_level`, `c1_level`, `c1_championships`, `c1_prior_winnings`, `c1_winnings`, 
	`c2_id`, `c2_game_skill_level`, `c2_level`, `c2_championships`, `c2_prior_winnings`, `c2_winnings`,
	`c3_id`, `c3_game_skill_level`, `c3_level`, `c3_championships`, `c3_prior_winnings`, `c3_winnings`, `comments`, `data_stream`)
	VALUES (".$g.", 'Game #".$g.".', '".$current_air_date."', '2', '0', 
	'".$contestant_id[0]."', '".$contestant_game_skill_level[0]."', '".$contestant_level[0]."', '".$contestant_championships[0]."', '".$contestant_prior_winnings[0]."', '0',
	'".$contestant_id[1]."', '".$contestant_game_skill_level[1]."', '".$contestant_level[1]."', '".$contestant_championships[1]."', '".$contestant_prior_winnings[1]."', '0',
	'".$contestant_id[2]."', '".$contestant_game_skill_level[2]."', '".$contestant_level[2]."', '".$contestant_championships[2]."', '".$contestant_prior_winnings[2]."', '0',
	'Game #".$g.".', '".$data_stream."')
	";

	echo ("<br><table><tr><th>id</th><th>game_skill_level</th><th>level</th><th>championships</th><th>prior_winnings</th><th>winnings</th></tr>");
	
	for ($a = 0; $a <= 2; $a++)
	{
		echo ("<tr><td>".$contestant_id[$a]."</td><td>".$contestant_game_skill_level[$a]."</td><td>".$contestant_level[$a]."</td><td>".$contestant_championships[$a]."</td><td>".$contestant_prior_winnings[$a]."</td></tr>");
	}
		
	echo ("</table><br>");
	
	echo ("<br>Game query is ".$game_query."<br><br>");
	
	$game_result = mysqli_query($db, $game_query) or die ('Error generating Game #'.$g.'.');
	$game_row = mysqli_fetch_array($game_result);

	$retrieve_query = "SELECT * FROM `TSQ100 Games` WHERE `id` = ".strval($g);

	$retrieve_result = mysqli_query($db, $retrieve_query) or die ('Error retrieving Game #'.$g.'.');
	$retrieve_row = mysqli_fetch_array($retrieve_result);

	$p1_query = "SELECT * FROM `TSQ100 Contestants` WHERE id = ".$retrieve_row['c1_id'];
	$p1_result = mysqli_query($db, $p1_query) or die ('Error querying contestant 1 data.');
	$p1_row = mysqli_fetch_array($p1_result);
	
	$p2_query = "SELECT * FROM `TSQ100 Contestants` WHERE id = ".$retrieve_row['c2_id'];
	$p2_result = mysqli_query($db, $p2_query) or die ('Error querying contestant 2 data.');
	$p2_row = mysqli_fetch_array($p2_result);
	
	$p3_query = "SELECT * FROM `TSQ100 Contestants` WHERE id = ".$retrieve_row['c3_id'];
	$p3_result = mysqli_query($db, $p3_query) or die ('Error querying contestant 3 data.');
	$p3_row = mysqli_fetch_array($p3_result);
		
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
	
	//Begin game.
	$season = $retrieve_row['season'] - 1;
	
	if ($season > 1)
	{
		$season = 1;
	}
	
	$mode = $retrieve_row['mode'];
	
	if ($mode == 1)
	{
		$rebound_pot = 40000;
	}
	if ($mode == 2)
	{
		$rebound_pot = 100000;
	}
	
	$data_stream = $retrieve_row['data_stream'];
	$data_stream_timestamp = $retrieve_row['timestamp'];

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
		}
		
		if ($contestant_game_skill_level[$a] == 0) 
		{
			$contestant_game_skill_level[$a] = getNextNumber();
		}
			
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
					echo "<br><u>Correct! Questions Get: ".strval($questions_get)."</u><br>";
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
							echo "<br><i>Correct! Questions Get: ".strval($questions_get)."</i><br>";
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
				echo ("<br>Questions Get: ".$questions_get."<br>");
				echo ("<br>Questions Left: ".$questions_left."<br>");
				echo ("<br>Questions Needed: ".$questions_needed[$round - 1]."<br>");
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
			//echo '<div id="dropout">';
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
			//echo '</div><br>';
		}
		
	
		if ($victory == 1)
		{
			//echo '<div id="seikai">';
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
			//echo '</div><br>';
		}
		if ($fail == 1)
		{
			$contestant_round_reached[$a] = 0;
		}
				//echo 'Round reached: '.($contestant_round_reached[$a]+1).'<br>';
		//$data_stream_counter--;
	}	//End of Regular part of show.
	
	
	
	
	//Start of rebound game loop.
	if ($rebound_pot > 0)
	{
		echo 'Rebound pot: '.$rebound_pot.'<br>';
		$game_script[3] += "Rp";		//for "Rebound Pot"
		//Rebound game.

		for ($a = 0; $a <= 2; $a++)
		{	
			$rebound_score[$a] = 0;
		}

		//While nobody has yet scored five points...
		do
		{
			displayReboundTable();
			$game_script[3] += "??";		//for "Question", the second ? means it's for a rebound.
			
			for ($a = 0; $a <= 2; $a++){$rebound_active[$a] = 1;}
			
			$rebound_gofor = getNextNumber();
			//echo $rebound_gofor."<br>";
			if ($rebound_gofor == 1)
			{
				$game_script[3] += "Nb";	//for "No Buzz"	
			}
			if ($rebound_gofor > 1)
			{
				$rebound_first_pick = getNextNumber();
				//echo "Rebound first pick: ".$rebound_first_pick."<br>";
				$rebound_first_pick = ($rebound_first_pick - 1) % 3;

				for ($pr = 0; $pr <= 2; $pr++) {if ($rebound_first_pick == $pr) {$game_script[3] += "P"+strval($pr+1);}}
				
				$total_skill_level = $contestant_initial_skill_level[$rebound_first_pick] + $contestant_game_skill_level[$rebound_first_pick];

				
				//Determines whether or not your answer is correct.
				$data_stream_value = getNextNumber();
				//echo $data_stream_value."<br>";
				if ($data_stream_value >= $skill_correct_first_roll[$total_skill_level])
				{
					//Correct
					$rebound_score[$rebound_first_pick]++;
					$rebound_right = 1;
					
					if ($rebound_score[$rebound_first_pick] == 5) {$game_script[3] += "G5";} else {$game_script[3] += "C"+ strval($rebound_score[$rebound_first_pick]);}	//for "Game 5" and "Correct n"
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
							if ($rebound_score[$rebound_first_pick] == 5) {$game_script[3] += "g5";} else {$game_script[3] += "c"+ strval($rebound_score[$rebound_first_pick]);}	//for "...Game 5" and "...Correct n"
							
							echo 'RIGHT<br><br>';
							displayReboundTable();
						}
						else
						{
							
							//Wrong
							$rebound_right = -1;
							$rebound_active[$rebound_first_pick] = 0;
							$game_script[3] += "wr"; 	//for "...Wrong"
							
							echo 'WRONG<br>';
							
						}
					}
					else
					{
						//Wrong
						$rebound_right = -1;
						$rebound_active[$rebound_first_pick] = 0;
						$game_script[3] += "Wr"; 		//for "Wrong"
						
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
					
					//If no one buzzes in...
					if ($rebound_gofor == 1)
					{
						$game_script[3] += "Nb";	//for "No Buzz"	
					}
					//If someone buzzes in...
					if ($rebound_gofor > 1)
					{
						$rebound_second_pick = getNextNumber();
						$rebound_second_pick = $rebound_second_available[$rebound_second_pick % 2];
						$total_skill_level = $contestant_initial_skill_level[$rebound_second_pick] + $contestant_game_skill_level[$rebound_second_pick];
						for ($pr = 0; $pr <= 2; $pr++) {if ($rebound_second_pick == $pr) {$game_script[3] += "P"+strval($pr+1);}}

						echo '<b>'.$contestant_fname[$rebound_second_pick].': </b>';
						
						//Is that person right?
						$data_stream_value = getNextNumber();
						if ($data_stream_value >= $skill_correct_first_roll[$total_skill_level])
						{
							//Correct
							$rebound_score[$rebound_second_pick]++;
							$rebound_right = 1;
							if ($rebound_score[$rebound_second_pick] == 5) {$game_script[3] += "G5";} else {$game_script[3] += "C"+ strval($rebound_score[$rebound_second_pick]);}	//for "Game 5" and "Correct n"

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
									if ($rebound_score[$rebound_second_pick] == 5) {$game_script[3] += "g5";} else {$game_script[3] += "c"+ strval($rebound_score[$rebound_second_pick]);}	//for "...Game 5" and "...Correct n"
									
									echo 'RIGHT<br><br>';
									displayReboundTable();
								}
								else
								{
									
									//Wrong
									$rebound_right = -1;
									$rebound_active[$rebound_second_pick] = 0;
									$game_script[3] += "wr"; 	//for "...Wrong"
									echo 'WRONG<br>';
								}
							}
							else
							{
								//Wrong
								$rebound_right = -1;
								$rebound_active[$rebound_second_pick] = 0;
								$game_script[3] += "Wr"; 		//for "Wrong"
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
							
							if ($rebound_gofor == 1)
							{
								$game_script[3] += "Nb";	//for "No Buzz"
							}
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
									if ($rebound_score[$rebound_third_pick] == 5) {$game_script[3] += "G5";} else {$game_script[3] += "C"+ strval($rebound_score[$rebound_third_pick]);}	//for "Game 5" and "Correct n"
									
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
											if ($rebound_score[$rebound_third_pick] == 5) {$game_script[3] += "g5";} else {$game_script[3] += "c"+ strval($rebound_score[$rebound_third_pick]);}	//for "Game 5" and "Correct n"
											
											echo 'RIGHT<br><br>';
											displayReboundTable();
										}
										else
										{
											
											//Wrong
											$rebound_right = -1;
											$rebound_active[$rebound_third_pick] = 0;
											$game_script[3] += "wr"; 	//for "...Wrong"
											echo 'WRONG<br><br>';
										}
									}
									else
									{
										//Wrong
										$rebound_right = -1;
										$rebound_active[$rebound_third_pick] = 0;
										$game_script[3] += "Wr"; 	//for "Wrong"
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
		
		//Determine the winner of the rebound pot.
		for ($a = 0; $a <= 2; $a++)
		{
			if ($rebound_score[$a] >= 5) 
			{
				echo '<h2>'.$contestant_fname[$a].' wins the rebound pot of $'.number_format($rebound_pot).'!</h2><br><br>';
				$contestant_winnings[$a] += $rebound_pot;
				echo "After Rebound: Contestant ".$a.": ".$contestant_winnings[$a]."<br>";
				//Just in case everyone loses, the Rebound game determines the returning champion.
				if ($contestant_round_reached[0] == 0 && $contestant_round_reached[1] == 0 && $contestant_round_reached[2] == 0) {$contestant_round_reached[$a]++;  $round_to_beat = $contestant_round_reached[$a];}
			}

		}

	//End of Rebound Game loop.
	}
	
	$game_script[3] += "Rp"; 	//for "Rebound Pot"
	
	//Add all the winnings to the prior winnings.
	for ($a = 0; $a <= 2; $a++)
	{
		$contestant_winnings[$a] += $contestant_prior_winnings[$a];
		
		
	}


	
	//Final Scores for Regular Play.
	
	//Clear result string and array.
	$result_string = "";
	$result_array = [];
	
	
	if ($mode == 0)
	{
		for ($a = 0; $a <= 2; $a++)
		{
			$retire_flag = 0;
			if ($contestant_round_reached[$a] >= $round_to_beat) 
			{
				if ($season == 0)
				{
					if ($contestant_championships[$a] % 10 < 6 && $contestant_level[$a] < 5)
					{
						//echo ('Player '.strval($a).', '.$contestant_fname[$a].' is champion');
						$game_script[3] += "C"+strval($a+1);		//for "Player n is Champion"
						echo '<h3>'.$contestant_fname[$a].' '.$contestant_lname[$a].' is coming back to play Level '.$contestant_level[$a].' with $'.number_format($contestant_winnings[$a]).'.</h3>';
					
						//Push result string fragment to array.
						array_push($result_array, strval($contestant_id[$a])."*".strval($contestant_level[$a])."*".strval($contestant_championships[$a]+1)."*".strval($contestant_winnings[$a])."*");
					}
					else if ($contestant_championships[$a] % 10 > 5 && $contestant_level[$a] < 5)
					{
						//echo ('Player '.strval($a).', '.$contestant_fname[$a].' is millionaire');
						$game_query = "UPDATE `sdevelop_youtube`.`TSQ100 Games` SET `comments` = '*Game #".strval($g).".' WHERE `TSQ100 Games`.`id` = '".$g."'";
						$game_result = mysqli_query($db, $game_query) or die ('Error updating 5-time champion comment.');
						//$contestant_championships[$a] -= 1;
						$game_query = "UPDATE `sdevelop_youtube`.`TSQ100 Games` SET `c".strval($a+1)."_championships` = ".$contestant_championships[$a]." WHERE `TSQ100 Games`.`id` = '".$g."'";
						$game_result = mysqli_query($db, $game_query) or die ('Error adjusting millionaire championships number.');

						$contestant_winnings[$a] += 1000000;
						$retire_flag = 1;
						$game_script[3] += "M"+strval($a+1);		//for "Player n is Millionaire"
						$contestant_championships[$a] = 0;
						echo '<h3>'.$contestant_fname[$a].' '.$contestant_lname[$a].' LEAVES AS A 7-TIME UNDEFEATED CHAMPION WITH $'.number_format($contestant_winnings[$a]).'!</h3>';
						//$contestant_winnings[$a] = 0;
					}
					else if ($contestant_championships[$a] % 10 < 6 && $contestant_level[$a] > 4)
					{
						//echo ('Player '.strval($a).', '.$contestant_fname[$a].' is millionaire');
						$game_query = "UPDATE `sdevelop_youtube`.`TSQ100 Games` SET `comments` = '*Game #".strval($g).".' WHERE `TSQ100 Games`.`id` = '".$g."'";
						$game_result = mysqli_query($db, $game_query) or die ('Error updating 5-time champion comment.');
						//$contestant_championships[$a] -= 1;
						$game_query = "UPDATE `sdevelop_youtube`.`TSQ100 Games` SET `c".strval($a+1)."_championships` = ".$contestant_championships[$a]." WHERE `TSQ100 Games`.`id` = '".$g."'";
						$game_result = mysqli_query($db, $game_query) or die ('Error adjusting millionaire championships number.');
						$retire_flag = 1;
						$game_script[3] += "F"+strval($a+1);		//for "Player n Final Score"
						$contestant_championships[$a] = 0;
						echo '<h3>'.$contestant_fname[$a].' '.$contestant_lname[$a].' is going home quite wealthy with $'.number_format($contestant_winnings[$a]).'.</h3>';
						//$contestant_winnings[$a] = 0;
					}
					else if ($contestant_championships[$a] % 10 > 5 && $contestant_level[$a] > 4)
					{
						//echo ('Player '.strval($a).', '.$contestant_fname[$a].' is millionaire');
						$game_query = "UPDATE `sdevelop_youtube`.`TSQ100 Games` SET `comments` = '*Game #".strval($g).".' WHERE `TSQ100 Games`.`id` = '".$g."'";
						$game_result = mysqli_query($db, $game_query) or die ('Error updating 5-time champion comment.');
						//$contestant_championships[$a] -= 1;
						$game_query = "UPDATE `sdevelop_youtube`.`TSQ100 Games` SET `c".strval($a+1)."_championships` = ".$contestant_championships[$a]." WHERE `TSQ100 Games`.`id` = '".$g."'";
						$game_result = mysqli_query($db, $game_query) or die ('Error adjusting millionaire championships number.');
						$retire_flag = 1;
						$game_script[3] += "F"+strval($a+1);		//for "Player n Final Score"
						$contestant_winnings[$a] += 1000000;
						$contestant_championships[$a] = 0;
						echo '<h3>Amazing.  '.$contestant_fname[$a].' '.$contestant_lname[$a].' has won both million dollar bonuses and is going home quite wealthy with $'.number_format($contestant_winnings[$a]).'.</h3>';
						//$contestant_winnings[$a] = 0;
					}
					if ($retire_flag < 1)
					{
						$contestant_championships[$a]++;
					}
					
				}
				else if ($season > 0)
				{
					if ($contestant_championships[$a] % 10 < 4 && $contestant_level[$a] < 4)
					{
						//echo ('Player '.strval($a).', '.$contestant_fname[$a].' is champion with $'.strval($contestant_winnings[$a]));
						$game_script[3] += "C"+strval($a+1);		//for "Player n is Champion"
						echo '<h3>'.$contestant_fname[$a].' '.$contestant_lname[$a].' is coming back to play Level '.$contestant_level[$a].' with $'.number_format($contestant_winnings[$a]).'.</h3>';

						//Push result string fragment to array.
						array_push($result_array, strval($contestant_id[$a])."*".strval($contestant_level[$a])."*".strval($contestant_championships[$a]+1)."*".strval($contestant_winnings[$a])."*");

						}
					else if ($contestant_championships[$a] % 10 > 3 && $contestant_level[$a] < 4)
					{
						//echo ('Player '.strval($a).', '.$contestant_fname[$a].' is millionaire');
						$game_query = "UPDATE `sdevelop_youtube`.`TSQ100 Games` SET `comments` = '*Game #".strval($g).".' WHERE `TSQ100 Games`.`id` = '".$g."'";
						$game_result = mysqli_query($db, $game_query) or die ('Error updating 5-time champion comment.');
						//$contestant_championships[$a] -= 1;
						$game_query = "UPDATE `sdevelop_youtube`.`TSQ100 Games` SET `c".strval($a+1)."_championships` = ".$contestant_championships[$a]." WHERE `TSQ100 Games`.`id` = '".$g."'";
						$game_result = mysqli_query($db, $game_query) or die ('Error adjusting millionaire championships number.');
						$retire_flag = 1;
						$contestant_winnings[$a] += 1000000;
						$game_script[3] += "M"+strval($a+1);		//for "Player n is Millionaire"
						$contestant_championships[$a] = 0;
						echo '<h3>'.$contestant_fname[$a].' '.$contestant_lname[$a].' LEAVES AS A 5-TIME UNDEFEATED CHAMPION WITH $'.number_format($contestant_winnings[$a]).'!</h3>';
						//$contestant_winnings[$a] = 0;
					}
					else if ($contestant_championships[$a] % 10 < 4 && $contestant_level[$a] > 3)
					{
						//echo ('Player '.strval($a).', '.$contestant_fname[$a].' is millionaire');
						$game_query = "UPDATE `sdevelop_youtube`.`TSQ100 Games` SET `comments` = '*Game #".strval($g).".' WHERE `TSQ100 Games`.`id` = '".$g."'";
						$game_result = mysqli_query($db, $game_query) or die ('Error updating 5-time champion comment.');
						//$contestant_championships[$a] -= 1;
						$game_query = "UPDATE `sdevelop_youtube`.`TSQ100 Games` SET `c".strval($a+1)."_championships` = ".$contestant_championships[$a]." WHERE `TSQ100 Games`.`id` = '".$g."'";
						$game_result = mysqli_query($db, $game_query) or die ('Error adjusting millionaire championships number.');
						$retire_flag = 1;
						$game_script[3] += "F"+strval($a+1);		//for "Player n Final Score"
						$contestant_championships[$a] = 0;
						echo '<h3>'.$contestant_fname[$a].' '.$contestant_lname[$a].' is going home quite wealthy with $'.number_format($contestant_winnings[$a]).'.</h3>';
						//$contestant_winnings[$a] = 0;
					}
					else if ($contestant_championships[$a] % 10 > 3 && $contestant_level[$a] > 3)
					{
						//echo ('Player '.strval($a).', '.$contestant_fname[$a].' is millionaire');
						$game_query = "UPDATE `sdevelop_youtube`.`TSQ100 Games` SET `comments` = '*Game #".strval($g).".' WHERE `TSQ100 Games`.`id` = '".$g."'";
						$game_result = mysqli_query($db, $game_query) or die ('Error updating 5-time champion comment.');
						//$contestant_championships[$a] -= 1;
						$game_query = "UPDATE `sdevelop_youtube`.`TSQ100 Games` SET `c".strval($a+1)."_championships` = ".$contestant_championships[$a]." WHERE `TSQ100 Games`.`id` = '".$g."'";
						$game_result = mysqli_query($db, $game_query) or die ('Error adjusting millionaire championships number.');
						$retire_flag = 1;
						$contestant_winnings[$a] += 1000000;
						$game_script[3] += "F"+strval($a+1);		//for "Player n Final Score"
						$contestant_championships[$a] = 0;
						echo '<h3>Amazing.  '.$contestant_fname[$a].' '.$contestant_lname[$a].' has won both million dollar bonuses and is going home quite wealthy with $'.number_format($contestant_winnings[$a]).'.</h3>';
						//$contestant_winnings[$a] = 0;
					}
					if ($retire_flag < 1)
					{
						$contestant_championships[$a]++;
					}
				}
				else
				{
					echo '<h3>Head-On.  Apply directly to the forehead.</h3>';
				}
				
			}
			else
			{
				$game_script[3] += "F"+strval($a+1);		//for "Player n Final Score"
				echo '<h3>'.$contestant_fname[$a].' '.$contestant_lname[$a].' leaves with $'.number_format($contestant_winnings[$a]).'.</h3>';
				$contestant_championships[$a] = 0;		//If a co-champion loses, don't allow that contestant to return.
				//$contestant_winnings[$a] = 0;
			}
			
			
				   if ($a == 0)  {$final_query = "UPDATE `TSQ100 Games` SET `c1_winnings` = ".$contestant_winnings[0]." WHERE `id` = '".$g."'";}
				   if ($a == 1)  {$final_query = "UPDATE `TSQ100 Games` SET `c2_winnings` = ".$contestant_winnings[1]." WHERE `id` = '".$g."'";}
				   if ($a == 2)  {$final_query = "UPDATE `TSQ100 Games` SET `c3_winnings` = ".$contestant_winnings[2]." WHERE `id` = '".$g."'";}
					$final_result = mysqli_query($db, $final_query) or die ('Error querying day winnings of Contestant '.$a.'.');
					//$game_row = mysqli_fetch_array($game_result);
				echo 'Player '.$a.' championships: '.$contestant_championships[$a];
		}

	}
	
	//Generate new result string.
	
	if (sizeof($result_array) < 3)
	{
		for ($a = 0; $a <= 2-sizeof($result_array); $a++)
		{
			$result_string = $result_string . "0*1*0*0*";
		}
		foreach ($result_array as $s)
		{
			$result_string = $result_string . $s;
		}
	}
	else
	{
		foreach ($result_array as $s)
		{
			$result_string = $result_string . $s;
		}
	}
	
	
	$game_script = array('','','','');


	
	
// End of 100 game loop.
}

	
//echo '<br><br><br>Timestamp: '.$data_stream_timestamp.'<br>Simulated Dice Rolls (courtesy of <a href="http://www.random.org" target="new">RANDOM.ORG</a>): '.$data_stream.'<br>';


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
		echo ("<br>Next number: ".substr($data_stream,$data_stream_counter,1)."<br>");
		return substr($data_stream,$data_stream_counter,1);
		
	}
?>


<?php
	function getNextContestant()
	{
		global $contestant_counter;
		$contestant_counter++;
		return $contestant_counter;
	}
?>

<?php
	function displayReboundTable()
	{
		global $contestant_fname, $rebound_score;
		
		//echo '<table border="1"><tr><td><b>Player</b></td><td><b>Score</b></td></tr>';
			for ($a = 0; $a <= 2; $a++)
			{
				//echo $contestant_fname[$a].": ".$rebound_score[$a]."<br>";
				//echo '<tr><td>'.$contestant_fname[$a].'</td><td>'.$rebound_score[$a].'</td></tr>';
			}
			//echo '</table><br>';
	}

?>

<?php
	function clearAllGames()
	{
		$result = mysqli_query($db, "TRUNCATE TABLE `sdevelop_youtube`.`TSQ100 Games`;") or die ('Error truncating table..');	
		$result = mysqli_query($db, "ALTER TABLE `sdevelop_youtube`.`TSQ100 Games` AUTO_INCREMENT = 1;") or die ('Error altering table.');
	}

?>

<?php
	function decodeResultString($string)
	{
		global $contestant_id, $contestant_level, $contestant_championships, $contestant_prior_winnings;
		
		$test_char = "";
		$temp_word = "";
		$c_num = 0;
		$field = 0;
		echo ("<br>Result string is ".$string."<br>");
		for ($a = 0; $a < strlen($string); $a++)
		{
			
			//if ($c_num > 2)
			//{
			//	die ("<br>Error in result string \"".$string."\".  Check your asterisks.<br>");
			//}
			$test_char = substr($string, $a, 1);
			if ($test_char == "*")
			{

				if ($field == 0) 
				{
					echo ("Contestant ID [".$c_num."] is rendered as ".$temp_word.".<br>");
					$contestant_id[$c_num] = $temp_word;
				}
				elseif ($field == 1)
				{	
					echo ("Contestant level [".$c_num."] is rendered as ".$temp_word.".<br>");
					$contestant_level[$c_num] = $temp_word;
				}
				elseif ($field == 2)
				{
					echo ("Contestant championships [".$c_num."] is rendered as ".$temp_word.".<br>");
					$contestant_championships[$c_num] = $temp_word;
				}
				elseif ($field == 3)
				{
					echo ("Contestant prior winnings [".$c_num."] is rendered as ".$temp_word.".<br>");
					$contestant_prior_winnings[$c_num] = $temp_word;
					
				}
				
				$field++;
				if ($field > 3)
				{
					$c_num++;
					$field = 0;
				}
				$temp_word = "";
			}
			else
			{
				$temp_word = $temp_word . $test_char;
			}
			
		}
		
	}
?>

<?php
	function encodeResultString($ids, $levels, $championships, $prior_winningses)
	{
		$working_string = "";
		
		for ($a = 0; $a <= 2; $a++)
		{
			$working_string = $working_string.strval($ids[$a])."*".strval($levels[$a])."*".strval($championships[$a])."*".strval($prior_winningses[$a]);
		}
		
		return $working_string;
	}
	

?>


