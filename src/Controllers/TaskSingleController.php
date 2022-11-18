<?php

class TaskSingleController extends AbstractController {

    private TaskEntity $task;
    private bool $edit;

  public function __construct(TaskServiceInterface $taskService, $task_id) {
        parent::__construct(($taskService));
        if($task_id!=null){
            $this->task = $this->taskService->get($task_id);
            $this->edit = true;
        }
        else{
            $this->task = new TaskEntity();
            $this->task ->setTitle("Nouvelle Tache");
            $this->edit = false;
        }
        if(isset($_POST["name"])){
            $this->submit_form();
        }
  }
  
  public function render() : void {
    // TODO remplacez les valeurs avec celles d'une tâche
    echo get_template( __PROJECT_ROOT__ . "/views/single.php", [
      'task' => $this->task,
      'editing' => $this->edit
    ]);
  }

  public function submit_form() : void{
      $this->task->setTitle($_POST['name'])
          ->setDescription($_POST['content']);
      if (isset($_POST['completed'])){
          $this->task->setCompleted($_POST['completed']);
      }
      else{
          $this->task->setCompleted(false);
      }
      if($this->edit){
          $this->taskService->update($this->task);
      }
      else{
          $this->taskService->create($this->task);
      }

      header("location:http://localhost");
  }
  

}