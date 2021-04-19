## 請解釋後端與前端的差異。

其實是分工上的不同，以餐廳做比喻，內場 = 後台 = 後端(black end)，外場 = 前台 = 前端(front end)
+ 內場比喻為廚房、廚師、內場服務人員，顧客無法看到或接觸的地方，負責處理外場的需求出餐，簡單來說就是後台依據前台使用者的需求，對資料庫進行操作
  - 後端語言: PHP, Java, C#等
  - 資料庫MSsql Mysql Oracle等
+ 外場比喻為顧客的餐廳裝潢擺設，餐桌、外場服務人員、經理，直接面對顧客點餐，等其他服務，前端主要負責網站門面，如餐廳的裝潢，與客人直接的互動，當接受後端的資料時如何在前台呈現，如字體顏色、大小、粗細。
  - 前端語言: HTML, CSS, Javascript



## 假設我今天去 Google 首頁搜尋框打上：JavaScript 並且按下 Enter，請說出從這一刻開始到我看到搜尋結果為止發生在背後的事情。

1. 當使用者透過瀏覽器輸入網址 google，使用者的作業系統(OS)命令硬體(網路卡)向 DNS伺服器請求 IP 位置
2. DNS伺服器解析後，回應 IP 位置
3. 瀏覽器發送 IP 位置給 Server 請求存取網站
4. Server 收到請求後，詢問資料庫使用者需要的關鍵字
5. 資料庫找到資料，回傳給 Server
6. Server 回傳資料(封包)到使用者硬體(網路卡)
7. 網路卡接收後一路傳回給瀏覽器解析構成網站

![later](https://i.imgur.com/RXNww2j.jpg)
<!--div class="mermaid">
    sequenceDiagram
    瀏覽器----DNS伺服器: 1.Request
    DNS伺服器---瀏覽器: 2.Responsive
    瀏覽器----Server: 3.Request
    Server----Database: 4.Request
    Database---Server: 5.Responsive
    Server---瀏覽器: 6.Responsive
</div-->

## 請列舉出 3 個「課程沒有提到」的 command line 指令並且說明功用

<font color="#f00">netstat, notepad, shutdown</font>

 Windows       | MacOS/Linux   | 說明
:--------------|:--------------|:------------
 cd / cd dir   | cd            | 改變工作目錄
 cd            | pwd           | 取得目前所在位置
 dir           | ls            | 列出目前檔案列表
 md / mkdir    | mkdir         | 建立新的目錄
 無            | touch         | 建立檔案
 copy / xcopy  | cp            | 複製檔案
 move          | mv            | 移動檔案
 del / erase   | rm	           | 刪除檔案
 cls           | clear         | 清除畫面上的內容
 help          | man           | 顯示指令查詢 
 start         | open          | 開啟當前的資料夾
 more, type    | cat           | 顯示檔案內容
 rmdir /s /q   | rmdir -rf     | 強制刪除非空的資料夾	
 netstat       | netstat       | 顯示通訊協定統計資料和目前的 TCP/IP 網路連線
 notepad       |               | 用筆記本開啟當前的檔案
 ipconfig -all | ifconfig      | 查看此電腦的IP資訊
 set           | export        | 設定環境變數	
 exit          | exit          | 離開終端機
 shutdown      | shutdown      | 關機

 + Netstat 指令可用來查詢網路問題及檢測網路狀態，可透過 `netstat /?` 來查看使用說明
   - `netstat –r` 查看本機的路由表資訊，有助於連線故障判斷。
 
 + 如何執行 **shutdown.exe**，可透過 `shutdown /?` 查詢參數說明
   - 關機：shutdown -s -t 10 => 電腦在10秒鐘之後關機。
   - 重新開機：shutdown -r -t 10 => 電腦在10秒鐘之後重開。

 + 如何在 Windows 命令提示字元下使用 Linux 常見的 touch 命令?
   - 可參考[保哥](https://blog.miniasp.com/post/2017/01/22/Useful-tool-touch-command-on-Windows)這篇文章。