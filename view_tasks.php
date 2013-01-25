<?php
	error_reporting(E_ALL);
	require 'head.html';
	
	echo '<fieldset><h3>Current Tasks</h3>';
	function make_list($parent) {
		global $tasks;
		echo '<ol>';
		foreach($parent as $tid => $todo) {
			echo <<<EOT
			<li><input type="checkbox" name="tasks[$tid]" value="done" /> $todo
EOT;
			if(isset($tasks[$tid])) {
				make_list($tasks[$tid]);
			}
			echo '</li>';
		}
		echo '</ol>';
	}
	
	$dbc = sqlite_open("tasks.db") or die("Failed to open</body></html>");
	if(isset($_POST['submitted']) && isset($_POST['tasks']) && is_array($_POST['tasks'])) {
		$q = 'UPDATE tasks SET completed=datetime() WHERE tid IN (';
		foreach($_POST['tasks'] as $tid => $v) {
			$q .= $tid . ', ';
		}
		
		$q = substr($q, 0, -2) . ')';
		$r = sqlite_query($dbc,$q);
	}
	$q = 'SELECT tid, pid, task FROM tasks WHERE completed="0000-00-00 00:00:00" ORDER BY pid, added ASC';
	$r = sqlite_query($dbc,$q);
	$tasks = array();
	while(list($tid,$pid,$task) = sqlite_fetch_array($r,SQLITE_NUM)) {
		$tasks[$pid][$tid] = $task;
	}
	// debug echo '<pre>' . print_r($tasks,1) . '</pre>';
?>
	
			<p>Check box and click "Update" to mark task as completed. Tasks marked as completed will disappear from the list, along with their respective subtasks.</p>
			<form action="view_tasks.php" method="post">
				<?php make_list($tasks[0]); ?>
				<input name="submitted" type="hidden" value="true">
				<input name="submit" type="submit" value="Update">
			</form>
		</fieldset>
		<p>
			<a href="view_tasks2.php">View</a>  | 
			<a href="add_task2.php">Add</a>  | 
			<a href="reset.php">Reset</a>
		</p>
	</wrapper>
</body>
</html>