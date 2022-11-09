<?php
class TaskListController extends AbstractController {
  
  public function render () : void {
      $orderBy = $GET['order-by'] ?? null;
      $search = $GET['search'] ?? null;
      $hideCompleted = $GET['only-show-completed'] ?? null;
      $page = $_GET["page"] ?? null;
   echo get_template( __PROJECT_ROOT__ . "/Views/list.php", [
     'tasks' => $this->taskService->list(["orderBy"=>$orderBy, "search"=>$search, "hideCompleted"=>$hideCompleted, "page"=>$page])['tasks']
   ] );
  }
  
}