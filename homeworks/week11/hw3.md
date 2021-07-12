## 請說明雜湊跟加密的差別在哪裡，為什麼密碼要雜湊過後才存入資料庫
加密 (Encrypt) 和解密必須要有 KEY (金鑰)，只有知道 key 的人才有辦法把加密過的密文解密回去，是一對一的關係，而雜湊 (Hashing) 的方式是把一組欄位或字元丟進雜湊演算法中，最後得出一個或多個值，不同輸入結果雜湊後的結果有機率相同，稱為碰撞 (Collision)，是一對多的關係，所以雜湊後的數值無法回推 (雜湊後不可逆)。
雜湊利用其不可逆的特性，將明碼變成像亂碼存入資料庫，這樣資料庫即使被駭了，使用者的密碼也不會洩漏出去，另外更安全的做法可以使用 bcrypt (慢雜湊演算法)，再加 salt 雜湊，PHP password_hash 就是使用 bcrypt 演算法，預設已經幫我們在背後產生隨機的SALT，只能透過 password_verify 進行驗證，因此會更加安全。

參考資料
[一次搞懂密碼學中的三兄弟 — Encode、Encrypt 跟 Hash](https://medium.com/starbugs/what-are-encoding-encrypt-and-hashing-4b03d40e7b0c)
[聽說不能用明文存密碼，那到底該怎麼存？](https://medium.com/starbugs/how-to-store-password-in-database-sefely-6b20f48def92)

## `include`、`require`、`include_once`、`require_once` 的差別
+ `require`、`require_once`
PHP 程式在執行前，就會先讀入 `require` 所指定引入的檔案，使它變成 PHP 程式網頁的一部份，常用的函式可以寫成一個函式庫檔案，然後用這個方法將它引入網頁中。
`require_once` 會先檢查要引入的檔案是不是已經在該程式中的其他地方被引入過了；如果有的話，就不會再次重複引入該檔案。如果在同一個程式重複引入這個檔案，在第二次引入的時候便會發生錯誤訊息。

+ `include`、`include_once`
PHP 程式網頁在讀到 `include` 的檔案時，才將它讀進來，可放在流程控制的處理區段，如條件判斷 if else 或 while，同 `require_once`，`include_once` 會先檢查欲引入檔案的內容是不是在之前就已經引入過了；如果是的話，便不會再次重複引入同樣的內容。

+ `require`與`include`的差別
`include()`提供有回傳值 return 的功能，`require()`函數並不容許有回傳值。
`include` 引入文件時，如果碰到錯誤，會給出提示，並繼續執行下面的程式碼，`require` 引入文件，如果碰到錯誤，會給出提示，並停止運行程式碼。
`require()`適合用來引入靜態的內容，而 `include()`則適合用來引入動態的程式碼（程式內容會依其他程式碼而變動）。
## 請說明 SQL Injection 的攻擊原理以及防範方法
+ 攻擊原理
Sql Injection 又稱SQL隱碼攻擊，指的是 SQL 語法上的漏洞，藉由特殊字元，改變語法上的邏輯，駭客就能取得資料庫的所有內容，當然也包含了使用者的帳號、密碼。
這是一段查詢 member 資料表的會員帳號及密碼的 SQL 指令:
```
SELECT * FROM members WHERE account='$name' AND password = '$password'
```
經過駭客插入惡意代碼的結果
```
SELECT * FROM members WHERE account='' OR 1=1 #' AND password=''
```
`#` 在 MYSQL 中代表註解的意思，在 `/*` 後面的程式碼都不會被執行，而判斷式 OR 1=1，則是永遠成立，駭客因此不需要密碼即可登入網站。
根據SQL 版本不同的註解語法 `/*`、`#`、`--`
+ 防範方式

1. 使用 Regular expression 正規化的方式驗證過濾輸入值，將含有SQL指令過濾掉、或是將單引號變換成雙引號。
2. 使用 Query Parameterization 參數化查詢，預處理 SQL 語句，資料庫先將 SQL 語句進行編譯，之後再把使用者輸入的參數丟進去編譯後的 SQL 語句再執行。
3. 將資料庫預設帳號、密碼關閉，資料庫管理員帳號確實把關，提高資料庫存取權限，限制使用者透過某些管道存取。
4. 在不需要使用到更新、插入資料時，資料庫以view方式處理供使用者查詢資料。
5. 盡可能不要取容易被猜取的資料庫、資料表名稱(但有可能造成維護人員的不易)。
6. 部屬Web 應用程式防火牆，過濾掉OSI應用層的威脅，一般防火牆只會顧到網路層、傳輸層間的威脅，對於應用層較為忽略。
7. 將伺服器與資料庫部屬在不同的機器上，並保持更新狀態。
8. 使用 PDO 防止 SQL Injection [](http://us3.php.net/manual/en/book.pdo.php)
## 請說明 XSS 的攻擊原理以及防範方法
 + XSS 又可以分為三種常見類型:
 1. Stored XSS (儲存型)
 Stored XSS 儲存型 XSS，把 JavaScript 程式儲存在後端資料庫裡，例如在留言板程式中，如果使用者輸入的是 \<script>alert(123)</script\>，這段文字被送出並建立留言時，這段 script 會被儲存到後端資料庫中，當留言板的其他使用者重新載入想看其他人的最新留言時，這段 script 便會從資料庫被抓出來，如果應用沒有做好字串的解析與特殊字元的防範，也就是說瀏覽器不會把 script 當成一般字串，而是一段程式，瀏覽器便有可能直接執行這段 script，也就是留言板使用者都會跳出 alert。
 2. Reflected XSS (反射型)
 攻擊方式為將 script 藏在 URL 網址列中，並透過 GET 參數傳遞資料給伺服器時，伺服器未檢查就將內容回應到網頁上所產生的漏洞，透過網址以釣魚手法將受害者導到其他網站。
 ```
  http://localhost:8080/tesh.php?name=<script>alert(123)</script>
 ```
 3. DOM-Based XSS (基於 DOM 的類型)
  DOM-Based XSS 指的是網頁上的 JavaScript 在執行過程中，未經過檢查使得操作 DOM 的過程代入了惡意指令，如果有使用 innerHTML 語法就有可能被惡意注入 Javascript 代碼，該方法會將插入的內容轉換成合法 HTML 字串，字串最後會被解析成 DOM 物件。
+ XSS 防範方法
  Stored、Reflected 的類型都必須由後端進行防範，任何允許使用者輸入的內容都需要檢查，將特定的符號，轉換為 HTML 實體符號，PHP 可透過 htmlspecialchars 函式將存取前的資料先轉換，成為較安全的符號，避免掉一些不必要的資料存取動作所產生的非預期結果。
  DOM-Based 由前端來防範，innerHTML 改由 innerText，Jquery HTML() 亦可由 TEXT() 方法取代，保證為純文字，不會被惡意代碼插入。

## 請說明 CSRF 的攻擊原理以及防範方法
+ 攻擊原理
  Cross Site Request Forgery(跨站請求偽造)，也被稱為 one-click attack 或者 session riding，縮寫為 CSRF 或者 XSRF，攻擊者盜用使用者的身份，偽裝成使用者，偷偷發送惡意請求，通過偽裝變成信任的用戶向向網站發起請求。

  1. 使用者登入 A 網站，使用者透過身份驗證在本機形成 cookie
  2. 在不登出的情況下，訪問 B 惡意網站
  3. 使用者點擊含有惡意程式的連結，或是直接連結了第三方網站，並瀏覽了帶有以下 html 程式碼的網頁： <img src = "惡意連結">
  4. 惡意程式碼利用使用者的身份發請求，以你的名義，盜取帳密、發送信件、留言、購買商品、結帳等等問題...

+ 防範方法
  - 檢查 referer 欄位
  HTTP 頭中有一個 Referer 欄位，這個欄位用來表示請求來源於哪個位址，通常 Referer 欄位應該要和請求的網址位在同一個域名，但此方法必須依賴瀏覽器發送正確的 Referer 欄位，如果駭客偽造這個 referer 欄位，那麼這個方法就會再度被破解，所以不是可靠的做法。
  - 加上圖形驗證碼、簡訊驗證碼
    驗證碼每次登入都不同，駭客無法得知，除了每次登入比較麻煩。
  - 加上 CSRF token
  這個 token 由 server 產生，並且加密存在 session 中，只能透過 server 給使用者，並在一定時間內更新。因為攻擊者不知道 CSRF token 的值，自然就無法攻擊，但是網站如果允許 CORS，攻擊者還是可以發起請求，拿到這個 token。
  - SameSite cookie
  不允許跨站請求，這個 cookie 只允許在同一個 domain 下使用，除此之外的請求都不會被加上。

  參考網站
  [Cookies - SameSite Attribute](https://ithelp.ithome.com.tw/articles/10251288)
  [讓我們來談談 CSRF](https://blog.techbridge.cc/2017/02/25/csrf-introduction/)