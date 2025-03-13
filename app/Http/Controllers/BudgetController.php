<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/budgets",
     *     summary="Get all budgets",
     *     tags={"Budgets"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     security={{ "bearerAuth": {} }}
     * )
     */
    public function index()
    {
        return response()->json(Auth::user()->budgets);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/budgets",
     *     summary="Create a new budget",
     *     tags={"Budgets"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"limit"},
     *             @OA\Property(property="limit", type="number", format="float", example=500.0)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Budget created successfully",
     *     ),
     *     security={{ "bearerAuth": {} }}
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'limit' => 'required|numeric|min:0',
        ]);

        $budget = Budget::create([
            'user_id' => Auth::id(),
            'limit' => $request->limit,
        ]);

        return response()->json($budget, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/budgets/{id}",
     *     summary="Get a specific budget",
     *     tags={"Budgets"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     security={{ "bearerAuth": {} }}
     * )
     */
    public function show(Budget $budget)
    {
        $this->authorize('view', $budget);
        return response()->json($budget);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/budgets/{id}",
     *     summary="Update a budget",
     *     tags={"Budgets"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"limit"},
     *             @OA\Property(property="limit", type="number", format="float", example=1000.0)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Budget updated successfully",
     *     ),
     *     security={{ "bearerAuth": {} }}
     * )
     */
    public function update(Request $request, Budget $budget)
    {
        $this->authorize('update', $budget);

        $request->validate([
            'limit' => 'required|numeric|min:0',
        ]);

        $budget->update([
            'limit' => $request->limit,
        ]);

        return response()->json($budget);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/budgets/{id}",
     *     summary="Delete a budget",
     *     tags={"Budgets"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Budget deleted successfully",
     *     ),
     *     security={{ "bearerAuth": {} }}
     * )
     */
    public function destroy(Budget $budget)
    {
        $this->authorize('delete', $budget);
        $budget->delete();
        return response()->json(['message' => 'Budget deleted successfully']);
    }
}
