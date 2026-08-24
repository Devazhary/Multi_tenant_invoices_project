<?php

namespace App\Repositories;

use Spatie\Permission\Models\Role;

class RoleRepository implements RoleRepositoryInterface
{
    public function getAll()
    {
        return Role::withCount(['users', 'permissions'])->orderBy('id', 'DESC')->paginate(5);
    }

    public function findById($id)
    {
        return Role::findOrFail($id);
    }

    public function create(array $data)
    {
        return Role::create($data);
    }

    public function update($id, array $data)
    {
        $role = $this->findById($id);
        $role->update($data);
        return $role;
    }

    public function delete($id)
    {
        $role = $this->findById($id);
        return $role->delete();
    }
}
