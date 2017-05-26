<?php

namespace App\Http\Controllers\Admin;

use App\UserReg;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class CheckUserController extends Controller
{
    public function checkUser(Request $request){

        if($request->ajax()) {
            $userID = $request->get('userID');
            var_dump($userID);die;
            if($userID != ''){
                $rs = UserReg::find($userID);
                if($rs != ''){
                    $response = array(
                        'status' => 'OK',
                        'msg' => 'User successfully',
                    );
                    return $response;
                }
            }

            $response = array(
                'status' => 'Fail',
                'msg' => 'User no exists',
            );
            return $response;

        }

    }
}
