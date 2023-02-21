<?php

namespace App\Trello\controllers;

use App\Trello\models\ListModel;
use App\Trello\models\ProjectModel;
use App\Trello\controllers\AbstractController;

class BoardController extends AbstractController
{
    public function index()
    {
        $listModel = new ListModel();
        $projectModel = new ProjectModel();
        
        $project_id = $_GET['id'];
        $title = $_POST['title'] ?? null;
        
        if(!empty($title)) {
            $listModel->create($title, $project_id);
        }
        
        $action = $_POST['action'] ?? null;
        switch ($action) {
            case 'delete':
                $list_id = $_POST["list_id"];
                $listModel->delete($list_id, $project_id);
                break;
        }

        $project = $projectModel->find($project_id);
        $lists = $listModel->findByProject($project_id);

        $this->render('project', [
            'project' => $project,
            'lists' => $lists
        ]);
    }
}
