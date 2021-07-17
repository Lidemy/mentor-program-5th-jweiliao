## Webpack 是做什麼用的？可以不用它嗎？
Webpack 是一個打包工具，它可以協助我們將許多資源(CSS、javascript、模組套件等等...)，透過預處理內容將檔案編譯過後打包成一綑檔案。再現代開發的前端框架如 Vue、React、Angular，瀏覽器無法正常處理其檔案內容，這時就需要透過編譯才能使用，通過編譯讓瀏覽器也能識別檔案內容。
通過 Bundle JS，讓我們可以撰寫模組化的 JavaScript，一個稍具有規模的專案，通常套件與套件的依賴性就會非常複雜，在優化也非常不便。這時 webpack 代替我們做了這些事，將多個文件打包成模組，想引入套件做什麼處理時就會非常清楚。
可以控制套件的處理方式。透過 loader 或者插件，我們可以對不同類型的文件引入做我們希望的操作。比如對程式碼做 minify、uglify、圖片壓縮、文件處理、css 預處理等等。
透過 babel 等等插件，幫我們實做 polyfill，解決 ES6 規範或 CSS 語法無法在舊瀏覽器上實現的問題。

Webpack 適用在大型專案，同時需要管理很多不同類型的檔案，在維護管理上比較方便，如果是小型的專案，可以使用其他前端管理工具如 Gulp、Grunt、bower

## gulp 跟 webpack 有什麼不一樣？
Gulp 的工作原理比較像是 Task manager，通過配置管理一系列的 Task，接著定義執行順序，每個功能都有統一個接口管理，每個功能都必需註冊一個任務，來讓 Gulp 執行，建立起自動化的工作流程，不同之處在於 Gulp 沒有模組化的功能，它的定位在規範前端的開發流程，而 webpack 就是專注在前端資源模組化及整合的工具。

gulp、webpack，儘管在功能上有重疊的地方，但是在使用上可以單讀使用或是一起使用。

參考資料 [gulp 與 webpack 區別](https://www.cnblogs.com/lovesong/p/6413546.html)
## CSS Selector 權重的計算方式為何？
簡單舉例:
1 個元素 div 代表 0-0-1
2 個元素 ul li 代表 0-0-2
多個元素 body ul li... 0-0-9
由此可知 多個元素 > 2個元素 > 1個元素

1 個 class .myclass 代表 0-1-0
1 個 class 加上 1個元素 div.myclass 代表 0-1-1
1 個 ID #myID 代表 1-0-0
可知 ID > div.myclass > .myclass

行內樣式 style="" 代表 1-0-0-0
!import(~~通殺~~) 代表 1-0-0-0-0

最終 !import > 行內 > ID selector > class selector > Element

![https://cssspecificity.com/](https://i.imgur.com/M2Xb8A4.png)
圖片來源: [cssspecificity](https://cssspecificity.com/)
