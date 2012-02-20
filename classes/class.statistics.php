<?php

class statistics {
	
	function get_shows_watched_summary($hours) {
		$dbstuff = new databee();
						$res = $dbstuff->query("SELECT *,COUNT(*) AS 'total' FROM v_episode_view WHERE date_of_play > DATE_SUB( NOW(), INTERVAL $hours HOUR) GROUP BY tvdb_episode_id;");
						?>
						<div class="row">
							<div class="eight columns">
								<h6>TV Shows Watched in Last <?php echo $hours; ?> Hours</h6>
							</div>
							<div class="one column">
								<?php echo mysql_num_rows($res); ?>
							</div>
							<div class="two columns">
								Shows
							</div>
							<div class="one column">
										<p><a class="xsmall white nice button radius" href="javascript:;" onmousedown="toggleDiv('last_<?php echo $hours; ?>_hours_shows',this);">v</a></p>
							</div>
						</div>
						
						<div id="last_<?php echo $hours; ?>_hours_shows" style="display: none; " class="row">
								<div class="panel">
								<div class="row">
										<div class="eight columns">
											<p><b>Show</b></p>
										</div>
										<div class="four columns">
											<p><b>Views</b></p>
										</div>
									</div>
								<?php
								if(mysql_num_rows($res) != 0){
									while($row = mysql_fetch_assoc($res)) {
									$episode = new episode($row['tvdb_episode_id']);
									$user = new user($row['user_id']);
									?>
									<div class="row">
										<div class="eight columns">
											<p><a href="player.php?id=<?php echo $episode->tvdb_episode_id; ?>"><?php echo $episode->show->name; ?> - <?php echo $episode->name; ?></a></p>
										</div>
										<div class="four columns">
											<p><?php echo $row['total']; ?></p>
										</div>
									</div>
									<?php
									}
								}
								?>
								</div>
						</div>
						
						<?php
	}
	
	function get_newsfeed($hours) {
		$dbstuff = new databee();
			$res = $dbstuff->query("SELECT * FROM v_episode_view WHERE date_of_play > DATE_SUB( NOW(), INTERVAL $hours HOUR) ORDER BY date_of_play DESC;");
			?>
			<div class="row">
							<div class="eight columns">
								<h6>News Feed of Last <?php echo $hours; ?> Hours</h6>
							</div>
							<div class="one column">
								<?php echo mysql_num_rows($res); ?>
							</div>
							<div class="two columns">
								Entries
							</div>
							<div class="one column">
								<p><a class="xsmall white nice button radius" href="javascript:;" onmousedown="toggleDiv('last_<?php echo $hours; ?>_hours_newsfeed',this);">v</a></p>
							</div>
			</div>
			<div id="last_<?php echo $hours; ?>_hours_newsfeed" style="display: none; " class="row">
			<div class="panel">
			<?php
			if(mysql_num_rows($res) != 0){
				while($row = mysql_fetch_assoc($res)) {
				$episode = new episode($row['tvdb_episode_id']);
				$user = new user($row['user_id']);
				?>
					<div class="row">
						<div class="eight columns">
							<p><a href="user.php?id=<?php echo $user->id; ?>"><?php echo ucfirst($user->username); ?></a> watched <a href="player.php?id=<?php echo $episode->tvdb_episode_id; ?>"><?php echo $episode->show->name; ?> - <?php echo $episode->name; ?></a></p>
						</div>
						<div class="four columns">
							<p><?php echo date('F j, Y, g:i a', strtotime(TIME_OFFSET, strtotime($row['date_of_play']))); ?></p>
						</div>
					</div>
				<?php
				}
			}
			?>
			</div>
			</div>
			<?php
	}
	
		function get_newsfeed_summary($hours) {
		$dbstuff = new databee();
			$res = $dbstuff->query("SELECT * FROM v_episode_view WHERE date_of_play > DATE_SUB( NOW(), INTERVAL $hours HOUR) ORDER BY date_of_play DESC LIMIT 5;");
			?>
			<?php
			if(mysql_num_rows($res) != 0){
				while($row = mysql_fetch_assoc($res)) {
				$episode = new episode($row['tvdb_episode_id']);
				$user = new user($row['user_id']);
				?>
					<div class="row">
						<div class="row" style="margin-bottom: 5px; ">
							<div class="twelve columns">
								<span style="font-size: 12px; ">
									<a href="show.php?id=<?php echo $episode->show->tvdb_series_id; ?>"><?php echo $episode->show->name; ?></a>
								</span>
								<br />
								<span style="font-size: 10px; ">
									<a href="player.php?id=<?php echo $episode->tvdb_episode_id; ?>"><?php echo $episode->name; ?></a>
								</span>
							</div>
						</div>
						<div class="row">
							<div class="nine columns">		
								<span style="font-size: 9px; text-decoration: none;"><a class="clean" href="user.php?id=<?php echo $user->id; ?>"><?php echo ucfirst($user->displayname); ?></a></span>
							</div>
							<div class="three columns">		
								<span style="font-size: 9px; "><?php echo date('g:i a', strtotime(TIME_OFFSET, strtotime($row['date_of_play']))); ?></span>
							</div>
						</div>
					</div>
					<hr style="margin-top: 4px; margin-bottom: 4px;"/>
				<?php
				}
			}
			?>
			<?php
	}
	
	function get_shows_unwatched($hours) {
		$dbstuff = new databee();
		$res = $dbstuff->query("SELECT *,COUNT(*) AS 'total' FROM v_episode_view WHERE date_of_play > DATE_SUB( NOW(), INTERVAL $hours HOUR) GROUP BY tvdb_episode_id;");
		
		?>
			<div class="row">
				<div class="eight columns">
					<h6>TV Shows Watched in Last <?php echo $hours; ?> Hours</h6>
				</div>
				<div class="one column">
					<?php echo mysql_num_rows($res); ?>
				</div>
				<div class="two columns">
					Shows
				</div>
				<div class="one column">
							<p><a class="xsmall white nice button radius" href="javascript:;" onmousedown="toggleDiv('last_<?php echo $hours; ?>_hours_shows',this);">v</a></p>
				</div>
			</div>
			
			<div id="last_<?php echo $hours; ?>_hours_shows" style="display: none; " class="row">
					<div class="panel">
					<?php
					if(mysql_num_rows($res) != 0){
						while($row = mysql_fetch_assoc($res)) {
						$episode = new episode($row['tvdb_episode_id']);
						$user = new user($row['user_id']);
						?>
						<div class="row">
							<div class="eight columns">
								<p><a href="player.php?id=<?php echo $episode->tvdb_episode_id; ?>"><?php echo $episode->show->name; ?> - <?php echo $episode->name; ?></a></p>
							</div>
							<div class="four columns">
								<p><?php echo $row['total']; ?></p>
							</div>
						</div>
						<?php
						}
					}
					?>
					</div>
			</div>
			
		<?php
	
	}
	
	function get_users_active($hours) {
		$dbstuff = new databee();
		$res = $dbstuff->query("SELECT id FROM u_user WHERE lastDate > DATE_SUB( NOW(), INTERVAL $hours HOUR);");
		
		?>
			<div class="row">
				<div class="eight columns">
					<h6>Users Active in Last <?php echo $hours; ?> Hours</h6>
				</div>
				<div class="one column">
					<?php echo mysql_num_rows($res); ?>
				</div>
				<div class="two columns">
					Users
				</div>
				<div class="one column">
							<p><a class="xsmall white nice button radius" href="javascript:;" onmousedown="toggleDiv('last_<?php echo $hours; ?>_hours_users',this);">v</a></p>
				</div>
			</div>
			
			<div id="last_<?php echo $hours; ?>_hours_users" style="display: none; " class="row">
					<div class="panel">
					<div class="row">
						<div class="four columns">
							<p><b>Username</b></p>
						</div>
						<div class="three columns">
							<p><b>IP Address</b></p>
						</div>
						<div class="three columns">
							<p><b>Premium</b></p>
						</div>
						<div class="two columns">
							<p><b>Logged in</b></p>
						</div>
					</div>
					<?php
					if(mysql_num_rows($res) != 0){
						while($row = mysql_fetch_assoc($res)) {
						$user = new user($row['id']);
						?>
						<div class="row">
							<div class="four columns">
								<p><a href="user.php?id=<?php echo $user->id; ?>"><?php echo $user->username; ?></a></p>
							</div>
							<div class="three columns">
								<p><?php echo $user->last_ip; ?></p>
							</div>
							<div class="three columns">
								<p><?php if($user->CheckPremium()){echo "Yes";}else{echo "No";}; ?></p>
							</div>
							<div class="two columns">
								<p><?php echo date('g:i a', strtotime(TIME_OFFSET, strtotime($user->lastDate))); ?></p>
							</div>
						</div>
						<?php
						}
					}
					?>
					</div>
			</div>
			
		<?php
	
	}
	
		function get_shows() {
		$dbstuff = new databee();
		$res = $dbstuff->query("SELECT tvdb_series_id FROM v_show;");
		
		?>
			<div class="row">
				<div class="eight columns">
					<h6>Shows Currently Visible</h6>
				</div>
				<div class="one column">
					<?php echo mysql_num_rows($res); ?>
				</div>
				<div class="two columns">
					Shows
				</div>
				<div class="one column">
							<p><a class="xsmall white nice button radius" href="javascript:;" onmousedown="toggleDiv('shows_in_database',this);">v</a></p>
				</div>
			</div>
			
			<div id="shows_in_database" style="display: none; " class="row">
				<div class="panel">
					<div class="row">
							<div class="six columns">
								<p><b>Name</b></p>
							</div>
							<div class="three columns">
								<p><b>Date Updated</b></p>
							</div>
					</div>
					<?php
					if(mysql_num_rows($res) != 0){
						while($row = mysql_fetch_assoc($res)) {
						$show = new show($row['tvdb_series_id']);
						?>
						<div class="row">
							<div class="six columns">
								<p><a href="show.php?id=<?php echo $show->tvdb_series_id; ?>"><?php echo $show->name; ?></a></p>
							</div>
							<div class="three columns">
								<p><?php echo date('F j, Y', strtotime(TIME_OFFSET, strtotime($show->date_added))); ?></p>
							</div>
						</div>
						<?php
						}
					}
					?>
				</div>
			</div>
			
		<?php
	
	}
	
	function get_reported_comments() {
		$dbstuff = new databee();
		$res = $dbstuff->query("SELECT id FROM c_reported where status = 2;");
		
		?>
			<div class="row">
				<div class="eight columns">
					<h6>Reported Comments</h6>
				</div>
				<div class="one column">
					<?php echo mysql_num_rows($res); ?>
				</div>
				<div class="two columns">
					Comments
				</div>
				<div class="one column">
							<p><a class="xsmall white nice button radius" href="javascript:;" onmousedown="toggleDiv('shows_in_database',this);">v</a></p>
				</div>
			</div>
			
			<div id="shows_in_database" style="display: none; " class="row">
				<div class="panel">
					<div class="row">
							<div class="six columns">
								<p><b>Type</b></p>
							</div>
							<div class="three columns">
								<p><b>Link</b></p>
							</div>
					</div>
					<?php
					if(mysql_num_rows($res) != 0){
						while($row = mysql_fetch_assoc($res)) {
						$comment = new comment($row['id']);
						?>
						<div class="row">
							<div class="six columns">
								<p><a href="show.php?id=<?php echo $show->tvdb_series_id; ?>"><?php echo $show->name; ?></a></p>
							</div>
							<div class="three columns">
								<p><?php echo $show->date_added; ?></p>
							</div>
						</div>
						<?php
						}
					}
					?>
				</div>
			</div>
			
		<?php
	
	}
	
	function get_requests() {
		$dbstuff = new databee();
		$res = $dbstuff->query("SELECT id FROM c_comment where status_id = 1 and type =3;");
		
		?>
			<div class="row">
				<div class="eight columns">
					<h6>TV Show Requests</h6>
				</div>
				<div class="one column">
					<?php echo mysql_num_rows($res); ?>
				</div>
				<div class="two columns">
					Requests
				</div>
				<div class="one column">
							<p><a class="xsmall white nice button radius" href="javascript:;" onmousedown="toggleDiv('shows_requested',this);">v</a></p>
				</div>
			</div>
			
			<div id="shows_requested" style="display: none; " class="row">
				<div class="panel">
					<div class="row">
							<div class="six columns">
								<p><b>Type</b></p>
							</div>
							<div class="three columns">
								<p><b>Link</b></p>
							</div>
					</div>
					<?php
					if(mysql_num_rows($res) != 0){
						while($row = mysql_fetch_assoc($res)) {
						$comment = new comment($row['id']);
						?>
						<div class="row">
							<div class="six columns">
								<p><a href="user.php?id=<?php echo $comment->user->id; ?>"><?php echo $comment->user->username; ?></a></p>
							</div>
							<div class="three columns">
								<p><?php echo $comment->date_added; ?></p>
							</div>
						</div>
						<div class="row">
							<p><?php echo nl2br(strip_tags($comment->message)); ?></p>
						</div>
						<?php
						}
					}
					?>
				</div>
			</div>
			
		<?php
	
	}

}