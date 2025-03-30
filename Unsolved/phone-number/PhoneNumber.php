<?php

declare(strict_types=1);

class PhoneNumber
{
    public $raw_number;
    public $formatted_number;

    public function __construct($n)
    {
        $this->raw_number = $n;        
        $this->formatted_number = $this->verifyInvalidNumber($n);        
    }
    // NANP numbers are ten-digit numbers
    // three-digit Numbering Plan Area code
    // seven-digit local number
    // NXX NXX-XXXX

    // N is any digit from 2 through 9 
    // X is any digit from 0 through 9.
    // Sometimes they also have the country code (represented as 1 or +1) prefixed.
    // 11 digits must start with 1

    private function verifyInvalidNumber($number){
        

        // we remove the spacing
        $number = str_replace(' ','',$number);

        // Verify the presense of letters inside the string
        $are_letters_in_string = preg_match('/[a-zA-Z]/',$number);
        if ($are_letters_in_string) throw new InvalidArgumentException('letters not permitted');
        
        // Verify the existance of anything else but numbers and parenthesis
        $are_punctuations_in_the_string = preg_match('/[^0-9()-.]/',$number);
        if ($are_punctuations_in_the_string) throw new InvalidArgumentException('punctuations not permitted');

        // Remove everything but the numbers
        $number = preg_replace('/[^0-9]/','',$number);
        $initial_number = $number[0];

        // Is the number too short?
        if(strlen($number)<10) throw new InvalidArgumentException('Number is too short');
        if(strlen($number)>11) throw new InvalidArgumentException('Number is too Long');

        // is the number too long ?
        
        if (strlen($number)==10) {
            if($number[0]==1) throw new InvalidArgumentException('area code cannot start with one');
            if($number[0]==0) throw new InvalidArgumentException('area code cannot start with zero');
            if($number[3]==1) throw new InvalidArgumentException('exchange code cannot start with one');
            if($number[3]==0) throw new InvalidArgumentException('exchange code cannot start with zero');

            return $number;
        }

        // if 11
        if($initial_number!=1) throw new InvalidArgumentException('11 digits must start with 1');
        
        $number = substr($number,1);
        
        if($number[0]==0) throw new InvalidArgumentException('area code cannot start with zero');
        if($number[0]==1) throw new InvalidArgumentException('area code cannot start with one');
        if($number[3]==1) throw new InvalidArgumentException('exchange code cannot start with one');
        if($number[3]==0) throw new InvalidArgumentException('exchange code cannot start with zero');
        if(!preg_match('/[2-9]/',$number[3])) throw new InvalidArgumentException('area code has an invalid number');
        return $number;        
    }
    
    public function number(): string
    {
        return $this->formatted_number;
    }
}
