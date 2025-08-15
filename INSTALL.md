# 勤怠管理アプリ

## 環境構築

1. リポジトリをクローン

    ```bash
    git clone git@github.com:kawamata-natsuki/attendance-app.git
    ``` 

2. クローン後、プロジェクトディレクトリに移動してVSCodeを起動
    ```bash
    cd attendance-app
    code .
    ```

3. Dockerを起動する  
Docker Desktopを起動してください。  

4. プロジェクトルートにDocker用.env を作成する （Laravelの.envとは別物です） 
    ```bash
    touch .env
    ```

5. Docker 用 UID / GID を設定  
    UID/GIDは `id -u` / `id -g` コマンドで確認できます。  
    自分の環境に合わせてUID/GIDを設定してください。  
    設定例: 
    ```bash
    UID=1000
    GID=1000
    ```

6. `docker-compose.override.yml`の作成  
    `docker-compose.override.yml` は、開発環境ごとの個別調整（ポート番号の変更など）を行うための設定ファイルです。  
    `docker-compose.yml` ではポートは設定されていないため、各自 `docker-compose.override.yml` を作成して、他のアプリケーションと競合しないポート番号を設定してください:     
    ```bash
    touch docker-compose.override.yml
    ```
    設定例:  
    ```yaml
    services:
      nginx:
        ports:
          - "8090:80"             # 開発環境用のNginxポート
    
      php:
        build:
          context: ./docker/php
          dockerfile: Dockerfile
          args:
            USER_ID: 1000         # .envで指定したUIDを使用
            GROUP_ID: 1000        # .envで指定したGIDを使用
        ports:
          - "5173:5173"           # Viteのホットリロード用ポート

      phpmyadmin:
        ports:
          - "8091:80"             # phpMyAdmin用ポート
    ```

7. 初期セットアップ  
    プロジェクトルートで以下のコマンドを実行し、初期セットアップを行います：
    ```bash
    make init
    ```
    `make init` では以下が自動で実行されます：
    - Dockerイメージのビルド
    - コンテナ起動
    - Laravel用 .env（.env.example → .env）配置
    - Composer依存インストール
    - APP_KEY生成
    - DBマイグレーション・シーディング

## フロントエンドセットアップ（Vite）
本案件では、Viteを用いて勤怠登録画面の日時をリアルタイムで更新・取得しています。  

1. Node.js をインストール  
Node.jsがインストールされていない場合は、公式サイトなどからインストールしてください。

2. 依存パッケージのインストール  
プロジェクト直下で以下を実行します：
    ```bash
    npm install
    ```

3. Vite の開発サーバー起動  
以下のコマンドで勤怠登録画面の日時をリアルタイムで反映できます：  
※npm run devを起動していないと、JavaScriptによる時刻自動更新などのフロント機能が動作しません。  
    ```bash
    npm run dev
    ```

## 権限設定

本模擬案件では Docker 内で `appuser` を作成・使用しているため、基本的に `storage` や `bootstrap/cache` の権限変更は不要です。  
ただし、ファイル共有設定やOS環境によっては権限エラーになる場合があるため、その場合は以下のコマンドで権限を変更してください：
```bash
sudo chmod -R 775 storage
sudo chmod -R 775 bootstrap/cache
```
    
## メール設定
 
メール認証は Mailtrap（[https://mailtrap.io/](https://mailtrap.io/)）を使用します。  
Mailtrapのアカウントを作成し、Inbox（受信箱）に表示される `MAIL_USERNAME` と `MAIL_PASSWORD` を `.env` に設定してください：  
```ini
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username_here
MAIL_PASSWORD=your_mailtrap_password_here
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

## URL(動作確認)
※ docker-compose.override.yml で設定した Nginx のポート番号に置き換えてアクセスしてください。  
（以下は例として 8090 を使用しています）
- 一般ユーザー画面: http://localhost:8090/login
- 管理者画面: http://localhost:8090/admin/login

## ログイン情報一覧
※ログイン確認用のテストアカウントです。  

| ユーザー種別    | メールアドレス             | パスワード  |
|----------------|----------------------------|------------|
| 一般ユーザー1   | reina.n@example.com      | 12345678   |
| 一般ユーザー2   | taro.y@example.com       | 12345678   |
| 一般ユーザー3   | issei.m@example.com      | 12345678   |
| 一般ユーザー4   | keikichi.y@example.com   | 12345678   |
| 一般ユーザー5   | tomomi.a@example.com     | 12345678   |
| 一般ユーザー6   | norio.n@example.com      | 12345678   |
| 管理者ユーザー  | admin@example.com        | admin123   |

## テスト環境構築と実行方法
テスト環境（.env.testing）ではViteのHMRを利用せず、ビルド済みのCSS/JSを読み込みます。　　
テストを正しく実行するには以下の手順で環境構築を行ってください：

1. `.env.testing.example` をコピーして `.env.testing` を作成：
    ```bash
    cp .env.testing.example .env.testing
    ```
    ※ `.env.testing.example` はテスト専用の設定テンプレートです。


2. テスト用データベースを作成：
    ```bash
    docker compose exec mysql mysql -u root -proot -e "CREATE DATABASE demo_test;"
    ```


3. テスト用データベースにマイグレーションを実行：
    ```bash
    docker compose exec php php artisan migrate:fresh --env=testing
    ```


4. フロントをビルド：
    ```bash
    npm run build
    ```

5. テスト用環境に切り替える前に .env をバックアップ
    テスト環境に切り替える前に現在の開発用 .env を保存します：
    ```bash
    cp .env .env.backup
    ```

6.  テスト用環境に切り替え
以下のコマンドで .env をテスト用環境に切り替えます：
    ```bash
    make set-testing-env
    ```

7. テスト実行
    ```bash
    docker compose exec php php artisan test tests/Feature
    ```

8. テスト完了後、開発環境に戻す  
テスト後は開発環境に戻して作業を続けてください：
    ```bash
    make restore-env
    ```

9. 設定キャッシュをクリア  
`.env` の切り替え後は Laravel のキャッシュをクリアして設定を反映させてください：
    ```bash
    docker compose exec php php artisan config:clear
    ```
