<?php
class ModelInstall extends Model {
	public function mysql($data) {
		$connection = mysqli_connect($data['db_host'], $data['db_user'], $data['db_password']);
		
		//mysqli_select_db($connection,$data['db_name']);
		mysqli_query($connection,"USE `{$data['db_name']}`");
		
		mysqli_query($connection,"SET NAMES 'utf8'");
		mysqli_query($connection,"SET CHARACTER SET utf8");
		
		$file = DIR_APPLICATION . 'shopine.sql';
		$demo = DIR_APPLICATION . 'demo.sql';
	
		if ($sql = file($file)) {
			$query = '';

			foreach($sql as $key=>$line) {
				$tsl = trim($line);

				if (($line != '') && (substr($tsl, 0, 2) != "--") && (substr($tsl, 0, 1) != '#')) {
					$query .= $line;
  
					if (preg_match('/;\s*$/', $line)) {
						$query = str_replace("DROP TABLE IF EXISTS `si_", "DROP TABLE IF EXISTS `" . $data['db_prefix'], $query);
						$query = str_replace("CREATE TABLE `si_", "CREATE TABLE `" . $data['db_prefix'], $query);
						$query = str_replace("INSERT INTO `si_", "INSERT INTO `" . $data['db_prefix'], $query);
											
						$result = mysqli_query($connection,$query);
  
						if (!$result) {
							echo 'line:'.$key;
							die(mysqli_error());
						}
	
						$query = '';
					}
				}
			}

			if(!empty($data['db_demo']) && $sql = file($demo)){
				$query = '';
				foreach($sql as $key=>$line) {
					$tsl = trim($line);
					if (($line != '') && (substr($tsl, 0, 2) != "--") && (substr($tsl, 0, 1) != '#')) {
						$query .= $line;
	  
						if (preg_match('/;\s*$/', $line)) {
							$query = str_replace("INSERT INTO `si_", "INSERT INTO `" . $data['db_prefix'], $query);
												
							$result = mysqli_query($connection,$query);
	  
							if (!$result) {
								echo 'line:'.$key;
								die(mysqli_error());
							}
		
							$query = '';
						}
					}
				}
			}
			
			mysqli_query($connection,"SET CHARACTER SET utf8");
	
			mysqli_query($connection,"SET @@session.sql_mode = 'MYSQL40'");
		
			mysqli_query($connection,"DELETE FROM from `" . $data['db_prefix'] . "user` WHERE user_id = '1'");
		
			mysqli_query($connection,"INSERT INTO `" . $data['db_prefix'] . "user` SET user_id = '1', user_group_id = '1', username = '" . mysqli_real_escape_string($connection,$data['username']) . "', password = '" . mysqli_real_escape_string($connection,md5($data['password'])) . "', status = '1', email = '" . mysqli_real_escape_string($connection,$data['email']) . "', date_added = NOW()");

			mysqli_query($connection,"DELETE FROM `" . $data['db_prefix'] . "setting` WHERE `key` = 'config_email'");
			mysqli_query($connection,"INSERT INTO `" . $data['db_prefix'] . "setting` SET `group` = 'config', `key` = 'config_email', value = '" . mysqli_real_escape_string($connection,$data['email']) . "'");
			
			mysqli_query($connection,"DELETE FROM `" . $data['db_prefix'] . "setting` WHERE `key` = 'config_url'");
			mysqli_query($connection,"INSERT INTO `" . $data['db_prefix'] . "setting` SET `group` = 'config', `key` = 'config_url', value = '" . mysqli_real_escape_string($connection,HTTP_SHOPINE) . "'");
			
			mysqli_query($connection,"UPDATE `" . $data['db_prefix'] . "product` SET `viewed` = '0'");
			
			mysqli_close($connection);	
		}		
	}	
}
?>
