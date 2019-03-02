<?php
//get tasklist array from POST
$task_list = filter_input(INPUT_POST, 'tasklist', 
        FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
if ($task_list === NULL) {
    $task_list = array();
    
//    add some hard-coded starting values to make testing easier
//    $task_list[] = 'Write chapter';
//    $task_list[] = 'Edit chapter';
//    $task_list[] = 'Proofread chapter';
}

//get action variable from POST
$action = filter_input(INPUT_POST, 'action');

//initialize error messages array
$errors = array();

//process
switch( $action ) {
    case 'Add Task':
        $new_task = filter_input(INPUT_POST, 'newtask');
        if (empty($new_task)) {
            $errors[] = 'The new task cannot be empty.';
        } else {
            // book original method
            //$task_list[] = $new_task;
            
            // use array_push method as recommend in the book
            //array_push($task_list, $new_task);

            // optional challenge method
            array_unshift($task_list, $new_task);
        }
        break;

    case 'Remove Task':
        // check if task 
        if (empty($task_list)) {
            $errors[] = 'Cannot remove if the task list is empty. \n Please add some tasks :)!';
        } else {
            array_shift($task_list);
        }
        break;

    case 'Delete Task':
        $task_index = filter_input(INPUT_POST, 'taskid', FILTER_VALIDATE_INT);
        if ($task_index === NULL || $task_index === FALSE) {
            $errors[] = 'The task cannot be deleted.';
        } else {
            // delete
            unset($task_list[$task_index]);

            // re-index the array
            $task_list = array_values($task_list);
        }
        break;

    case 'Modify Task':   
        $task_index = filter_input(INPUT_POST, 'taskid', FILTER_VALIDATE_INT);
        if ($task_index === NULL || $task_index === FALSE) {
            $errors[] = 'The task cannot be modified.';
        } else {
            $task_to_modify = $task_list[$task_index];
        }
        break;

    case 'Save Changes':
        // get modified item index
        $i = filter_input(INPUT_POST, 'modifiedtaskid', FILTER_VALIDATE_INT);

        // get new modified task name
        $modified_task = filter_input(INPUT_POST, 'modifiedtask');

        // check if modified task is empty and check if index is valid
        // otherwise proceed 
        if (empty($modified_task)) {
            $errors[] = 'The modified task cannot be empty.';
        } elseif($i === NULL || $i === FALSE) {
            $errors[] = 'The task cannot be modified.';        
        } else {
            // assign the new modified task name to the task list
            $task_list[$i] = $modified_task;
            $modified_task = '';
        }
        break;

    case 'Cancel Changes':
        $modified_task = '';
        break;

    case 'Promote Task':
        $task_index = filter_input(INPUT_POST, 'taskid', FILTER_VALIDATE_INT);
        if ($task_index === NULL || $task_index === FALSE) {
            $errors[] = 'The task cannot be promoted.';
        } else if ($task_index == 0){
            $errors[] = 'The task cannot be promoted any further.';
        } else {
            // swap task
            $temp = $task_list[$task_index-1];
            $task_list[$task_index-1] = $task_list[$task_index];
            $task_list[$task_index] = $temp;
        }
        break;

    case 'Sort Tasks':
        $task_index = filter_input(INPUT_POST, 'taskid', FILTER_VALIDATE_INT);
        if ($task_index === NULL || $task_index === FALSE) {
            $errors[] = 'The task cannot be sorted.';
        } else {
            sort($task_list);
        }
        break;
}

include('task_list.php');
?>