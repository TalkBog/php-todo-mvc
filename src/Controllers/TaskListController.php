<?php
class TaskListController extends AbstractController {
  
  public function render () : void {
      $orderBy = $_GET['order-by'] ?? null;
      $search = $_GET['search'] ?? null;
      $hideCompleted = $_GET['only-show-completed'] ?? null;
      $page = $_GET["page"] ?? null;
   echo get_template( __PROJECT_ROOT__ . "/Views/list.php", [
     'tasks' => $this->taskService->list(["orderBy"=>$orderBy, "search"=>$search, "hideCompleted"=>$hideCompleted, "page"=>$page])['tasks']
   ] );
  }
  
}