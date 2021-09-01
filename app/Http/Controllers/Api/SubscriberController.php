<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Exception;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SubscriberController extends Controller
{




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = $this->validatorStore($request->all());
            if ($validator->fails()) {
                $errors = $validator->errors();
                return response()->json([
                    'data' => null,
                    'message' => $errors,
                    'code' => 401
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $user = User::where('email', $request->email)->first();
            if (empty($user)) {
                //user not found with email create user
                $user = User::create([
                    "name" => $request->name,
                    "email" => $request->email,
                    "password" => Hash::make(Str::random(8)),
                ]);
            }

            $findSubscriber = Subscriber::with(['user'])->where('user_id', $user->id)->where('brand_id', $request->brand_id)->first();
            if (!empty($findSubscriber)) {
                return response()->json([
                    'data' => $findSubscriber,
                    'message' => "Subscriber Already Exist in Same Brand",
                    'code' => 200
                ]);
            }
            //store subscriber
            $subscriber = Subscriber::create([
                "user_id" => $user->id,
                "brand_id" => $request->brand_id,
            ]);
            $subscriber = Subscriber::with('user')->where('id', $subscriber->id)->first();
            return response()->json([
                'data' => $subscriber,
                'message' => "Subscriber Created Successfully",
                'code' => 200
            ]);
        } catch (Exception $e) {
            return response()->json([
                'data' => null,
                'message' => "Whoops, looks like something went wrong.",
                'code' => 422
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     *  validate store subscriber 
     */
    protected function validatorStore($data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'brand_id' => 'required|integer|min:1|exists:brands,id',

        ]);
    }
}
