<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\V1\MemoResource;
use App\Memo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemoController extends Controller
{
    /**
     * メモ一覧を取得するAPI
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        return MemoResource::collection(
            $request->user()->memos()->with(['user'])->latest()->get()
        );
    }

    /**
     * メモ一件取得API
     * @param Memo $memo
     * @return MemoResource
     */
    public function show(Memo $memo)
    {
        $memo->load(['user']);
        return new MemoResource($memo);
    }

    /**
     * メモつ追加API
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|min:1|max:50',
            'content' => 'required|string',
            'image' => 'nullable|image',
        ]);
        
        $memo = new Memo();
        
        if ($request->hasFile('image')) {
            $path = $request->image->store('images', 'public');
            $memo->image_path = $path;
        }
        
        $memo->title = $request->input('title');
        $memo->content = $request->input('content');
        $memo->user_id = $request->user()->id;
        
        $memo->save();
        
        return (new MemoResource($memo))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * メモ更新API
     * @param Request $request
     * @param Memo $memo
     * @return MemoResource
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Memo $memo)
    {
        $this->validate($request, [
            'title' => 'sometimes|required|string|min:1|max:50',
            'content' => 'sometimes|required|string',
            'image' => 'sometimes|nullable|image',
        ]);

        if ($request->has('title')) {
            $memo->title = $request->input('title');
        }

        if ($request->has('content')) {
            $memo->content = $request->input('content');
        }

        if ($request->hasFile('image')) {
            $path = $request->image->store('images', 'public');
            $memo->image_path = $path;
        }

        $memo->update();

        return new MemoResource($memo);
    }
}
