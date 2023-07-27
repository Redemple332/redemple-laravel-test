<?php

namespace App\Repository\Base;

use App\Models\Document;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


abstract class BaseRepository implements BaseRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function filter(array $search = [])
    {
        return $this->model->filter($search)->get();
    }

    public function getList(array $search = [], array $relations = [], string $sortByColumn = 'created_at', string $sortByOrder = 'DESC')
    {
        if ($relations) {
            $this->model = $this->model->with($relations);
        }
        return $this->model->orderBy($sortByColumn, $sortByOrder)->paginate(request('limit') ?? 10);
    }


    public function find($id, $with = []): ?Model
    {
        $record = $this->model->with($with)->find($id);
        if ($record) {
            return $record;
        } else{
            $this->notFound();
        }
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        $model = $this->model->find($id);
        if ($model){
            $model->update($data);
            return $model->fresh();
        } else{
            $this->notFound();
        }
    }

    public function delete(string $id, string $deletion_note = null)
    {
        $model = $this->model->find($id);
        if ($model) {
            if($deletion_note){
                $model->update(['deletion_note' =>  $deletion_note]);
            }
            $model->delete();
        } else{
            $this->notFound();
        }
    }

    public function notFound(){
        throw ValidationException::withMessages([
            'record_not_found' => "Record not found"
        ]);
    }


}
