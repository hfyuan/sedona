<?php
class UnitModel {
    // property declaration
    public $UnitId = "";
	public $SquareFeet = 0;
	public $MarketRentMin = 0;
	public $MarketRentMax = 0;
	public $EffectiveRentMin = 0;
	public $EffectiveRentMax = 0;
    public $FloorplanId = "";
	public $FloorplanName = "";
	public $BedroomCount = 0;
	public $BathroomCount = 0;
	public $HasDen = FALSE;
	public $IsAvailable = FALSE;
	public $AvailableDate = "";
	public $FloorId = "";
	public $FloorCode = "";
	public $FloorName = "";
}

class FloorplanModel {
    // property declaration
    public $FloorplanId = "";
	public $Name = "";
	public $Comment = "";
	public $MarketRentMin = 0;
	public $MarketRentMax = 0;
	public $SquareFeetMin = 0;
	public $SquareFeetMax = 0;
	public $BedroomCount = 0;
	public $BathroomCount = 0;	
	public $Rank = 0;
    public $ImageSrc = "";
	public $ImageWidth = 0;
	public $ImageHeight = 0;
	public $Status = "";
	public $VacantCount = 0;
}

class FileModel {
    // property declaration
    public $FileId = "";
    public $FloorplanId = "";
	public $Type = "";
	public $Caption = "";
    public $Src = "";
	public $Width = 0;
	public $Height = 0;
	
}
class FloorModel {
	public $Id = "";
	public $Code = "";
	public $Name = "";
}

class PagerModel {
	public $searchQuery = "";
	public $totalPages = 0;
	public $totalRows = 0;
	public $pageSize = 0;
	public $pageNum = 0;
	public $prevPage = 0;
	public $nextPage = 0;
	public $showPrev = FALSE;
	public $showNext = FALSE;
	public $startNum = 0;
	public $endNum = 0;
	public $results = array();
	public function __construct($rows,$page,$perpage,$total){
		$this->results=$rows;
		$this->pageNum=$page;
		$this->pageSize=$perpage;
		$this->totalRows=$total;
		// Calculate the rest
		$this->totalPages = ((int)($this->totalRows / $this->pageSize) + 1);
		$this->startNum = ($page-1) * $perpage;
		
		$this->nextPage=$page+1;
		$this->prevPage=$page-1;
		$this->showPrev = $this->startNum > 0;
		$this->showNext = $this->totalRows > ($this->startNum + $this->pageSize);
		$this->getEndNum();
	}
	public function hasNextPage() {
		return $this->totalRows > ($this->startNum + $this->pageSize);
	}

	public function hasPreviousPage() {
		return $this->startNum > 0;
	}

	public function getPageCount() {
		$this->totalPages = ($this->totalRows / $this->pageSize) + 1;
		return $this->totalPages;
	}

	public function getStartNum() {
		$this->startNum += 1;
		return $this->startNum;
	}

	public function getEndNum() {
		$this->endNum = $this->startNum + $this->pageSize;
		$this->endNum = min($this->endNum, $this->totalRows);
		return $this->endNum;
	}
}

?>
