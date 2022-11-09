<?php

class TaskEntity {
    private int $id;
    private string $title;
    private string $description;
    private string $completed;
    private string $createdAt;
    private string $updatedAt;
    private string $completedAt;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id): TaskEntity
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): TaskEntity
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->desccription;
    }

    /**
     * @param string $desccription
     * @return $this
     */
    public function setDescription(string $desccription): TaskEntity
    {
        $this->desccription = $desccription;
        return $this;
    }

    /**
     * @return string
     */
    public function isCompleted(): string
    {
        return $this->completed;
    }

    /**
     * @param string $completed
     * @return $this
     */
    public function setCompleted(string $completed): TaskEntity
    {
        $this->completed = $completed;
        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt(string $createdAt): TaskEntity
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    /**
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt(string $updatedAt): TaskEntity
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return string
     */
    public function getCompletedAt(): ?string
    {
        return $this->completedAt ?? null;
    }

    /**
     * @param string $completedAt
     * @return $this
     */
    public function setCompletedAt(string $completedAt): TaskEntity
    {
        $this->completedAt = $completedAt;
        return $this;
    }



}
