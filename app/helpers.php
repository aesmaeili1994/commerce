<?php

use Carbon\Carbon;

function generateFileName($name){
    $year=Carbon::now()->year;
    $month=Carbon::now()->month;
    $day=Carbon::now()->day;
    $hour=Carbon::now()->hour;
    $minute=Carbon::now()->minute;
    $second=Carbon::now()->second;
    $microsecond=Carbon::now()->microsecond;
    return $year.'_'.$month.'_'.$day.'_'.$hour.'_'.$minute.'_'.$second.'_'.$microsecond.'_'.$name;
}

function convertShamsiToMiladi($dateTimeShamsi){
    if ($dateTimeShamsi == null) {
        return null;
    }

    //  [-\s] => \s => any space  &  - => -
    $pattern="/[-\s]/";
    $shamsiDateSplit=preg_split($pattern,$dateTimeShamsi);
    $dateMiladi=Verta::getGregorian($shamsiDateSplit[0],$shamsiDateSplit[1],$shamsiDateSplit[2]);
    $dateTimeMiladi=implode("-",$dateMiladi)." ".$shamsiDateSplit[3];
    return $dateTimeMiladi;
}
