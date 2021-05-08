<?php
namespace App\Repositories\Interfaces;
use App\Repositories\BaseRepositoryInterface;
use App\Models\Project;

interface ProjectRepositoryInterface extends BaseRepositoryInterface {
    public function all($columns = array('*'));
    public function paginate($perPage = 9);
    public function listProjects($order = 'id', $sort = 'desc', array $columns = array());
    public function findProjectById(int $id);
    public function destroy($id);
}