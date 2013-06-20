<?php
/*
Template Name: Floorplans
*/
?>
<?php

include_once('model-floorplans.php');
include_once('service-floorplans.php');

// Convert floorId values into friendly display values
	function readFloorName($floorId) {
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
	$DEFAULT_PAGE_SIZE = 6;
	
	$curpath = dirname(__FILE__);
	$file = $curpath . '/data/properties.xml';
	$floorList = array();
	$floorFormat = "%s = %s";
	$optionFormat = "<option value='%s'>%s</option>\n";
	$index = 0;
	$floorplanDB = array();
	$fileDB = array();
	$unitDB = array();
	
	$unitResults = array();
	$fpResults = array();
	$pageResults = array();
	
	$debugFormat = "%s -- %s\n";
	$fpService = new FloorplanService();
	$qsArray = array();
	$qs = "";
	$qs = $_SERVER['QUERY_STRING'];
	$xpos = strpos($qs, "&x=");
	if ($xpos > -1) {
		$qs = substr($qs, 0, $xpos);
	}
	$page = 1;
	$count = 12;
	
	if (file_exists($file)) {
		
		$xml = wp_cache_get("sedona_properties_xml", $found = null);
		
		if ($found == true) {
			echo "Loading from cache";
		} else {
			echo "Loading from xml file";
			$xml = simplexml_load_file($file); 
			wp_cache_set("sedona_properties_xml", $xml);
		}
		// echo "floor count = " . count($floorList);
		// $floorList = wp_cache_get("sedona_floorList");
		// if (isset($_SESSION['floorList'])) {
		// 	echo "Loading from Session";
		// 	$floorList = $_SESSION['floorList'];
		// } else {
		// 	echo "Loading from XML";
		// 	$_SESSION['floorList'] = $floorList;
		// }
		$floorList = $fpService->readFloorList($xml);
		
		
		
		if (isset($_GET['vacant']) || isset($_GET['floor']) || isset($_GET['priceRange']) || isset($_GET['bedrooms'])  ) {
			
			if (isset($_GET['x'])) {
 				$page =  $_GET['x'];
			}
			$pCount = $_GET['count'];
			
			$fileDB = $fpService->loadFileDB($xml);
			// echo "file count = " . count($fileDB);

			$floorplanDB = $fpService->loadFloorplanDB($xml);
			// echo "floorplan count = " . count($floorplanDB);
			
			$unitDB = $fpService->loadUnitDB($xml);
			// echo "unit count = " . count($unitDB);
			
			$unitResults = $unitDB;

			$pVacant = $_GET['vacant'];
			if ($pVacant && $pVacant == "on") {
				$unitResults = $fpService->filterByVacancy($unitResults);
			}

			$pFloor = $_GET['floor'];			
			if ($pFloor && $pFloor != "all") {
				$unitResults = $fpService->filterByFloor($unitResults, $pFloor);
			}
			
			$pBedrooms = $_GET['bedrooms'];
			if (!isset($pBedrooms)) {
				$pBedrooms = array();
			}
			for ($i=0; $i<count($pBedrooms); $i++) {
				$unitResults = $fpService->filterByBedrooms($unitResults, $pBedrooms);
			}
			
			$pPrice = $_GET['priceRange'];
			if ($pPrice && $pPrice != "") {
				
				$values = split("-", $pPrice);
				$minPrice = intval((string) $values[0]);
				$maxPrice = intval((string) $values[1]);
				$unitResults = $fpService->filterByPriceRange($unitResults, $minPrice, $maxPrice);
			}
			
			$fpResults = $fpService->buildFloorplanResults($unitResults);
			$start = ($page - 1) * $DEFAULT_PAGE_SIZE;
			// $rows,$start,$perpage,$total
			$num = min(count($fpResults) - $start, $DEFAULT_PAGE_SIZE);

			$pageResults = array_slice($fpResults, $start, $num);
			
			$pager = new PagerModel($pageResults, $page, $DEFAULT_PAGE_SIZE, count($fpResults));
			$pagerdebug = "totalRows=%d totalPages=%d start=%d num=%d rowcount=%d";
			echo sprintf($pagerdebug, $pager->totalRows, $pager->totalPages, $start, $num, count($pageResults));
		}
		
		
	} else {
		$msg = "file not found: " . $file;
		echo "<p>" . $msg . "</p>";
		
	}	
?>
<?php get_header(); ?>
			
<div id="content">

	<?php get_sidebar(); // sidebar 1 ?>

	<div class="span10">

		<section id="grabcontent">
			<?php the_content(); ?>
			
			<div id="search-form-wrapper" class='container'>
				<form method='GET' enctype='multipart/form-data'  id='search-form'  action='floorplans-beta'>
					<div class='form_heading'>
					    <h2>Search</h2>
					</div>
					<div class="span3">
						<label class='search-field-label' for='priceRangeOptions'>PRICE RANGE</label>
						<select id="priceRangeOptions" name="priceRange">
							<option value="">Select range</option>
							<option value="1500-2000">$1,500 to $2,000</option>
							<option value="2000-2500">$2,000 to $2,500</option>
							<option value="2500-3000">$2,500 to $3,000</option>
							<option value="3000-3500">$3,000 to $3,500</option>
							<option value="3500-4000">$3,500 to $4,000</option>
						</select>
						<div class="vspace" style="height:30px;"></div>
						<label class='search-field-label'>AVAILABILITY</label>
						<label class="checkbox">
							<input type="checkbox" name="vacant" id="vacantOption"> SEE AVAILABLE UNITS ONLY
						</label>
					</div>
					<div class="span3">
						<label class='search-field-label' for='floorOptions'>Floor Number</label>
						<select id="floorOptions" name="floor">
							<option value="all">All Floors</option>
							<?php
							foreach ($floorList as $floor) {
								$optionNode = sprintf($optionFormat, $floor->Code, $floor->Name);
								echo $optionNode;
							}
							?>
						</select>
					</div>
					<div class="span3" style="min-width:250px;">
						
						<label class='search-field-label'>BEDROOMS</label>
						<fieldset>
							<label class="checkbox">
								<input id="ck-studio" type="checkbox" name="bedrooms[]" value="studio"> STUDIO
							</label>
							<label class="checkbox">
								<input id="ck-1br" type="checkbox" name="bedrooms[]" value="1br"> ONE BEDROOM
							</label>
							<label class="checkbox">
								<input id="ck-1br_den" type="checkbox" name="bedrooms[]" value="1br_den"> ONE BEDROOM + DEN
							</label>
							<label class="checkbox">
								<input id="ck-2br" type="checkbox" name="bedrooms[]" value="2br"> TWO BEDROOM
							</label>
						</fieldset>

					</div>
					
					<div class="span9">
						<div class="vspace" style="height:30px;"></div>
						<p style="text-align:left;"><input class="btn btn-primary" type='submit' value='Search' style="width:150px;" /></p>
					</div>
				</form>
			</div>

			<div id="search-results" class="container">
				<ul class="thumbnails" style="width:840px;">
					<?php
					foreach ($pageResults as $fp) {
					?>
					<li class="span3" style="height:400px; overflow:hidden;">
						<div class="grid-cell" style="height:400px;">
							<img src="<?php echo $fp->ImageSrc ?>"  alt="floorplan" style="width:240px;"/>
							<div class="grid-copy">
							<h3 class="fp-title"><?php echo $fp->Name ?></h3>
							<p><?php echo $fp->BedroomCount ?> bed / <?php echo $fp->BathroomCount ?> baths</p>
							<p><?php echo $fp->SquareFeetMin ?> Sq. Ft.</p>
							<p><?php
							if ($fp->VacantCount > 0) {
								echo $fp->VacantCount . " AVAILABLE";
							} else {
								echo "UNAVAILABLE";
							}
							?></p>
							<p class="fp-price">$
							<?php
								if ($fp->MarketRentMin == $fp->MarketRentMax) {
									echo $fp->MarketRentMin;
								} else {
									echo $fp->MarketRentMin . " - " . $fp->MarketRentMax;
								}
							?></p>
							<div class="vspace" style="height:30px;"></div>
							</div>
						</div>
					</li>
					<?php
					}
					?>
				</ul>
			</div>
				<div class="pagination">
					<ul>
						<?php 
							$linkformat = "<li class='%s'><a href='?%s&x=%s'>%s</a></li>";
							if ($pager->showPrev) {
								$link = sprintf($linkformat, "prevlink", $qs, $pager->pageNum-1, "&laquo;");
								echo $link;
							}
						?>
						<?php
							foreach (range(1, $pager->totalPages) as $number) {
								if ($pager->pageNum == $number) {
									$link = sprintf($linkformat, "active", $qs, $number, $number);
								} else {
									$link = sprintf($linkformat, "other", $qs, $number, $number);
								}
								echo $link;
							}
 						?>
						<?php 
							if ($pager->showNext) {
								$link = sprintf($linkformat, "nextlink", $qs, $pager->pageNum+1, "&raquo;");
								echo $link;
							}
						?>
					</ul>
				</div>

		</section>
		
	</div> <!-- end #span10 -->

</div> <!-- end #content -->
<script type="text/javascript" charset="utf-8">
jQuery(document).ready(function() {
	jQuery("#priceRangeOptions").val("<?php echo $pPrice ?>");
	jQuery("#floorOptions").val("<?php echo $pFloor ?>");
	<?php if ($pVacant == "on") { ?>
		jQuery("#vacantOption").prop('checked', true);
	<?php } ?>
	<?php
		if (in_array("studio", $pBedrooms, true)) {
			echo "jQuery('#ck-studio').prop('checked', true);";
		}
		if (in_array("1br", $pBedrooms, true)) {
			echo "jQuery('#ck-1br').prop('checked', true);";
		}
		if (in_array("1br_den", $pBedrooms, true)) {
			echo "jQuery('#ck-1br_den').prop('checked', true);";
		}
		if (in_array("2br", $pBedrooms, true)) {
			echo "jQuery('#ck-2br').prop('checked', true);";
		}
	?>
});
</script>

<?php get_footer(); ?>
