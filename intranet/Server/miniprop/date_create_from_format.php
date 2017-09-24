<?php
function DEFINE_date_create_from_format()
{

  function date_create_from_format( $dformat, $dvalue )
  {

    $schedule = $dvalue;
    $schedule_format = str_replace(array('Y','m','d', 'H', 'i','a'),array('%Y','%m','%d', '%I', '%M', '%p' ) ,$dformat);
    // %Y, %m and %d correspond to date()'s Y m and d.
    // %I corresponds to H, %M to i and %p to a
    $ugly = strptime($schedule, $schedule_format);
    $ymd = sprintf(
        // This is a format string that takes six total decimal
        // arguments, then left-pads them with zeros to either
        // 4 or 2 characters, as needed
        '%04d-%02d-%02d %02d:%02d:%02d',
        $ugly['tm_year'] + 1900,  // This will be "111", so we need to add 1900.
        $ugly['tm_mon'] + 1,      // This will be the month minus one, so we add one.
        $ugly['tm_mday'], 
        $ugly['tm_hour'], 
        $ugly['tm_min'], 
        $ugly['tm_sec']
    );
    $new_schedule = new DateTime($ymd);

   return $new_schedule;

  }
}

if( !function_exists("date_create_from_format") )
  DEFINE_date_create_from_format();
?>