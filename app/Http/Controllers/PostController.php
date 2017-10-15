<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $query = Post::orderBy('created_at', 'desc')->with('author');

        if ($request->input('my_posts', 0) == 1) {
            $query->whereIn('type', [Post::TYPE_PUBLISHED, Post::TYPE_DRAFT]);
            $query->where('user_id', Auth::user()->getKey());
        } else {
            $query->where('type', Post::TYPE_PUBLISHED);
        }

        return response()->json(
            $query->paginate($request->input('per_page', 5))
        );
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        return response()->json(
            Post::where(is_int($id) ? 'post_id' : 'slug', $id)->with('author')->first()
        );
    }


    /**
     * Update the specified resource in storage.
     *
     * @param StorePost|Request $request
     * @param Post $post
     * @return \Illuminate\Http\Response
     * @internal param $id
     * @internal param Post $post
     * @internal param int $id
     */
    public function update(StorePost $request, Post $post)
    {

        $post->fill($request->all());

        if ($post->save()) {
            return response()->json([
                'code' => 'ok',
                'message' => 'Update successful.',
                'post' => $post
            ]);
        }

        return response()->json([
            'code' => 'failed',
            'message' => 'Update failed.'
        ], 500);
    }

    public function massUpdate(StorePost $request)
    {
        $ids = $request->input('post_ids', null);

        if (is_array($ids)) {

            if (Post::whereIn('post_id', $ids)->update($request->except(['post_ids']))) {

                return response()->json([
                    'code' => 'ok',
                    'message' => 'Update successful.'
                ]);

            }
        }

        return response()->json([
            'code' => 'failed',
            'message' => 'Update failed.'
        ], 500);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Post $post
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy(Post $post)
    {
        if ($post->fill(['type' => Post::TYPE_DELETED])->save()) {
            return response()->json([
                'code' => 'ok',
                'message' => 'Delete successful.'
            ]);
        }

        return response()->json([
            'code' => 'failed',
            'message' => 'Delete failed.'
        ], 500);
    }


    public function massDestroy(StorePost $request)
    {
        $ids = explode(',', $request->input('post_ids', null));

        if (count($ids)) {

            if (Post::whereIn('post_id', $ids)->update([
                'type' => Post::TYPE_DELETED
            ])) {

                return response()->json([
                    'code' => 'ok',
                    'message' => 'Delete successful.'
                ]);

            }
        }

        return response()->json([
            'code' => 'failed',
            'message' => 'Delete failed.'
        ], 500);
    }

}
