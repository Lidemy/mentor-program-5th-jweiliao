## 教你朋友 CLI

### command line 到底是什麼?
  這個黑色的視窗稱為**命令列介面 (Command-Line Interface 縮寫: CLI)**，我習慣稱呼他為 **terminal(終端機)**，不同於我們電腦使用的**圖形使用者介面 (graphical user interface 縮寫: GUI)**。主要以純文字與電腦溝通的應用程式，它擁有不少的指令，提供你查看、處理、控制電腦的檔案。
<br>
### 如何在 command line 建立一個叫做 wifi 的資料夾?
  首先若你是 windows 作業系統，建議你到 [git](https://gitforwindows.org/) 官網下載 Git Bash，安裝完成就能在電腦上操作 command line 指令。
  在開啟 CMD 模式下，首先輸入 `pwd` 列出目前資料夾所在的位置，例如 /c/Users/，接著輸入 `mkdir wifi`，意思是建立一個名稱為 wifi 的資料夾，你可以輸入 `ls` 確認剛才的資料夾是否被建
  立，完成就會在 /c/Users/ 下會新增一個 wifi 的資料夾。
<br>

### 如何在裡面建立一個叫 afu.js 的檔案?
  輸入指令 `cd wifi`，切換到 wifi 資料夾裡，輸入 `touch afu.js` 新增 afu.js 的檔案，一樣可以使用 `ls` 來確認檔案是否存在。
