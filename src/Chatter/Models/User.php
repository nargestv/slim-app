<?php
namespace Chatter\Models;
use Illuminate\Database\Eloquent\Model;

class User extends Model{

    public function authenticate($apikey){
        $user = User::where('apikey', '=', $apikey)->take(1)->get();
        $this->details = $user[0];

        return ($user[0]->exits) ? true: false;
    }
}
