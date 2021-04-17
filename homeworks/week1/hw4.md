## 跟你朋友介紹 Git

Git 有兩個重要的用途，一個是版本控制，另一個是團隊的多人協作，我們可以用它來管理這麼多不同版本的笑話。

### 為什麼要用 Git

如下圖所示，這些檔案可能每天都在新增修改，原本3個檔案，過了1天增加2個修改1個，在過2天增加5個修改3個，你可能覺得幾天前的笑話比較好，想改回來時，這時你就不得不做備份，但是總不能每次修改就做一次備份，這樣檔案不僅多且不好管理，沒有辦法很快確認這些檔案修改了什麼，更別說忘記備份或不小心覆蓋，透過版本控制，系統化的管理，清楚的紀錄每個檔案是誰在什麼時間做了修改、新增、刪除，還能返回過去修改的內容，就像遊戲存檔一樣，可以載入舊進度重新過關。

![joke1](https://i.imgur.com/kK3lJ4E.jpg)
<!--div class="mermaid">
    graph LR
    c_1(版本1 共3個檔案)-- 過了1天 ---c_2(版本2 共5個笑話)-- 過了2天 --- C_3(版本3 10個笑話) -- 過了7天 --- c_4(版本4 20個笑話)
</div-->

### Git 怎麼使用

首先必須安裝 [Git](https://git-scm.com/download)，開啟 CMD 將位置切換到你放笑話的資料夾下，假設我們有一個**笑話版本1**的資料夾。

1. 輸入 <code>git init</code>，對這個資料夾做版本控制
2. 輸入 <code>git status</code>，當你有檔案改動時CMD，會提示你哪些檔案做了改動，staged: 加入版控，untracked: 未加入版控
3. 輸入 <code>git diff</code> 查看修改哪些內容
4. 輸入 <code>git add [檔案名稱]</code>一次加入多個檔案 <code>git .</code>
5. 輸入 <code>git commit -m "你的訊息"</code>
6. 輸入 <code>git log</code>，查看歷史訊息</p>

<p>假設我們 commit 到版本3，圖解可以想像成下圖</p>

![joke2](https://i.imgur.com/0u0WpRM.jpg)
<!--div class="mermaid">
    graph LR
    j_1(笑話 版本1) --過了1天--- j_2(笑話 版本2) --過了2天--- j_3(笑話版本 3):::joke

    classDef joke fill #227d51, color: #fff
</div-->

### 那麼我想回到舊的版本怎麼辦

1. `git log --oneline`，列出精簡的 git log
2. 每一個 commit 之後都有一個獨立的 git hash，將他複製起來
3. 輸入 `checkout {笑話版本1 git-hash}`，貼上剛剛 git hash 在 checkout 之後
4. 我們就從笑話版本3切換到笑話版本1

![joke3](https://i.imgur.com/jKXbrmv.jpg)
<!--div class="mermaid">
    graph LR
    j_1(笑話 版本1):::joke --- j_2(笑話 版本2) --- j_3(笑話版本 3) -- checkout --- j_1

    classDef joke fill #f00, color: #fff
</div-->
