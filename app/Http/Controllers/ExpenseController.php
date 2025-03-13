<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/expenses",
     *     summary="Get all expenses",
     *     tags={"Expenses"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     security={{ "bearerAuth": {} }}
     * )
     */
    public function index()
    {
        return response()->json(Auth::user()->expenses);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/expenses",
     *     summary="Create a new expense",
     *     tags={"Expenses"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "amount", "date"},
     *             @OA\Property(property="category_id", type="integer", nullable=true),
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="amount", type="number"),
     *             @OA\Property(property="date", type="string", format="date")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Expense created successfully"),
     *     security={{ "bearerAuth": {} }}
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        $expense = Auth::user()->expenses()->create($request->all());

        return response()->json($expense, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/expenses/{id}",
     *     summary="Get a specific expense",
     *     tags={"Expenses"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=404, description="Expense not found"),
     *     security={{ "bearerAuth": {} }}
     * )
     */
    public function show($id)
    {
        $expense = Auth::user()->expenses()->findOrFail($id);
        return response()->json($expense);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/expenses/{id}",
     *     summary="Update an expense",
     *     tags={"Expenses"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="category_id", type="integer", nullable=true),
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="amount", type="number"),
     *             @OA\Property(property="date", type="string", format="date")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Expense updated successfully"),
     *     security={{ "bearerAuth": {} }}
     * )
     */
    public function update(Request $request, $id)
    {
        $expense = Auth::user()->expenses()->findOrFail($id);
        $expense->update($request->all());

        return response()->json($expense);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/expenses/{id}",
     *     summary="Delete an expense",
     *     tags={"Expenses"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Expense deleted successfully"),
     *     @OA\Response(response=404, description="Expense not found"),
     *     security={{ "bearerAuth": {} }}
     * )
     */
    public function destroy($id)
    {
        $expense = Auth::user()->expenses()->findOrFail($id);
        $expense->delete();

        return response()->json(['message' => 'Expense deleted successfully']);
    }
}
