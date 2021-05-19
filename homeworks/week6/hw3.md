## 請找出三個課程裡面沒提到的 HTML 標籤並一一說明作用。
**fieldset**
將 `form` 表單元素如 `input`、`select`、`checkobox`、`radio`...等等群組化，內置 `legend` 做為 `fieldset` 的標題。

屬性值
  - disabled: 禁用 `filedset` 元素內所有關聯 `form` 的表單元素，例 如  `input`、`select`、`checkobox`、`radio`、`button`..等等
  - id: 屬性值將 `fieldset` 設置成這個 `form` 的一部分
  - name: 元素分組的名稱

**簡單範例**
  ```
  <form>
      <fieldset>
          <legend>個人資訊</legend>
          <label>姓名：<input type="text"></label><br><br>
          <label>性別：<input type="text"></label>
      </fieldset>
      <fieldset>
          <legend>連絡方式</legend>
          <label>市話：<input type="text"></label><br><br>
          <label>手機：<input type="text"></label>
      </fieldset>
  </form>
  ```
![預覽圖](https://i.imgur.com/gCC0a1p.jpg)

**禁用表單**
  ```
  <form>
      <fieldset disabled>
          <legend>個人資訊</legend>
          <label>姓名：<input type="text"></label><br><br>
          <label>性別：<input type="text"></label>
      </fieldset>
      <fieldset disabled>
          <legend>連絡方式</legend>
          <label>市話：<input type="text"></label><br><br>
          <label>手機：<input type="text"></label>
      </fieldset>
  </form>
  ```
![預覽圖](https://i.imgur.com/2LrxdSW.jpg)
<br>
**table**
一個HTML表格包括<table>元素，一個或多個tr、th 以及 td 元素。
tr 元素定義表格行，th 元素定義表頭，td 元素定義表格單元。
更複雜的HTML 表格也可能包括caption、col、colgroup、thead、tfoot 以及 tbody 元素。在 HTML5 中僅支持 border，參照 [w3c](http://www.w3big.com/zh-TW/tags/tag-table.html)

屬性值
  - border: 定義表格是否有邊框 1 或 ""

**簡單範例**
  ```
  <style>
  body
  {
    counter-reset: Serial;
  }

  table
  {
    border-collapse: separate;
  }

  tr td:first-child:before
  {
    counter-increment: Serial;      /* Increment the Serial counter */
    content: "Serial is: " counter(Serial); /* Display the counter */
  }
</style>

<table border="1">
  <thead>
    <tr>
      <th>Automatic Serial number</th>
      <th>Column 1</th>
      <th>Column 2</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td></td>
      <td>Column 1</td>
      <td>Column 2</td>
    </tr>
    <tr>
      <td></td>
      <td>Column 1</td>
      <td>Column 2</td>
    </tr>
    <tr>
      <td></td>
      <td>Column 1</td>
      <td>Column 2</td>
    </tr>
  </tbody>
</table>
  ```
![預覽圖](https://i.imgur.com/svw79bc.jpg)
<br>
**HTML特殊字元**
使用實體名稱的優點：實體名稱易於記憶。
使用實體名稱的缺點：瀏覽器可能不支持所有實體名稱，但是對實體編號的支持很好。
 Result        | Description   | Entity Name | Entity Number
:--------------|:--------------|:------------|--------------
  &nbsp;       | 空格          | \&nbsp;     | \&#160;
  &amp;        | ampersand     | \&amp;      | \&#38;
  &cent;       | cent          | \&cent;     | \&#162;
  &pound;      | pound         | \&pound;    | \&#163;
  &yen;        | yen           | \&yen;      | \&#165;
  &euro;       | euro          | \&euro;     | \&#8364; 
  &copy;       | copyright     | \&copy;     | \&#169;
  &reg;        | registered trademark | \&reg; | \&#17s4;
 
 更多請參照 [w3c](https://www.w3schools.com/html/html_entities.asp)
<br>
## 請問什麼是盒模型（box modal）
![box modal](https://i.imgur.com/cpPz3sT.png)

Box Model 分為四個部分組成，由內而外依序是 Content ( 內容 )、Padding ( 內邊距 )、Border ( 邊框 ) 和 Margin ( 外邊距 )。[圖片來源](https://www.tutorialrepublic.com/css-tutorial/css-box-model.php)
<br>

![box modal](https://i.imgur.com/yHHOQMW.jpg)
+ Content: 內容顯示圖像、文字等
+ Margin：邊框與外部元素的距離，可以設定正負數
+ background-color：背景顏色 
+ background-image：背景圖片
+ Padding: 內容與邊框間的距離，只能設定正數，負數無效
+ Border：邊框的顏色、粗細與樣式
#### 立體圖
![box modal](https://i.imgur.com/t2DEevZ.jpg)
#### 平面圖
![box modal](https://i.imgur.com/boBQbTD.jpg)
這裡補充一下在 Margin 的外圍還有一層 Outline，工作原理可以參考[這裡](https://tinyurl.com/aas49t2n)
<br>

<!-- ![速記法](https://i.imgur.com/UAeSQKz.jpg) -->

## 請問 display: inline, block 跟 inline-block 的差別是什麼？
+ inline 行內元素 :
元素均在同一行顯示，圖片文字不換行，無法設定寬高即 width、height，寬度即高度決定於內容稱開的大小，設定上下 margin、padding 無效，左右 margin、padding 有效，常見行內標籤為 `span`、`br`、`img`、`strong`、`input`、`select`、`a`...等等。
<br>
行內（inline）元素圖示
![inline](https://i.imgur.com/DVGthgh.png)
<br>
+ block 區塊元素 :
元素在不同行顯示，每個區塊 (block) 元素自成一行，默認寬度 100%，可設定 width、height、mar＿gin、padding，常見區塊標籤為 `div`、`p`、`hr`、`ul`、`ol`、`li`、`h1~h6`、`form`...等等。
<br>
區塊（block）元素圖示
![inline](https://i.imgur.com/rQXqcjA.png)
<br>
+ inline-block 行內元素 :
元素以 inline 方式呈現，同時具有 block 屬性。可設定 width、height、margin、padding，元素不占滿整行，其寬高根據內容大小決定，排版方式類似 inline 屬性。

傳統的 `float` 屬性，利用元素浮動的特性讓區塊水平排列，但也會造成其他區塊跟著浮動上來，解決這個問題需要清除浮動，通常會在其父元素設定 `clear`屬性，但是 `inline-block` 屬性就可讓區塊水平排列，而且不需要額外清除浮動，還可使用 `vertical-align`垂直對齊，再搭配其他 `inline` 元素，就能排出整齊的版面，個人是常用在表單或是一行多列的設計，不過現已經有更好用的的 `flex` 排版，使用到 `inline-block` 的場景應該會越來越少。使用上還需要注意 [Inline-Block 元素的間隙](http://blog.darkthread.net/blog/inline-block-redundant-space/)。

>參考資料
[w3schools HTML Block and Inline Elements](https://www.w3schools.com/html/html_blocks.asp)
[Will 保哥 學習 CSS 版面配置](https://zh-tw.learnlayout.com/)
## 請問 position: static, relative, absolute 跟 fixed 的差別是什麼？

![postion](https://i.imgur.com/lFfaVt4.jpg)

**position: static** :
  > static 是元素預設值為靜態屬性，不受 top、right、bottom、left 屬性影響，元素依照瀏覽器排版在頁面上。

**position: relative** :
  > 如果元素套用「相對定位」，那麼在元素內設定 top、right、bottom、left 屬性，會使其元素「相對地」調整其原本該出現的所在位置，而不管這些「相對定位」過的元素如何在頁面上移動位置或增加了多少空間，都不會影響到原本其他元素所在的位置。

**position: absolute** :
  > 這裡要注意的是，元素套用「絕對定位」，它會像它的外層尋找有沒有 relative、absolute、fixed 還有 inherit 繼承前面三個屬性，如果都沒有，那麼就會以網頁的 body 當作參考點。

**position: fixed** :
 > 「固定定位」以瀏覽器當作參考點進行定位，當頁面捲動時，它還是是固定在同一個位置。

[z-index 補充](https://tympanus.net/codrops/css_reference/z-index/)

![fixed](https://i.imgur.com/ErgGhhb.png)
[圖片來源](https://o7planning.org/12063/bootstrap-position)


fixed 
> 通常應用在擺放廣告或是回到最上的按鈕網頁右下角的 chat 或者是 contact us，搭配 static 特性作出像 stick 般的效果。

absolute
> 常搭配 relative 一起使用，堆疊在同一個元素上很有用，常應用在拍賣網站，滑鼠移到商品上，可能出現加入購物車或是加入最愛清單的按鈕，或是 banner 上壓上文字等等。
