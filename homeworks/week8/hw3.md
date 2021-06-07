## 什麼是 Ajax？
Asynchronous Javascript And XML（非同步 JavaScript 和 XML），是一種無須刷新整個頁面就能為頁面的某一部份加載數據的方法。
Ajax 透過 XMLHttpRequest 向伺服器發送非同步請求，從伺服器取得資料，然後使用 JavaScript 来操作 DOM 從而更新頁面。

瀏覽器實現了一個 XMLHttpRequest 的物件來處理 Ajax 的請求，而 XMLHttpRequest 是 Ajax 核心機制，IE5 中首先引入，是一種非同步的方法，，也就是javascript 可以向伺服器請求和處理回應，而不阻塞用户，達到頁面無刷新的效果。

## 用 Ajax 與我們用表單送出資料的差別在哪？
傳統表單使用同步 (Synchronous)，如果想得到伺服器端資料庫或文件上的資訊，或者發送客戶端訊息到伺服器，需要建立一個 HTML form 表單然後 `GET` 或者 `POST` 數據到服務器端。用戶需要點擊 `Submit` 按鈕來發送或者接受資料訊息，然後等待伺服器回應請求，頁面重新加載。因為伺服器每次都會返回一個新的頁面，所以使用者在伺服器回應的期間，就必須等待，有可能很慢而且用戶交互不友善。
>即：查看—>提交—>等待—>新頁面查看—>新的提交...

Ajax 是非同步 (Asynchronous)， Javascript 通過 XMLHttpRequest 直接與伺服器進行交互。透過 HTTP Request 一個 web 頁面可以發送一個請求到 web 伺服器接受 web 伺服器返回的訊息(不用重新加載頁面)，展示给使用者的還是同一個頁面，使用者感覺頁面刷新，也看不到到 Javascript 後台進行的發送請求和接受回應。
>查看—>提交—>繼續流覽—>舊頁面查看—>新的提交...頁面無刷新，所以使用者的體驗連貫

## JSONP 是什麼？
JSONP 全名 (JSON with Padding)，Padding 指的是呼叫的函式，因為瀏覽器安全性限制 Same origin policy，(同源策略)，無法跨站請求 (cross-domain)，此協定僅允許 `script` 在同個網域之間互相傳送資料，禁止不同網域互相取用方法與屬性，JSONP 利用 `<script>` 標籤的特性解決跨網域限制，透過`<script>`裡的 `src` 屬性引用外部網站的資源，例如 cdn 或 import 進來的 url 就是不同源，就不會跳出 CORS 錯誤，原因是 `src` 屬性不受同源政策限制，需要注意只能使用 get method 向後端要資料。

## 要如何存取跨網域的 API？
瀏覽器會將 CORS 請求分為兩種「簡單請求（simple request）」和「非簡單請求（not-so-simple request）」

如果 Request method 是 `GET`、`HEAD`、`POST`，且 Request header 的 Content-Type 是以下其中一種就是簡單請求，後端在方法本身加上 header `Access-Control-Allow-Origin` 加上 `*` 或是來源網站。

  - application/x-www-form-urlencoded
  - multipart/form-data
  - text/plain

 >更詳細的規則請參考 [Simple requests - MDN](https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS)

  如果 Request method 是 `PUT`、`DELETE` 方法，或是 `Content-Type: application/json` 等，瀏覽器在發送請求之前會先發送一個 「preflight request（預檢請求）」，目的是在詢問伺服器是否允許這樣的請求，如果允許才把請求送過去，後端在 header 加上 `Access-Control-Allow-Methods` 及 `Access-Control-Allow-Headers`，另外在本身的方法加上` Access-Control-Allow-Origin` 

  - Access-Control-Allow-Headers：指定哪些 HTTP 標頭可以於實際請求中使用。
  - Access-Control-Allow-Methods：存取資源所允許的方法，用來回應預檢請求。
  - Access-Control-Expose-Headers：瀏覽器能夠存取伺服器回應當中哪些標頭。
  - Access-Control-Max-Age：預檢請求之結果可以被快取的秒數。
  - Access-Control-Allow-Credentials：用於驗證請求中。

>參考資料 
[ CORS 是什麼? 如何設定 CORS?](https://shubo.io/what-is-cors/)
[[Web] 同源政策與跨來源資源共用（CORS）](https://pjchender.dev/webdev/web-cors/)

第二種方式使用 JSONP，建立一個 `<script>` 標籤元素，將`src` 指向一個跨網域的網址，例如
```
// 前端
<script>
  function getData(response) {
    console.log('data', response)
  }
</script>
<script type="text/javascript" src="/app/User.js"></script>
```
```
// 伺服器端
getData({
  'id': '1',
  'name': 'user'
})...
```

遠端伺服器收到請求後回傳一個 JavaScript 檔案 (application/javascript)，檔案會執行一個 JavaScript function，而這個 function 傳入的參數 response 就是我們請求的資料結果，將資料傳入 getData 這個 Callback 中執行。

## 為什麼我們在第四週時沒碰到跨網域的問題，這週卻碰到了？
因為執行環境不同，前四週我們是透過作業系統的 command-line 介面，安裝 Node.js 的執行環境向遠端發送請求及接受回應。
如果執行環境是瀏覽器，那麼就是透過瀏覽器向遠端發送請求及接受回應，請求其實已經發出去了，瀏覽器也能收到伺服器的回應，因為安全性的考量，瀏覽器必須遵守同源政策（same-origin policy），才把我們收到的回應擋下。
