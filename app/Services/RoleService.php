<?php

namespace App\Services;

use App\Repositories\RoleRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;

class RoleService
{
    protected $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function getAllRoles()
    {
        return $this->roleRepository->getAll();
    }

    public function findRoleById($id)
    {
        return $this->roleRepository->findById($id);
    }

    public function createRole(array $data)
    {
        DB::beginTransaction();
        try {
            $role = $this->roleRepository->create(['name' => $data['name']]);
            
            if (isset($data['permission']) && is_array($data['permission'])) {
                $this->syncPermissions($role, $data['permission']);
            }

            DB::commit();
            return $role;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating role: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updateRole($id, array $data)
    {
        DB::beginTransaction();
        try {
            $role = $this->roleRepository->update($id, ['name' => $data['name']]);
            
            if (isset($data['permission']) && is_array($data['permission'])) {
                $this->syncPermissions($role, $data['permission']);
            } else {
                $role->syncPermissions([]);
            }

            DB::commit();
            return $role;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating role: ' . $e->getMessage());
            throw $e;
        }
    }

    public function deleteRole($id)
    {
        return $this->roleRepository->delete($id);
    }

    protected function syncPermissions($role, array $permissions)
    {
        foreach ($permissions as $permName) {
            Permission::firstOrCreate(['name' => $permName, 'guard_name' => 'web']);
        }
        $role->syncPermissions($permissions);
    }
}
