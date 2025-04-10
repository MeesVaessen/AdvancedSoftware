<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\postServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function __construct(protected PostServiceInterface $postService)
    {
    }


    public function createPost(Request $request): JsonResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);
        $jwtPayload = $request->attributes->get('jwt_payload');
        $data['created_by'] = $jwtPayload['sub'];
        return response()->json($this->postService->create($data));
    }

    public function getPosts($paginate=null): JsonResponse
    {
        return response()->json($this->postService->getAll($paginate));
    }

    public function getPost($uuid): JsonResponse
    {
        return response()->json($this->postService->get($uuid));
    }

    public function updatePost(Request $request, $id): JsonResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);
        $jwtPayload = $request->attributes->get('jwt_payload');
        $data['created_by'] = $jwtPayload['sub'];

        return response()->json($this->postService->update($id, $data));
    }

    public function deletePost($id): JsonResponse
    {
        return response()->json(['success' => $this->postService->delete($id)]);
    }

    public function likePost(Request $request,$id): JsonResponse
    {
        $jwtPayload = $request->attributes->get('jwt_payload');
        $data = [
            "postId" => $id,
            "userId" => $jwtPayload['sub'],
            "is_like"=> true
        ];
    }

    public function dislikePost(Request $request, $id): JsonResponse
    {
        $jwtPayload = $request->attributes->get('jwt_payload');
        $data = [
                "postId" => $id,
                "userId" => $jwtPayload['sub'],
                "is_like"=> false
                ];
        return response()->json([$this->postService->dislike($data)]);
    }


}

