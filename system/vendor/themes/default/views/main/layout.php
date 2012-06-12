<!-- main body -->

	<!-- leftcol -->
<div class="leftcol">
	<div class="container">
		<!-- logo -->
		<div id="logo">
			<h1><a href="#">Smoke-Free Kosovo</a></h1>
		</div>
		<!-- / logo -->
		
		<!-- SUBMIT FORM -->
		<div class="submit-block">
				<h5>Report a Violation</h5>
	
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
	
					<h5><?php echo Kohana::lang('ui_main.reports_submit_new'); ?></h5>
	
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
					<!-- end/ red-box-->
					
					<?php endif; ?>
					<!-- hidden --> <div class="row"> <input type="hidden" name="form_id" id="form_id" value="<?php echo $id?>"/></div>
					
					<div class="report">
						
						<!-- categories --> 
						<div class="report_row">							
							<fieldset>
								<legend><h4><?php echo Kohana::lang('ui_main.reports_categories'); ?> <span class="required">*</span></h4></legend>
								
								<div class="report_category" id="categories">
								
								<?php
									$selected_categories = (!empty($form['incident_category']) AND is_array($form['incident_category']))
										? $selected_categories = $form['incident_category']
										: array();
										
									$columns = 2;
									echo category::tree($categories1, TRUE, $selected_categories, 'incident_category', $columns);
									?>
								</div>
							</fieldset>
						</div>
						<?php
						// Action::report_form - Runs right after the report categories
						Event::run('ushahidi_action.report_form');
						?>
			
						<?php Event::run('ushahidi_action.report_form_location', $id); ?>
						
						
						<!-- dropdowns -->
						<div class="report_row">
							<fieldset>
								<legend><h4>Location </h4></legend>
								
								<label for="city">Choose a city <span class="required">*</span></label>
								<select name="city" id="city">
									<option value="" selected>Prishtina</option>
									<option value="" disabled="disabled">Gjakova</option>
									<option value="" disabled="disabled">Ferizaj</option>
									<option value="" disabled="disabled">Gjilan</option>
									<option value="" disabled="disabled">Prizren</option>
									<option value="" disabled="disabled">Mitrovica</option>
									<option value="" disabled="disabled"></option>
								</select>
								
								<label for="cat">Choose type of public place <span class="required">*</span></label>
								<select name="cat" id="cat" onChange="getValues(this.value)">
									<option value="" disabled="disabled" selected>---Select---</option>
									<option value="government">Governmental Institutions</option>
									<option value="public_companies">Public Companies</option>
									<option value="independent_agencies">Independent Agencies</option>
									<option value="police">Police Stations</option>
									<option value="courthouse">Courts</option>
									<option value="hospital">Health Centers</option>
									<option value="university">Universities</option>
									<option value="school">Schools</option>
									<option value="library">Libraries</option>
									<option value="restaurant">Restaurants</option>
									<option value="pub">Pubs</option>
									<option value="cafe">Caffes</option>
									<option value="bar">Bars</option>
									<option value="theatre">Theatres</option>
									<option value="cinema">Cinemas</option>
								</select>
								
								<label for="catname">Choose location <span class="required">*</span></label>
								  <select name="catname" id="catname" onchange=' var obj = this.value.split(",") ; document.getElementById("latitude").value = obj[0];document.getElementById("longitude").value = obj[1];document.getElementById("location_name").value = obj[2]; document.getElementById("incident_title").value = "Smoking Violation "+ obj[2] ;' >
											<option value="" disabled="disabled" selected>---Select---</option>
								  </select>
		
								<?php print form::input('location_name', $form['location_name'], ' class="text long" style="display:none;"'); ?>
							</fieldset>	
						</div>
						
						
						<!-- date & time --> 
						<div class="report_row" id="datetime_default">
							<h6>
								<?php echo Kohana::lang('ui_main.date_time'); ?>: 
								<?php echo Kohana::lang('ui_main.today_at')." "."<span id='current_time'>".$form['incident_hour']
									.":".$form['incident_minute']." ".$form['incident_ampm']."</span>"; ?>
								<?php if($site_timezone != NULL): ?>
									<small>(<?php echo $site_timezone; ?>)</small>
								<?php endif; ?>
							</h6>
							<!-- remove Modify Date option --><!--<a href="#" id="date_toggle" class="show-more"><?php echo Kohana::lang('ui_main.modify_date'); ?></a> -->
						</div>
	
						<!-- submit button -->
						<div class="report_row">
							<input name="submit" type="submit" value="<?php echo Kohana::lang('ui_main.reports_btn_submit'); ?>" class="btn_submit" /> 
						</div>
					</div><!-- end/ report -->
				</div>
				<?php print form::close(); ?>
				<!-- end report form block -->
			</div>
		<!-- /end SUBMIT FORM -->
		
		<!-- Social Media -->
		<div id="social-boxes">
				<!-- facebook -->
				<div id="fb-likebox">
					<iframe src="//www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2FKosovoInnovations&amp;width=280&amp;height=395&amp;colorscheme=light&amp;show_faces=false&amp;border_color=%23ebebeb&amp;stream=true&amp;header=false&amp;appId=170256203031026" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:280px; height:395px;" allowTransparency="true"></iframe>
				</div>
				<!-- twitter -->
				<script charset="utf-8" src="http://widgets.twimg.com/j/2/widget.js"></script>
				<div id="twitter-feedbox" style="margin-top: 10px; border:1px solid #ebebeb; width:100%;">
				<script>
				new TWTR.Widget({
				  version: 2,
				  type: 'search',
				  search: '#smoking',
				  interval: 30000,
				  title: 'Smoking hashtag tweets',
				  subject: 'Smoking Violations',																											
				  width: 280,
				  height: 200,
				  theme: {
					shell: {
					  background: '#ffffff',
					  color: '#444444'
					},
					tweets: {
					  background: '#ffffff',
					  color: '#444444',
					  links: '#0099CC'
					}
				  },
				  features: {
					scrollbar: true,
					loop: true,
					live: false,
					behavior: 'default'
				  }
				}).render().start();
				</script>
				</div>
				</div>
		<!-- /end Social Media -->

	</div>
</div>
<!-- / leftcol -->


<div id="main" class="clearingfix">
	<div id="mainmiddle" class="floatbox">

	<?php if ($site_message != ''): ?>
		<div class="green-box">
			<h3><?php echo $site_message; ?></h3>
		</div>
	<?php endif; ?>
	
		<!-- content column -->
    	<div id="content" class="clearingfix">
    		<!-- map with filters -->
			<div class="floatbox">
				<!-- filters -->
				<div class="filters clearingfix">
						<div style="float:left; width: 100%">
								<strong><?php echo Kohana::lang('ui_main.filters'); ?></strong>
								<ul>
										<li><a id="media_0" class="active" href="#"><span><?php echo Kohana::lang('ui_main.reports'); ?></span></a></li>
										<li><a id="media_4" href="#"><span><?php echo Kohana::lang('ui_main.news'); ?></span></a></li>
										<li><a id="media_1" href="#"><span><?php echo Kohana::lang('ui_main.pictures'); ?></span></a></li>
										<li><a id="media_2" href="#"><span><?php echo Kohana::lang('ui_main.video'); ?></span></a></li>
										<li><a id="media_0" href="#"><span><?php echo Kohana::lang('ui_main.all'); ?></span></a></li>
								</ul>
						</div>

				</div>
				<!-- / filters -->
				
				<!-- category filters -->
				<div id="category-filters">
					<div class="cat-filters clearingfix">
						<strong>
							<?php echo Kohana::lang('ui_main.category_filter');?>
							<span>
								[<a href="javascript:toggleLayer('category_switch_link', 'category_switch')" id="category_switch_link">
									<?php echo Kohana::lang('ui_main.hide'); ?>
								</a>]
							</span>
						</strong>
					</div>
				
					<ul id="category_switch" class="category-filters top_filters">
						<?php
						$color_css = 'class="swatch" style="background-color:#'.$default_map_all.'"';
						$all_cat_image = '';
						if ($default_map_all_icon != NULL)
						{
							$all_cat_image = html::image(array(
								'src'=>$default_map_all_icon,
								'style'=>'float:left;padding-right:5px;'
							));
							$color_css = '';
						}
						?>
						<li>
							<a class="active" id="cat_0" href="#">
								<span <?php echo $color_css; ?>><?php echo $all_cat_image; ?></span>
								<span class="category-title"><?php echo Kohana::lang('ui_main.all_categories');?></span>
							</a>
						</li>
						<li> 
							<ul id="kml_switch" class="category-filters">
								<li>
									<a href="#" id="layer_13">
									<span class="swatch" style="background-color:#11d611"></span>
									<span class="layer-name">Smoke Free</span>
									</a>
								</li>	
							</ul>
						</li>

					</ul>
					
					
					<div class="cat-filters clearingfix">
						<strong>
							<?php echo Kohana::lang('ui_main.category_filter');?>
							<span>
								[<a href="javascript:toggleLayer('category_switch_link', 'category_switch')" id="category_switch_link">
									<?php echo Kohana::lang('ui_main.hide'); ?>
								</a>]
							</span>
						</strong>
					</div>
					<ul id="category_switch" class="category-filters secondary_filters">
					<?php
						foreach ($categories as $category => $category_info)
						{
							$category_title = $category_info[0];
							$category_color = $category_info[1];
							$category_image = ($category_info[2] != NULL)
								? url::convert_uploaded_to_abs($category_info[2])
								: NULL;
	
							$color_css = 'class="swatch" style="background-color:#'.$category_color.'"';
							if ($category_info[2] != NULL)
							{
								$category_image = html::image(array(
									'src'=>$category_image,
									'style'=>'float:left;padding-right:5px;'
									));
								$color_css = '';
							}
	
							echo '<li>'
								. '<a href="#" id="cat_'. $category .'">'
								. '<span '.$color_css.'>'.$category_image.'</span>'
								. '<span class="category-title">'.$category_title.'</span>'
								. '</a>';
	
							// Get Children
							echo '<div class="hide" id="child_'. $category .'">';
							if (sizeof($category_info[3]) != 0)
							{
								echo '<ul>';
								foreach ($category_info[3] as $child => $child_info)
								{
									$child_title = $child_info[0];
									$child_color = $child_info[1];
									$child_image = ($child_info[2] != NULL)
										? url::convert_uploaded_to_abs($child_info[2])
										: NULL;
									
									$color_css = 'class="swatch" style="background-color:#'.$child_color.'"';
									if ($child_info[2] != NULL)
									{
										$child_image = html::image(array(
											'src' => $child_image,
											'style' => 'float:left;padding-right:5px;'
										));
	
										$color_css = '';
									}
	
									echo '<li style="padding-left:20px;">'
										. '<a href="#" id="cat_'. $child .'">'
										. '<span '.$color_css.'>'.$child_image.'</span>'
										. '<span class="category-title">'.$child_title.'</span>'
										. '</a>'
										. '</li>';
								}
								echo '</ul>';
							}
							echo '</div></li>';
						}
					?>
				</ul>
				</div>
				<!-- / category filters -->
				
				<!-- map and timeline -->
				<?php
				echo $div_map;
				echo $div_timeline;
				?>
				
				<div id="other-layers">
					<div class="cat-filters clearingfix">
					<strong>Other Layers
					<span>
					[<a href="javascript:toggleLayer('kml_switch_link', 'kml_switch')" id="kml_switch_link">
					Hide	 </a>]
					</span>
					</strong>
					</div>
					
				</div>
				
			</div><!-- end/ floatbox -->
			
			<div id="words">
				<h2>Did you know?</h2>
				<p>47.2% of young people first tried a cigarette before the age of 18 years.</p>
				<p>20.9% of pregnant women are smoking in Kosovo.</p>
				<p>53.6% of children are exposed to secondary smoking.</p>
			</div> 	

			
			
			<!-- reports listing -->
			<div class="content-container">
				<?php
						// Action::main_filters - Add items to the main_filters
						Event::run('ushahidi_action.map_main_filters');
						?>
						
				<!-- content blocks -->
				<div class="content-blocks clearingfix">
					<ul class="content-column">
						<?php blocks::render(); ?>
					</ul>
				</div>
				<!-- /content blocks -->
				
			</div>
			<!-- end/ reports listing -->
			
			

        </div>
    	 <!-- / content column -->
		
		<!-- this div is hidden because we do not need the content within -->
			<!-- right column -->
			<div id="right" class="clearingfix">
	
				<!-- additional content -->
				<?php if (Kohana::config('settings.allow_reports')): ?>
					<div class="additional-content">
						<h5><?php echo Kohana::lang('ui_main.how_to_report'); ?></h5>
	
						<div>
	
							<!-- Phone -->
							<?php if ( ! empty($phone_array)): ?>
							<div style="margin-bottom:10px;">
								<?php echo Kohana::lang('ui_main.report_option_1'); ?>
								<?php foreach ($phone_array as $phone): ?>
									<strong><?php echo $phone; ?></strong>
									<?php if ($phone != end($phone_array)): ?>
										 <br/>
									<?php endif; ?>
								<?php endforeach; ?>
							</div>
							<?php endif; ?>
							
							<!-- External Apps -->
							<?php if (count($external_apps) > 0): ?>
							<div style="margin-bottom:10px;">
								<strong><?php echo Kohana::lang('ui_main.report_option_external_apps'); ?>:</strong><br/>
								<?php foreach ($external_apps as $app): ?>
									<a href="<?php echo $app->url; ?>"><?php echo $app->name; ?></a><br/>
								<?php endforeach; ?>
							</div>
							<?php endif; ?>
	
							<!-- Email -->
							<?php if ( ! empty($report_email)): ?>
							<div style="margin-bottom:10px;">
								<strong><?php echo Kohana::lang('ui_main.report_option_2'); ?>:</strong><br/>
								<a href="mailto:<?php echo $report_email?>"><?php echo $report_email?></a>
							</div>
							<?php endif; ?>
	
							<!-- Twitter -->
							<?php if ( ! empty($twitter_hashtag_array)): ?>
							<div style="margin-bottom:10px;">
								<strong><?php echo Kohana::lang('ui_main.report_option_3'); ?>:</strong><br/>
								<?php foreach ($twitter_hashtag_array as $twitter_hashtag): ?>
									<span>#<?php echo $twitter_hashtag; ?></span>
									<?php if ($twitter_hashtag != end($twitter_hashtag_array)): ?>
										<br />
									<?php endif; ?>
								<?php endforeach; ?>
							</div>
							<?php endif; ?>
	
							<!-- Web Form -->
							<div style="margin-bottom:10px;">
								<a href="<?php echo url::site().'reports/submit/'; ?>">
									<?php echo Kohana::lang('ui_main.report_option_4'); ?>
								</a>
							</div>
	
						</div>
	
					</div>
				<?php endif; ?>
				<!-- / additional content -->
				
				<!-- Checkins -->
				<?php if (Kohana::config('settings.checkins')): ?>
				<br/>
				<div class="additional-content">
					<h5><?php echo Kohana::lang('ui_admin.checkins'); ?></h5>
					<div id="cilist"></div>
				</div>
				<?php endif; ?>
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


