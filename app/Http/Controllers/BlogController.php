<?php

namespace App\Http\Controllers;

use App\Services\BlogService;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Muestra el índice del Blog con todos los artículos pilares de SEO.
     */
    public function index()
    {
        $posts = BlogService::getAllPosts();
        return view('blog.index', compact('posts'));
    }

    /**
     * Muestra el detalle del artículo con Rich Snippets Schema.org Article.
     */
    public function show(string $slug)
    {
        $post = BlogService::getPostBySlug($slug);

        if (!$post) {
            abort(404, 'Artículo no encontrado en el blog de AVI-Plan');
        }

        $relatedPosts = BlogService::getRelatedPosts($slug, 2);

        return view('blog.show', compact('post', 'relatedPosts'));
    }
}
