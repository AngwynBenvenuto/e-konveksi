<?php

namespace App\Repositories;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use App\Models\Project;
use Illuminate\Config\Repository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProjectRepository implements ProjectRepositoryInterface {
    protected $project;
	protected $config;
	public function __construct(Project $project) {
		$this->project = $project;
    }

	public function all($columns = array('*')) {}
    public function listProjects($order = 'id', $sort = 'desc', array $columns = array()){}
    public function paginate($perPage = 0) {
		$perPage = $perPage ? $perPage : $this->config->get('project.perPage');
		return $this->project->orderBy('id')->paginate($perPage);
	}
	public function findProjectById(int $id) {
		try {
            return $this->product->find($id);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e);
        }
	}
    public function destroy($id) {}
}