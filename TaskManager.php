<?php

class TaskManager {
    private $filePath;

    public function __construct($filePath) {
        $this->filePath = $filePath;
        if (!file_exists($filePath)) {
            file_put_contents($filePath, json_encode([]));
        }
    }

    public function getTasks() {
        return json_decode(file_get_contents($this->filePath), true);
    }

    public function addTask($taskName) {
        $tasks = $this->getTasks();
        $tasks[] = [
            'id' => uniqid(),
            'name' => $taskName
        ];
        $this->saveTasks($tasks);
    }

    public function deleteTask($taskId) {
        $tasks = $this->getTasks();
        $tasks = array_filter($tasks, function ($task) use ($taskId) {
            return $task['id'] !== $taskId;
        });
        $this->saveTasks($tasks);
    }

    private function saveTasks($tasks) {
        file_put_contents($this->filePath, json_encode($tasks, JSON_PRETTY_PRINT));
    }
}
