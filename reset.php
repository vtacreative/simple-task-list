<?php
	error_reporting(E_ALL);
	require 'head.html';
	
	define('CREATE_TASKS',"CREATE table tasks(
		tid integer primary key,
		pid integer not null,
		task text not null,
		added datetime not null,
		completed datetime)");
	$dbc = new SQLiteDatabase("tasks.db",0644);
	$dbc->query('DROP TABLE tasks');
	@$dbc->query(CREATE_TASKS);
	$dbc->query("INSERT INTO tasks values(NULL,0,'Finish Coffee',datetime('now'),'0000-00-00 00:00:00')");
	$dbc->query("INSERT INTO tasks values(NULL,0,'Write Some Code',datetime('now'),'0000-00-00 00:00:00')");
	$dbc->query("INSERT INTO tasks values(NULL,0,'Get Some Exercise',datetime('now'),'0000-00-00 00:00:00')");
	$dbc->query("INSERT INTO tasks values(NULL,0,'Practice Creative Writing',datetime('now'),'0000-00-00 00:00:00')");
	$dbc->query("INSERT INTO tasks values(NULL,0,'Stay Healthy',datetime('now'),'0000-00-00 00:00:00')");
	$dbc->query("INSERT INTO tasks values(NULL,0,'Cultivate Social Life',datetime('now'),'0000-00-00 00:00:00')");
	$dbc->query("INSERT INTO tasks values(NULL,0,'Play With Daughter',datetime('now'),'0000-00-00 00:00:00')");
	$res = $dbc->query("SELECT * FROM tasks",SQLITE_ASSOC);
	echo '<br /><br /><fieldset><h3>Current Tasks</h3>';
	foreach($res as $row) {
	    var_dump($row);
	}
?>
		</fieldset>
		<p>
			<a href="view_tasks2.php">View</a>  | 
			<a href="add_task2.php">Add</a>  | 
			<a href="reset.php">Reset</a>
		</p>
	</wrapper>
</body>
</html>