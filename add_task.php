<?php
	error_reporting(E_ALL);
	require 'head.html';
	$dbc = sqlite_open("tasks.db",0666) or die("Failed to open</body></html>");
	
	if(isset($_POST['submitted']) && !empty($_POST['task'])) {
		if(isset($_POST['pid'])) {
			$pid = (int) $_POST['pid'];
		} else {
			$pid = 0;
		}
		
		//$q = "INSERT INTO tasks values(NULL,$pid,'$task',datetime('now'),'0000-00-00 00:00:00')";
		$q = sprintf("INSERT INTO tasks (tid,pid,task,added,completed) values (NULL,%d,'%s',datetime('now'),'0000-00-00 00:00:00')", $pid, sqlite_escape_string($_POST['task']));
		$r = sqlite_query($dbc,$q);
	}
?>
		<fieldset>
			<form action="add_task.php" method="post">
				<h3>Add Task</h3>
				<p>Task: <input name="task" type="text" size="60" maxlength="120"></p>
				<p>Parent Task: <select name="pid"><option value="0">None</option>
		
<?php
	$q = 'SELECT tid,pid,task FROM tasks WHERE completed="0000-00-00 00:00:00" ORDER BY added ASC';
	$r = sqlite_query($dbc,$q);
	while(list($tid,$pid,$task) = sqlite_fetch_array($r,SQLITE_NUM)) {
		echo "<option value=\"$tid\">$task</option><br />";
		$tasks[] = array('tid' => $tid,'pid' => $pid,'task' => $task);
	}
?>
				</select></p>
				<input name="submitted" type="hidden" value="true">
				<input name="submit" type="submit" value="Add This Task">
			</form>
		</fieldset>
	
<?php
	function parent_sort($x,$y) {
		return ($x['pid'] > $y['pid']);
	}
	usort($tasks,'parent_sort');
	echo '<fieldset><h3>Current Tasks</h3><ul>';
	foreach($tasks as $task) {
		echo "<li>{$task['task']}</li><br>";
	}
	//var_dump($_POST);
?>

		</ul>
		</fieldset>
		<p>
			<a href="view_tasks2.php">View</a>  | 
			<a href="add_task2.php">Add</a>  | 
			<a href="reset.php">Reset</a>
		</p>
	</wrapper>
</body>
</html>