<?php


namespace Shared\Domain\ValueObject;


class TimeValueObject
{
    /**
     * @var int
     */
    private $totalMinutes;

    /**
     * TimeValueObject constructor.
     * @param int $totalMinutes
     */
    public function __construct(int $totalMinutes)
    {
        $this->totalMinutes = $totalMinutes;
    }

    public static function createFromString(string $time): TimeValueObject {
        $hourMinutes = explode(":",$time);

        $hour = $hourMinutes[0];
        $minutes = $hourMinutes[1];

        $totalMinutes = ($hour * 60) + $minutes;

        return new TimeValueObject($totalMinutes);
    }

    /**
     * @return int
     */
    public function getTotalMinutes(): int
    {
        return $this->totalMinutes;
    }

    public function getTime()
    {
        $hour = floor($this->totalMinutes / 60);
        $minutes = $this->totalMinutes - ($hour * 60);

        if(strlen((string)$hour) == 1){
            $hour = "0".$hour;
        }
        if(strlen((string)$minutes) == 1){
            $minutes = "0".$minutes;
        }

        $time = $hour.":".$minutes;

        return $time;
    }

    public function getHour()
    {

    }

    public function getMinutes()
    {

    }
}