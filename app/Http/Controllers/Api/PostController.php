<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Exception;
use App\Models\Post;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Jobs\SchedulePostNotifications;

class PostController extends Controller
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

            $storePost = Post::create([
                "title" => $request->title,
                "description" => $request->description,
                "brand_id" => $request->brand_id,
            ]);

            $postData = Post::with('brand')->where('id', $storePost->id)->first();
            SchedulePostNotifications::dispatch($postData->id);
            return response()->json([
                'data' => $postData,
                'message' => "Post Created Successfully",
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
     *  validate store post
     */
    protected function validatorStore($data)
    {
        return Validator::make($data, [
            'title' => 'required|string',
            'description' => 'required|string',
            'brand_id' => 'required|integer|min:1|exists:brands,id',

        ]);
    }
}
