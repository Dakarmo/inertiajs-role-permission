<?php

namespace App\Http\Controllers;
use App\Http\Requests\CreatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Safety\DecryptageData;
use Inertia\Response;
use Inertia\Inertia;


use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PostController extends Controller
{
    public function index(): Response
    {  
        $posts = Post::all();
        $decryptedPosts = $posts->map(function ($post) {
            $post->title = DecryptageData::datadecrypt($post->title);
            $post->contenu = DecryptageData::datadecrypt($post->contenu);
            return $post;
        });
        return Inertia::render('Admin/Posts/PostIndex', [
            'posts' => PostResource::collection($decryptedPosts)
        ]);

    }

    public function create(): Response
    {
        $this->authorize('create', Post::class);
        return Inertia::render('Admin/Posts/PostCreate');
    } 

    public function store(CreatePostRequest $request): RedirectResponse
    {
        $this->authorize('create', Post::class);
        Post::create($request->validated());

        return redirect(route('posts.index'));
    }

    public function edit(Post $post): Response
    {
        $this->authorize('update', $post);
        return Inertia::render('Admin/Posts/PostEdite', [
            'post' => new postResource($post)
        ]);
    }

    public function update(CreatePostRequest $request, Post $post): RedirectResponse
    {
        $this->authorize('update', $post);
        $post->update($request->validated());
        return redirect(route('posts.index'));
    }

    public function destroy(Post $post): RedirectResponse
    {
        $this->authorize('delete', $post);
        $post->delete();
        return redirect(route('posts.index'));
    }
}
