<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    /**
     * お問い合わせ入力画面の表示
     */
    public function index()
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('contact.index', compact('categories', 'tags'));
    }

    /**
     * バリデーション実行・確認画面表示
     */
    public function confirm(StoreContactRequest $request)
    {
        $validated = $request->validated();

        // 選択されたカテゴリの取得
        $category = Category::find($validated['category_id']);

        // 選択されたタグの取得
        $tags = collect();
        if (! empty($validated['tag_ids'])) {
            $tags = Tag::whereIn('id', $validated['tag_ids'])->get();
        }

        return view('contact.confirm', compact('validated', 'category', 'tags'));
    }

    /**
     * 送信処理（DB保存）
     */
    public function store(StoreContactRequest $request)
    {
        $validated = $request->validated();

        // トランザクションを張り contacts および contact_tag へ保存
        DB::transaction(function () use ($validated) {
            $contact = Contact::create([
                'last_name' => $validated['last_name'],
                'first_name' => $validated['first_name'],
                'gender' => $validated['gender'],
                'email' => $validated['email'],
                'tel' => $validated['tel'],
                'address' => $validated['address'],
                'building' => $validated['building'] ?? null,
                'category_id' => $validated['category_id'],
                'detail' => $validated['detail'],
            ]);

            if (! empty($validated['tag_ids'])) {
                $contact->tags()->sync($validated['tag_ids']);
            }
        });

        return redirect()->route('contact.thanks');
    }

    /**
     * 送信完了画面表示
     */
    public function thanks()
    {
        return view('contact.thanks');
    }
}
