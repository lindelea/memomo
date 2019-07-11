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
}
