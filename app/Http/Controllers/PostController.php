<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Http\Requests\UpdatePost;
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
     * @param StorePost|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePost $request)
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

        $post = Post::where(preg_match("/^\\d+$/", $id) ? 'post_id' : 'slug', $id)->where('type', '!=', Post::TYPE_DELETED)->with('author')->first();

        if ($post) {
            return response()->json($post);
        }

        return response('', 500);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param StorePost|UpdatePost|Request $request
     * @param Post $post
     * @return \Illuminate\Http\Response
     * @internal param $id
     * @internal param Post $post
     * @internal param int $id
     */
    public function update(UpdatePost $request, Post $post)
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

    public function massUpdate(Request $request)
    {
        $ids = $request->input('post_ids', null);

        if (is_array($ids)) {

            if (Post::whereIn('post_id', $ids)->ownedByAuthUser()->update($request->except(['post_ids']))) {

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
        if ($post->user_id == Auth::user()->getKey() && $post->fill(['type' => Post::TYPE_DELETED])->save()) {
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


    public function massDestroy(Request $request)
    {
        $ids = explode(',', $request->input('post_ids', null));

        if (count($ids)) {

            if (Post::whereIn('post_id', $ids)->ownedByAuthUser()->update([
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
