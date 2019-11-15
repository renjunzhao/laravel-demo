<?php

namespace App\Repositories\User;

use App\Events\AddActivity;
use App\Events\AddFriend;
use App\Events\CreditDecrement;
use App\Events\UserNew;
use App\Jobs\UpgradeChangeGroup;
use App\Models\System\App;
use App\Models\Taoke\Order;
use App\Models\Taoke\Setting;
use App\Models\User\Code;
use App\Models\User\Group;
use Carbon\Carbon;
use Hashids\Hashids;
use App\Events\Upgrade;
use App\Models\Taoke\Pid;
use App\Models\User\User;
use App\Models\User\Level;
use App\Criteria\RequestCriteria;
use App\Exceptions\PhoneException;
use http\Exception\InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Validators\User\UserValidator;
use Illuminate\Support\Facades\Validator;
use mysql_xdevapi\Exception;
use Prettus\Repository\Eloquent\BaseRepository;
use App\Repositories\Interfaces\User\UserRepository;

/**
 * Class UserRepositoryEloquent.
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'nickname' => 'like',
        'inviter_id',
        'phone' => 'like',
    ];

    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * Specify Validator class name.
     *
     * @return mixed
     */
    public function validator()
    {
        return UserValidator::class;
    }

    /**
     * Boot up the repository, pushing criteria.
     */
    public function boot()
    {
        $this->pushCriteria (app (RequestCriteria::class));
    }

    /**
     * @return string
     */
    public function presenter()
    {
        return 'Prettus\\Repository\\Presenter\\ModelFractalPresenter';
    }
}
