# AWS EC2 部署方法

#### 1. 選擇服務主機
進入 AWS 管理主控台，點擊右上方選擇服務要掛在哪個地區，預設是掛在美國東部(俄亥俄州) us-east-2，這邊我選離我們最接近的地區東京。

![setp1](https://upload.cc/i1/2021/07/16/4YGPw9.jpg)

#### 2. 啟用 EC2
在主控台點擊"使用EC2"，之後按下「Launch Instance」進入選擇 Amazon 虛擬機器的畫面。

#### 3. 建立虛擬機器
看到標誌有「**Free tier eligible**」表示可以免費使用，我們要選 **Ubuntu Server 20.04**，Ubuntu 還有 18.04的版本，選最新版的就可以了。

![setp2](https://upload.cc/i1/2021/07/16/RVuTPh.jpg)

#### 4. 選擇實例的類型
因為我們想用免費方案，所以只能選擇帶綠色標籤的方案，可以直接點擊 Review and Launch」跳到最後一步，或是按下 「Next: Configure Instance Details」去看看基本設定有哪些。

![setp3](https://upload.cc/i1/2021/07/16/cULMvY.jpg)

#### 5. Configure Security Group
預設只幫我們打開 port 22，這個連接阜是讓我們用來做 SSH 連線用的，點擊「Add Rule」，新增兩個 port，分別是 HTTP 80 和 HTTPS 443 port。

![setp5](https://upload.cc/i1/2021/07/16/WOSDtV.jpg)

#### 6. Review Instance Launch
這裡會列出所有設定，讓你確認，按下「Launch」完成。

![setp6](https://upload.cc/i1/2021/07/16/G9j6b3.jpg)

#### 7. 下載金鑰
點擊「Create a new key pair」

![setp7](https://upload.cc/i1/2021/07/16/0YKZpm.jpg)

Key pair name 欄位，輸入一個名稱，然後按下 Download Pair，將金鑰下載回來，這個步驟相當重要，一但按下 Launch Instances 離開畫面，就無法再回來。

![setp7](https://upload.cc/i1/2021/07/16/5EAlSM.jpg)

#### 8. Launch Status
按下「View instances」下一步。

![setp8](https://upload.cc/i1/2021/07/16/8Iswgj.jpg)

#### 9. 啟動狀態
回到主控台，這裡需要給一點時間讓系統檢查。
![setp9](https://upload.cc/i1/2021/07/16/wlOtL4.jpg)

最後可以看到我們的 Server 正在執行中。
![setp9](https://upload.cc/i1/2021/07/16/kAl7b5.jpg)

#### 10. 使用 SSH 連線到 EC2
這裡介紹 Windows 用戶的操作方法，不使用 Putty 可以直接使用 EC2 Instance Connect 連線，直接跳到步驟 11

首先到 [Putty](https://www.chiark.greenend.org.uk/~sgtatham/putty/releases/0.75.html) 官方網站，下載 Putty 和 Puttygen

主控台點選「Connect」或「連線」

![setp10](https://upload.cc/i1/2021/07/16/2laThE.jpg)

選擇「SSH 用戶端」，等下會用到這裡範例的 SSH 指令

![setp10](https://upload.cc/i1/2021/07/16/1JgdGC.jpg)

開啟 Puttygen 載入我們剛剛下載回來的金鑰，選擇 Save private key 儲存私有密鑰，以 Putty 的格式儲存金鑰，我們會得到一個檔名 ppk 結尾的檔案

![setp10](https://upload.cc/i1/2021/07/16/67HnMk.jpg)

開啟 Putty，設定基本上不用調整，在 Connection 下找到 Auth，在 「Private key file for authentication」上傳剛剛轉換完成的 private key (.ppk)檔案

![setp10](https://upload.cc/i1/2021/07/16/CRGZKt.jpg)

找到 Session，Host name 填入 SSH 用戶端給的範例
`ssh -i "你的私鑰名稱" ubuntu@ec2-54-65-196-25.ap-northeast-1.compute.amazonaws.com`

Save Session 可以自己命名，按下 Save 存檔，下次就能再次讀取設定檔

![setp10](https://upload.cc/i1/2021/07/16/nrZIkF.jpg)

點選 Open 後，第一次進來會跳一次警告，按下 Accept 同意

![setp10](https://upload.cc/i1/2021/07/16/b0TJME.jpg)

成功連線!

![setp10](https://upload.cc/i1/2021/07/16/SZBtaL.jpg)

#### 11. 更新 Ubuntu Server
連線成功後，用以下指令來更新 Ubuntu Server
`sudo apt update && sudo apt upgrade && sudo apt dist-upgrade`

之後都按下 Y 確認

![setp11](https://upload.cc/i1/2021/07/16/TanVq7.jpg)

安裝 Tasksel
`sudo apt install tasksel`

安裝 LAMP Server
`sudo tasksel install lamp-server`

![setp11](https://upload.cc/i1/2021/07/16/DtL5hU.jpg)

安裝 phpMyAdmin
`sudo apt install phpmyadmin`

按下空白鍵選擇 apache2

![setp11](https://upload.cc/i1/2021/07/16/GlYQZ4.jpg)

詢問是否要設定 dbconfig-common，選擇 Y

設定 phpmyadmin 使用者密碼，第二次再次輸入確認密碼

![setp11](https://upload.cc/i1/2021/07/16/hU2Wqi.jpg)

設定MySQL的root帳號，使其能夠使用密碼登入的功能
`sudo mysql -u root mysql`

讓 root 帳號啟用 mysql_native_password 插件
`UPDATE user SET plugin='mysql_native_password' WHERE User='root';`

重新載入權限表
`FLUSH PRIVILEGES;`

執行更改root密碼
`sudo mysql_secure_installation`

![setp11](https://upload.cc/i1/2021/07/16/Yg4BWH.jpg)

設定 root 的密碼
`sudo mysql_secure_installation`

輸入 Y 同意
我選擇 2，使用複雜的密碼規則

看到 ALL done 就表示設定完成了!

![setp11](https://upload.cc/i1/2021/07/16/KePrNk.jpg)

#### 在Ubuntu 20.04 LTS 架 Apache2 網頁伺服器及 SSL 憑證
1. 開啟UFW防火牆
`sudo ufw enable`

2. SSH 加入防火牆，兩道命令擇一即可
`
sudo ufw allow ssh
sudo ufw allow 22
`
3. Apache 也加入防火牆
`sudo ufw allow 'Apache Full'`

接下來的操作方式是是參考官方網站，不管怎麼試這道命令都會出現錯誤提示
`
sudo certbot --apache -d {your.domain.com} -d {www.your.domain.com}
`
查了一下丟出錯誤的關鍵字
> Challenge failed for domain your.domain.com

4. 似乎是防火牆的 PORT 80 & PORT 443 沒有開啟，但是這項設定在建立 EC2 的時候已經打開了，於是到官網查一下文件，前面的套件跳過不裝，只需要執行下面的命令。
`
sudo certbot --apache
`

5. 接著會問你 Please enter in your domain
name(s) (comma and/or space separated)  (Enter 'c' to cancel)，輸入你的 domain name，多個可以用逗號分隔，這邊設定的方式和 AWS 後台設定很相似

6. Enter email address (used for urgent renewal and security notices) (Enter 'c' to cancel):

填入 Email，快到期會寄信通知你

7. 接著會要你同意條款，按 A (gree)

8. 再來問你願不願意分享你的資料，看個人意願，我填 N (否)

9. 問你需不需要自動將 HTTP 轉址到 HTTPs，(1) 不需要 (2) 需要，選 2


`*.{domain name}`

10. 測試一下 [SSL Server Test](https://www.ssllabs.com/ssltest/index.html)

![I get it](https://upload.cc/i1/2021/07/19/EKbXnh.jpg)


11. 完成後，來測試自動續訂功能
`
sudo certbot renew --dry-run
`

關於 `Challenge failed for domain` 這個錯誤，雖然不是查不到有這樣問題的文章，實際上發生問題的情境是不一樣的，無法複製其他人解決問題的模式時，這時候只能自己慢慢去摸索，至於為什麼會命令失敗，目前尚未弄清楚，不確定是不是 SSL 生效時間的問題，會這樣猜是因為曾經有客戶網站 SSL 到期，重新申請後大半天的時間都還連不上，還是商用等級的主機，且從發生問題到排除也過了好幾個小時，無法推斷。我想重現這個問題的方式，大概就是在申請一個憑證吧(~~好累 ORZ~~)

參考資料
[在Ubuntu 20.04 LTS 架 Apache2 網頁伺服器及 SSL 憑證](https://blog.cre0809.com/archives/55)
[Apache on Ubuntu 20.04](https://certbot.eff.org/lets-encrypt/ubuntufocal-apache)