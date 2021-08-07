<?php


namespace App\Utils;


class TrimString
{

      protected string $newString;

      public function noSpace(String $string): string
      {
            if ($string) {
                  $newString = str_replace(' ', '', $string);
            }
            return $newString;
      }
      
}
