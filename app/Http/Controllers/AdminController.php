<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexContactRequest;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Tag;

class AdminController extends Controller
{
    public function index(IndexContactRequest $request)
    {
        $query = Contact::with(['category', 'tags']);

        // キーワード検索（名前・メールアドレス）
        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where(function ($q) use ($keyword) {
                $q->where('first_name', 'like', "%{$keyword}%")
                    ->orWhere('last_name', 'like', "%{$keyword}%")
                    ->orWhereRaw('CONCAT(last_name, first_name) LIKE ?', ["%{$keyword}%"])
                    ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$keyword}%"])
                    ->orWhere('email', 'like', "%{$keyword}%");
            });
        }

        // 性別検索
        if ($request->filled('gender')) {
            $query->where('gender', $request->input('gender'));
        }

        // カテゴリ検索
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        // 日付検索
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->input('date'));
        }

        // 7件ずつのページネーション (検索条件を保持)
        $contacts = $query->orderBy('created_at', 'desc')->simplePaginate(7)->withQueryString();
        $categories = Category::all();
        $tags = Tag::all(); // ★ タグ一覧を取得

        return view('admin.index', compact('contacts', 'categories', 'tags')); // ★ compactに 'tags' を追加
    }

    /**
     * お問い合わせ詳細表示
     */
    public function show(Contact $contact)
    {
        $contact->load(['category', 'tags']);

        if (request()->wantsJson()) {
            return response()->json($contact);
        }

        return view('admin.show', compact('contact'));
    }

    /**
     * お問い合わせ削除処理
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('admin.index')->with('success', 'お問い合わせを削除しました。');
    }
}
