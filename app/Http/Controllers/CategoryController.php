<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/categories",
     *     summary="Get all categories",
     *     tags={"Categories"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     security={{ "bearerAuth": {} }}
     * )
     */
    public function index()
    {
        $categories = Cache::remember('categories', 3600, function () {
            return Category::all();
        });

        return response()->json($categories);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/categories",
     *     summary="Create a new category",
     *     tags={"Categories"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Food")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Category created successfully",
     *     ),
     *     security={{ "bearerAuth": {} }}
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
        ]);

        $category = Category::create($request->only('name'));

        Cache::forget('categories');

        return response()->json($category, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/categories/{id}",
     *     summary="Get a specific category",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Category ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     security={{ "bearerAuth": {} }}
     * )
     */
    public function show($id)
    {
        $category = Cache::remember("category_{$id}", 3600, function () use ($id) {
            return Category::findOrFail($id);
        });

        return response()->json($category);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/categories/{id}",
     *     summary="Update a category",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Category ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Entertainment")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Category updated successfully",
     *     ),
     *     security={{ "bearerAuth": {} }}
     * )
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
        ]);

        $category = Category::findOrFail($id);
        $category->update($request->only('name'));

        Cache::forget('categories');
        Cache::forget("category_{$id}");

        return response()->json($category);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/categories/{id}",
     *     summary="Delete a category",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Category ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Category deleted successfully",
     *     ),
     *     security={{ "bearerAuth": {} }}
     * )
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        Cache::forget('categories');
        Cache::forget("category_{$id}");

        return response()->json(['message' => 'Category deleted successfully']);
    }
}
