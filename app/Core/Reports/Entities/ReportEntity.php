<?php

namespace App\Core\Reports\Entities;

class ReportEntity
{
    public $reportID;
    public $folio;
    public $buildingID; 
    public $roomID; 
    public $categoryID; 
    public $goodName; 
    public $priority;
    public $description;
    public $image;
    public $id; 
    public $status;
    public $requires_approval;
    public $involve_third_parties;
    public $created_at; 

    public function __construct($reportID, $folio, $buildingID, $roomID, $categoryID, $goodName, $priority, $description, $image, $id, $status, $requires_approval, $involve_third_parties, $created_at)
    {
        $this->reportID = $reportID;
        $this->folio = $folio;
        $this->buildingID = $buildingID; 
        $this->roomID = $roomID; 
        $this->categoryID = $categoryID; 
        $this->goodName = $goodName; 
        $this->priority = $priority;
        $this->description = $description;
        $this->image = $image;
        $this->id = $id; 
        $this->status = $status;
        $this->requires_approval = $requires_approval;
        $this->involve_third_parties = $involve_third_parties;
        $this->created_at = $created_at; 
    }
}
