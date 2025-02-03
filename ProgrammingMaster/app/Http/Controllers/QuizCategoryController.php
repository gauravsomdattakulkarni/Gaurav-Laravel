<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\QuizCategory;
use Illuminate\Http\Request;

class QuizCategoryController extends Controller
{
    public function index()
    {
        $categories = QuizCategory::paginate(10);
        return view('admin.quiz_categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
        ]);

        QuizCategory::create([
            'category_name' => $request->category_name,
            'category_status' => $request->category_status ?? 'active',
        ]);

        return redirect()->back()->with('success', 'Category added successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
        ]);

        $category = QuizCategory::findOrFail($id);
        $category->update([
            'category_name' => $request->category_name
        ]);

        return redirect()->back()->with('success', 'Category updated successfully.');
    }

    public function destroy($id)
    {
        QuizCategory::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Category deleted successfully.');
    }

    public function toggleStatus($id)
    {
        $category = QuizCategory::findOrFail($id);
        $category->update([
            'category_status' => $category->category_status === 'Active' ? 'Inactive' : 'Active',
        ]);

        return redirect()->back()->with('success', 'Category status updated successfully.');
    }
}
