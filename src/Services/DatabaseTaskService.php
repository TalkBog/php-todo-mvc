<?php

class DatabaseTaskService implements TaskServiceInterface
{
    use SingletonTrait;

    /**
     * @var TaskEntity[]
     */
    private array $data;
    private Database $database;

    protected function __construct() {
        $this->database = Database::getInstance();
        $this->init();
    }


    /**
     * Generate sample tasks
     *
     * @return void
     */
    private function init() : void {
        $sentence = $this->database->get()-> prepare("SELECT * FROM tache;");
        $sentence -> execute();
        $taches = $sentence->fetchAll();
        $this->data = [];
        foreach ($taches as $tache){

            $this->data[$tache[0]] = (new TaskEntity())
                ->setId( $tache[0] )
                ->setTitle($tache[1] )
                ->setDescription( $tache[2] )
                ->setCompleted($tache[3]? 1:0)
                ->setCreatedAt( $tache[4] )
                ->setUpdatedAt($tache[5]);
            if($tache[6]!=null){
                $this->data[$tache[0]]->setCompletedAt($tache[6]);
            }

        }
    }

    public function get(int $id): ?TaskEntity
    {
        return $this->data[$id] ?? null;
    }

    public function list(array $args = []): array
    {
        $results = [];

        // Filters results : we exclude unwanted tasks from output
        foreach ( $this->data as $task ) :
            // Search filter
            if ( isset( $args['search'] ) && ! str_contains( $task->getTitle(), $args['search'] ) )
                continue;

            // If we only want to show uncompleted tasks
            if ( isset( $args['hideCompleted'] ) && $args['hideCompleted'] && $task->isCompleted() )
                continue;

            $results[] = $task;
        endforeach;

        // Order by handling
        usort( $results, function ( TaskEntity $a, TaskEntity $b ) use ( $args ) {
            switch ( $args['orderBy'] ?? null ) :
                case "title":
                    return strnatcmp($a->getTitle(), $b->getTitle());

                case "completedAt":
                    $aTime = strtotime( $a->getCompletedAt() ?? 0 );
                    $bTime = strtotime( $b->getCompletedAt() ?? 0 );

                    if ( $aTime === $bTime )
                        return 0;

                    return $aTime > $bTime
                        ? -1
                        : 1;

                case "createdAt":
                default:
                    $aTime = strtotime( $a->getCreatedAt() );
                    $bTime = strtotime( $b->getCreatedAt() );

                    if ( $aTime === $bTime )
                        return 0;

                    return $aTime > $bTime
                        ? -1
                        : 1;
            endswitch;
        } );
        $page = $args['page'] ?? 1;
        $perPage = $args['perPage'] ?? 10;

        return array(
            'page' => $page,
            'perPage' => $perPage,
            'total' => count($results),
            'tasks' => array_slice($results, ($page-1)*$perPage, 10, true)
        );
    }

    public function create(TaskEntity $task): TaskEntity
    {
        $lastId = count($this->data);

        $this->data[$lastId] = $task;
        $task->setId($lastId);
        $task->setCreatedAt( date("Y-m-d H:i:s") );

        $sentence = $this->database->get()->prepare("INSERT INTO tache (title,description,completed) VALUES (:title,:description,:completed);");
        $sentence -> execute(["title"=>$task->getTitle(), "description"=>$task->getDescription(), "completed"=> $task->isCompleted()? 1 : 0]);

        return $task;
    }

    public function update(TaskEntity $task): TaskEntity
    {
        $this->data[ $task->getId() ] = $task;
        $sentence = $this->database->get()->prepare("UPDATE tache SET title=:title, description=:description, completed=:completed, completedAt=>:completedAt WHERE id=:id;");
        $sentence ->execute(['id'=>$task->getId(), "title"=>$task->getTitle(), "description"=>$task->getDescription(), "completed"=> $task->isCompleted()? 1 : 0, "completedAt" => $task->getCompletedAt()]);
        return $task;
    }

    public function delete(int $id): void
    {
        unset( $this->data[ $id ] );
        $sentence = $this->database->get()->prepare("DELETE tache WHERE id=:id;");
        $sentence->execute(["id"=>$id]);
    }
}