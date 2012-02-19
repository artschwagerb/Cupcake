<?php

class statistics {
	
	function stat_shows($hours) {
		$dbstuff = new databee();
						$res = $dbstuff->query("SELECT *,COUNT(*) AS 'total' FROM v_episode_view WHERE date_of_play > DATE_SUB( NOW(), INTERVAL $hours HOUR) GROUP BY tvdb_episode_id;");
						?>
						<div class="row">
							<div class="six columns">
								<p>TV Shows Watched in Last <?php echo $hours; ?> Hours</p>
							</div>
							<div class="two columns">
								<?php echo mysql_num_rows($res); ?>
							</div>
							<div class="one column">
										<p><a class="xsmall white nice button radius" href="javascript:;" onmousedown="toggleDiv('last48hours_views',this);">v</a></p>
							</div>
						</div>
						
						<div id="last48hours_views" style="display: none; " class="row">
							<div class="twelve columns">
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
						</div>
						
						<?php
	}
	
	function stat_newsfeed($hours) {
		$dbstuff = new databee();
			$res = $dbstuff->query("SELECT * FROM v_episode_view WHERE date_of_play > DATE_SUB( NOW(), INTERVAL $hours HOUR) ORDER BY date_of_play DESC;");
			?>
			<div class="row">
							<div class="six columns">
								<p>News Feed of Last <?php echo $hours; ?> Hours</p>
							</div>
							<div class="two columns">
								<?php echo mysql_num_rows($res); ?>
							</div>
							<div class="one column">
								<p><a class="xsmall white nice button radius" href="javascript:;" onmousedown="toggleDiv('last_<?php echo $hours; ?>_hours_newsfeed',this);">v</a></p>
							</div>
						</div>
			<div id="last_<?php echo $hours; ?>_hours_newsfeed" style="display: none; " class="row">
			<?php
			if(mysql_num_rows($res) != 0){
				while($row = mysql_fetch_assoc($res)) {
				$episode = new episode($row['tvdb_episode_id']);
				$user = new user($row['user_id']);
				?>
					<div class="row">
						<div class="eight columns">
							<p><?php echo ucfirst($user->username); ?> watched <a href="player.php?id=<?php echo $episode->tvdb_episode_id; ?>"><?php echo $episode->show->name; ?> - <?php echo $episode->name; ?></a></p>
						</div>
						<div class="four columns">
							<p><?php echo date('F j, Y, g:i a', strtotime($row['date_of_play'])); ?></p>
						</div>
					</div>
				<?php
				}
			}
	}
	
	

}