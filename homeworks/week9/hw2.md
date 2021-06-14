## 資料庫欄位型態 VARCHAR 跟 TEXT 的差別是什麼
**定長與變長**
定長(沒有 var ):文字的長度固定，當輸入的數據長度沒有達到指定的長度時將自動以英文空格在其後面填充，讓長度達到相對應的長度。

變長(有 var ):表示是實際存儲空間是變長的，也就是說當輸入的數據長度沒有達到指定的長度時不會在後面填充空格。(text 所存儲的也是可變長的)。

**Unicode 或非 Unicode**
Unicode(有 n ):所有的文字都用 2 Byte 來儲存，即使是英文字也是使用 2 Byte來儲存，就可以解決中英文字符集不兼容的問題。

非 Unicode (沒有 n ):文字是英文字符就是 1 Byte;非英文字符就是使用 2 Byte來儲存。

**VARCHAR(n)**
  可以有預設值，資料沒有固定長度，並且都為英文數字，可以設置最大長度，適合用在長度可變得屬性。

**text(n)**
  不可指定預設值，非 Unicode 數據，最大長度為 2^31-1(2,147,483,647)個字符，當不知道最大長度時，適合用 TEXT。

查詢速度 char > varchar > text

1. 經常變化的字段用 varchar 
2. 知道固定長度的用 char 
3. 盡量用 varchar 
4. 超過255字節的只能用 varchar 或者 text
5. 能用 varchar 的地方不用 text (因 varchar 查詢速度比較快)

參考資料
> 節錄自 [SQL Server 資料型態 char varchar nchar nvarchar](https://ithelp.ithome.com.tw/articles/10213922)
## Cookie 是什麼？在 HTTP 這一層要怎麼設定 Cookie，瀏覽器又是怎麼把 Cookie 帶去 Server 的？
Cookie 用來識別使用者的身份或是相關資訊。因為是放置在用戶端的電腦，瀏覽者不必與伺服器溝通即可取得其中的資訊，免除與伺服器之間多餘的連線。例如瀏覽者將未結帳的商品放置在購物車中，中途可能因故離開或是關閉瀏覽器，都能藉由 Cookie 的幫忙，在下一次回到原網站操作時，調出未結帳的商品繼續購物。Cookie 放置在瀏覽者的電腦中能保持一段較長的時間，在 Cookie 未消失前都能正確記錄資訊，搭配程式的應用即可免除重複輸入資料的麻煩。例如當登入會員系統之後，程式則將該使用者的資訊記入在 Cookie 中，即使關閉瀏覽器後重新開啟原來的頁面，該使用者依然能夠因為 Cookie 的幫忙維持登入的狀態。

因為 Cookie 是以檔案的型態儲存在瀏覽者的電腦，所以有以下限制：
1. 每個使用者的瀏覽器只能儲存使用 300 個 Cookie。
2. 每個瀏覽器只能針對同一個伺服器存取 20 個Cookie。
3. 每個Cookie 的大小只有 4k Bytes 的容量。
4. 瀏覽器可以設定關掉 Cookie 的功能，如此可能會造成 Cookie 無法使用。Cookie 在使用時較讓人擔心的是資訊安全，因為它是以明碼的方式儲存在使用
者的電腦中，有可能被擷取進行不當的利用。所以若記錄的資訊較為機密，如帳號密碼、信用卡卡號等，就不適合了。

使用 setcookie() 函式將資料存入 Cookie 中，setcookie("變數名稱","變數值","存活時間","路徑","網域")。
設定 cookie
> ex: setcookie("Token","username","time()+3600")
cookie 存活時間就是現在加上 3600 秒
讀取
> ex: <?php  echo $_COOKIE["UserName"];?>
刪除
> ex: setcookie("username","","time()-3600")

Cookie定義了一些 HTTP 請求標頭和 HTTP 回應標頭，通過這些HTTP頭資訊使伺服器可以與客戶進行狀態互動。

客戶端請求伺服器後，如果伺服器需要記錄使用者狀態，伺服器會在回應的資訊中包含一個 Set-Cookie 的標頭，客戶端會根據這個回應 儲存 Cookie 資訊。再次請求伺服器時，客戶端會在請求資訊中包含一個 Cookie 請求標頭，而伺服器會根據這個請求標頭進行使用者身份、狀態等校驗。

## 我們本週實作的會員系統，你能夠想到什麼潛在的問題嗎？
由於我們並沒有對使用者輸入的內容做限制，可能會讓有心人士利用惡意程式碼，竊取使用者的個人資料、假冒使用者身份，或將使用者瀏覽器導向其它惡意網站。

> 常見的攻擊方式
+ [XSS (Cross-site scripting)](https://zh.wikipedia.org/wiki/%E8%B7%A8%E7%B6%B2%E7%AB%99%E6%8C%87%E4%BB%A4%E7%A2%BC)
+ [SQL Injection](https://zh.wikipedia.org/wiki/SQL%E6%B3%A8%E5%85%A5)

我們使用的 session 機制，會生成暫存檔案並儲存於伺服器端，伺服器要承擔檔案的容量，試著想假如這個網站每天造訪的人數 1000 人，一個月後就會有 30000 個暫存檔案，如果沒有定期清理，對伺服器將是額外的開銷。

參考資料
> [PHP session 暫存檔過多的注意事項](https://blog.longwin.com.tw/2008/10/php-too-more-session-file-set-2008/)
> [PHP 的session 儲存於mysql 資料庫內](http://pim0110.idv.tw/joomla/index.php/php-/188-php-session-mysql-)

其他
我們在資料庫儲存會員密碼是明碼，如果有駭客駭進主機裡，那麼資料庫裡的會員資料形同~~裸體~~，而伺服器管理者也不應該知道使用者的密碼。
我們的網域 mentor-program.co 沒有申請 SSL 憑證，請記得幫網站加上隱私權政策。

雖然是農場文章，但是可參考其中的觀念
[10 個 PHP 常見安全問題](https://tw511.com/a/01/4227.html)