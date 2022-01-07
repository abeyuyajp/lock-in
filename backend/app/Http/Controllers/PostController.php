<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Http\Requests\StoreComment;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function __construct()
    {
        // 認証が必要
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * 写真一覧
     */
    public function index()
    {
        $posts = Post::with(['owner'])
            ->orderBy(Post::CREATED_AT, 'desc')->paginate();

        return $posts;
    }

    /**
     * 投稿
     *
     * @param StorePost $request
     */
    public function create(StorePost $request)
    {
        $request = $request->all();
        $post = new Post($request);

        // データベースエラー時に投稿削除を行うため
        // トランザクションを利用する
        DB::beginTransaction();

        try {
            Auth::user()->posts()->save($post);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            throw $exception;
        }

        return response($post, 201);
    }

    /**
     * 投稿詳細
     *
     * @param string $id
     * @return Post
     */
    public function show(string $id)
    {
        $post = Post::where('id', $id)->with(['owner', 'comments.author'])->first();

        // 投稿データが見つからなかった場合は、404を返却
        return $post ?? abort(404);
    }

    /**
     * コメント投稿
     *
     */
    public function addComment(StoreComment $request, Post $post)
    {
        $comment = new Comment();
        $comment->content = $request->get('content');
        $comment->user_id = Auth::user()->id;
        $post->comments()->save($comment);

        // authorリレーションをロードするためにコメントを取得しなおす
        $new_comment = Comment::where('id', $comment->id)->with('author')->first();

        return response($new_comment, 201);
    }
}
