<!-- main body -->
<div id="main" class="clearingfix">
	<div id="mainmiddle" class="floatbox">
	
	<?php if($site_message != '') { ?>
		<div class="green-box">
			<h3><?php echo $site_message; ?></h3>
		</div>
	<?php } ?>
		
		<!-- category filters -->
		<div class="sidebar">
			<div class="cat-filters clearingfix">
				<strong><?php echo Kohana::lang('ui_main.category_filter');?> <span>[<a href="javascript:toggleLayer('category_switch_link', 'category_switch')" id="category_switch_link"><?php echo Kohana::lang('ui_main.hide'); ?></a>]</span></strong>
			</div>
			<ul id="category_switch" class="category-filters">
				<?php
				$color_css = 'class="swatch" style="background-color:#'.$default_map_all.'"';
				$all_cat_image = '';
				if($default_map_all_icon != NULL) {
					$all_cat_image = html::image(array(
						'src'=>$default_map_all_icon,
						'style'=>'float:left;padding-right:5px;'
					));
					$color_css = '';
				}
				?>
				<li><a class="active" id="cat_0" href="#"><span <?php echo $color_css;?>><?php echo $all_cat_image; ?></span><span class="category-title"><?php echo Kohana::lang('ui_main.all_categories');?></span></a></li>
				<?php
					foreach ($categories as $category => $category_info)
					{
						$category_title = $category_info[0];
						$category_color = $category_info[1];
						$category_image = ($category_info[2] != NULL) ? url::convert_uploaded_to_abs($category_info[2]) : NULL;
						$color_css = 'class="swatch" style="background-color:#'.$category_color.'"';
						if($category_info[2] != NULL) {
							$category_image = html::image(array(
								'src'=>$category_image,
								'style'=>'float:left;padding-right:5px;'
								));
							$color_css = '';
						}
						echo '<li><a href="#" id="cat_'. $category .'"><span '.$color_css.'>'.$category_image.'</span><span class="category-title">'.$category_title.'</span></a>';
						// Get Children
						echo '<div class="hide" id="child_'. $category .'">';
												if( sizeof($category_info[3]) != 0)
												{
													echo '<ul>';
													foreach ($category_info[3] as $child => $child_info)
													{
															$child_title = $child_info[0];
															$child_color = $child_info[1];
															$child_image = ($child_info[2] != NULL) ? url::convert_uploaded_to_abs($child_info[2]) : NULL;
															$color_css = 'class="swatch" style="background-color:#'.$child_color.'"';
															if($child_info[2] != NULL) {
																	$child_image = html::image(array(
																			'src'=>$child_image,
																			'style'=>'float:left;padding-right:5px;'
																			));
																	$color_css = '';
															}
															echo '<li style="padding-left:20px;"><a href="#" id="cat_'. $child .'"><span '.$color_css.'>'.$child_image.'</span><span class="category-title">'.$child_title.'</span></a></li>';
													}
													echo '</ul>';
												}
						echo '</div></li>';
					}
				?>
			</ul>
			
			<?php
			if ($layers)
			{
				?>
				<!-- Layers (KML/KMZ) -->
				<div class="cat-filters clearingfix" style="margin-top:20px;">
					<strong><?php echo Kohana::lang('ui_main.layers_filter');?> <span>[<a href="javascript:toggleLayer('kml_switch_link', 'kml_switch')" id="kml_switch_link"><?php echo Kohana::lang('ui_main.hide'); ?></a>]</span></strong>
				</div>
				<ul id="kml_switch" class="category-filters">
					<?php
					foreach ($layers as $layer => $layer_info)
					{
						$layer_name = $layer_info[0];
						$layer_color = $layer_info[1];
						$layer_url = $layer_info[2];
						$layer_file = $layer_info[3];
						$layer_link = (!$layer_url) ?
							url::base().Kohana::config('upload.relative_directory').'/'.$layer_file :
							$layer_url;
						echo '<li><a href="#" id="layer_'. $layer .'"
						onclick="switchLayer(\''.$layer.'\',\''.$layer_link.'\',\''.$layer_color.'\'); return false;"><div class="swatch" style="background-color:#'.$layer_color.'"></div>
						<div>'.$layer_name.'</div></a></li>';
					}
					?>
				</ul>
				<!-- /Layers -->
			<?php
			}
			?>
			<br />
			<!-- additional content -->
			<?php
			if (Kohana::config('settings.allow_reports'))
			{
				?>
				<div class="additional-content">
					<h5><?php echo Kohana::lang('ui_main.how_to_report'); ?></h5>

					<div>

						<!-- Phone -->
						<?php if (!empty($phone_array)) { ?>
						<div style="margin-bottom:10px;">
							<?php echo Kohana::lang('ui_main.report_option_1'); ?>
							<?php foreach ($phone_array as $phone) { ?>
								<strong><?php echo $phone; ?></strong>
								<?php if ($phone != end($phone_array)) { ?>
									 <br/>
								<?php } ?>
							<?php } ?>
						</div>
						<?php } ?>
						
						<!-- External Apps -->
						<?php if (count($external_apps) > 0) { ?>
						<div style="margin-bottom:10px;">
							<strong><?php echo Kohana::lang('ui_main.report_option_external_apps'); ?>:</strong><br/>
							<?php foreach ($external_apps as $app) { ?>
								<a href="<?php echo $app->url; ?>"><?php echo $app->name; ?></a><br/>
							<?php } ?>
						</div>
						<?php } ?>

						<!-- Email -->
						<?php if (!empty($report_email)) { ?>
						<div style="margin-bottom:10px;">
							<strong><?php echo Kohana::lang('ui_main.report_option_2'); ?>:</strong><br/>
							<a href="mailto:<?php echo $report_email?>"><?php echo $report_email?></a>
						</div>
						<?php } ?>

						<!-- Twitter -->
						<?php if (!empty($twitter_hashtag_array)) { ?>
						<div style="margin-bottom:10px;">
							<strong><?php echo Kohana::lang('ui_main.report_option_3'); ?>:</strong><br/>
							<?php foreach ($twitter_hashtag_array as $twitter_hashtag) { ?>
								<span>#<?php echo $twitter_hashtag; ?></span>
								<?php if ($twitter_hashtag != end($twitter_hashtag_array)) { ?>
									<br />
								<?php } ?>
							<?php } ?>
						</div>
						<?php } ?>

						<!-- Web Form -->
						<div style="margin-bottom:10px;">
							<a href="<?php echo url::site() . 'reports/submit/'; ?>"><?php echo Kohana::lang('ui_main.report_option_4'); ?></a>
						</div>

					</div>

				</div>
			<?php } ?>
			<!-- / additional content -->
		</div>
		<!-- / category filters -->
		
		<!-- content column -->
		<div id="content" class="clearingfix">
			<div class="floatbox">

				<!-- filters -->
				<div class="filters clearingfix">
					<div style="width: 100%">
						<strong><?php echo Kohana::lang('ui_main.filters'); ?></strong>
						<ul>
							<li><a id="media_0" class="active" href="#"><span><?php echo Kohana::lang('ui_main.reports'); ?></span></a></li>
							<li><a id="media_4" href="#"><span><?php echo Kohana::lang('ui_main.news'); ?></span></a></li>
							<li><a id="media_1" href="#"><span><?php echo Kohana::lang('ui_main.pictures'); ?></span></a></li>
							<li><a id="media_2" href="#"><span><?php echo Kohana::lang('ui_main.video'); ?></span></a></li>
							<li><a id="media_0" href="#"><span><?php echo Kohana::lang('ui_main.all'); ?></span></a></li>
						</ul>
					</div>


					<?php
					// Action::main_filters - Add items to the main_filters
					Event::run('ushahidi_action.map_main_filters');
					?>
				</div>
				<!-- / filters -->
				

				<!-- Map -->
				<?php echo $div_map; ?>
				
				<!-- Timeline Blocks -->
				<?php	echo $div_timeline; ?>

				<div class="content-bg">

			<?php if ($site_submit_report_message != ''): ?>
				<div class="green-box" style="margin: 25px 25px 0px 25px">
					<h3><?php echo $site_submit_report_message; ?></h3>
				</div>
			<?php endif; ?>

			<!-- start report form block -->
			<?php print form::open(NULL, array('enctype' => 'multipart/form-data', 'id' => 'reportForm', 'name' => 'reportForm', 'class' => 'gen_forms')); ?>

			
			<input type="hidden" name="country_name" id="country_name" value="<?php echo $form['country_name']; ?>" />
			<input type="hidden" name="incident_zoom" id="incident_zoom" value="<?php echo $form['incident_zoom']; ?>" />
			<div class="big-block">
				<h1><?php echo Kohana::lang('ui_main.reports_submit_new'); ?></h1>
				<?php if ($form_error): ?>
				<!-- red-box -->
				<div class="red-box">
					<h3>Error!</h3>
					<ul>
						<?php
							foreach ($errors as $error_item => $error_description)
							{
								// print "<li>" . $error_description . "</li>";
								print (!$error_description) ? '' : "<li>" . $error_description . "</li>";
							}
						?>
					</ul>
				</div>
				<?php endif; ?>
				<div class="row">
					<input type="hidden" name="form_id" id="form_id" value="<?php echo $id?>">
				</div>
				<div class="report_left">
					<div class="report_row">
						<?php if(count($forms) > 1): ?>
						<div class="row">
							<h4><span><?php echo Kohana::lang('ui_main.select_form_type');?></span>
							<span class="sel-holder">
								<?php print form::dropdown('form_id', $forms, $form['form_id'],
							' onchange="formSwitch(this.options[this.selectedIndex].value, \''.$id.'\')"') ?>
							</span>
							<div id="form_loader" style="float:left;"></div>
							</h4>
						</div>
						<?php endif; ?>
						<h4><?php echo Kohana::lang('ui_main.reports_title'); ?> <span class="required">*</span> </h4>
						<?php print form::input('incident_title', $form['incident_title'], ' class="text long"'); ?>
					</div>
					<div class="report_row">
						<h4><?php echo Kohana::lang('ui_main.reports_description'); ?> <span class="required">*</span> </h4>
						<?php print form::textarea('incident_description', $form['incident_description'], ' rows="10" class="textarea long" ') ?>
					</div>
					<div class="report_row" id="datetime_default">
						<h4>
							<a href="#" id="date_toggle" class="show-more"><?php echo Kohana::lang('ui_main.modify_date'); ?></a>
							<?php echo Kohana::lang('ui_main.date_time'); ?>: 
							<?php echo Kohana::lang('ui_main.today_at')." "."<span id='current_time'>".$form['incident_hour']
								.":".$form['incident_minute']." ".$form['incident_ampm']."</span>"; ?>
							<?php if($site_timezone != NULL): ?>
								<small>(<?php echo $site_timezone; ?>)</small>
							<?php endif; ?>
						</h4>
					</div>
					<div class="report_row hide" id="datetime_edit">
						<div class="date-box">
							<h4><?php echo Kohana::lang('ui_main.reports_date'); ?></h4>
							<?php print form::input('incident_date', $form['incident_date'], ' class="text short"'); ?>
							<script type="text/javascript">
								$().ready(function() {
									$("#incident_date").datepicker({ 
										showOn: "both", 
										buttonImage: "<?php echo url::file_loc('img'); ?>media/img/icon-calendar.gif", 
										buttonImageOnly: true 
									});
								});
							</script>
						</div>
						<div class="time">
							<h4><?php echo Kohana::lang('ui_main.reports_time'); ?></h4>
							<?php
								for ($i=1; $i <= 12 ; $i++)
								{
									// Add Leading Zero
									$hour_array[sprintf("%02d", $i)] = sprintf("%02d", $i);
								}
								for ($j=0; $j <= 59 ; $j++)
								{
									// Add Leading Zero
									$minute_array[sprintf("%02d", $j)] = sprintf("%02d", $j);
								}
								$ampm_array = array('pm'=>'pm','am'=>'am');
								print form::dropdown('incident_hour',$hour_array,$form['incident_hour']);
								print '<span class="dots">:</span>';
								print form::dropdown('incident_minute',$minute_array,$form['incident_minute']);
								print '<span class="dots">:</span>';
								print form::dropdown('incident_ampm',$ampm_array,$form['incident_ampm']);
							?>
							<?php if ($site_timezone != NULL): ?>
								<small>(<?php echo $site_timezone; ?>)</small>
							<?php endif; ?>
						</div>
						<div style="clear:both; display:block;" id="incident_date_time"></div>
					</div>
					<div class="report_row">
						<h4><?php echo Kohana::lang('ui_main.reports_categories'); ?> <span class="required">*</span></h4>
						<div class="report_category" id="categories">
						<?php
							$selected_categories = (!empty($form['incident_category']) AND is_array($form['incident_category']))
								? $selected_categories = $form['incident_category']
								: array();
								
							$columns = 2;
							echo category::tree($categories1, TRUE, $selected_categories, 'incident_category', $columns);
							?>
						</div>
					</div>


					<?php
					// Action::report_form - Runs right after the report categories
					Event::run('ushahidi_action.report_form');
					?>

					<?//php echo $custom_forms ?>

					<div class="report_optional">
						<h3><?php echo Kohana::lang('ui_main.reports_optional'); ?></h3>
						<div class="report_row">
							<h4><?php echo Kohana::lang('ui_main.reports_first'); ?></h4>
							<?php print form::input('person_first', $form['person_first'], ' class="text long"'); ?>
						</div>
						<div class="report_row">
							<h4><?php echo Kohana::lang('ui_main.reports_last'); ?></h4>
							<?php print form::input('person_last', $form['person_last'], ' class="text long"'); ?>
						</div>
						<div class="report_row">
							<h4><?php echo Kohana::lang('ui_main.reports_email'); ?></h4>
							<?php print form::input('person_email', $form['person_email'], ' class="text long"'); ?>
						</div>
						<?php
						// Action::report_form_optional - Runs in the optional information of the report form
						Event::run('ushahidi_action.report_form_optional');
						?>
					</div>
				</div>
				<div class="report_right">
					
						
					<?php Event::run('ushahidi_action.report_form_location', $id); ?>
					<div class="report_row">
							<input type="hidden" name="latitude" id="latitude" value="">
							<input type="hidden" name="longitude" id="longitude" value="">

							<select name="cat" id="cat" onchange='getValues(this.value)'>
							 
						          <option value="" disabled="disabled" selected>---Select a City---</option>
						          <option value="prishtina" id="">Prishtina</option>
						          <option value="" id="" disabled="disabled">Prizren</option>
						          <option value="" id="" disabled="disabled">Peja</option>
						          <option value="" id="" disabled="disabled">Gjakova</option>
						          <option value="" id="" disabled="disabled">Mitrovica</option>
						          <option value="" id="" disabled="disabled">Gjilan</option>
				            	  <option value="" id="" disabled="disabled">Feizaj</option>
							      <option value="" id="" disabled="disabled">aaa</option>
							 
							  </select>
						
							<select name="cat" id="cat" onchange='getValues(this.value)'>
							 
							          <option value="" disabled="disabled" selected>---Select a Category---</option>
							          <option value="restaurant" id="">Restaurant</option>
							          <option value="hospital" id="">Health Center</option>
							          <option value="pub" id="">Pubs</option>
							 
							  </select>
							 
							  <select name="catname" id="catname" onchange='var obj = this.value.split(",") ; document.getElementById("latitude").value = obj[0];document.getElementById("longitude").value = obj[1];document.getElementById("location_name").value = obj[2];' >
								        <option value="" disabled="disabled" selected>---Select a Public Place---</option>
							  </select>

						<h4>
							<?php //echo Kohana::lang('ui_main.reports_location_name'); ?> 
							
						
						</h4>
						<?php print form::input('location_name', $form['location_name'], ' class="text long" style="display:none;"'); ?>
					</div>

					<!-- News Fields -->
					<div id="divNews" class="report_row" style="display:none">
						<h4><?php echo Kohana::lang('ui_main.reports_news'); ?></h4>
						
						<?php 
							// Initialize the counter
							$i = (empty($form['incident_news'])) ? 1 : 0;
						?>

						<?php if (empty($form['incident_news'])): ?>
							<div class="report_row">
								<?php print form::input('incident_news[]', '', ' class="text long2"'); ?>
								<a href="#" class="add" onClick="addFormField('divNews','incident_news','news_id','text'); return false;">add</a>
							</div>
						<?php else: ?>
							<?php foreach ($form['incident_news'] as $value): ?>
							<div class="report_row" id="<?php echo $i; ?>">
								<?php echo form::input('incident_news[]', $value, ' class="text long2"'); ?>
								<a href="#" class="add" onClick="addFormField('divNews','incident_news','news_id','text'); return false;">add</a>

								<?php if ($i != 0): ?>
									<?php $css_id = "#incident_news_".$i; ?>
									<a href="#" class="rem"	onClick="removeFormField('<?php echo $css_id; ?>'); return false;">remove</a>
								<?php endif; ?>

							</div>
							<?php $i++; ?>

							<?php endforeach; ?>
						<?php endif; ?>

						<?php print form::input(array('name'=>'news_id', 'type'=>'hidden', 'id'=>'news_id'), $i); ?>
					</div>


					<!-- Video Fields -->
					<div id="divVideo" class="report_row">
						<h4><?php print Kohana::lang('ui_main.external_video_link'); ?></h4>
						<?php 
							// Initialize the counter
							$i = (empty($form['incident_video'])) ? 1 : 0;
						?>

						<?php if (empty($form['incident_video'])): ?>
							<div class="report_row">
								<?php print form::input('incident_video[]', '', ' class="text long2"'); ?>
								<a href="#" class="add" onClick="addFormField('divVideo','incident_video','video_id','text'); return false;">add</a>
							</div>
						<?php else: ?>
							<?php foreach ($form['incident_video'] as $value): ?>
								<div class="report_row" id="<?php  echo $i; ?>">

								<?php print form::input('incident_video[]', $value, ' class="text long2"'); ?>
								<a href="#" class="add" onClick="addFormField('divVideo','incident_video','video_id','text'); return false;">add</a>

								<?php if ($i != 0): ?>
									<?php $css_id = "#incident_video_".$i; ?>
									<a href="#" class="rem"	onClick="removeFormField('<?php echo $css_id; ?>'); return false;">remove</a>
								<?php endif; ?>

								</div>
								<?php $i++; ?>
							
							<?php endforeach; ?>
						<?php endif; ?>

						<?php print form::input(array('name'=>'video_id','type'=>'hidden','id'=>'video_id'), $i); ?>
					</div>
					
					<?php Event::run('ushahidi_action.report_form_after_video_link'); ?>

					<!-- Photo Fields -->
					<div id="divPhoto" class="report_row">
						<h4><?php echo Kohana::lang('ui_main.reports_photos'); ?></h4>
						<?php 
							// Initialize the counter
							$i = (empty($form['incident_photo']['name'][0])) ? 1 : 0;
						?>

						<?php if (empty($form['incident_photo']['name'][0])): ?>
						<div class="report_row">
							<?php print form::upload('incident_photo[]', '', ' class="file long2"'); ?>
							<a href="#" class="add" onClick="addFormField('divPhoto', 'incident_photo','photo_id','file'); return false;">add</a>
						</div>
						<?php else: ?>
							<?php foreach ($form[$this_field]['name'] as $value): ?>

								<div class="report_row" id="<?php echo $i; ?>">
									<?php print form::upload('incident_photo[]', $value, ' class="file long2"'); ?>
									<a href="#" class="add" onClick="addFormField('divPhoto','incident_photo','photo_id','file'); return false;">add</a>

									<?php if ($i != 0): ?>
										<?php $css_id = "#incident_photo_".$i; ?>
										<a href="#" class="rem"	onClick="removeFormField('<?php echo $css_id; ?>'); return false;">remove</a>
									<?php endif; ?>

								</div>

								<?php $i++; ?>

							<?php endforeach; ?>
						<?php endif; ?>

						<?php print form::input(array('name'=>'photo_id','type'=>'hidden','id'=>'photo_id'), $i); ?>
					</div>
										
					<div class="report_row">
						<input name="submit" type="submit" value="<?php echo Kohana::lang('ui_main.reports_btn_submit'); ?>" class="btn_submit" /> 
					</div>
				</div>
			</div>
			<?php print form::close(); ?>
			<!-- end report form block -->
		</div>

				
			</div>
		</div>
		<!-- / content column -->
		
		<!-- right column -->
		<div id="right" class="clearingfix">
			
			
			<!-- Checkins -->
			<?php if ( Kohana::config('settings.checkins') ) { ?>
			<br/>
			<div class="additional-content">
				<h5><?php echo Kohana::lang('ui_admin.checkins'); ?></h5>
				<div id="cilist"></div>
			</div>
			<?php } ?>
			<!-- /Checkins -->
			
			<?php
			// Action::main_sidebar - Add Items to the Entry Page Sidebar
			Event::run('ushahidi_action.main_sidebar');
			?>
	
		</div>
		<!-- / right column -->
		
	</div>
</div>
<!-- / main body -->

<!-- content -->
<div class="content-container">

	<!-- content blocks -->
	<div class="content-blocks clearingfix">
		<ul class="content-column">
			<?php blocks::render(); ?>
		</ul>
	</div>
	<!-- /content blocks -->

</div>
<!-- content -->
