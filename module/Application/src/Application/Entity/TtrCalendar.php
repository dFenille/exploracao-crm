<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TtrCalendar
 *
 * @ORM\Table(name="ttr_calendar", indexes={@ORM\Index(name="IX_ttr_calendar", columns={"day_name"}), @ORM\Index(name="IX_ttr_calendar_1", columns={"begin_time"}), @ORM\Index(name="IX_ttr_calendar_2", columns={"end_time"})})
 * @ORM\Entity
 */
class TtrCalendar
{
    /**
     * @var string
     *
     * @ORM\Column(name="day_number", type="string", length=50, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $dayNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="day_name", type="string", length=50, nullable=true)
     */
    private $dayName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="begin_time", type="datetime", nullable=true)
     */
    private $beginTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_time", type="datetime", nullable=true)
     */
    private $endTime;

    /**
     * @var float
     *
     * @ORM\Column(name="duration", type="float", precision=24, scale=0, nullable=true)
     */
    private $duration;



    /**
     * Get dayNumber
     *
     * @return string
     */
    public function getDayNumber()
    {
        return $this->dayNumber;
    }

    /**
     * Set dayName
     *
     * @param string $dayName
     *
     * @return TtrCalendar
     */
    public function setDayName($dayName)
    {
        $this->dayName = $dayName;

        return $this;
    }

    /**
     * Get dayName
     *
     * @return string
     */
    public function getDayName()
    {
        return $this->dayName;
    }

    /**
     * Set beginTime
     *
     * @param \DateTime $beginTime
     *
     * @return TtrCalendar
     */
    public function setBeginTime($beginTime)
    {
        $this->beginTime = $beginTime;

        return $this;
    }

    /**
     * Get beginTime
     *
     * @return \DateTime
     */
    public function getBeginTime()
    {
        return $this->beginTime;
    }

    /**
     * Set endTime
     *
     * @param \DateTime $endTime
     *
     * @return TtrCalendar
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * Get endTime
     *
     * @return \DateTime
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * Set duration
     *
     * @param float $duration
     *
     * @return TtrCalendar
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return float
     */
    public function getDuration()
    {
        return $this->duration;
    }
}
