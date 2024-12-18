<?php


namespace Aldar\Project2\Service;

use Aldar\Project2\Model\Review;

class GradeService
{
     public function getAvarageRate(array $reviews):float
     {
        $avarage = 0;
        if (!$reviews){
            return $avarage;
        }
        foreach ($reviews as $review){
            $gradeAll[] = $review->getGrade();
        }

        $avarage = round(array_sum($gradeAll)/count($gradeAll),2);
        return $avarage;
     }

}