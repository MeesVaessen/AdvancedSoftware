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
        return response()->json($this->postService->create($data));
    }

    public function getPosts($paginate=null): JsonResponse
    {
        return response()->json($this->postService->getAll($paginate));
    }

    public function getPost($id): JsonResponse
    {
        return response()->json($this->postService->get($id));
    }

    public function updatePost(Request $request, $id): JsonResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);
        return response()->json($this->postService->update($id, $data));
    }

    public function deletePost($id): JsonResponse
    {
        return response()->json(['success' => $this->postService->delete($id)]);
    }


}

