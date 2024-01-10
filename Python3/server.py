# RFIを再現するためのコード
# 外部からアクセスできないPython3のHTTPサーバー

import http.server
import socketserver
import re
import netifaces

# ローカルのネットワークインターフェースからIPアドレスに変換したリストを返す関数
# ex) ['lo', 'wlan0'] -> ['127.0.0.1', '192.168.1.123']
def get_ip():
    interface_list = netifaces.interfaces()
    ip_list = [netifaces.ifaddresses(interface)[netifaces.AF_INET][0]['addr'] for interface in interface_list]
    return ip_list

# get_ip関数のリストから取得したIPアドレスのリストを正規表現に変換する関数
# ex) ['127.0.0.1', '192.168.1.123'] -> ^(127\.0\.0\.1|192\.168\.1\.123)$
def regex():
    ip_list = get_ip()

    pattern = "^("

    for count, ip in enumerate(ip_list):
        for char in ip:
            if char == ".":
                pattern += "\\"
            pattern += char
        else:
            if count != (len(ip_list) - 1):
                pattern += "|"

    pattern += ")$"
    return pattern

# 自身のIPアドレスからのリクエストにのみ200を返し、それ以外のIPアドレスからのリクエストには403を返すように設定したクラス
class MyHandler(http.server.SimpleHTTPRequestHandler):

    # クライアントのIPアドレスを文字列として取得するための関数
    def address_string(self):
        host, port = self.client_address[:2]
        return host
    
    # regex関数で作成した正規表現に一致するか確認するための関数
    # 一致した場合はアクセスを許可し、一致しなかった場合は403とエラーメッセージを返す
    def do_GET(self):
        if allowed_ip_pattern.match(self.address_string()):
            self.directory = DIRECTORY
            super().do_GET()
        else:
            self.send_response(403)
            self.send_header("Content-type", "text/html")
            self.end_headers()
            self.wfile.write(b"403 Forbidden: You are not allowed to access this server.")

# 正規表現を設定
regex_pattern = regex()
allowed_ip_pattern = re.compile(regex_pattern)

# サーバーのポートとアクセスできるディレクトリを設定
PORT = 12345
DIRECTORY = "/home/vagrant/secret"

# MyHandlerにポートとディレクトリを渡し、サーバーとしてインスタンス化
httpd = socketserver.TCPServer(("", PORT), MyHandler)

# サーバーを起動したときのメッセージ
print(f"serving at port {PORT}, serving files from {DIRECTORY}")

# サーバーとしてリクエストを受け付け、処理する
httpd.serve_forever() 
