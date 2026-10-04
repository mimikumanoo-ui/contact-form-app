<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Contact;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        // DBからカテゴリ一覧を取得
        $categories = Category::all();

        // お問い合わせ一覧を取得
        $contacts = Contact::with('category')->paginate(7);

        // ビューにデータを渡す
        return view('admin.index', compact('categories', 'contacts'));
    }
}
