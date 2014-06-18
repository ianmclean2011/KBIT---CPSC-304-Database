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
	@return a nine digit id number.
	 */
	function idGen($personType, $personCount)
	{
		// First digit of ID identifies whether the person is a guest or vendor.
		$first = $personType;
		
		// Second to sixth is determined by personCount. 
		if(strlen($personCount) > 5)
		{
			return null;
		} 
		else 
		{
			$secondToEight = str_pad($personCount, 5, "0", STR_PAD_LEFT);
			
			// Seven to eighth digit is randomized.
			$random= strval(rand(10,99));
			$secondToEight = $secondToEight.$random;
		}

		$ninth = calculateCheckDigit("$first"."$secondToEight");
		
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

		if ($id[8] == calculateCheckDigit($id))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function calculateCheckDigit($id)
	{
		$first = intVal($id{0});
		$second = array_sum(str_split(strval(intVal($id{1}) * 2)));
		$third = intVal($id{2});
		$fourth =  array_sum(str_split(strval(intVal($id{3}) * 2)));
		$fifth = intVal($id{4});
		$sixth =  array_sum(str_split(strval(intVal($id{5}) * 2)));
		$seventh = intVal($id{6});
		$eighth =  array_sum(str_split(strval(intVal($id{7}) * 2)));
		
		$ninth = 10 - (($first + $second + $third + $fourth + $fifth + $sixth + $seventh + $eighth) % 10);
		
		if ($ninth == 10)
		{
			return 0;
		}
		else
		{
			return $ninth;
		}
	}
?>