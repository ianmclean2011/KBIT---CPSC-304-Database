<?php
	/* Generates an unique ID when adding a Guest or Vendor. Note that 
	dependent guests do not use this generator as they are a weak entity that
	is identified by the original invitee. 	

	This generator is uses the Luhn algorithm or Luhn formula, also known
	as the "modulus 10" or "mod 10" algorithm, which is a simple checksum formula used 
	to validate a variety of identification numbers. The Luhn algorithm will detect any
	single-digit error, as well as almost all transpositions of adjacent digits.
	Reference: http://en.wikipedia.org/wiki/Luhn_algorithm

	@param $personType: 1 for Guests and 2 for Vendors.
	@param $personCount: number of people already in the database for that person type.
	 */
	function idGen($personType, $personCount)
	{
		// First digit of ID identifies whether the person is a guest or vendor.
		$first = strval($personType);
		
		// Second to Sixith is determined by personCount. 
		// Therefore, if person count is greater than 5 digits, then all available unique IDS have been assigned.
		if(strlen($personCount) > 5){
			return null;
		} else {
			$secondToEight = str_pad($personCount, 5, "0", STR_PAD_LEFT);
			
			// Seven and eighth digit is randomized.
			$random= strval(rand(10,99));
			$secondToEight = $secondToEight.$random;
		}

		// Calculate the ninth check digit which can be used to check the integrity of the ID entered at a later time.
		$second = intVal($secondToEight{0}) * 2;
		$third = intVal($secondToEight{1});
		$fourth =  intVal($secondToEight{2}) * 2;
		$fifth = intVal($secondToEight{3});
		$sixth =  intVal($secondToEight{4}) * 2;
		$seventh = intVal($secondToEight{5});
		$eighth =  intVal($secondToEight{6}) * 2;
		
		$ninth = ($second + $third + $fourth + $fifth + $sixth + $seventh + $eighth) * 9 % 10;
			
		return $first.$secondToEight."$ninth";
	}
?>