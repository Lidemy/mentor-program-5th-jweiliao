## 請以自己的話解釋 API 是什麼
API 的全名是 Application Programming Interface，API翻譯為「應用程式介面」，提供雙方交換資料的橋梁。可以想像 API 接收你的請求，傳送至伺服器，伺服器收到請求後，再將結果回傳給你，舉例你在一家餐廳用餐，這時候服務生拿著 menu 詢問您需要什麼餐點，接著將您的菜單送至廚房，服務生再將餐點送至桌上，而廚房就是伺服器，服務生及菜單就是您的 API，如果我想使用 google map 的服務，就必須依照 google 提供的方法進行串接，透過 API 將資料分享出去。

## 請找出三個課程沒教的 HTTP status code 並簡單介紹
**408 - (Request Timeout) — 請求逾時**
表示 Server 決定 關閉連線，而非繼續等待。

**414 - (URI Too Long) — URI 過長**
表示客戶端所請求的 URI 超過了服務器允許的範圍

**505 - (HTTP Version Not Supported) — HTTP版本不支援**
是一種HTTP協議的服務器端錯誤狀態代碼，表示服務器不支持請求所使用的 HTTP 版本。

**418 - (I’m a teapot) — 我是個茶壺**
任何企圖以茶壺沖泡咖啡者，皆應回覆 418 錯誤碼。
意譯： 目前的伺服器是茶壺，而非咖啡壺，因此拒絕煮咖啡。
[超文本咖啡壺控制協定 (HTCPCP)](https://tools.ietf.org/html/rfc2324)

參考文章
[MDN HTTP response status codes](https://developer.mozilla.org/zh-CN/docs/Web/HTTP)
[notfalse 技術客 HTTP 狀態碼 (Status Codes)](https://notfalse.net/48/http-status-codes#414-URI-Too-Long-8212-URI)

## 假設你現在是個餐廳平台，需要提供 API 給別人串接並提供基本的 CRUD 功能，包括：回傳所有餐廳資料、回傳單一餐廳資料、刪除餐廳、新增餐廳、更改餐廳，你的 API 會長什麼樣子？請提供一份 API 文件。

Lidemy 餐廳示範網址 `https://Lidemybistrot.com.tw`

### 

**查詢所有**
```
GET https://api.Lidemybistrot/stores/all
```
**範例回應**
```
[
    {
        "StoreID":"1001",
        "StoreName":"O北店",
        "StoreAdress":"OO市OO區OO路OO號",
        "StoreTEL": "02-xxxx-xxxx"
    },
    {
        "StoreID":"1002",
        "StoreName":"O中店",
        "StoreAdress":"OO縣OO區OO街OO號",
        "StoreTEL": "05-xxxx-xxxx"
    },
]
```
**查詢**
```
GET https://api.Lidemybistrot/stores?id=<store ID>
```
**範例回應**
```
{
    "StoreID":"1001",
    "StoreName":"O北店",
    "StoreAdress":"OO市OO區OO路OO號",
    "StoreTEL": "02-xxxx-xxxx"
}
```
**新增**
```
POST https://api.Lidemybistrot/stores?name=<store name>?address=<store address>?tel=<store tel>
```
**刪除**
```
DELETE https://api.Lidemybistrot/stores?id=<store ID>
```
**更新**
```
PATCH https://api.Lidemybistrot/stores?id=<store ID>?name=<store name>?address=<store address>?tel=<store tel>
```
**Optional Query Parameters**
參數          |參數類型    | 必須      | 說明
|:------------|:----------|:----------|:------------
all           | query     | require   | 回傳所有店面資訊
id            | query     | require   | 餐廳編號
name          | query     | require   | 餐廳名稱
address       | query     | require   | 餐廳地址
tel           | query     | require   | 餐廳電話