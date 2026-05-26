<?php

namespace App\Action\V1\User;

use App\Models\User;

class CreateUserAction{

public static function execute(array $data){


if (isset($data['profile']) && is_array($data['profile'])) {

            $data['profile'] = json_encode($data['profile']);
        }

$user=User::create($data);

$user->is_real=true;//To distinguish the real user from the created user from the server
//so that we send emails only to real users when events are launched.

$user->save();

return $user->makeHidden(['is_real']);//This field should not be displayed to the user.


}
}
