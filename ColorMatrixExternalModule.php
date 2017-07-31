<?php namespace ExternalModules;

class ColorMatrixExternalModule extends AbstractExternalModule
{
    function hook_survey_page_top($project_id, $record, $instrument) {
		$this->colorMatrix($project_id, $record, $instrument);
	}

    function hook_data_entry_form_top($project_id, $record, $instrument) {
		$this->colorMatrix($project_id, $record, $instrument);
	}

	function colorMatrix($project_id, $record, $instrument) {
		$mtxgrp = $this->getProjectSetting("matrix-group", $project_id);
		$labelColor = $this->getProjectSetting("label-color", $project_id);
		$colColor = $this->getProjectSetting("column-color", $project_id);
		if (!is_array($colColor)) {
			$colColor = array($colColor);
		}
		echo "<script>
			function colorMatrix(mtxgrp) {
				$('tr').each(function() {
					if ($(this).attr('mtxgrp') == mtxgrp) {
						var labelColor = '".$labelColor."';
						var colColor = ".json_encode($colColor).";
						if (labelColor) {
							$(this).find('td.labelmatrix').css({ 'background-color': labelColor });
						}
						$(this).find('td.choicematrix').each(function(index, elem) {
							if ((colColor.length > index) && colColor[index]) {
								$(elem).css({ 'background-color': colColor[index] });
							}
						});
					}
				});
			}
			window.onload = function() { colorMatrix('".$mtxgrp."'); };
			</script>";
	}
}
