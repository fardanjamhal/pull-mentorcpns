<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\Contracts\User\UserInterface;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use App\Models\MasterData\Student;
use Illuminate\Support\Arr;
use Ramsey\Uuid\Uuid;

class UserRepository extends BaseRepository implements UserInterface
{
    /**
     * @var
     */
    protected $model;

    public function __construct()
    {
        $this->model = new User();
    }

    public function getAllPaginatedWithParams($params, $limit = 10)
    {
        $users = $this->model->query();
        if(isset($params->search) && !empty($params->search)) $users->where('name', 'like', '%' . $params->search . '%');
        $users = $users->orderBy('created_at', 'ASC')->paginate($limit);

        $users->appends([
            'search' => $params->search,
        ]);

        return $users;
    }

    public function getAllUserStudentSimplePaginatedWithParams($params, $limit = 10)
    {
        $users = $this->model->query();
        if(isset($params->search) && !empty($params->search)) $users->where('name', 'like', '%' . $params->search . '%');
        $users = $users->with(['student'])->where('level', 2)->orderBy('created_at', 'ASC')->paginate($limit);
        return $users;
    }

    public function create($attributes)
    {
        $attributes = $attributes->all();
        $attributes['password'] = bcrypt($attributes['password']);
    
        $user = $this->model->create($attributes);

        $attributes['user_id'] = $user->id;
        $attributes['is_member'] = $attributes['member_type'] == 1 ? 1 : 0;
        Student::create($attributes);

        return $user;
    }

    public function update($attributes, $id)
    {
        $user = $this->model->find($id);

        $attributes = $attributes->all();

        if (!empty($attributes['password'])) {
            $attributes['password'] = bcrypt($attributes['password']);
        } else {
            $attributes = Arr::except($attributes,array('password'));
        }

        $attributes['expiry_verification_date'] = $attributes['is_active'] == 0 ? null : $user->is_active;
        $user->update($attributes);

        Student::updateOrInsert(
            ['user_id' => $user->id],
            [
                'id' => Uuid::uuid4()->toString(),
                'province_id' => $attributes['province_id'],
                'city_id' => $attributes['city_id'],
                'district_id' => $attributes['district_id'],
                'village_id' => $attributes['village_id'],
                'address' => $attributes['address'],
                'phone_number' => $attributes['phone_number'],
                'gender' => $attributes['gender'],
                'is_member' => $attributes['member_type'] == 1 ? 1 : 0
            ]
        );

        return $user;
    }

    public function find($id)
    {
        return $this->model->with(['userMemberCategory', 'userMemberCategory.category', 'student', 'student.province', 'student.city', 'student.district', 'student.village'])->find($id);
    }

    public function getTotalStudent()
    {
        return $this->model->where('level', 2)->count();
    }

    public function getTotalStudentActive()
    {
        return $this->model->where(['level' => 2, 'is_active' => 1])->count();
    }

    public function getTotalStudentNonActive()
    {
        return $this->model->where(['level' => 2, 'is_active' => 0])->count();
    }

    public function getTotalStudentMember()
    {
        return $this->model->where('level', 2)->whereHas('student', function(Builder $query) {
            $query->where('is_member', 1);
        })->count();
    }
}
