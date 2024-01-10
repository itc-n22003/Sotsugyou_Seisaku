# 卒業制作で作成したWebアプリ
Webアプリの脆弱性について学習できるサイト

## "わざと"組み込んだ脆弱性
- 組み込んだ脆弱性は3つ
  - OCI -> OSコマンドインジェクションは、ターゲットのサーバー上で任意のコマンドを実行できる脆弱性
  - LFI -> ローカルファイルインクルードは、ターゲットのサーバー上で任意のファイルを読み取る脆弱性
  - RFI -> リモートファイルインクルードは、ターゲットのサーバー上で外部、内部のサーバーのファイルを読み取る脆弱性
- 脆弱性について解説するページと、実際に脆弱に作ったページで構築している

## システム
- サーバー -> Apache HTTP Server
- 言語
  - HTML
  - CSS
  - JavaScript
  - PHP