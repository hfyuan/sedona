<?php
include_once('model-floorplans.php');

class FloorplanService {
    // property declaration
	public $_floorList;
	public $_floorplanDB;
	public $_fileDB;
	public $_unitDB;
	

	public function readFloorList($xml) {
		$floorList = array();
		$index = 0;
		$idSet = array();
		
		foreach ($xml->xpath("/PhysicalProperty/Property/Unit/Amenities/*[substring(name(),string-length(name()) - 4) =  'Floor']") as $floor) {
			$floorId = $floor->getName();
			
			if (!in_array($floorId, $idSet, true)) {
				$f = new FloorModel();
				$f->Id = $floorId;
				$f->Code = $this->readFloorCode($floorId);
				$f->Name = $this->readFloorName($floorId);
				
				$floorList[$floorId] = $f;
				$idSet[$index] = $floorId;
				$index++;
			}
			
		}
		// Identify units with *PenthouseApt element
		foreach ($xml->xpath("/PhysicalProperty/Property/Unit/Amenities/*[substring(name(),string-length(name()) - 11) =  'PenthouseApt']") as $floor) 	
		{
			$floorId = "Penthouse";
			
			if (!in_array($floorId, $idSet, true)) {
				$f = new FloorModel();
				$f->Id = $floorId;
				$f->Code = $this->readFloorCode($floorId);
				$f->Name = $this->readFloorName($floorId);
				
				$floorList[$floorId] = $f;
				$idSet[$index] = $floorId;
				$index++;
			}
		}
		$this->_floorList = $floorList;
		return $floorList;
	}
	public function loadFileDB($xml) {
		$fileDB = array();
		
		foreach ($xml->Property->File as $file) {
			
			if ($file->Type == "floorplan") {
				$fileId = (string) $file->attributes()->id;
				$floorplanId = (string) $file->attributes()->FloorplanID;
				$f = new FileModel();
				$f->FileId = $fileId;
				$f->FloorplanId = $floorplanId;
				$f->Type = $file->Type;
				$f->Caption = $file->Caption;
				$f->Src = $file->Src;
				$f->Width = (int) $file->Width;
				$f->Height = (int) $file->Height;
				$fileDB[$floorplanId] = $f;
			}
		}
		$this->_fileDB = $fileDB;
		return $fileDB;
	}

	public function loadFloorplanDB($xml) {
		$floorplanDB = array();
		
		foreach ($xml->Property->Floorplan as $fp) {
			$f = new FloorplanModel();
			$f->FloorplanId = $fp->attributes()->id ;
			$f->Name = $fp->Name;
			$f->Comment = $fp->Comment;
			$f->Rank = (int) $fp->Rank;
			$f->MarketRentMin = (int) $fp->MarketRent->attributes()->min;
			$f->MarketRentMax = (int) $fp->MarketRent->attributes()->max;
			$f->SquareFeetMin = (int) $fp->SquareFeet->attributes()->min;
			$f->SquareFeetMax = (int) $fp->SquareFeet->attributes()->max;
			
			$bedroom = $fp->xpath("Room[@type='bedroom']");
			if ($bedroom && $bedroom[0]->Count) {
				$f->BedroomCount = (int)$bedroom[0]->Count;
			}
			$bathroom = $fp->xpath("Room[@type='bathroom']");
			if ($bathroom && $bathroom[0]->Count) {
				$f->BathroomCount = (int)$bathroom[0]->Count;
			}
			$fpid = (string) $f->FloorplanId;
			
			$file = $this->_fileDB[$fpid];
			if ($file) {
				$f->ImageSrc = $file->Src;
				$f->ImageWidth = $file->Width;
				$f->ImageHeight = $file->Height;
			}
			$floorplanDB[$fpid] = $f;
		}
		$this->_floorplanDB = $floorplanDB;
		return $floorplanDB;
	}

	
	public function loadUnitDB($xml) {
		$unitDB = array();
		$dateformat = "%s-%s-%s";
		
		foreach ($xml->Property->Unit as $unit) {
			$unitId = (string) $unit->attributes()->id;
			$u = new UnitModel();
			
			$u->UnitId = $unitId;
			
			$floorplanId = (string) $unit->attributes()->FloorplanID;
			
			if ($floorplanId == "") {
				continue;
			}
			$u->FloorplanId = $floorplanId;
			// echo $u->FloorplanId . " /// ";
			
			$u->SquareFeet = (int) $unit->SquareFeet;
			$u->MarketRentMin = (int) $unit->MarketRent->attributes()->min;
			$u->MarketRentMax = (int) $unit->MarketRent->attributes()->max;
			$u->EffectiveRentMin = (int) $unit->EffectiveRent->attributes()->min;
			$u->EffectiveRentMax = (int) $unit->EffectiveRent->attributes()->max;
			
			$vacancy = $unit->Availability->VacancyClass;
			if ($vacancy == "Unoccupied") {
				$u->IsAvailable = TRUE;
			} else {
				$u->IsAvailable = FALSE;
			}
			
			if ($unit->Amenities->Den) {
				$u->HasDen = TRUE;
			} else {
				$u->HasDen = FALSE;
			}
			$year = $unit->Availability->MadeReadyDate->year;
			$month = $unit->Availability->MadeReadyDate->month;
			$day = $unit->Availability->MadeReadyDate->day;
			 
			$u->AvailableDate = sprintf($dateformat, year, month, day);
			
			$fp = $this->_floorplanDB[$floorplanId];
			
			if ($fp) {
				// echo sprintf($dateformat, $fp->Name, $fp->BedroomCount, $fp->BathroomCount);
				$u->FloorplanName = $fp->Name;
				$u->BedroomCount = $fp->BedroomCount;
				$u->BathroomCount = $fp->BathroomCount;
			}
			$floorNode = $unit->xpath("Amenities/*[substring(name(),string-length(name()) - 4) =  'Floor']");
			$floorId = "";
			if ($floorNode) {
				$floorId = (string) $floorNode[0]->getName();
				
			} else {
				$floorNode = $unit->xpath("Amenities/*[substring(name(),string-length(name()) - 11) =  'PenthouseApt']");
				if ($floorNode) {
					$floorId = "Penthouse";
					// $floorId = $floorNode->getName();
				} 
			}
			
			$fl = $this->_floorList[$floorId];
			
			if ($fl) {
				$u->FloorId = $fl->Id;
				$u->FloorCode = $fl->Code;
				$u->FloorName = $fl->Name;
			}
			// $this->_unitDB = $unitDB;
			
			$unitDB[$unitId] = $u;
		}
		return $unitDB;
	}
	public function readFloorName($floorId) {
		// $pattern = '/^a\w+Floor$/';
		$name = "";
		$result = "";
		if (preg_match("/^a\w+Floor$/", $floorId)) {
			$name = substr($floorId, 1);
		} else if (preg_match("/^\w+PenthouseApt$/", $floorId)) {
			$name = "Penthouse";
		} else {
			$name = $floorId;
		}
		$pos = strrpos($name, "Floor");
		if ($pos > -1) {
			$key = substr($name, 0, $pos);
			$result = $key . " Floor";
		} else {
			$result = $name;
		}
		return $result;
	}
	public function readFloorCode($floorId) {
		$code = "";
		
		if (preg_match("/^\w*Penthouse$/", $floorId)) {
			$code = "PH";
		} else if (preg_match("/^GroundFloor$/", $floorId)) {
			$code = "G";
		} else if (preg_match("/^a\w+Floor$/", $floorId)) {
			$code = substr($floorId, 1);
			// Strip off everything after the number
			// http://hungred.com/how-to/regular-expression-find-position-strpos-stripos-php/
			if (preg_match("/[A-Za-z]/", $code, $matches, PREG_OFFSET_CAPTURE)) {
				$pos = $matches[0][1];
				$code = substr($code, 0, $pos);
			}
		} else {
			$code = $floorId;
		}
		return $code;
	}
	public function lookupFloorplanByCode($code) {
		
		foreach ($floorList as $f) {
			if ($f->Code == $code) {
				return $f;
			}
		}
		return null;
	}
	
	public function XXXXXX_SEARCH_FUNCTIONS_XXXXXX() {}
		
	public function filterByFloor($unitList, $code) {
		$results = array();
		
		if ($code == "all") {
			return $unitList;
		}
		foreach ($unitList as $u) {
			if ($u->FloorCode == $code) {
				
				array_push($results, $u);
			} else {
				// var_dump($u);
				// echo "No match " . $u->FloorCode . " vs. " . $code;
			}
		}
		return $results;
	}

	public function filterByVacancy($unitList) {
		$results = array();
		
		foreach ($unitList as $u) {
			if ($u->IsAvailable) {
				array_push($results, $u);
			}
		}
		return $results;
	}

	public function filterByBedrooms($unitList, $picks) {
		$results = array();
		
		foreach ($unitList as $u) {
			foreach ($picks as $pick) {
				// echo "<br>br count = " . $u->BedroomCount . " // " . $pick;
				switch($pick)
				{
					
				    case '2br';
						if ($u->BedroomCount == 2) {
							array_push($results, $u);
						}
						break;
				    case '1br_den';
						if ($u->BedroomCount == 1 && $u->HasDen) {
							array_push($results, $u);
						}
						break;
				    case '1br';
						if ($u->BedroomCount == 1) {
							array_push($results, $u);
						}
						break;
				    case 'studio';
						if ($u->BedroomCount == 0) {
							array_push($results, $u);
						}
						break;
				    default;
						// echo "unknown: " . $pick;
				    break;
				}
			}
		}
		return $results;
	}
	public function filterByPriceRange($unitList, $minPrice, $maxPrice) {
		$results = array();
		// echo $minPrice . " // " . $maxPrice;
		$logfmt = "min=%d // max=%d // rentMin=%d // rentMax=%d <br>";
		foreach ($unitList as $u) {
			// echo "EVAL:" . sprintf($logfmt, $minPrice, $maxPrice, $u->MarketRentMin, $u->MarketRentMax);
			if ($minPrice <= $u->MarketRentMin && $maxPrice >= $u->MarketRentMax ) {
				// echo "OK:" . sprintf($logfmt, $minPrice, $maxPrice, $u->MarketRentMin, $u->MarketRentMax);
				array_push($results, $u);
			} else {
				// echo "IGNORE:" . sprintf($logfmt, $minPrice, $maxPrice, $u->MarketRentMin, $u->MarketRentMax);
				
			}
		}
		return $results;
	}

	public function buildFloorplanResults($unitList) {
		$fpList = array();
		// echo "unitList count = " . count($unitList);
		foreach ($unitList as $u) {
			if (!array_key_exists($u->FloorplanId, $fpList)) {
				$fp = $this->_floorplanDB[$u->FloorplanId];
				if ($fp) {
					// echo "<br>Found floorplan: " . $fp->Name;
					$fpList[$u->FloorplanId] = $fp;
				} else {
					// echo "Floorplan not found: " . $u->FloorplanId;
				}
				
				if ($u->IsAvailable) {
					$fpList[$u->FloorplanId]->VacantCount += 1;
					// echo "Increment vacant count: " . $fpList[$u->FloorplanId]->VacantCount;
				}
				// OVERRIDE PRICES RANGES IN FLOORPLAN DATA BASED ON ACTUALS
				if ($u->MarketRentMin < $fpList[$u->FloorplanId]->MarketRentMin) {
					$fpList[$u->FloorplanId]->MarketRentMin = $u->MarketRentMin;
				}
				if ($u->MarketRentMax > $fpList[$u->FloorplanId]->MarketRentMax) {
					$fpList[$u->FloorplanId]->MarketRentMax = $u->MarketRentMax;
				}
				
				
			} else {
				// echo "Ignore floorplan<br>";
			}
			
		}
		return $fpList;
	}
	
}
?>
