<?php
	/* 
	Generates an unique ID when adding a Guest or Vendor. Note that 
	dependent guests do not use this generator as they are a weak entity that
	is identified by the original invitee. 	

	This generator uses the Luhn algorithm or Luhn formula, also known
	as the "modulus 10" or "mod 10" algorithm, which is a simple checksum formula used 
	to validate a variety of identification numbers. The Luhn algorithm will detect any
	single-digit error, as well as almost all transpositions of adjacent digits.
	Reference: http://en.wikipedia.org/wiki/Luhn_algorithm

	@param $personType - 1 for Guests and 2 for Vendors.
	@param $personCount - number of people already in the database for that person type.
	@return an unique nine digit id number
	 */
	function idGen($personType, $personCount)
	{
		// First digit of ID identifies whether the person is a guest or vendor.
		$first = $personType;
		
		// Second to Sixth is determined by personCount. 
		// Therefore, if person count is greater than 5 digits, then all available unique IDS have been assigned.
		if(strlen($personCount) > 5)
		{
			return null;
		} 
		else 
		{
			$secondToEight = str_pad($personCount, 5, "0", STR_PAD_LEFT);
			
			// Seven and eighth digit is randomized.
			$random= strval(rand(10,99));
			$secondToEight = $secondToEight.$random;
		}

		// Calculate the ninth check digit which can be used to check the integrity of the ID entered at a later time.
		$second = array_sum(str_split(strval(intVal($secondToEight{0}) * 2)));
		$third = intVal($secondToEight{1});
		$fourth =  array_sum(str_split(strval(intVal($secondToEight{2}) * 2)));
		$fifth = intVal($secondToEight{3});
		$sixth =  array_sum(str_split(strval(intVal($secondToEight{4}) * 2)));
		$seventh = intVal($secondToEight{5});
		$eighth =  array_sum(str_split(strval(intVal($secondToEight{6}) * 2)));
		
		$ninth = 10 - (($first + $second + $third + $fourth + $fifth + $sixth + $seventh + $eighth) % 10);
			
		return "$first".$secondToEight."$ninth";
	}
	
	/* 
	Checks whether an id number is valid. This function can be used to validate an id
	number before proceeding to search through the database.
	@param $id - the id number that needs to be validated
	@return true if id is valid, false otherwise.
	 */
	function idValidate($id)
	{
		if($id == null || strlen($id) != 9)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
?>