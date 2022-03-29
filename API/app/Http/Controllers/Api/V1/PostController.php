<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

use App\Http\Resources\V1\PostResource;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Retorno de los datos como coleccion en un arreglo json -> http://192.168.0.12:8000/api/v1/posts
        return PostResource::collection(Post::latest()->paginate());
    }

   
    public function show(Post $post)
    {
        // Retorno de un post -> http://192.168.0.12:8000/api/v1/posts/1
        return new PostResource($post);
    }


    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json([
            'message:' => "Success"
        ], 204);
        // El codigo 204 corresponde a sin contenido
    }
}
