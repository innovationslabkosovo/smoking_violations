	<?php
/**
 * View file for updating the reports display
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team - http://www.ushahidi.com
 * @package    Ushahidi - http://source.ushahididev.com
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
 */

?>
		<!-- Top reportbox section-->
		<div class="rb_nav-controls r-5">
			<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td>
						<ul class="link-toggle report-list-toggle lt-icons-and-text">
							<li class="active"><a href="#rb_list-view" class="list"><?php echo Kohana::lang('ui_main.list'); ?></a></li>
							<li><a href="#rb_map-view" class="map"><?php echo Kohana::lang('ui_main.map'); ?></a></li>
						</ul>
					</td>
					<td><?php echo $pagination; ?></td>
					<td></td>
					<td class="last">
						<ul class="link-toggle lt-icons-only">
							<?php //@todo Toggle the status of these links depending on the current page ?>
							<li><a href="#" class="prev" id="page_<?php echo $previous_page; ?>"><?php echo Kohana::lang('ui_main.previous'); ?></a></li>
							<li><a href="#" class="next" id="page_<?php echo $next_page; ?>"><?php echo Kohana::lang('ui_main.next'); ?></a></li>
						</ul>
					</td>
				</tr>
			</table>
		</div>
		<!-- /Top reportbox section-->

		<!-- Report listing -->
		<div class="r_cat_tooltip"><a href="#" class="r-3"></a></div>
		<div class="rb_list-and-map-box">
			<div id="rb_list-view">
			<?php
			$l = Kohana::config('locale.language.0');
			$view_reports = false;
			if (isset($_GET['lc']))
			{
				$l_id =  $_GET['lc'];
				$view_reports = true;
			}


			$locations = Location_Model::get_locations_date();
			$ct = array();


			foreach ($locations as $location) {

				$rat_count =0;
				$last_date = " ";
				$counter = 0;
				$loc_thumb = "";
				$cat_array = array();
				for($i=1;$i<10;$i++)
				{
					$ct[$i] = 0;
				}

				$location = ORM::factory('location', $location->id);
				$location_id1 = $location->id;
				$location_name1 = $location->location_name;
				$location_img = $location->location_image;
				if ($location_img == 1)
				{
					$loc_thumb = url::file_loc('img')."media/img/". $location_id1.".jpg";
				}
				else {
					$loc_thumb = url::file_loc('img')."media/img/no_image_available.png";
				}
				//$loc_thumb = url::file_loc('img')."media/img/". $location_id1.".jpg";
				//$no_image = url::file_loc('img')."media/img/no_image_available.png";

				$incident_verified = $location->ratings;


				if ($view_reports == true)
				{
					if ($location_id1 != $l_id)
						continue;
				}
				foreach ($incidents as $incident)
				{

					$incident = ORM::factory('incident', $incident->incident_id);
					$incident_id = $incident->id;

					$incident_title = substr_replace($incident->incident_title, Kohana::lang('ui_main.violation_title'), 0, 0);
					$incident_description = $incident->incident_description;
					//$incident_category = $incident->incident_category;
					// Trim to 150 characters without cutting words
					// XXX: Perhaps delcare 150 as constant

					$incident_description = text::limit_chars(strip_tags($incident_description), 140, "...", true);
					$incident_date = date('H:i M d, Y', strtotime($incident->incident_date));
					$incident_date1 = $incident->incident_date;
					//$incident_time = date('H:i', strtotime($incident->incident_date));
					$location_id = $incident->location_id;
					$location_name = $incident->location->location_name;
					//$incident_verified = $incident->incident_verified;



					//if ($rating->incident_id == )


					if ($location_id1 ==$location_id )
					{

						$rating =  ORM::factory('rating')->where('rating.incident_id',$incident_id)->count_all();

						if ($rating > 0) {
							$rat_count += $rating ;
						}
						//echo $rat_count;
						foreach ($incident->category as $category)
						{

							//$cat_array [$category->id] = $category->category_title;
							//if($cat_array[$category->id] == $category->id)
							//{

								$ct[$category->id]++;
							//}
							//else

							//$cat_array[$category->id] = $category->id;
						}

						if ($last_date < $incident_date1)
						{
							$last_date = date('d M, Y H:i ', strtotime($incident_date1));
						}
						$counter += 1;
						//echo $counter;


						$comment_count = $incident->comment->count();

					$incident_thumb = url::file_loc('img')."media/img/report-thumb-default.jpg";

						$media = $incident->media;
						if ($media->count())
						{
							foreach ($media as $photo)
							{
								if ($photo->media_thumb)
								{ // Get the first thumb
									$incident_thumb = url::convert_uploaded_to_abs($photo->media_thumb);
									break;
								}
							}
						}

					if($view_reports==true)
					{
						?>
						<div id="<?php echo $incident_id ?>" >
							<div class="r_media">
								<p class="r_photo" style="text-align:center;"> <a href="<?php echo url::site(); ?>reports/view/<?php echo $incident_id; ?>">
							<img src="<?php echo $incident_thumb; ?>" style="max-width:180px;max-height:120px;" /> </a>
						</p>

								<!-- Only show this if the report has a video -->
								<p class="r_video" style="display:none;"><a href="#"><?php echo Kohana::lang('ui_main.video'); ?></a></p>

								<!-- Category Selector -->
								<div class="r_categories">
									<h4><?php echo Kohana::lang('ui_main.categories'); ?></h4>
									<?php foreach ($incident->category as $category): ?>

										<?php // Don't show hidden categories ?>
										<?php if($category->category_visible == 0) continue; ?>
										<?php $category_title = Category_Lang_Model::category_title($category->id, $l); ?>
										<?php if ($category->category_image_thumb): ?>
											<?php $category_image = url::base().Kohana::config('upload.relative_directory')."/".$category->category_image_thumb; ?>
											<a class="r_category" href="<?php echo url::site(); ?>reports/?c=<?php echo $category->id; ?>">
												<span class="r_cat-box"><img src="<?php echo $category_image; ?>" height="16" width="16" /></span>
												<span class="r_cat-desc"><?php echo $category_title;?></span>
											</a>
										<?php else:	?>
											<a class="r_category" href="<?php echo url::site(); ?>reports/?c=<?php echo $category->id; ?>">
												<span class="r_cat-box" style="background-color:#<?php echo $category->category_color;?>;"></span>
												<span class="r_cat-desc"><?php echo $category_title;?></span>
											</a>
										<?php endif; ?>
									<?php endforeach; ?>
								</div>
									<?php
									// Action::report_extra_media - Add items to the report list in the media section
									Event::run('ushahidi_action.report_extra_media', $incident_id);
									?>
							</div>


							<div class="r_details">
								<h3><a class="r_title" href="<?php echo url::site(); ?>reports/view/<?php echo $incident_id; ?>">
										<?php echo $incident_title; ?>
									</a>
									<a href="<?php echo url::site(); ?>reports/view/<?php echo $incident_id; ?>#discussion" class="r_comments">
										<?php echo $comment_count; ?></a>
										<?php //echo $incident_verified; ?>
									</h3>
								<p class="r_date r-3 bottom-cap"></p>
								<div class="r_description"> <?php echo $incident_description; ?>
								  <a class="btn-show btn-more" href="#<?php echo $incident_id ?>"><?php echo Kohana::lang('ui_main.more_information'); ?> &raquo;</a>
								  <a class="btn-show btn-less" href="#<?php echo $incident_id ?>">&laquo; <?php echo Kohana::lang('ui_main.less_information'); ?></a>
								</div>
								<p class="r_location"><a href="<?php echo url::site(); ?>reports/?lc=<?php echo $location_id; ?>"><?php echo $location_name; ?></a></p>
								<?php
								// Action::report_extra_details - Add items to the report list details section
								Event::run('ushahidi_action.report_extra_details', $incident_id);
								?>
							</div>
						</div>

			<!-- THE GOOD STUFF -->
			<?php
					}}
				}
				if ($view_reports==false && $counter!=0)
				{
				?>

					<div id="<?php echo $location_id1 ?>" class="violation_wrap"><?php  // if ($rat_count > 5) { $incident_verified = true ;}?>
						<div class="r_media">
							<p class="r_photo" style="text-align:center;"> <a href="<?php echo url::site(); ?>reports?lc=<?php echo $location_id1; ?>">
								<img src="<?php echo $loc_thumb; ?>"  style="max-width:180px;max-height:120px;"/> </a>
							</p>


							<!-- Only show this if the report has a video -->
							<!-- <p class="r_video" style="display:none;"><a href="#"><?php //echo Kohana::lang('ui_main.video'); ?></a></p> -->

							<!-- Category Selector -->

							<?php
							// Action::report_extra_media - Add items to the report list in the media section
							Event::run('ushahidi_action.report_extra_media', $incident_id);
							?>
						</div>

						<div class="r_details">
								<?php

									  if ($incident_verified>5)
							    		{
							    			echo '<p style="background:#368C00;float:right;width:100px; color:#FFFFFF;font-size:11px;font-weight:bold;display:block;
											    padding:3px 5px;
											    text-align:center;
											    text-transform:uppercase;
											    -webkit-border-radius:3px;
											    -moz-border-radius:3px;
											    border-radius:3px;">'.Kohana::lang('ui_main.verified').'</p>';
							    		}

							if ($counter == 1){?>

							<a  class="r_title" href="<?php echo url::site(); ?>reports/view/<?php echo $incident_id; ?>" >
								<h3><?php echo  $location_name1 ?></h3>
								<span class="count_reports">(<?php echo $counter?> <?php echo Kohana::lang('ui_main.reports'); ?>)</span>
							</a><?php }
							else {?>
							<a  class="r_title" href="<?php echo url::site(); ?>reports?lc=<?php echo $location_id1; ?>">
								<h3><?php echo  $location_name1 ?></h3>
								<span class="count_reports">(<?php echo $counter?> <?php echo Kohana::lang('ui_main.reports'); ?>)</span>
							</a>

							<?php } ?>

							<a style ='display:none' href="<?php echo url::site(); ?>reports/view/<?php echo $incident_id; ?>#discussion" class="r_comments"></a>

							<span class="latest_violation"><strong><?php echo Kohana::lang('ui_main.latest_violation') ?> </strong><?php echo $last_date; ?></span>


							<!--<p ><?php echo "Violation ".Kohana::lang('ui_main.categories'); ?></p> -->

								<?php
								$cats = Category_Model::get_categories();
								$i=1;


								foreach ($cats as $category): ?>

									<?php if($ct[$i] != 0) {;?>

									<?php if($category->category_visible == 0) {continue;}

										$category_title = Category_Lang_Model::category_title($category->id, $l);

									?>

									<?php if ($category->category_image_thumb): ?>
										<?php $category_image = url::base().Kohana::config('upload.relative_directory')."/".$category->category_image_thumb; ?>
										<a class="r_category" href="<?php echo url::site(); ?>reports/?c=<?php echo $category->id; ?>">
											<span ><?php echo "(".$ct[$i].") ".$category_title; ?></span>
											<span class="r_cat-box"><img src="<?php echo $category_image; ?>" height="16" width="16" /></span>
											<span class="r_cat-desc"><?php  echo($ct[$i])." ";echo $category_title;?></span>
										</a>
									<?php else:?>
										<a class="r_category" href="<?php echo url::site(); ?>reports/?c=<?php echo $category->id; ?>">
											<span ><?php echo "(".$ct[$i].") ".$category_title; ?></span>
											<span class="r_cat-box" style="background-color:#<?php echo $category->category_color;?>;"></span>
											<span class="r_cat-desc"><?php  echo($ct[$i])." "; echo $category_title;?></span>
										</a>
									<?php endif; ?>
								<?php } $i++; endforeach; ?>
							<p class="r_date r-3 bottom-cap"><?php //echo $incident_date; ?></p>
							<div class="r_description">

							</div>
							<p class="r_location"><a href="<?php echo url::site(); ?>reports/?lc=<?php echo $location_id; ?>"><?php echo $location_name; ?></a></p>
							<?php
							// Action::report_extra_details - Add items to the report list details section
							Event::run('ushahidi_action.report_extra_details', $incident_id);
							?>
						</div>
					</div>

			<?php

			}}?>


			</div>
			<div id="rb_map-view" style="display:none; width: 590px; height: 384px; border:1px solid #CCCCCC; margin: 3px auto;">
			</div>
		</div>
		<!-- /Report listing -->

		<!-- Bottom paginator -->
		<div class="rb_nav-controls r-5">
			<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td>
						<ul class="link-toggle report-list-toggle lt-icons-and-text">
							<li class="active"><a href="#rb_list-view" class="list"><?php echo Kohana::lang('ui_main.list'); ?></a></li>
							<li><a href="#rb_map-view" class="map"><?php echo Kohana::lang('ui_main.map'); ?></a></li>
						</ul>
					</td>
					<td><?php echo $pagination; ?></td>
					<td></td>
					<td class="last">
						<ul class="link-toggle lt-icons-only">
							<?php //@todo Toggle the status of these links depending on the current page ?>
							<li><a href="#" class="prev" id="page_<?php echo $previous_page; ?>"><?php echo Kohana::lang('ui_main.previous'); ?></a></li>
							<li><a href="#" class="next" id="page_<?php echo $next_page; ?>"><?php echo Kohana::lang('ui_main.next'); ?></a></li>
						</ul>
					</td>
				</tr>
			</table>
		</div>
		<!-- /Bottom paginator -->


