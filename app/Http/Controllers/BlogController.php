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
        if (strtolower(trim(request()->getHost())) === 'www.avipetapp.com') {
            return redirect()->to('https://avipetapp.com' . request()->getRequestUri(), 301);
        }
        $posts = BlogService::getAllPosts();
        return view('blog.index', compact('posts'));
    }

    /**
     * Muestra el detalle del artículo con Rich Snippets Schema.org Article.
     */
    public function show(string $slug)
    {
        if (strtolower(trim(request()->getHost())) === 'www.avipetapp.com') {
            return redirect()->to('https://avipetapp.com' . request()->getRequestUri(), 301);
        }
        $post = BlogService::getPostBySlug($slug);

        if (!$post) {
            abort(404, 'Artículo no encontrado en el blog de AviPetApp');
        }

        $relatedPosts = BlogService::getRelatedPosts($slug, 2);

        return view('blog.show', compact('post', 'relatedPosts'));
    }
}
