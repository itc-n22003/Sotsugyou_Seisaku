# RFIの脆弱性を再現するためのPython3のサーバーの検証用のコード
# ローカル環境のネットワークインターフェースをIPアドレスに変換し、IPアドレスに対してrequestでGETリクエストを送信する

import netifaces
import requests

# ローカル環境のネットワークインターフェースの一覧を取得
interface_list = netifaces.interfaces()

# インターフェースからIPアドレスに変換し格納するためにリスト
ip_list = []

# インターフェースからIPアドレスに変換するためのfor文
for interface in interface_list:

    # 取得したインターフェースをIPアドレスに変換 ex) lo -> 127.0.0.1
    ip_address = netifaces.ifaddresses(interface)[netifaces.AF_INET][0]['addr']

    # IPアドレスにリストに追加
    ip_list.append(ip_address)

# 変換したIPアドレスに対してリクエストを送信するためのfor文
for address in ip_list:

    # URLの設定
    url = f"http://{address}:12345/"

    # 設定したURLにGETリクエストを送信した結果をresponseに格納
    response = requests.get(url)
    
    # responseからステータスコードを取得
    status_code = response.status_code

    # GETリクエストの結果を表示
    print(f"{url} -> {status_code}")
