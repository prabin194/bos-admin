<?php

namespace App\Http\Controllers\API\Admin;

use App\Actions\Common\CreateTranslationAction;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $category_translation = $request->category;
            $user = Auth::user();

            $category = Category::create([
                'uid' => Uuid::uuid4()->toString(),
                'domain' => $request->domain,
                'icon' => $request->icon,
                'user_id' => $user->user_id,
            ]);

            (new CreateTranslationAction())->execute($category, $category_translation, $user);

            DB::commit();
            return response()->json(['message' => 'Category added successfully', 'success' => true], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
