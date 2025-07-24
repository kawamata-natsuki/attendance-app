# Attendance App

Laravel + Docker で構築した勤怠管理アプリです。  
ログイン・出退勤打刻・休憩管理・勤怠一覧・修正申請・管理者承認など、基本的な勤怠管理機能を一通り実装しました。

---

## 概要

- 一般ユーザー：出勤・退勤・休憩の打刻、勤怠履歴の確認・修正申請
- 管理者：全ユーザーの勤怠管理、申請承認、スタッフ一覧の確認
- メール認証（Mailtrap）によるユーザー登録
- Dockerを用いた開発環境構築
- Vite + JavaScript によるリアルタイム時計表示

---

## 主な機能

### 一般ユーザー
- 会員登録・ログイン（メール認証対応）
- 出勤／退勤／休憩の打刻（多重送信対策あり）
- 勤怠ステータス管理（勤務外／出勤中／休憩中）
- 勤怠一覧・詳細（修正申請フォームあり）
- 承認待ち／承認済みの申請一覧表示

### 管理者
- 管理者ログイン／ログアウト
- 全ユーザーの日次勤怠一覧（前日・翌日切り替え）
- スタッフ別月次勤怠一覧（CSV出力対応）
- 勤怠詳細の確認／直接修正
- 修正申請一覧と承認処理
- スタッフ一覧（氏名・メールアドレス表示）

---

## 使用技術

- **フレームワーク**：Laravel 10
- **言語**：PHP 8.2 / JavaScript
- **DB**：MySQL 8.0
- **インフラ**：Docker / Docker Compose / Nginx / phpMyAdmin
- **フロントエンド**：Bladeテンプレート / Vite
- **その他**：Mailtrap（メール認証）、GitHub

---

## 画面キャプチャ

### ログイン画面
![ログイン画面](public/images/screen1.png)

### 勤怠管理画面
![勤怠管理画面](public/images/screen4.png)

---

## 工夫したポイント
- **多重送信対策**：打刻ボタンの連打による不正データ登録を防止
- **修正履歴のログ化**：`attendance_logs` テーブルを追加し、修正前のデータを記録
- **UIの使いやすさ向上**：プレースホルダー、ボタンの無効化、わかりやすいステータス表示を実装
- **Viteによるリアルタイム更新**：勤務中の時刻を秒単位でリアルタイム更新

---

## 環境構築（ローカル用）

1. リポジトリをクローン
    ```bash
    git clone git@github.com:kawamata-natsuki/attendance-app.git
    cd attendance-app
    ```

2. Dockerを起動
    ```bash
    make init
    ```

3. フロントエンドをセットアップ
    ```bash
    npm install
    npm run dev
    ```

4. ブラウザでアクセス
    - ユーザー画面: [http://localhost:8090/login](http://localhost:8090/login)
    - 管理者画面: [http://localhost:8090/admin/login](http://localhost:8090/admin/login)

---

## テスト

Featureテストを用いて主要機能の動作確認を実施。
```bash
docker compose exec php php artisan test
```
