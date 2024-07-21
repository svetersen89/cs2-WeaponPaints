<!DOCTYPE html>
<html lang="en">
<!-- ======= Header ======= -->
<?php include "./pages/header.php"; ?>

<body>
	<?php		
		if(isset($_GET['type']))
		{
			$type = $_GET["type"]; 
		}
		else 
		{
			$type = ''; 
		}
	?>

	<!-- <button type="button" class="btn btn-success" onclick="this.form.submit()">Refresh</button> -->
	<?php
		
		if ($type == '' || $type == "knives")
		{
			echo '<div class="col-sm-2">';
			echo '	<div class="card text-center mb-3 border border-primary">';
			echo '		<div class="card-body">';
						$actualKnife = $knifes[0];
						if ($selectedKnife != null)
						{
							foreach ($knifes as $knife) {
								if ($selectedKnife[0]['knife'] == $knife['weapon_name']) {
									$actualKnife = $knife;
									break;
								}
							}
						}

						echo "<div class='card-header'>";
						echo "<h6 class='card-title item-name'>Knife type</h6>";
						echo "<h5 class='card-title item-name'>{$actualKnife["paint_name"]}</h5>";
						echo "</div>";
						echo "<img src='{$actualKnife["image_url"]}' class='skin-image'>";
			echo '	</div>';
			echo '		<div class="card-footer">';
			echo '			<form action="" method="POST">';
			echo '				<select name="forma" class="form-control select" onchange="this.form.submit()" class="SelectWeapon">';
			echo '					<option disabled>Select knife</option>';
								foreach ($knifes as $knifeKey => $knife) {
									if ($selectedKnife[0]['knife'] == $knife['weapon_name'])
										echo "<option selected value=\"knife-{$knifeKey}\">{$knife['paint_name']}</option>";
									else
										echo "<option value=\"knife-{$knifeKey}\">{$knife['paint_name']}</option>";
								}
							echo '</select>';
						echo '</form>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
		}
		
		if ($type == '' || $type == 'gloves')
		{
			echo '<div class="col-sm-2">';
				echo '<div class="card text-center mb-3 border border-primary">';
					echo '<div class="card-body">';
						$actualGlove = $gloves[0];
						if ($selectedGloves != null)
						{
							foreach ($gloves as $glove) {
								if ($selectedGloves[0]['weapon_defindex'] == $glove['weapon_name']) {
									$actualGlove = $glove;
									$defindex = $selectedGloves[0]['weapon_defindex']; 
									break;
								}
							}
						}

						echo "<div class='card-header'>";
						echo "<h6 class='card-title item-name'>Selected Gloves</h6>";
						echo "<h5 class='card-title item-name'>{$actualGlove["paint_name"]}</h5>";
						echo "</div>";
						echo "<img src='{$skins[$defindex][$selectedSkins[$defindex]['weapon_paint_id']]['image_url']}' class='skin-image'>";

					echo '</div>';
					echo '<div class="card-footer">';
						echo '<form action="" method="POST">';
							echo '<select name="forma" class="form-control select" onchange="this.form.submit()" class="SelectWeapon">';
								echo '<option disabled>Select gloves</option>';
								foreach ($gloves as $gloveKey => $glove) {
									if ($selectedGloves[0]['weapon_defindex'] == $glove['weapon_name'])
										echo "<option selected value=\"glove-{$gloveKey}\">{$glove['paint_name']}</option>";
									else
										echo "<option value=\"glove-{$gloveKey}\">{$glove['paint_name']}</option>";
								}
							echo '</select>';
						echo '</form>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
		}		
		
		foreach ($weapons as $defindex => $default) { 
			if ($type == '' 
				|| ($type == 'weapons' 
				&& !array_key_exists($defindex, $knifes) 
				&& !array_key_exists($defindex, $gloves))
				|| ($type == 'knives' 
				&& array_key_exists($defindex, $knifes)) 
				|| ($type == 'gloves' 
				&& array_key_exists($defindex, $gloves)))
			{		
			?>
			<div class="col-sm-2">
				<div class="card text-center mb-3">
					<div class="card-body">
						<?php
						if (array_key_exists($defindex, $selectedSkins) && array_key_exists($defindex, $skins)) {
							echo "<div class='card-header'>";
							$skinName = $skins[$defindex][$selectedSkins[$defindex]['weapon_paint_id']]["paint_name"]; 
							
							if (strLen($skinName) < 26)
							{								
								echo "<h5 class='card-title item-name'>{$skinName}<br><br></h5>";
							}
							else 
							{
								echo "<h5 class='card-title item-name'>{$skinName}</h5>";
							}
							
							echo "</div>";
							$imgSrc = $skins[$defindex][$selectedSkins[$defindex]['weapon_paint_id']]['image_url']; 
							if ($imgSrc != '')
							{
								echo "<img src='{$imgSrc}' class='skin-image'>";
							}
							else 
							{								
								echo "<img src='{$default["image_url"]}' class='skin-image'>";
							}
						} else {
							echo "<div class='card-header'>";
							
							$skinName = $default["paint_name"]; 
							
							if (strLen($skinName) < 26)
							{								
								echo "<h5 class='card-title item-name'>{$skinName}<br><br></h5>";
							}
							else 
							{
								echo "<h5 class='card-title item-name'>{$skinName}</h5>";
							}
							echo "</div>";
							echo "<img src='{$default["image_url"]}' class='skin-image'>";
						}
						?>
					</div>
					<div class="card-footer">
						<form action="" method="POST">
							<select name="forma" class="form-control select" onchange="this.form.submit()" class="SelectWeapon">
								<option disabled>Select skin</option>
								<?php
								foreach ($skins[$defindex] as $paintKey => $paint) {
									if (array_key_exists($defindex, $selectedSkins) && $selectedSkins[$defindex]['weapon_paint_id'] == $paintKey)
										echo "<option selected value=\"{$defindex}-{$paintKey}\">{$paint['paint_name']}</option>";
									else
										echo "<option value=\"{$defindex}-{$paintKey}\">{$paint['paint_name']}</option>";
								}
								?>
							</select>
							<br></br>
							<?php
							$selectedSkinInfo = isset($selectedSkins[$defindex]) ? $selectedSkins[$defindex] : null;
							$steamid = $_SESSION['steamid'];

							if ($selectedSkinInfo) :
							?>
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#weaponModal<?php echo $defindex ?>">
									Settings
								</button>
							<?php else : ?>
								<button type="button" class="btn btn-primary" onclick="showSkinSelectionAlert()">
									Settings
								</button>
								<script>
									function showSkinSelectionAlert() {
										alert("You need to select a skin first.");
									}
								</script>
							<?php endif; ?>

					</div>

					<?php
					// wear value 
					$selectedSkinInfo = isset($selectedSkins[$defindex]['weapon_paint_id']) ? $selectedSkins[$defindex] : null;
					$queryWear = $selectedSkins[$defindex]['weapon_wear'] ?? 1.0;
					$initialWearValue = isset($selectedSkinInfo['weapon_wear']) ? $selectedSkinInfo['weapon_wear'] : (isset($queryWear[0]['weapon_wear']) ? $queryWear[0] : 0.0);

					// seed value 
					$querySeed = $selectedSkins[$defindex]['weapon_seed'] ?? 0;
					$initialSeedValue = isset($selectedSkinInfo['weapon_seed']) ? $selectedSkinInfo['weapon_seed'] : 0;

					// legacy value
					$queryLegacyValue = $selectedSkins[$defindex]['weapon_legacy'] ?? 0;
					$initialLegacyValue = isset($selectedSkinInfo['weapon_legacy']) ? $selectedSkinInfo['weapon_legacy'] : 0;
					?>


					<div class="modal fade" id="weaponModal<?php echo $defindex ?>" tabindex="-1" role="dialog" aria-labelledby="weaponModalLabel<?php echo $defindex ?>" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class='card-title item-name'>
										<?php
										if (array_key_exists($defindex, $selectedSkins)) {
											echo "{$skins[$defindex][$selectedSkins[$defindex]['weapon_paint_id']]["paint_name"]} Settings";
										} else {
											echo "{$default["paint_name"]} Settings";
										}
										?>
									</h5>
								</div>
								<div class="modal-body">
									<div class="form-group">
										<select class="form-select" id="wearSelect<?php echo $defindex ?>" name="wearSelect" onchange="updateWearValue<?php echo $defindex ?>(this.value)">
											<option disabled>Select Wear</option>
											<option value="0.00" <?php echo ($initialWearValue == 0.00) ? 'selected' : ''; ?>>Factory New</option>
											<option value="0.07" <?php echo ($initialWearValue == 0.07) ? 'selected' : ''; ?>>Minimal Wear</option>
											<option value="0.15" <?php echo ($initialWearValue == 0.15) ? 'selected' : ''; ?>>Field-Tested</option>
											<option value="0.38" <?php echo ($initialWearValue == 0.38) ? 'selected' : ''; ?>>Well-Worn</option>
											<option value="0.45" <?php echo ($initialWearValue == 0.45) ? 'selected' : ''; ?>>Battle-Scarred</option>
										</select>

									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="wear">Wear:</label>
												<input type="text" value="<?php echo $initialWearValue; ?>" class="form-control" id="wear<?php echo $defindex ?>" name="wear">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="seed">Seed:</label>
												<input type="text" value="<?php echo $initialSeedValue; ?>" class="form-control" id="seed<?php echo $defindex ?>" name="seed" oninput="validateSeed(this)">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="legacy">Legacy:</label>
												<input type="text" value="<?php echo $initialLegacyValue; ?>" class="form-control" id="legacy<?php echo $defindex ?>" name="legacy" oninput="validateLegacy(this)">
											</div>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									<button type="submit" class="btn btn-danger">Use</button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<script>
				//  wear
				function updateWearValue<?php echo $defindex ?>(selectedValue) {
					var wearInputElement = document.getElementById("wear<?php echo $defindex ?>");
					wearInputElement.value = selectedValue;
				}

				function validateWear(inputElement) {
					inputElement.value = inputElement.value.replace(/[^0-9]/g, '');
				}
				// seed
				function validateSeed(input) {
					// Check entered value
					var inputValue = input.value.replace(/[^0-9]/g, ''); // Just get the numbers

					if (inputValue === "") {
						input.value = 0; // Set to 0 if empty or no numbers
					} else {
						var numericValue = parseInt(inputValue);
						numericValue = Math.min(1000, Math.max(1, numericValue)); // Interval control

						input.value = numericValue;
					}
				}
				// legacy
				function validateLegacy(input) {
					// Check entered value
					var inputValue = input.value;

					if (inputValue === "0" || inputValue === "1")
					{
						input.value = inputValue;
					} 
					else 
					{
						input.value = "0"; 
					}
				}
				
				function openTab(evt, tabName) {
				  // Declare all variables
				  var i, tabcontent, tablinks;

				  // Get all elements with class="tabcontent" and hide them
				  tabcontent = document.getElementsByClassName("tabcontent");
				  for (i = 0; i < tabcontent.length; i++) {
					tabcontent[i].style.display = "none";
				  }

				  // Get all elements with class="tablinks" and remove the class "active"
				  tablinks = document.getElementsByClassName("tablinks");
				  for (i = 0; i < tablinks.length; i++) {
					tablinks[i].className = tablinks[i].className.replace(" active", "");
				  }

				  // Show the current tab, and add an "active" class to the button that opened the tab
				  document.getElementById(tabName).style.display = "block";
				  evt.currentTarget.className += " active";
				}
			</script>
		<?php } ?>
	<?php } ?>
	</div>
	</div>
	<!-- ======= footer ======= -->
	<?php include "./pages/footer.php"; ?>
</body>

</html>
