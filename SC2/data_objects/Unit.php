<?php

/**
 * Created by PhpStorm.
 * User: vic
 * Date: 2017-01-23
 * Time: 5:16 PM
 */
class Unit
{
    private $_id;
    private $_subject_id;
    private $_date;
    private $_name;
    private $_description;
    private $_subject_type;
    private $_duration;
    private $_active;
    private $_color;

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->_active;
    }

    /**
     * @return mixed
     */
    public function getDuration()
    {
        return $this->_duration;
    }

    /**
     * @param mixed $duration
     */
    public function setDuration($duration)
    {
        $this->_duration = $duration;
    }

    public function __construct($id, $type, $name, $description, $subject_type, $active, $color)
    {
        $this->_id = $id;
        $this->_subject_id = $type;
        $this->_date = new DateTime();
        $this->_name = $name;
        $this->_description = $description;
        $this->_duration = 0;
        $this->_subject_type = $subject_type;
        $this->_active = $active;
        $this->_color = $color;
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->_color;
    }

    /**
     * @return mixed
     */
    public function getSubjectType()
    {
        return $this->_subject_type;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->_description;
    }

    public function set_date($newDate)
    {
        $this->_date = $newDate;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @return mixed
     */
    public function getSubjectid()
    {
        return $this->_subject_id;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->_date;
    }


    public function __toString()
    {
        return 'Unit Object 
            [ id: ' . $this->_id .
            ' type: ' . $this->_subject_id .
            ' date ' . date_format($this->_date, 'm/d/y') .
            ' duration ' . $this->_duration . ' ]' .
            ' description ' . $this->_description . ' ]' .
            ' active ' . $this->_active;
    }
}