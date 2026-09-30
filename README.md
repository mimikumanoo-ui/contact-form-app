# COACHTECH お問い合わせフォーム

## 概要
本プロジェクトは、COACHTECH確認テストの要件に沿って構築されたお問い合わせ管理システムです。
一般ユーザー向けのお問い合わせ入力・確認・送信・完了画面をはじめ、管理者向けのお問い合わせ管理（一覧・検索・詳細・削除）、タグ管理（CRUD）、CSV出力機能、および公開APIを提供します。

## ER図

```mermaid
erDiagram
    users {
        bigint id PK
        string name
        string email UK
        timestamp email_verified_at
        string password
        string remember_token
        timestamp created_at
        timestamp updated_at
    }

    categories {
        bigint id PK
        string content
        timestamp created_at
        timestamp updated_at
    }

    contacts {
        bigint id PK
        bigint category_id FK
        string first_name
        string last_name
        integer gender
        string email
        string tel
        string address
        string building
        text detail
        timestamp created_at
        timestamp updated_at
    }

    tags {
        bigint id PK
        string name UK
        timestamp created_at
        timestamp updated_at
    }

    contact_tag {
        bigint id PK
        bigint contact_id FK
        bigint tag_id FK
        timestamp created_at
        timestamp updated_at
    }

    categories ||--o{ contacts : "1対多"
    contacts ||--o{ contact_tag : "多対多"
    tags ||--o{ contact_tag : "多対多"
```

## 環境構築手順
1. リポジトリのクローン
git clone git@github.com:mimikumanoo-ui/contact-form-app.git
cd contact-form-app

2. 環境変数の設定
cp .env.example .env

3. Dockerコンテナの起動
./vendor/bin/sail up -d

4. アプリケーションキーの生成
sail artisan key:generate

5. マイグレーションおよびシーディングの実行
sail artisan migrate:fresh --seed

## 使用技術
- PHP 8.2
- Laravel 10.x
- MySQL 8.0
- Webサーバー: Nginx
- フロントエンド: Vite, Tailwind CSS ^3.4.0
- 開発ツール: Docker, Laravel Sail, phpMyAdmin

## APIエンドポイント一覧
- GET /api/v1/contacts : お問い合わせ一覧取得
- POST /api/v1/contacts : お問い合わせ作成
- GET /api/v1/contacts/{id} : お問い合わせ詳細取得
- PUT /api/v1/contacts/{id} : お問い合わせ更新
- DELETE /api/v1/contacts/{id} : お問い合わせ削除

## 開発環境URL
- WEB: http://localhost
- phpMyAdmin: http://localhost:8080

## 作成者
戸澤美優