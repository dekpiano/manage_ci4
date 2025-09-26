<?php namespace App\Libraries;

class Grade {

    function check_grade($sum) {
        if (($sum > 100) || ($sum < 0)) {
             $grade = "ไม่สามารถคิดเกรดได้ คะแนนเกิน";
        } else if (($sum >= 79.5) && ($sum <= 100)) {
             $grade = 4;
        } else if (($sum >= 74.5) && ($sum <= 79.4)) {
             $grade = 3.5;
        } else if (($sum >= 69.5) && ($sum <= 74.4)) {
             $grade = 3;
        } else if (($sum >= 64.5) && ($sum <= 69.4)) {
             $grade = 2.5;
        } else if (($sum >= 59.5) && ($sum <= 64.4)) {
             $grade = 2;
        } else if (($sum >= 54.5) && ($sum <= 59.4)) {
             $grade = 1.5;
        } else if (($sum >= 49.5) && ($sum <= 54.4)) {
             $grade = 1;
        } else if ($sum <= 49.4) {
             $grade = 0;
        }
        return $grade;
    }

}