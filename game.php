<?php

$count 		= 0;
$handle  	= fopen('php://stdin', 'r');
$min 		= 0;
$max 		= 1;
$numbers 	= [];
$number 	= null;

echo "\nVou descobrir o teu numero, indica um intervalo onde teu numero se encontra!";

echo "\n Minimo:\n";
$min = (int) trim(fgets($handle));

echo "\n Máximo:\n";
$max = (int) trim(fgets($handle));

if(!is_numeric($min) || !is_numeric($max))
{
	echo "\n Numeros inválidos!\n";
	exit;
}

// Get all numbers between
foreach(range($min, $max) as $number)
{
	$numbers[] = $number;
}

// Find middle number
// get rest of division
function getMiddle($nums)
{
	if(count($nums)%2 === 0){
		$index = (int) ((count($nums) - 1) / 2);
		// index exists in array ?
		if(array_key_exists($index, $nums)){
			return $nums[$index];
		}else {
			echo "\nRange Invalido!\n";
			exit;
		}
	}
	else{
		$index = (int) (count($nums) / 2);
		// index exists in array ?
		if(array_key_exists($index, $nums)){
			// yes
			return $nums[$index];
		}else {
			// nop
			echo "\nRange Invalido!\n";
			exit;
		}
	}
}
$number = getMiddle($numbers);

while (true)
{
	$count++;
	echo "Teu numero é: $number ? \n";
	echo "[S] - Sim | [C] - Cima |  [B] - Baixo\n";

	$answer = trim(fgets($handle));
	$options = ['s', 'S', 'c', 'C', 'b', 'B'];

	if (in_array($answer, $options))
	{
		// Correct number 
		// close while loop
		if($answer == 'S' || $answer == 's')
		{
			echo "\n Advinhei teu numero com $count tentativas!\n";
			exit;

		}elseif($answer == 'c' || $answer == 'C')
		{
			// set min to current number
			$min = $number;
			// get all numbers above min
			$numbers = array_filter($numbers, function($num) use($min) {
				return  $num > $min;
			});
			
			// Update all key's
			$numbers = array_values($numbers);

			$number = getMiddle($numbers);

		}elseif($answer == 'b' || $answer == 'B')
		{
			//set Max to current number
			$max = $number;

			// Remove all elems where max > number
			$numbers = array_filter($numbers, function($num) use($max){
				return $max > $num;
			});

			// Update all key's
			$numbers = array_values($numbers);

			// Get midle number
			$number = getMiddle($numbers);
		}
	}
}

?>